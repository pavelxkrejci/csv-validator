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
 * Bulk user registration script from a comma separated file
 *
 * @package    tool
 * @subpackage uploaduservalidator
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
require('../../../config.php');
require_once($CFG->libdir . '/adminlib.php');
require_once($CFG->libdir . '/csvlib.class.php');
require_once($CFG->dirroot . '/user/profile/lib.php');
require_once($CFG->dirroot . '/group/lib.php');
require_once($CFG->dirroot . '/cohort/lib.php');
require_once('locallib.php');
require_once('user_form.php');

require_once('functionlib.php');

global $CFG;

$iid = optional_param('iid', '', PARAM_INT);
$previewrows = optional_param('previewrows', 10, PARAM_INT);

@set_time_limit(60 * 60); // 1 hour should be enough
raise_memory_limit(MEMORY_HUGE);

require_login();
require_capability('tool/uploaduservalidator:use', context_system::instance());

$PAGE->set_url('/admin/tool/uploaduservalidator/index.php');
$PAGE->set_context(get_system_context());
$PAGE->set_pagelayout('standard');

$PAGE->set_heading(get_string("pluginname", "tool_uploaduservalidator"));
$PAGE->set_title(get_string("pluginname", "tool_uploaduservalidator"));
$PAGE->navbar->add(get_string("pluginname", "tool_uploaduservalidator"));

$returnurl = new moodle_url('/admin/tool/uploaduservalidator/index.php');
$bulknurl = new moodle_url('/admin/user/user_bulk.php');

$today = time();
$today = make_timestamp(date('Y', $today), date('m', $today), date('d', $today), 0, 0, 0);

$notify = array();
echo setTableStyle();

// array of all valid fields for validation
$STD_FIELDS = array('id', 'firstname', 'lastname', 'username', 'email',
    'city', 'country', 'lang', 'timezone', 'mailformat',
    'maildisplay', 'maildigest', 'htmleditor', 'autosubscribe',
    'institution', 'department', 'idnumber', 'skype',
    'msn', 'aim', 'yahoo', 'icq', 'phone1', 'phone2', 'address',
    'url', 'description', 'descriptionformat', 'password',
    'auth', // watch out when changing auth type or using external auth plugins!
    'oldusername', // use when renaming users - this is the original username
    'suspended', // 1 means suspend user account, 0 means activate user account, nothing means keep as is for existing users
    'deleted', // 1 means delete user
    'mnethostid', // Can not be used for adding, updating or deleting of users - only for enrolments, groups, cohorts and suspending.
);

$PRF_FIELDS = array('profile_field_school', 'profile_field_class');

$mform1 = new admin_uploaduservalidator_form1();
$noerror = true; // Keep status of any error.

