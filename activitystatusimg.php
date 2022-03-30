<?php
define('NO_DEBUG_DISPLAY', true);
require(dirname(__FILE__).'/../../config.php');
require_once($CFG->dirroot.'/lib/completionlib.php');

$idnumber = required_param('idnumber', PARAM_TEXT);
$iconset = optional_param('iconset', '', PARAM_TEXT);

$completeacticon = 'completeacticon'.$iconset;
$incompleteacticon = 'incompleteacticon'.$iconset;
$completefailacticon = 'completefailacticon'.$iconset;

// Default to incomplete state for anonymous users.
if (!isloggedin()) {
    print_icon($incompleteacticon);
    return;
}

// If the course module can't be identified return an image saying so.
$moduleid = $DB->get_field('course_modules', 'id', array('idnumber' => $idnumber));

if (empty($moduleid)) {
    print_unknownactivity();
    return;
}

// Check completion status and print complete/incomplete icon.
$completion = $DB->get_record('course_modules_completion', array('coursemoduleid' => $moduleid, 'userid' => $USER->id));
// Incomplete if no completion.
if (empty($completion)) {
    print_icon($incompleteacticon);
    return;
}

// Three types of possible completion.
if ($completion->completionstate == COMPLETION_COMPLETE || $completion->completionstate == COMPLETION_COMPLETE_RPL || $completion->completionstate == COMPLETION_COMPLETE_PASS) {
    print_icon($completeacticon);
    return;
}
// One type of fail action.
if ($completion->completionstate == COMPLETION_COMPLETE_FAIL) {
    print_icon($completefailacticon);
    return;
}

print_icon($incompleteacticon);
return;

function print_unknownactivity() {
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
