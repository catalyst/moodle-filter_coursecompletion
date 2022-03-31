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

define('NO_DEBUG_DISPLAY', true);
require(dirname(__FILE__).'/../../config.php');
require_login();
require_once($CFG->dirroot.'/completion/completion_completion.php');

$shortname = required_param('shortname', PARAM_TEXT);
$iconset = optional_param('iconset', '', PARAM_INT);

$completeicon = 'completeicon'.$iconset;
$incompleteicon = 'incompleteicon'.$iconset;
$inprogressicon = 'inprogressicon'.$iconset;

// Default to incomplete state for anonymous users.
if (!isloggedin()) {
    print_icon('incomplete');
    return;
}

// If the course can't be identified return an image saying so.
$courseid = $DB->get_field('course', 'id', array('shortname' => $shortname));

if (empty($courseid)) {
    print_unknowncourse();
    return;
}

// Check completion status and print complete/incomplete icon.
$completion = $DB->get_record('course_completions', array('course' => $courseid, 'userid' => $USER->id));

if (empty($completion)) {
    print_icon($incompleteicon);
    return;
}

if ($completion->status == COMPLETION_STATUS_INPROGRESS) {
    print_icon($inprogressicon);
    return;
}

if ($completion->status != COMPLETION_STATUS_COMPLETE && $completion->status != COMPLETION_STATUS_COMPLETEVIARPL) {
    print_icon($incompleteicon);
    return;
}

print_icon($completeicon);
return;

function print_unknowncourse() {
    global $CFG;
    header("HTTP/1.1 303 See Other");
    header("Location: $CFG->wwwroot/filter/coursecompletion/pix/unknown.png");
}

function print_icon($name) {
    $config = get_config('filter_coursecompletion');
    $url = moodle_url::make_pluginfile_url(context_system::instance()->id, 'filter_coursecompletion', $name, 0, '', $config->$name);

    header("HTTP/1.1 303 See Other");
    header("Location: $url");
}
