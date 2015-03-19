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
 * Link to CSV user upload
 *
 * @package    tool
 * @subpackage uploaduservalidator
 * @copyright  2010 Petr Skoda {@link http://skodak.org}
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
defined('MOODLE_INTERNAL') || die;

$ADMIN->add('accounts', new admin_externalpage('tooluploaduservalidator', get_string('uploaduservalidators', 'tool_uploaduservalidator'), "$CFG->wwwroot/$CFG->admin/tool/uploaduservalidator/index.php"));

if ($hassiteconfig) {
    $settings = new admin_settingpage('tool_uploaduservalidator', get_string('uploaduservalidators_conf', 'tool_uploaduservalidator'));
    $ADMIN->add('accounts', $settings);

    $settings->add(new admin_setting_configcheckbox('username_school_validation', get_string('config_username_school_validation_name', 'tool_uploaduservalidator'), get_string('config_username_school_validation_desc', 'tool_uploaduservalidator'), 'false', 'true', 'false'));
    $settings->add(new admin_setting_configcheckbox('username_start_number_validation', get_string('config_username_start_number_validation_name', 'tool_uploaduservalidator'), get_string('config_username_start_number_validation_desc', 'tool_uploaduservalidator'), 'false', 'true', 'false'));
    $settings->add(new admin_setting_configcheckbox('validator_city_validate', get_string('config_city_validate_name', 'tool_uploaduservalidator'), get_string('config_city_validate_desc', 'tool_uploaduservalidator'), 'false', 'true', 'false'));
    $settings->add(new admin_setting_configtextarea('validator_city_list', get_string('config_validator_city_list_name', 'tool_uploaduservalidator'), get_string('config_validator_city_list_desc', 'tool_uploaduservalidator'), ''));
    
    $settings->add(new admin_setting_configtext('table_head_repeat', get_string('config_table_head_repeat_name', 'tool_uploaduservalidator'), get_string('config_table_head_repeat_desc', 'tool_uploaduservalidator'), '25'));
}
