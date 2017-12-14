<?php

defined('MOODLE_INTERNAL') || die;

if ($ADMIN->fulltree) {

    // Icon for complete courses
    $name = 'filter_coursecompletion/completeicon';
    $title = new lang_string('completeicon', 'filter_coursecompletion');
    $description = new lang_string('completeicon_desc', 'filter_coursecompletion');
    $setting = new admin_setting_configstoredfile($name, $title, $description, 'completeicon');
    $settings->add($setting);

    // Icon for inprogress courses
    $name = 'filter_coursecompletion/inprogressicon';
    $title = new lang_string('inprogressicon', 'filter_coursecompletion');
    $description = new lang_string('inprogressicon_desc', 'filter_coursecompletion');
    $setting = new admin_setting_configstoredfile($name, $title, $description, 'inprogressicon');
    $settings->add($setting);


    // Icon for incomplete courses
    $name = 'filter_coursecompletion/incompleteicon';
    $title = new lang_string('incompleteicon', 'filter_coursecompletion');
    $description = new lang_string('incompleteicon_desc', 'filter_coursecompletion');
    $setting = new admin_setting_configstoredfile($name, $title, $description, 'incompleteicon');
    $settings->add($setting);

    // Icon for complete activities
    $name = 'filter_coursecompletion/completeacticon';
    $title = new lang_string('completeacticon', 'filter_coursecompletion');
    $description = new lang_string('completeacticon_desc', 'filter_coursecompletion');
    $setting = new admin_setting_configstoredfile($name, $title, $description, 'completeacticon');
    $settings->add($setting);

    // Icon for complete - failed activities
    $name = 'filter_coursecompletion/completefailacticon';
    $title = new lang_string('completefailacticon', 'filter_coursecompletion');
    $description = new lang_string('completefailacticon_desc', 'filter_coursecompletion');
    $setting = new admin_setting_configstoredfile($name, $title, $description, 'completefailacticon');
    $settings->add($setting);


    // Icon for incomplete activity
    $name = 'filter_coursecompletion/incompleteacticon';
    $title = new lang_string('incompleteacticon', 'filter_coursecompletion');
    $description = new lang_string('incompleteacticon_desc', 'filter_coursecompletion');
    $setting = new admin_setting_configstoredfile($name, $title, $description, 'incompleteacticon');
    $settings->add($setting);

}
