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


class filter_coursecompletion extends moodle_text_filter {

    public function filter($text, array $options = array()) {
        if (!is_string($text) || empty($text)) {
            return $text;
        }
        // Avoid doing regex if we can get away with it.
        if (strpos($text, '[[course_completion:')) {
            $text = preg_replace_callback('/\[\[course_completion:(.*?)\]\]/', function ($matches) {
                global $CFG;

                $idnumber = clean_param($matches[1], PARAM_TEXT);
                $src = $CFG->wwwroot.'/filter/coursecompletion/statusimg.php?shortname='.urlencode($idnumber);
                $img = '<img src="'.$src.'" />';

                return $img;

            }, $text);
        }
        if (strpos($text, '[[activity_completion:')) {
            $text = preg_replace_callback('/\[\[activity_completion:(.*?)\]\]/', function ($matches) {
                global $CFG;

                $idnumber = clean_param($matches[1], PARAM_TEXT);
                $src = $CFG->wwwroot.'/filter/coursecompletion/activitystatusimg.php?idnumber='.urlencode($idnumber);
                $img = '<img src="'.$src.'" />';

                return $img;

            }, $text);
        }
        if (strpos($text, '[[course_completion2:')) {
            $text = preg_replace_callback('/\[\[course_completion2:(.*?)\]\]/', function ($matches) {
                global $CFG;
                $iconset = 2;
                $idnumber = clean_param($matches[1], PARAM_TEXT);
                $src = $CFG->wwwroot.'/filter/coursecompletion/statusimg.php?shortname='.urlencode($idnumber)
                ."&iconset=".$iconset;
                $img = '<img src="'.$src.'" />';

                return $img;

            }, $text);
        }
        if (strpos($text, '[[activity_completion2:')) {
            $text = preg_replace_callback('/\[\[activity_completion2:(.*?)\]\]/', function ($matches) {
                global $CFG;
                $iconset = 2;
                $idnumber = clean_param($matches[1], PARAM_TEXT);
                $src = $CFG->wwwroot.'/filter/coursecompletion/activitystatusimg.php?idnumber='.urlencode($idnumber)
                ."&iconset=".$iconset;
                $img = '<img src="'.$src.'" />';

                return $img;

            }, $text);
        }        return $text;
    }
}
