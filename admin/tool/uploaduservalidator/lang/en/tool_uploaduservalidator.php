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
 * Strings for component 'tool_uploaduservalidator', language 'en', branch 'MOODLE_22_STABLE'
 *
 * @package    tool
 * @subpackage uploaduservalidator
 * @copyright  2014 Petr Skoda, PragoData, Pavel Krejci
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
$string['uploaduservalidator:use'] = 'Use validator';
$string['allowdeletes'] = 'Allow deletes';
$string['allowrenames'] = 'Allow renames';
$string['allowsuspends'] = 'Allow suspending and activating of accounts';
$string['csvdelimiter'] = 'CSV delimiter';
$string['defaultvalues'] = 'Default values';
$string['deleteerrors'] = 'Delete errors';
$string['encoding'] = 'Encoding';
$string['errormnetadd'] = 'Can not add remote users';
$string['errors'] = 'Errors';
$string['nochanges'] = 'No changes';
$string['pluginname'] = 'User upload';
$string['pluginname_conf'] = 'Upload users - settings';
$string['renameerrors'] = 'Rename errors';
$string['requiredtemplate'] = 'Required. You may use template syntax here (%l = lastname, %f = firstname, %u = username). See help for details and examples.';
$string['rowpreviewnum'] = 'Preview rows';
$string['uploadpicture_baduserfield'] = 'The user attribute specified is not valid. Please, try again.';
$string['uploadpicture_cannotmovezip'] = 'Cannot move zip file to temporary directory.';
$string['uploadpicture_cannotprocessdir'] = 'Cannot process unzipped files.';
$string['uploadpicture_cannotsave'] = 'Cannot save picture for user {$a}. Check original picture file.';
$string['uploadpicture_cannotunzip'] = 'Cannot unzip pictures file.';
$string['uploadpicture_invalidfilename'] = 'Picture file {$a} has invalid characters in its name. Skipping.';
$string['uploadpicture_overwrite'] = 'Overwrite existing user pictures?';
$string['uploadpicture_userfield'] = 'User attribute to use to match pictures:';
$string['uploadpicture_usernotfound'] = 'User with a \'{$a->userfield}\' value of \'{$a->uservalue}\' does not exist. Skipping.';
$string['uploadpicture_userskipped'] = 'Skipping user {$a} (already has a picture).';
$string['uploadpicture_userupdated'] = 'Picture updated for user {$a}.';
$string['uploadpictures'] = 'Upload user pictures';
$string['uploadpictures_help'] = 'User pictures can be uploaded as a zip file of image files. The image files should be named chosen-user-attribute.extension, for example user1234.jpg for a user with username user1234.';
$string['uploaduservalidators'] = 'CSV Validator';
$string['uploaduservalidators_btn'] = 'Validate';
$string['uploaduservalidators_conf'] = 'CSV Validator - config';
$string['uploaduservalidators_help'] = 'Users may be uploaded (and optionally enrolled in courses) via text file. The format of the file should be as follows:

* Each line of the file contains one record
* Each record is a series of data separated by commas (or other delimiters)
* The first record contains a list of fieldnames defining the format of the rest of the file
* Required fieldnames are username, password, firstname, lastname, email';
$string['uploaduservalidatorspreview'] = 'Upload users preview';
$string['uploaduservalidatorsresult'] = 'Upload users results';
$string['useraccountupdated'] = 'User updated';
$string['useraccountuptodate'] = 'User up-to-date';
$string['userdeleted'] = 'User deleted';
$string['userrenamed'] = 'User renamed';
$string['userscreated'] = 'Users created';
$string['usersdeleted'] = 'Users deleted';
$string['usersrenamed'] = 'Users renamed';
$string['usersskipped'] = 'Users skipped';
$string['usersupdated'] = 'Users updated';
$string['usersweakpassword'] = 'Users having a weak password';
$string['uubulk'] = 'Select for bulk user actions';
$string['uubulkall'] = 'All users';
$string['uubulknew'] = 'New users';
$string['uubulkupdated'] = 'Updated users';
$string['uucsvline'] = 'CSV line';
$string['uulegacy1role'] = '(Original Student) typeN=1';
$string['uulegacy2role'] = '(Original Teacher) typeN=2';
$string['uulegacy3role'] = '(Original Non-editing teacher) typeN=3';
$string['uunoemailduplicates'] = 'Prevent email address duplicates';
$string['uuoptype'] = 'Upload type';
$string['uuoptype_addinc'] = 'Add all, append number to usernames if needed';
$string['uuoptype_addnew'] = 'Add new only, skip existing users';
$string['uuoptype_addupdate'] = 'Add new and update existing users';
$string['uuoptype_update'] = 'Update existing users only';
$string['uupasswordcron'] = 'Generated in cron';
$string['uupasswordnew'] = 'New user password';
$string['uupasswordold'] = 'Existing user password';
$string['uustandardusernames'] = 'Standardise usernames';
$string['uuupdateall'] = 'Override with file and defaults';
$string['uuupdatefromfile'] = 'Override with file';
$string['uuupdatemissing'] = 'Fill in missing from file and defaults';
$string['uuupdatetype'] = 'Existing user details';
$string['uuusernametemplate'] = 'Username template';