if ($formdata = $mform1->get_data()) {
    $iid = csv_import_reader::get_new_iid('uploaduservalidator');
    $cir = new csv_import_reader($iid, 'uploaduservalidator');

    $is_csv_file = checkFileExtension($mform1->get_new_filename('userfile'));

    $content = $mform1->get_file_content('userfile');

    // Odstrani Unicode BOM z prvniho radku
    $content = textlib::trim_utf8_bom($content);

    // Info o tom, zda dokument obsahuje / neobsahuje diakritiku + kodovani dokumentu
    $notify[]['notifymessage'] = printEncAndDiaProp($content);

    // Pokud je pocet radku nastaven na AUTODETEKCI, nastavime pocet radku na 1000
    if ($previewrows == 0) {
        $previewrows = 1000;
    }

    $allowed_encoding = array('UTF-8', 'WINDOWS-1250');
    
    // V pripade, ze je zvolena moznost autodetekce, priradi se kodovani dokumentu kodovani zjistene ze souboru
    if ($formdata->encoding == 'AUTO') {
        if (in_array(detectEncoding($content), $allowed_encoding)) {
            $formdata->encoding = detectEncoding($content);
            $notify[]['notifymessage'] = get_string('notice_auto_encoding', 'tool_uploaduservalidator', $formdata->encoding);
        } else {
            $formdata->encoding = 'UTF-8';
            get_string('notice_bad_encoding', 'tool_uploaduservalidator');
        }
    } else {
        if ($formdata->encoding != detectEncoding($content)) {
            $notify[]['notifymessage'] = get_string('notice_different_encoding', 'tool_uploaduservalidator');
        }
    }

    // Info o stavu CSV souboru - jestli obsahuje oddelovace, nebo ma spravne vyplnene nazvy sloupcu
    $is_valid = isCSVFile($content, $formdata->encoding, $formdata->delimiter_name, $STD_FIELDS, $PRF_FIELDS);
    $notify[]['notifyproblem'] = $is_valid;

    $is_valid_cols_count = checkColsCount($content, $formdata->delimiter_name, $formdata->encoding);

    // Pokud neni soubor validni, zkusime pridat chybejici sloupce
    if ($is_valid_cols_count === false) {
        $content = checkColsCount($content, $formdata->delimiter_name, $formdata->encoding, true);
    }

    $readcount = $cir->load_csv_content($content, $formdata->encoding, $formdata->delimiter_name);
    $rows_string_array = getRowsString($content, $formdata->delimiter_name);

    unset($content);

    if ($readcount === false) {
        $notify[]['notifyproblem'] = get_string('error_loading_csv', 'tool_uploaduservalidator');
        $noerror = false;
    } else if ($readcount == 0) {
        $notify[]['notifyproblem'] = get_string('error_csv_empty', 'tool_uploaduservalidator');
        $noerror = false;
    }

    // test if columns ok
    $filecolumns = uu_validate_user_upload_columns($cir, $STD_FIELDS, $PRF_FIELDS, $returnurl);  //nacteni hlavicek
} else {
    echo $OUTPUT->header();

    echo $OUTPUT->heading_with_help(get_string('uploaduservalidators', 'tool_uploaduservalidator'), 'uploaduservalidators', 'tool_uploaduservalidator');

    $mform1->display();
    echo $OUTPUT->footer();
    die;
}

if ($is_csv_file['status'] === false) {
    $redirect_url = new moodle_url('/admin/tool/uploaduservalidator/index.php');
    redirect($redirect_url, get_string('error_no_csv_file', 'tool_uploaduservalidator', $is_csv_file['file_ext']));
}

// Print the header
echo $OUTPUT->header();

echo $OUTPUT->heading(get_string('uploaduservalidatorspreview', 'tool_uploaduservalidator'));

// NOTE: this is JUST csv processing preview, we must not prevent import from here if there is something in the file!!
//       this was intended for validation of csv formatting and encoding, not filtering the data!!!!
//       we definitely must not process the whole file!
// preview table data
$data = array();
$cir->init();
$linenum = 1;                                                                   // column header is first line
$username_school_validation = $CFG->username_school_validation;                 // Validace username - profile_field_school (globalni konfigurace modulu)
$username_start_number_validation = $CFG->username_start_number_validation;     // Validace username - musi zacinat dvojcislim (globalni konfigurace modulu)
$validator_city_validate = $CFG->validator_city_validate;                       // Validace mesta dle seznamu obci
$val_city_list = getCityNameList($CFG->validator_city_list);                    // Pole validovanych mest
$errLinesArr = array();                                                         // Pole s cisly radku s chybama

/* Pole mailu. Pri kontrole kazdeho radku se do nej ulozi email a v pripade, ze dojde k duplicite, zahlasi se chyba */
$mail_arr = array();
$username_arr = array();
$csv_rows = array();

