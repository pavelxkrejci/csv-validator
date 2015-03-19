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
 * @copyright  2011 Petr Skoda {@link http://skodak.org}
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
$string['uploaduservalidator:use'] = 'Využívat validátor csv souborů pro import';
$string['allowdeletes'] = 'Povolit mazání';
$string['allowrenames'] = 'Povolit přejmenování';
$string['allowsuspends'] = 'Povolit pozastavení a aktivaci účtů';
$string['csvdelimiter'] = 'CSV oddělovač';
$string['defaultvalues'] = 'Výchozí hodnoty';
$string['deleteerrors'] = 'Vymazat chyby';
$string['encoding'] = 'Kódování';
$string['errormnetadd'] = 'Nelze přidat vzdálené uživatele';
$string['errors'] = 'Chyby';
$string['nochanges'] = 'Žádné změny';
$string['pluginname'] = 'Upload uživatelů';
$string['pluginname_conf'] = 'Upload uživatelů - nastavení';
$string['renameerrors'] = 'Přejmenovat chyby';
$string['requiredtemplate'] = 'Required. You may use template syntax here (%l = lastname, %f = firstname, %u = username). See help for details and examples.';
$string['rowpreviewnum'] = 'Zobrazit řádků';
$string['uploadpicture_baduserfield'] = 'Atribut není validní. Prosím, zkuste to znovu';
$string['uploadpicture_cannotmovezip'] = 'ZIP soubor nelze přemístit do dočasného adresáře.';
$string['uploadpicture_cannotprocessdir'] = 'Nelze zpracovat rozbalené soubory.';
$string['uploadpicture_cannotsave'] = 'Nelze uložit obrázek pro uživatele {$a}. Zkontrolujte původní soubor.';
$string['uploadpicture_cannotunzip'] = 'Nelze rozbalit obrázkové soubory.';
$string['uploadpicture_invalidfilename'] = 'Obrázkový soubor {$a} obsahuje nepovolené znaky v jeho názvu. Přeskakuji.';
$string['uploadpicture_overwrite'] = 'Přepsat stávající uživatelské obrázky?';
$string['uploadpicture_userfield'] = 'User attribute to use to match pictures:';
$string['uploadpicture_usernotfound'] = 'User with a \'{$a->userfield}\' value of \'{$a->uservalue}\' does not exist. Skipping.';
$string['uploadpicture_userskipped'] = 'Přeskakuji uživatele {$a} (již má obrázek).';
$string['uploadpicture_userupdated'] = 'Změněn obrázek pro uživatele {$a}.';
$string['uploadpictures'] = 'Nahrát uživatelské obrázky';
$string['uploadpictures_help'] = 'User pictures can be uploaded as a zip file of image files. The image files should be named chosen-user-attribute.extension, for example user1234.jpg for a user with username user1234.';
$string['uploaduservalidators'] = 'CSV Validátor';
$string['uploaduservalidators_btn'] = 'Provést validaci';
$string['uploaduservalidators_conf'] = 'CSV Validátor - nastavení';
$string['uploaduservalidators_help'] = 'Users may be uploaded (and optionally enrolled in courses) via text file. The format of the file should be as follows:

* Each line of the file contains one record
* Each record is a series of data separated by commas (or other delimiters)
* The first record contains a list of fieldnames defining the format of the rest of the file
* Required fieldnames are username, password, firstname, lastname, email';
$string['uploaduservalidatorspreview'] = 'Náhled uploadu uživatelů';
$string['uploaduservalidatorsresult'] = 'Výsledky uploadu uživatelů';
$string['useraccountupdated'] = 'Uživatel změněn';
$string['useraccountuptodate'] = 'Uživatelský účet je zastaralý';
$string['userdeleted'] = 'Uživatel smazán';
$string['userrenamed'] = 'Uživatel přejmenován';
$string['userscreated'] = 'Uživatel vytvořen';
$string['usersdeleted'] = 'Uživatelé smazáni';
$string['usersrenamed'] = 'Uživatelé přejmenováni';
$string['usersskipped'] = 'Uživatelé přeskočeni';
$string['usersupdated'] = 'Uživatelé změněni';
$string['usersweakpassword'] = 'Uživatelé mají slabé heslo';
$string['uubulk'] = 'Select for bulk user actions';
$string['uubulkall'] = 'Všichni uživatelé';
$string['uubulknew'] = 'Noví uživatelé';
$string['uubulkupdated'] = 'Změnění uživatelé';
$string['uucsvline'] = 'CSV řádek';
$string['uulegacy1role'] = '(Original Student) typeN=1';
$string['uulegacy2role'] = '(Original Teacher) typeN=2';
$string['uulegacy3role'] = '(Original Non-editing teacher) typeN=3';
$string['uunoemailduplicates'] = 'Zabránit duplikaci uživatelů';
$string['uuoptype'] = 'Typ uploadu';
$string['uuoptype_addinc'] = 'Add all, append number to usernames if needed';
$string['uuoptype_addnew'] = 'Add new only, skip existing users';
$string['uuoptype_addupdate'] = 'Add new and update existing users';
$string['uuoptype_update'] = 'Upravit pouze existující uživatele';
$string['uupasswordcron'] = 'Generated in cron';
$string['uupasswordnew'] = 'Nové uživatelské heslo';
$string['uupasswordold'] = 'Stávající uživatelské heslo';
$string['uustandardusernames'] = 'Standardizace uživatelských jmen';
$string['uuupdateall'] = 'Override with file and defaults';
$string['uuupdatefromfile'] = 'Override with file';
$string['uuupdatemissing'] = 'Fill in missing from file and defaults';
$string['uuupdatetype'] = 'Existing user details';
$string['uuusernametemplate'] = 'Username template';


$string['wrong_username'] = '<b>Uživatelské jméno</b> ({$a}) nezačíná číslicemi 00-99';
$string['wrong_username_profile_field_school'] = 'Hodnota pole "profile_field_school" a první 2 čísla z uživatelského jména ("username") se nerovnají';
$string['invalid_email'] = 'Neplatná e-mailová adresa';
$string['invalid_username'] = 'Neplatné uživatelské jméno';
$string['invalid_email_missing_dot'] = 'Část za zavináčem (@) musí obsahovat alespoň jednu tečku';
$string['invalid_email_invalid_chars'] = 'Řetězec obsahuje nepovolené znaky';
$string['invalid_username_invalid_chars'] = 'Řetězec obsahuje nepovolené znaky';
$string['dupl_email'] = 'Duplicitní e-mailová adresa';
$string['dupl_username'] = 'Duplicitní uživatelské jméno';
$string['course_not_exist'] = 'Kurz <b><i>{$a->name}</i></b> neexistuje';
$string['error_loading_csv'] = '<b>Chyba při načítání CSV souboru</b>';
$string['error_csv_empty'] = '<b>CSV soubor je prázdný</b>';
$string['error_no_csv_file'] = '<b>!!!!! Soubor není ve formátu CSV ani není textový soubor. Přípona aktuálního souboru je: {$a} !!!!!</b>';

$string['missing_username'] = 'Není vyplněno <b>uživatelské jméno</b>';
$string['missing_firstname'] = 'Není vyplněno <b>křestní jméno</b>';
$string['missing_lastname'] = 'Není vyplněno <b>příjmení</b>';
$string['missing_city'] = 'Není vyplněno <b>město</b>';
$string['wrong_city'] = 'Není platný název obce';
$string['missing_email'] = 'Není vyplněn <b>email</b>';
$string['missing_role_column'] = 'Chybí sloupec <b>role{$a}</b>';
$string['wrong_role_name'] = 'Neplatná role uživatele';
$string['missing_column'] = 'Sloupec <b>{$a}</b> nemá vyplněnu žádnou hodnotu';

$string['notice_document_valid'] = 'Dokument je VALIDNÍ';
$string['notice_show_number_of_lines'] = 'Je zobrazeno prvních {$a->show} řádků z celkového počtu {$a->total} řádků';
$string['notice_no_diacrtics'] = 'Dokument neobsahuje diakritiku!';
$string['notice_bad_encoding'] = 'Kódování dokumentu je jiné než UTF-8 nebo WINDOWS-1250';
$string['notice_auto_encoding'] = 'Kódování dokumentu detekováno a automaticky a nastaveno na <b>{$a}</b>';
$string['notice_different_encoding'] = 'Váni zvolené kódování neodpovídá kódování dokumentu';
$string['notice_col_spaces'] = 'Sloupec <b>{$a}</b> obsahuje nadbytečné mezery';
$string['notice_col_quot_marks'] = 'Sloupec <b>{$a}</b> obsahuje nadbytečné uvozovky';
$string['notice_col_apostrophe'] = 'Sloupec <b>{$a}</b> obsahuje nadbytečné apostrofy';
$string['notice_col_dots'] = 'Sloupec <b>{$a}</b> obsahuje nadbytečné tečky';
$string['notice_col_comma'] = 'Sloupec <b>{$a}</b> obsahuje nadbytečné čárky';
$string['notice_col_contains_qouts_apos'] = 'CHYBA : Vstupní soubor obsahuje uvozovky a/nebo apostrofy';
$string['notice_col_delimiter'] = 'Sloupec <b>{$a}</b> je ukončen oddělovačem pole';
$string['notice_bad_delimiter_used'] = '<b>CHYBA : Vámi zvolený oddělovač pole je odlišný od oddělovače použitého v CSV souboru. Oddělovač použitý v CSV souboru je: "{$a}"</b>';
$string['notice_no_csv_file'] = '<b>CHYBA : Nejedná se o CSV soubor, protože neobsahuje žádný oddělovač (čárka, středník, dvojtečka, tabulátor)</b>';
$string['notice_not_corr_ended'] = 'CHYBA : V CSV souboru jsou některé řádky ukončeny <b>{$a->delimiter_accent}</b> jakožto oddělovačem pole. Konkrétně se jedná o řádky č. <b>{$a->line_numbers}</b>';
$string['notice_wrong_number_cols'] = 'CHYBA : Řádek s číslem <b>{$a}</b> neobsahuje správný počet sloupců';
$string['notice_bad_col_name'] = 'CHYBA : <b>"{$a}"</b> je nepovolený název sloupce';
$string['notice_bad_col_name_with_spaces'] = 'CHYBA : Název sloupce <b>"{$a}"</b> obsahuje nadbytečné mezery';

$string['delimiter_accent_comma']='čárkou';
$string['delimiter_accent_semicolon']='středníkem';
$string['delimiter_accent_colon']='dvojtečkou';
$string['delimiter_accent_tab']='tabulátorem';

$string['button_continue'] = 'Pokračovat k načtení uživatele';

$string['setting_validate_firstname'] = 'Validovat atrib. first name';
$string['setting_validate_lastname'] = 'Validovat atrib. last name';
$string['setting_validate_city'] = 'Validovat atrib. city';
$string['setting_show_inputline'] = 'Zobrazit vstupní řádek';
$string['setting_show_only_errors'] = 'Zobrazit pouze chybové řádky';
$string['setting_duplicate_username'] = 'Kontrolovat duplicitu uživ. jména';

$string['config_username_school_validation_name'] = 'Validovat počáteční dvojčíslí';
$string['config_username_school_validation_desc'] = 'Zvolte, zda validovat počáteční dvoucifernou hodnotu u <b>username</b> proti počáteční dvouciferné hodnotě pole <b>profile_field_school</b> (pokud soubor toto pole obsahuje)';
$string['config_username_start_number_validation_name'] = 'Username musí začínat dvojčíslím';
$string['config_username_start_number_validation_desc'] = 'Zvolte, zda musí uživatelské jméno začínat dvojčíslím 00-99';
$string['config_city_validate_name'] = 'Validovat atribut "city"';
$string['config_city_validate_desc'] = 'Zvolte, zda vylidovat atribut "city" dle níže uvedeného seznamu obcí';
$string['config_validator_city_list_name'] = 'Seznam obcí';
$string['config_validator_city_list_desc'] = 'Vyplňte seznam obcí, které mají být použity při validaci pole "city"';
$string['config_table_head_repeat_name'] = 'Opakovat hlavičku tabulky';
$string['config_table_head_repeat_desc'] = 'Zadejte počet řádků pro opakování hlavičky tabulky. V případě, že zadáte hodnotu 0 , nebude se provádět opakování hlavičky.';