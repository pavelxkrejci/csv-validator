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
 * Bulk user upload forms
 *
 * @package    tool
 * @subpackage uploaduservalidator
 * @copyright  2007 Dan Poltawski
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

require_once $CFG->libdir.'/formslib.php';


/**
 * Upload a file CVS file with user information.
 *
 * @copyright  2007 Petr Skoda  {@link http://skodak.org}
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class admin_uploaduservalidator_form1 extends moodleform {
    function definition () {
        $mform = $this->_form;

        $mform->addElement('header', 'settingsheader', get_string('upload'));

        $mform->addElement('filepicker', 'userfile', get_string('file'), null, array('accepted_types' => 'csv'));
        $mform->addRule('userfile', null, 'required');

        $choices = csv_import_reader::get_delimiter_list();
        $mform->addElement('select', 'delimiter_name', get_string('csvdelimiter', 'tool_uploaduservalidator'), $choices);
        if (array_key_exists('cfg', $choices)) {
            $mform->setDefault('delimiter_name', 'cfg');
        } else if (get_string('listsep', 'langconfig') == ';') {
            $mform->setDefault('delimiter_name', 'semicolon');
        } else {
            $mform->setDefault('delimiter_name', 'comma');
        }
        
        // Dame na vyber pouze 2 kodovani
        $choices = array('AUTO' => 'Autodetekce', 'UTF-8' => 'UTF-8', 'WINDOWS-1250' => 'WINDOWS-1250');
        
        $mform->addElement('select', 'encoding', get_string('encoding', 'tool_uploaduservalidator'), $choices);
        $mform->setDefault('encoding', 'AUTO');

        $choices = array('AUTO' => 'Autodetekce', '10'=>10, '20'=>20, '100'=>100, '1000'=>1000, '100000'=>100000);
        $mform->addElement('select', 'previewrows', get_string('rowpreviewnum', 'tool_uploaduservalidator'), $choices);
        $mform->setType('previewrows', PARAM_INT);

        // Pridani moznosti validace jednotlivych poli
        
        // Pridani prepinace pro validaci krestniho jmena
        $radioarray=array();
        $radioarray[] =& $mform->createElement('radio', 'rb_firstname', '', get_string('yes'), 1, null);
        $radioarray[] =& $mform->createElement('radio', 'rb_firstname', '', get_string('no'), 0, null);
        $mform->addGroup($radioarray, 'rb_firstname_group', get_string('setting_validate_firstname', 'tool_uploaduservalidator'), array(' '), false);
        $mform->setDefault('rb_firstname', 1);
        
        // Pridani prepinace pro validaci prijmeni
        $radioarray=array();
        $radioarray[] =& $mform->createElement('radio', 'rb_lastname', '', get_string('yes'), 1, null);
        $radioarray[] =& $mform->createElement('radio', 'rb_lastname', '', get_string('no'), 0, null);
        $mform->addGroup($radioarray, 'rb_lastname_group', get_string('setting_validate_lastname', 'tool_uploaduservalidator'), array(' '), false);
        $mform->setDefault('rb_lastname', 1);
        
        // Pridani prepinace pro validaci mesta
        $radioarray=array();
        $radioarray[] =& $mform->createElement('radio', 'rb_city', '', get_string('yes'), 1, null);
        $radioarray[] =& $mform->createElement('radio', 'rb_city', '', get_string('no'), 0, null);
        $mform->addGroup($radioarray, 'rb_city_group', get_string('setting_validate_city', 'tool_uploaduservalidator'), array(' '), false);
        $mform->setDefault('rb_city', 1);
        
        // Pridani prepinace pro zobrazeni vstupniho radku
        $radioarray=array();
        $radioarray[] =& $mform->createElement('radio', 'rb_inputrow', '', get_string('yes'), 1, null);
        $radioarray[] =& $mform->createElement('radio', 'rb_inputrow', '', get_string('no'), 0, null);
        $mform->addGroup($radioarray, 'rb_inputrow_group', get_string('setting_show_inputline', 'tool_uploaduservalidator'), array(' '), false);
        $mform->setDefault('rb_inputrow', 0);
        
        // Pridani prepinace pro zobrazeni pouze chybovych radku
        $radioarray=array();
        $radioarray[] =& $mform->createElement('radio', 'rb_onlyerrors', '', get_string('yes'), 1, null);
        $radioarray[] =& $mform->createElement('radio', 'rb_onlyerrors', '', get_string('no'), 0, null);
        $mform->addGroup($radioarray, 'rb_onlyerrors_group', get_string('setting_show_only_errors', 'tool_uploaduservalidator'), array(' '), false);
        $mform->setDefault('rb_onlyerrors', 0);
        
        // Pridani prepinace pro kontrolu duplicity username
        $radioarray=array();
        $radioarray[] =& $mform->createElement('radio', 'rb_dup_username', '', get_string('yes'), 1, null);
        $radioarray[] =& $mform->createElement('radio', 'rb_dup_username', '', get_string('no'), 0, null);
        $mform->addGroup($radioarray, 'rb_dup_username_group', get_string('setting_duplicate_username', 'tool_uploaduservalidator'), array(' '), false);
        $mform->setDefault('rb_dup_username', 1);
        
        $this->add_action_buttons(false, get_string('uploaduservalidators_btn', 'tool_uploaduservalidator'));
    }
}


/**
 * Specify user upload details
 *
 * @copyright  2007 Petr Skoda  {@link http://skodak.org}
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
