<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * Version details
 *
 * @package    filter
 * @subpackage completionfilter
 * @copyright  2015 onwards Catalyst IT
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */


/**
 * Serves files with more browser cache friendly headers
 *
 * @param stdClass $course
 * @param stdClass $cm
 * @param context $context
 * @param string $filearea
 * @param array $args
 * @param bool $forcedownload
 * @param array $options
 * @return bool
 */

function filter_coursecompletion_pluginfile($course, $cm, $context, $filearea, $args, $forcedownload, array $options = array()) {
    global $CFG;

    \core\session\manager::write_close(); // Unlock session during file serving.

    $isicon = ($filearea === 'completeicon' || $filearea === 'incompleteicon' || $filearea === 'inprogressicon');
    $isacticon = ($filearea === 'completeacticon' || $filearea === 'incompleteacticon' || $filearea === 'inprogressacticon'
    || $filearea === 'completefailacticon');
    $isicon2 = ($filearea === 'completeicon2' || $filearea === 'incompleteicon2' || $filearea === 'inprogressicon2');
    $isacticon2 = ($filearea === 'completeacticon2' || $filearea === 'incompleteacticon2' || $filearea === 'inprogressacticon2'
    || $filearea === 'completefailacticon2');

    if ($context->contextlevel == CONTEXT_SYSTEM && ($isicon || $isacticon || $isicon2 || $isacticon2)) {
        require_once("$CFG->libdir/filelib.php");

        $syscontext = context_system::instance();
        $component = 'filter_coursecompletion';

        $lifetime = 60 * 60 * 24 * 60;
        array_shift($args);
        $fs = get_file_storage();
        $relativepath = implode('/', $args);

        $fullpath = "/{$syscontext->id}/{$component}/{$filearea}/0/{$relativepath}";
        $fullpath = rtrim($fullpath, '/');
        if ($file = $fs->get_file_by_hash(sha1($fullpath))) {
            header('Content-Disposition: inline; filename="'.$file->filename.'"');
            header('Cache-Control: public, max-age='.$lifetime.', no-transform');
            header('Expires: '. gmdate('D, d M Y H:i:s', time() + $lifetime) .' GMT');
            header('Pragma: ');

            readfile_accel($file, $file->get_mimetype(), true);
            exit;
        } else {
            send_file_not_found();
        }

    } else {
        send_file_not_found();
    }
}