while ($linenum <= $previewrows and $fields = $cir->next()) {
    $linenum++;
    $rowcols = array();
    $rowcols['line'] = $linenum;
    $empty_fields_err = array();

    $csv_rows[$linenum] = array();

    foreach ($fields as $key => $field) {
        if ($filecolumns[$key] == '' && $linenum >= 0) {
            $filecolumns[$key] = str_repeat(' ', $key);
        }

        $rowcols[$filecolumns[$key]] = s($field);

        // vlastni vicerozmerne pole
        $csv_rows[$linenum][$filecolumns[$key]] = '';

        // Pokud je nejaky sloupec prazdny, bude tato skutecnost oznamena
        if ($field == null || $field == '') {
            if (!preg_match('/^course\d+$/', $filecolumns[$key]) && !preg_match('/^role\d+$/', $filecolumns[$key]) && $filecolumns[$key] != 'profile_field_class') {
                $empty_fields_err[] = get_string('missing_column', 'tool_uploaduservalidator', $filecolumns[$key]);
                $csv_rows[$linenum][$filecolumns[$key]] = get_string('missing_column', 'tool_uploaduservalidator', $filecolumns[$key]);
            }
        } else {
            $isCellValueCorrect = checkCellValue($filecolumns[$key], $field, $mform1->get_data()->delimiter_name);
            if ($isCellValueCorrect !== false) {
                $empty_fields_err[] = $isCellValueCorrect;
                $csv_rows[$linenum][$filecolumns[$key]] = $isCellValueCorrect;
            }
        }
    }
    $rowcols['status'] = array();

    foreach ($empty_fields_err as $ef) {
        $rowcols['status'][] = $ef;
    }

    // Zjistime si konfiguraci validace
    $valid_params = $mform1->get_data();

    // Kontrola, zda se jedna o zapis uzivatelu - musi existovat sloupec course1 .. courseN
    foreach ($filecolumns as $col) {
        if (!preg_match('/^course\d+$/', $col)) {
            continue;
        }

        $i = substr($col, 6); // Cislo z promenne courseXX. Napr. course1 vrati 1
        // Pokud chybi nazev kurzu, neni treba jej hledat v databazi
        if ($rowcols['course' . $i] != '') {
            $course_shortname_exist = $DB->get_record('course', array('shortname' => $rowcols['course' . $i]), 'shortname');
        } else {
            $course_shortname_exist = true;
        }

        $errarr = array();

        // Pokud v tabulce course neexistuje kurz se zadanym shortname, vypiseme chybu
        if ($course_shortname_exist === false) {
            $error_string_sn = get_string('course_not_exist', 'tool_uploaduservalidator', array('name' => $rowcols['course' . $i]));
            $rowcols['status'][] = $error_string_sn;
            $errarr[] = $error_string_sn;
        }

        if (!isset($rowcols['role' . $i])) {
            $error_string_r = get_string('missing_role_column', 'tool_uploaduservalidator', $i);
            $rowcols['status'][] = $error_string_r;
            $errarr[] = $error_string_r;
        } else {
            $role_shortname_exist = $DB->get_record('role', array('shortname' => $rowcols['role' . $i]), 'shortname');
            if ($role_shortname_exist === false && $rowcols['course' . $i] != '') {
                $csv_rows[$linenum]['role' . $i] = get_string('wrong_role_name', 'tool_uploaduservalidator');
            }
        }

        $csv_rows[$linenum]['course' . $i] = implode('<hr />', $errarr);
    }

    // Kontrola, zda je vyplneno uzivatelske jmeno
    if (empty($rowcols['username'])) {
        $rowcols['status'][] = get_string('missing_username', 'tool_uploaduservalidator');
        $csv_rows[$linenum]['username'] = get_string('missing_username', 'tool_uploaduservalidator');
    } else {
        // Kontrola, zda username neobsahuje nepovolene znaky
        $username_errors = checkUsernameErrors($rowcols['username']);

        // Pokud obsahuje, vypiseme seznam chyb
        if ($username_errors['status'] === false) {
            $rowcols['username'] = $username_errors['string'];
            array_unshift($username_errors['error_array'], get_string('invalid_username', 'tool_uploaduservalidator'));
            $csv_rows[$linenum]['username'] = implode('<hr />', $username_errors['error_array']);
        } else {
            if ($username_start_number_validation == 'true' || $username_school_validation == 'true') {
                $pattern = '/^\d{2}[^0-9][A-Za-z0-9_]+/';
                if (!preg_match($pattern, $rowcols['username'])) {
                    $rowcols['status'][] = get_string('wrong_username', 'tool_uploaduservalidator', $rowcols['username']);
                    $csv_rows[$linenum]['username'] = get_string('wrong_username', 'tool_uploaduservalidator', $rowcols['username']);
                } else {
                    if ($username_school_validation == 'true' && !empty($rowcols['profile_field_school'])) {
                        $username_number_prefix = substr($rowcols['username'], 0, 2);
                        if ($username_number_prefix != $rowcols['profile_field_school']) {
                            $rowcols['status'][] = get_string('wrong_username_profile_field_school', 'tool_uploaduservalidator');
                            $csv_rows[$linenum]['username'] = get_string('wrong_username_profile_field_school', 'tool_uploaduservalidator');
                        }
                    }
                }
            }
            
            // Kontrola duplicity uzivatelskeho jmena
            if ($valid_params->rb_dup_username == 1) {
                if (in_array($rowcols['username'], $username_arr)) {
                    $rowcols['status'][] = get_string('dupl_username', 'tool_uploaduservalidator');
                    $csv_rows[$linenum]['username'] = get_string('dupl_username', 'tool_uploaduservalidator');
                } else {
                    $username_arr[] = $rowcols['username'];
                }
            }
        }
    }

    // Validace krestniho jmena
    if ($valid_params->rb_firstname == 1) {
        if (empty($rowcols['firstname'])) {
            $rowcols['status'][] = get_string('missing_firstname', 'tool_uploaduservalidator');
            $csv_rows[$linenum]['firstname'] = get_string('missing_firstname', 'tool_uploaduservalidator');
        }
    }

    // Validace prijmeni
    if ($valid_params->rb_lastname == 1) {
        if (empty($rowcols['lastname'])) {
            $rowcols['status'][] = get_string('missing_lastname', 'tool_uploaduservalidator');
            $csv_rows[$linenum]['lastname'] = get_string('missing_lastname', 'tool_uploaduservalidator');
        }
    }

    // Validace mesta
    if ($valid_params->rb_city == 1) {
        if (empty($rowcols['city'])) {
            $rowcols['status'][] = get_string('missing_city', 'tool_uploaduservalidator');
            $csv_rows[$linenum]['city'] = get_string('missing_city', 'tool_uploaduservalidator');
        }
    }

    // Pokud je zapla validace podle seznamu obci, zkontrolujeme si hodnoty v poli
    if ($validator_city_validate == 'true' && !empty($rowcols['city'])) {
        $is_valid_city_name = checkCityName(trim($rowcols['city']), $val_city_list);

        if ($is_valid_city_name === false) {
            $csv_rows[$linenum]['city'] = get_string('wrong_city', 'tool_uploaduservalidator');
        }
    }

    // Kontrola zda a jak je vyplnen email a zda neni v danem souboru duplicitni
    if (isset($rowcols['email'])) {
        $email_pattern = '#^[-!\#$%&\'*+\\/0-9=?A-Z^_`a-z{|}~]+' . '(\.[-!\#$%&\'*+\\/0-9=?A-Z^_`a-z{|}~]+)*' . '@' . '[-!\#$%&\'*+\\/0-9=?A-Z^_`a-z{|}~]+\.' . '[-!\#$%&\'*+\\./0-9=?A-Z^_`a-z{|}~]+$#';

        if (empty($rowcols['email'])) {
            $rowcols['status'][] = get_string('missing_email', 'tool_uploaduservalidator');
            $csv_rows[$linenum]['email'] = get_string('missing_email', 'tool_uploaduservalidator');
        } else {
            if (!preg_match($email_pattern, $rowcols['email'])) {

                // Kontrola, zda email neobsahuje nepovolene znaky
                $mail_errors = checkMailErrors($rowcols['email']);

                // Pokud obsahuje, vypiseme seznam chyb
                if ($mail_errors['status'] === false) {
                    $rowcols['email'] = $mail_errors['string'];
                    array_unshift($mail_errors['error_array'], get_string('invalid_email', 'tool_uploaduservalidator'));
                    $csv_rows[$linenum]['email'] = implode('<hr />', $mail_errors['error_array']);
                } else {
                    $rowcols['status'][] = get_string('invalid_email', 'tool_uploaduservalidator');
                    $csv_rows[$linenum]['email'] = get_string('invalid_email', 'tool_uploaduservalidator');
                }
            } else {
                if (in_array($rowcols['email'], $mail_arr)) {
                    $rowcols['status'][] = get_string('dupl_email', 'tool_uploaduservalidator');
                    $csv_rows[$linenum]['email'] = get_string('dupl_email', 'tool_uploaduservalidator');
                } else {
                    $mail_arr[] = $rowcols['email'];
                }
            }
        }
    }

    if (isset($rowcols['email'])) {
        if ($DB->record_exists('user', array('email' => $rowcols['email']))) {
            $rowcols['status'][] = get_string('dupl_email', 'tool_uploaduservalidator');
            $csv_rows[$linenum]['email'] = get_string('dupl_email', 'tool_uploaduservalidator');
        }
    }

    if (isset($rowcols['city'])) {
        $rowcols['city'] = trim($rowcols['city']);
        if (empty($rowcols['city'])) {
            $rowcols['status'][] = get_string('fieldrequired', 'error', 'city');
            $csv_rows[$linenum]['city'] = get_string('fieldrequired', 'error', 'city');
        }
    }
    // Check if rowcols have custom profile field with correct data and update error state.
    $noerror = uu_check_custom_profile_data($rowcols) && $noerror;

    unset($rowcols['status']);
    $data[] = $rowcols;
}