$string['wrong_username'] = '<b>Username</b> ({$a}) does not start with numbers 00-99';
$string['wrong_username_profile_field_school'] = 'Value of "profile_field_school" and first 2 numbers from username start not equal';
$string['invalid_email'] = 'Invalid e-mail address';
$string['invalid_username'] = 'Invalid username';
$string['invalid_email_missing_dot'] = 'Missing dot in e-mail - after (@) ';
$string['invalid_email_invalid_chars'] = 'Invalid characters in e-mail';
$string['invalid_username_invalid_chars'] = 'Invalid characters in username';
$string['dupl_email'] = 'Duplicate e-mail address';
$string['dupl_username'] = 'Duplicate username';
$string['course_not_exist'] = 'Course <b><i>{$a->name}</i></b> does not exist';
$string['error_loading_csv'] = '<b>Error loading CSV file</b>';
$string['error_csv_empty'] = '<b>CSV file empty</b>';
$string['error_no_csv_file'] = '<b>!!!!! File not CSV nor text: Current file extension: {$a} !!!!!</b>';

$string['missing_username'] = 'Missing <b>username</b>';
$string['missing_firstname'] = 'Missing <b>firstname</b>';
$string['missing_lastname'] = 'Missing <b>lastname</b>';
$string['missing_city'] = 'Missing <b>city</b>';
$string['wrong_city'] = 'Invalid (Unknown) city name';
$string['missing_email'] = 'Missing <b>e-mail</b>';
$string['missing_role_column'] = 'Missing column <b>role{$a}</b>';
$string['wrong_role_name'] = 'Invalid role name';
$string['missing_column'] = 'Column <b>{$a}</b> has no values';

$string['notice_document_valid'] = 'File is VALID';
$string['notice_show_number_of_lines'] = 'Displayed first {$a->show} lines of total {$a->total} lines';
$string['notice_no_diacrtics'] = 'No national characters detected';
$string['notice_bad_encoding'] = 'File encoding other then UTF-8 or WINDOWS-1250';
$string['notice_auto_encoding'] = 'File encoding auto-detected and set to <b>{$a}</b>';
$string['notice_different_encoding'] = 'You have chosen different or possibly invalid encoding';
$string['notice_col_spaces'] = 'Column <b>{$a}</b> contains redundant space-characters';
$string['notice_col_quot_marks'] = 'Column <b>{$a}</b> contains redundant quotation marks';
$string['notice_col_apostrophe'] = 'Column <b>{$a}</b> contains redundant apostrophes';
$string['notice_col_dots'] = 'Column <b>{$a}</b> contains redundant dots';
$string['notice_col_comma'] = 'Column <b>{$a}</b> contains redundant commas';
$string['notice_col_contains_qouts_apos'] = 'Error : Input file contains quotation marks and/or apostrophes';
$string['notice_col_delimiter'] = 'Column <b>{$a}</b> ends with field delimiter';
$string['notice_bad_delimiter_used'] = '<b>Error : You have chose (possibly wrong) delimiter different from the one detected in CSV file: "{$a}"</b>';
$string['notice_no_csv_file'] = '<b>Error : Not CSV file, no delimiter detected (coma, semicolon, colon, tab)</b>';
$string['notice_not_corr_ended'] = 'Error : Some lines in CSV end with <b>{$a->delimiter_accent}</b> which is delimiter. Specific lines: <b>{$a->line_numbers}</b>';
$string['notice_wrong_number_cols'] = 'Error : Line number <b>{$a}</b> contains wrong number of columns';
$string['notice_bad_col_name'] = 'Error : <b>"{$a}"</b> is invalid column name';
$string['notice_bad_col_name_with_spaces'] = 'Error : Column name <b>"{$a}"</b> contains redundant space characters';

$string['delimiter_accent_comma']='coma';
$string['delimiter_accent_semicolon']='semicolon';
$string['delimiter_accent_colon']='colon';
$string['delimiter_accent_tab']='tab';

$string['button_continue'] = 'Continue to load users';

$string['setting_validate_firstname'] = 'Validate attrib. first name';
$string['setting_validate_lastname'] = 'Validate attrib. last name';
$string['setting_validate_city'] = 'Validate attrib. city';
$string['setting_show_inputline'] = 'Show input lines';
$string['setting_show_only_errors'] = 'Show only lines with errors';
$string['setting_duplicate_username'] = 'Check for duplicate usernames';

$string['config_username_school_validation_name'] = 'Validate usernames to start with number code';
$string['config_username_school_validation_desc'] = 'Check if you want to validate <b>usernames</b> to have starting code numbers same as values in custom <b>profile_field_school</b> (if present in input file)';
$string['config_username_start_number_validation_name'] = 'Username must start with 2 number code';
$string['config_username_start_number_validation_desc'] = 'Check if username must start with number codes 00-99';
$string['config_city_validate_name'] = 'Validate attribute "city"';
$string['config_city_validate_desc'] = 'Choose to validate "city" attribute according to list of city names below';
$string['config_validator_city_list_name'] = 'List of valid city names';
$string['config_validator_city_list_desc'] = 'Enter list of valid city names for validation of field "city"';
$string['config_table_head_repeat_name'] = 'Repeat table header each x lines';
$string['config_table_head_repeat_desc'] = 'Enter number of lines after which the table header will be displayed again. Enter 0 to disable repeated headers.';