<?php

defined('MOODLE_INTERNAL') || die();
global $CFG;
require_once("$CFG->dirroot" . "/lib/navigationlib.php");

/* Export plugin hook to extend the main navigation, see also local/readme.txt */

function local_validator_extends_navigation(global_navigation $nav) {
    /** @var moodle_page */
    global $PAGE;
    global $CFG;

    $right_url = $CFG->wwwroot . '/admin/tool/uploaduser/index.php';
    $validator_url = $CFG->wwwroot . '/admin/tool/uploaduservalidator/index.php';

    $PAGE->requires->data_for_js('need_url', $right_url);
    $PAGE->requires->data_for_js('validator_url', $validator_url);
    $PAGE->requires->data_for_js('val_js_button_text', get_string('val_js_button_text', 'local_validator'));
		$PAGE->requires->js('/local/validator/js/jquery-1.9.1.js');
		$PAGE->requires->js('/local/validator/js/validator.js');
}

function local_validator_extends_settings_navigation($settingsnav, $context) {
}