$noerror = hasNoErrors($csv_rows, $is_valid);

// Pokud se jedna o CSV soubor, vypise se seznam notifikaci
if ($is_csv_file['status'] === true) {
    echo '<div class="notify_container">';
    if (isset($notify)) {
        foreach ($notify as $not) {
            foreach ($not as $key => $n) {
                if ($n !== '') {
                    echo $OUTPUT->notification($n, $key);
                }
            }
        }
    }

    if ($fields = $cir->next()) {
        echo $OUTPUT->notification(get_string('notice_show_number_of_lines', 'tool_uploaduservalidator', array('show' => $previewrows, 'total' => (count($rows_string_array) - 1))), 'notifymessage');
    }

    if ($noerror && $readcount != false) {
        echo $OUTPUT->notification(get_string('notice_document_valid', 'tool_uploaduservalidator'), 'notifysuccess');
    }
    echo '</div>';
} else {
    // Pokud se nejedna o CSV soubor, vypise se chybove hlaseni
    echo $OUTPUT->notification(get_string('error_no_csv_file', 'tool_uploaduservalidator', $is_csv_file['file_ext']));
}

$cir->close();

$table = new html_table();
$table->id = "uupreview";
$table->attributes['class'] = 'generaltable';
$table->tablealign = 'center';
$table->summary = get_string('uploaduservalidatorspreview', 'tool_uploaduservalidator');
$table->head = array();
$table->data = $data;

$table->head[] = get_string('uucsvline', 'tool_uploaduservalidator');
foreach ($filecolumns as $column) {
    $table->head[] = $column;
}

// Vlastni vykresleni tabulky
// Pokud se jedna o CSV soubor, vykresli se tabulka
if ($is_csv_file['status'] === true) {
    echo generateReportTable($data, $table, $csv_rows);
}

// Pokud je vse v poradku, zobrazi se odkaz pro pokracovani
if ($noerror) {
    $link = new moodle_url('/admin/tool/uploaduser/index.php');
    echo html_writer::tag('div', html_writer::link($link, get_string('button_continue', 'tool_uploaduservalidator'), array()), array('style' => 'text-align: center; margin-top: 15px;'));
}

echo $OUTPUT->footer();
die;