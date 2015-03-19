<?php

defined('MOODLE_INTERNAL') || die();

/**
 * Kontrola win-1250
 * 
 * @param string $s
 * @return boolean
 */
function verify1250cs($s) {
    return !(preg_match('#[\x0E-\x1F\x3C-\x3E\x5E\x60\x7B-\x81\x86-\x89\x8B\x8F-\x95\x98\x99\x9B\x9F-\xBD\xBF\xC0\xC6\xC7\xCA\xCE\xD0\xD7\xDE\xDF\xE7\xEA\xEE\xF0\xF1\xF7]#', $s));
}

/**
 * Kontrola UTF-8
 * 
 * @param string $s
 * @return boolean
 */
function verifyUTF8($s) {
    return verify1250cs(iconv('UTF-8', 'Windows-1250//IGNORE', $s));
}

/**
 * Vrati kodovani retezce
 * 
 * @staticvar array $list
 * @param string $string
 * @return boolean
 */
function detectStringEncoding($string) {
    static $list = array('ASCII//IGNORE', 'UTF-8//IGNORE', 'Windows-1250//IGNORE');

    foreach ($list as $item) {
        $sample = @iconv($item, $item, $string);
        if ($sample && (md5($sample) == md5($string))) {
            return $item;
        }
    }
    return false;
}

/**
 * Funkce pro detekci kodovani
 * 
 * @param string $s
 * @return string
 */
function detectEncoding($s) {
    $enc = detectStringEncoding($s);
    $return_encoding = "UNSUPORTED";

    if ($enc) {
        switch ($enc) {
            case 'Windows-1250//IGNORE': {
                    if (verify1250cs($s)) {
                        $return_encoding = strtoupper(rtrim($enc, "//IGNORE"));
                    }
                    break;
                }
            case 'UTF-8//IGNORE': {
                    if (verifyUTF8($s)) {
                        $return_encoding = strtoupper(rtrim($enc, "//IGNORE"));
                    }
                    break;
                }
            case 'ASCII//IGNORE': {
                    $return_encoding = "ASCII";
                    break;
                }
            default: {
                    $return_encoding = rtrim($enc, "//IGNORE");
                }
        }
    }

    return $return_encoding;
}

/**
 * Prevod cehokoliv na UTF-8
 * 
 * @param string $s
 * @return string
 */
function autoUTF($s) {
    // detect UTF-8
    if (preg_match('//u', $s))
        return $s;

    // detect WINDOWS-1250
    if (preg_match('#[\x7F-\x9F\xBC]#', $s))
        return iconv('WINDOWS-1250', 'UTF-8', $s);

    // assume ISO-8859-2
    return iconv('ISO-8859-2', 'UTF-8', $s);
}

// WINDOWS-1250 to ASCII for diacritic chars 
function cs_win2ascii($s) {
    return strtr($s, "\xe1\xe4\xe8\xef\xe9\xec\xed\xbe\xe5\xf2\xf3\xf6\xf5\xf4\xf8\xe0\x9a\x9d\xfa\xf9\xfc\xfb\xfd\x9e\xc1\xc4\xc8\xcf\xc9\xcc\xcd\xbc\xc5\xd2\xd3\xd6\xd5\xd4\xd8\xc0\x8a\x8d\xda\xd9\xdc\xdb\xdd\x8e", "aacdeeillnoooorrstuuuuyzAACDEEILLNOOOORRSTUUUUYZ");
}

// ISO-8859-2 to ASCII for diacritic chars 
function cs_iso2ascii($s) {
    return strtr($s, "\xe1\xe4\xe8\xef\xe9\xec\xed\xb5\xe5\xf2\xf3\xf6\xf5\xf4\xf8\xe0\xb9\xbb\xfa\xf9\xfc\xfb\xfd\xbe\xc1\xc4\xc8\xcf\xc9\xcc\xcd\xa5\xc5\xd2\xd3\xd6\xd5\xd4\xd8\xc0\xa9\xab\xda\xd9\xdc\xdb\xdd\xae", "aacdeeillnoooorrstuuuuyzAACDEEILLNOOOORRSTUUUUYZ");
}

// UTF-8 to ASCII for diacritic chars 
function cs_utf2ascii($s) {
    static $tbl = array("\xc3\xa1" => "a", "\xc3\xa4" => "a", "\xc4\x8d" => "c", "\xc4\x8f" => "d", "\xc3\xa9" => "e", "\xc4\x9b" => "e", "\xc3\xad" => "i", "\xc4\xbe" => "l", "\xc4\xba" => "l", "\xc5\x88" => "n", "\xc3\xb3" => "o", "\xc3\xb6" => "o", "\xc5\x91" => "o", "\xc3\xb4" => "o", "\xc5\x99" => "r", "\xc5\x95" => "r", "\xc5\xa1" => "s", "\xc5\xa5" => "t", "\xc3\xba" => "u", "\xc5\xaf" => "u", "\xc3\xbc" => "u", "\xc5\xb1" => "u", "\xc3\xbd" => "y", "\xc5\xbe" => "z", "\xc3\x81" => "A", "\xc3\x84" => "A", "\xc4\x8c" => "C", "\xc4\x8e" => "D", "\xc3\x89" => "E", "\xc4\x9a" => "E", "\xc3\x8d" => "I", "\xc4\xbd" => "L", "\xc4\xb9" => "L", "\xc5\x87" => "N", "\xc3\x93" => "O", "\xc3\x96" => "O", "\xc5\x90" => "O", "\xc3\x94" => "O", "\xc5\x98" => "R", "\xc5\x94" => "R", "\xc5\xa0" => "S", "\xc5\xa4" => "T", "\xc3\x9a" => "U", "\xc5\xae" => "U", "\xc3\x9c" => "U", "\xc5\xb0" => "U", "\xc3\x9d" => "Y", "\xc5\xbd" => "Z");
    return strtr($s, $tbl);
}

/**
 * Odstraneni diakritiky
 * 
 * @param string $s
 * @return string
 */
function noDia($s) {
    // detect UTF-8
    if (preg_match('#[\x80-\x{1FF}\x{2000}-\x{3FFF}]#u', $s))
        return cs_utf2ascii($s);

    // detect WINDOWS-1250
    if (preg_match('#[\x7F-\x9F\xBC]#', $s))
        return cs_win2ascii($s);

    // assume ISO-8859-2
    return cs_iso2ascii($s);
}

/**
 * Funkce, ktera vrati informace o stavu diakritiky 
 * a v pripade znakove sady odlisne od UTF-8, nebo CP1250 take informaci o jine znakove sade
 * 
 * @param string $input_string
 * @return string
 */
function printEncAndDiaProp($input_string) {
    $ret = array();

    if (noDia($input_string) === $input_string) {
        $ret[] = get_string('notice_no_diacrtics', 'tool_uploaduservalidator');
    }

    $encoding = detectEncoding($input_string);
    if ($encoding !== 'UTF-8' && $encoding !== 'WINDOWS-1250') {
        $ret[] = get_string('notice_bad_encoding', 'tool_uploaduservalidator');
    }

    $arr = implode('<br />', $ret);
    return trim($arr);
}

/**
 * Funkce, ktera zjisti oddelovac
 * 
 * @param string $formdata_delimiter
 * @return string
 */
function getDelimiterChar($formdata_delimiter) {
    switch ($formdata_delimiter) {
        case 'comma':
            $delimiter = ',';
            break;
        case 'semicolon':
            $delimiter = ';';
            break;
        case 'colon':
            $delimiter = ':';
            break;
        case 'tab':
            $delimiter = '\t';
            break;
        default:
            $delimiter = ';';
            break;
    }

    return $delimiter;
}

/**
 * Funkce, ktera zjisti, zda jsou radky korektne ukoncene
 * 
 * @param string $content
 * @param string $formdata_delimiter
 * @return boolean
 */
function isLineCorrectlyEnded($content, $formdata_delimiter) {
    // Do pole se ulozi jednotlive radky CSV souboru. Bude potreba pro detekci koncovych znaku radku
    $csv_lines = explode(PHP_EOL, $content);
    $csv_correct_line_end = array('status' => true, 'line_num' => 0);

    $head_cols_exploded = explode(getDelimiterChar($formdata_delimiter), $csv_lines[0]);
    $head_col_count = count($head_cols_exploded);
    $error_lines_nr = array();

    // Projde kazdy radek CSVcka a zjisti, zda nekonci nejakym z oddelovacu
    foreach ($csv_lines as $key => $l) {
        $delimiter = getDelimiterChar($formdata_delimiter);

        if ($l != '') {
            $line_explode = explode($delimiter, $l);
            if (isset($line_explode[$head_col_count - 1]) && $line_explode[$head_col_count - 1] == '') {
                $csv_correct_line_end['status'] = false;
                $error_lines_nr[] = $key + 1;
            }
        }
    }

    $csv_correct_line_end['line_num'] = implode(', ', $error_lines_nr);

    return $csv_correct_line_end;
}

/**
 * Vrati pole s radky CSVcka
 * 
 * @param string $content
 * @param string $formdata_delimiter
 * @return array
 */
function getRowsString($content, $formdata_delimiter) {
    $csv_lines = explode(PHP_EOL, $content);
    return $csv_lines;
}

/**
 * Kontrola hodnoty bunky tabulky
 * 
 * @param string $cell_name
 * @param string $cell_value
 * @param string $delimiter
 * @return boolean / array
 */
function checkCellValue($cell_name, $cell_value, $delimiter) {
    $delim = getDelimiterChar($delimiter);
    $first_char = mb_substr($cell_value, 0, 1);
    $last_char = mb_substr($cell_value, strlen($cell_value) - 1);
    $result = array();

    // Test na mezery
    if ($first_char == ' ' || $last_char == ' ') {
        $result[] = get_string('notice_col_spaces', 'tool_uploaduservalidator', $cell_name);
    }

    // Test na uvozovky
    if ($first_char == '"' || $last_char == '"') {
        $result[] = get_string('notice_col_quot_marks', 'tool_uploaduservalidator', $cell_name);
    }

    // Test na apostrofy
    if ($first_char == '\'' || $last_char == '\'') {
        $result[] = get_string('notice_col_apostrophe', 'tool_uploaduservalidator', $cell_name);
    }

    // Test na tecky
    if ($first_char == '.' || $last_char == '.') {
        $result[] = get_string('notice_col_dots', 'tool_uploaduservalidator', $cell_name);
    }

    // Test na carky (pokud carky nejsou zaroven oddelovacem pole)
    if (($first_char == ',' && $delim != ',') || ($last_char == ',' && $delim != ',')) {
        $result[] = get_string('notice_col_comma', 'tool_uploaduservalidator', $cell_name);
    }

    // Test na oddelovace pole
    if ($first_char == $delim || $last_char == $delim) {
        $result[] = get_string('notice_col_delimiter', 'tool_uploaduservalidator', $cell_name);
    }

    ($result == null) ? $result = false : $result = implode(', ', $result);

    return $result;
}

/**
 * INCLUDE stylu pro chybne radky tabulky
 * 
 * @return string
 */
function setTableStyle() {
    $res = '';
    $res .= '<style type="text/css">';
    $res .= '.generaltable .cell { line-height: 15px; padding: 0px !important; }';
    $res .= '.notify_container { width: 450px; margin: 0px auto; text-align: left; }';
    $res .= '.notifysuccess, .notifyproblem, .notifymessage { text-align: left !important; padding: 10px !important }';
    $res .= '.dtable_cell { max-height: 60px; padding: 0.5em; overflow: hidden; }';
    $res .= '</style>';

    return $res;
}

/**
 * Funkce, ktera zjisti, zda se jedna o CSV soubor
 * 
 * @param string $content
 * @param string $encoding
 * @param string $delimiter_name
 * @param array $column_names
 * @param array $profile_column_names
 * @return string
 */
function isCSVFile($content, $encoding, $delimiter_name, $column_names, $profile_column_names) {
    $content = textlib::convert($content, $encoding, 'utf-8');
    $delimiter = getDelimiterChar($delimiter_name);
    $cols = array_merge($column_names, $profile_column_names);
    $lines = array();
    $errors = array();

    // Kontrola, zda soubor obsahuje nejaky z oddelovacu Moodlu
    $moodle_delimiters = array(',', ';', ':', '\t');
    $has_moodle_delimiter = array('status' => false, 'used_delimiter' => '');
    foreach ($moodle_delimiters as $md) {
        if (mb_strpos($content, $md)) {
            $has_moodle_delimiter['status'] = true;
            $has_moodle_delimiter['used_delimiter'] = $md;
        }
    }

    // Kontrola, zda soubor obsahuje uzivatelsky definovany oddelovac
    $has_delimiter = mb_strpos($content, $delimiter);
    $content = preg_replace('!\r\n?!', "\n", $content);
    $content_lines_array = explode(PHP_EOL, $content);
    $is_correctly_ended = isLineCorrectlyEnded($content, $delimiter);

    if ($has_delimiter === false) {
        if ($has_moodle_delimiter['status'] === true) {
            $errors[] = get_string('notice_bad_delimiter_used', 'tool_uploaduservalidator', $has_moodle_delimiter['used_delimiter']);
        } else {
            $errors[] = get_string('notice_no_csv_file', 'tool_uploaduservalidator');
        }
    } else {
        if ($is_correctly_ended['status'] === false) {
            $delimiter_accent = get_string('delimiter_accent_' . strtolower($delimiter_name), 'tool_uploaduservalidator');
            $errors[] = get_string('notice_not_corr_ended', 'tool_uploaduservalidator', array('delimiter_accent' => $delimiter_accent, 'line_numbers' => $is_correctly_ended['line_num']));
        }
    }

    if ($has_delimiter !== false && !empty($content_lines_array)) {
        $line_number = 0;
        $error_lines_numbers = array();
        $apos_and_quots = false;

        foreach ($content_lines_array as $cla) {
            $curr_line = str_getcsv($cla, $delimiter); // Rozparsovani CSV retezce
            $lines[] = $curr_line;

            $line_number++;

            // Pokud je pocet sloupcu aktualniho radku mensi nez pocet sloupcu hlavicky, jedna se o chybu
            if ((count($curr_line) < count($lines[0])) && $curr_line !== array(null)) {
                $error_lines_numbers[] = $line_number;
            }

            // Pokud radek obsahuje apostrof, nebo uvozovku -> nastavime promennou $apos_and_quots na TRUE
            if (strpos($cla, '\'') !== false || strpos($cla, '"') !== false) {
                $apos_and_quots = true;
            }
        }

        // Pokud jsou nejake chybne radky, vypiseme chybu
        if ($error_lines_numbers != null) {
            $errors[] = get_string('notice_wrong_number_cols', 'tool_uploaduservalidator', implode(', ', $error_lines_numbers));
        }

        // Pokud soubor obsahuje apostrof, nebo uvozovku, vypiseme chybu
        if ($apos_and_quots === true) {
            $errors[] = get_string('notice_col_contains_qouts_apos', 'tool_uploaduservalidator');
        }

        // Hlavicky
        foreach ($lines[0] as $lin_0) {
            $first_char = mb_substr($lin_0, 0, 1);
            $last_char = mb_substr($lin_0, strlen($lin_0) - 1);

//            if (!in_array(strtolower($lin_0), $cols) && !preg_match('/^(cohort|course|group|type|role|enrolperiod)\d+$/', strtolower($lin_0)) && $is_correctly_ended['status'] === true) {
            if (!in_array(strtolower($lin_0), $cols) && !preg_match('/^(cohort|course|group|type|role|enrolperiod)\d+$/', strtolower($lin_0))) {
                $errors[] = get_string('notice_bad_col_name', 'tool_uploaduservalidator', $lin_0);
            }

            if ($first_char == ' ' || $last_char == ' ') {
                $errors[] = get_string('notice_bad_col_name_with_spaces', 'tool_uploaduservalidator', $lin_0);
            }
        }
    }

    return implode('<br />', $errors);
}

/**
 * Funkce, ktera kontroluje pocty sloupcu a pokud nejake chybi, muze je doplnit
 * 
 * @param string $content
 * @param string $delimiter_name
 * @param string $encoding
 * @param boolean $fill_empty
 * @return boolean
 */
function checkColsCount($content, $delimiter_name, $encoding = null, $fill_empty = null) {
    $delimiter = getDelimiterChar($delimiter_name);
    $content = preg_replace('!\r\n?!', "\n", $content);
    $cont_list_arr = explode(PHP_EOL, $content);
    $line_number = 0;
    $is_valid = true;

    foreach ($cont_list_arr as $cla) {
        $curr_line = str_getcsv($cla, $delimiter); // Rozparsovani CSV retezce
        $lines[] = $curr_line;

        $line_number++;

        // Pokud je pocet sloupcu aktualniho radku mensi nez pocet sloupcu hlavicky, jedna se sice o chybu, ale v ramci zobrazeni pridame chybejici sloupce
        if ((count($curr_line) < count($lines[0])) && $curr_line !== array(null)) {
            $count = count($lines[0]) - count($curr_line);
            $cont_list_arr[$line_number - 1] .= str_repeat($delimiter, $count);
            $is_valid = false;
        }
    }

    $return_value = implode(PHP_EOL, $cont_list_arr);

    if ($fill_empty == null) {
        $return_value = $is_valid;
    }

    return $return_value;
}

/**
 * Funkce, ktera vygeneruje tabulku vypisu
 * 
 * @global object $valid_params
 * @global array $rows_string_array
 * @param array $data
 * @param object $table
 * @param array $csv_rows
 * @return string
 */
function generateReportTable($data, $table, $csv_rows) {
    global $valid_params;
    global $rows_string_array;
    global $CFG;

    $return_string = '';
    $t_class = $table->attributes['class'];
    $t_align = 'boxalign' . $table->tablealign;

    $return_string .= '<div class="flexible-wrap" style="overflow-x: auto">';
    $return_string .= '<table class="' . $t_class . ' ' . $t_align . '" id="' . $table->id . '" summary="' . $table->summary . '" style="margin-bottom: 0px !important;">';

    // ↓ hlavicka tabulky
    $table_head = '';
    $table_head .= '<thead><tr>';
    foreach ($table->head as $key => $t_head) {
        $table_head .= '<th class="header c' . $key . '" scope="col">' . $t_head . '</th>';
    }
    $table_head .= '</tr></thead>';

    $return_string .= $table_head;
    // ↑ hlavicka tabulky
    // ↓ telo tabulky
    $lines_count = 0;
    $return_string .= '<tbody>';
    foreach ($data as $key => $value) {
        $err_line_empty = isErrLineEmpty($csv_rows[$value['line']]);

        $lines_count++;

        if ($valid_params->rb_onlyerrors == 1 && empty($err_line_empty)) {
            continue;
        }

        if ($valid_params->rb_inputrow == 1 && !empty($err_line_empty)) {
            $cs_count = 0;
            $rs_count = 2;
            $line_number = 0;
            $row_string = '';

            if (!empty($err_line_empty)) {
                $rs_count = $rs_count + 2;
            }

            $return_string .= '<tr>';
            foreach ($value as $v => $l) {
                $cs_count++;
                if ($v == 'line') {
                    $line_number = $l;
                    $row_string = $rows_string_array[$l - 1];
                }
            }
            $return_string .= '<td class="cell" rowspan="' . $rs_count . '">' . $line_number . '</td>';
            $return_string .= '<td class="cell" colspan="' . count($value) . '"><pre>' . $row_string . '</pre></td>';
            $return_string .= '</tr>';
        }

        $return_string .= '<tr>';
        foreach ($value as $k => $val) {
            $rs_count = 1;
            if (!empty($err_line_empty)) {
                $rs_count = $rs_count + 2;
            }

            (in_array($k, $err_line_empty)) ? $t_error = ' style="background-color: #fcdddd;"' : $t_error = '';
            ($k == 'line' && $rs_count > 1 && $valid_params->rb_inputrow == 0) ? $t_rowspan = ' rowspan="' . $rs_count . '"' : $t_rowspan = '';

            if ($valid_params->rb_inputrow == 1 && !empty($err_line_empty)) {
                if ($k != 'line') {
                    $return_string .= '<td class="cell"' . $t_rowspan . '' . $t_error . '><div class="dtable_cell">' . $val . '</div></td>';
                }
            } else {
                $return_string .= '<td class="cell"' . $t_rowspan . '' . $t_error . '><div class="dtable_cell">' . $val . '</div></td>';
            }
        }

        $return_string .= '</tr>';

        if (!empty($err_line_empty)) {
            $return_string .= '<tr>';
            foreach ($csv_rows[$value['line']] as $err_line) {
                ($err_line != '') ? $te_error = ' style="background-color: #fcdddd;"' : $te_error = '';
                $return_string .= '<td class="cell"' . $te_error . ' title="' . strip_tags(str_replace(array('<hr />', '<br />'), PHP_EOL . '-----' . PHP_EOL, trim($err_line))) . '"><div class="dtable_cell">' . $err_line . '</div></td>';
            }
            $return_string .= '</tr>';

            // Prazdny radek
            $return_string .= '<tr><td class="cell" colspan="' . count($value) . '" style="height: 8px; padding: 0px;"></td></tr>';
        }

        // V pripade, ze je nastaveno opakovani radku tabulky, pridame zalomeni
        if ($CFG->table_head_repeat != 0 && $lines_count % $CFG->table_head_repeat == 0 && $lines_count != count($data)) {
            $return_string .= '</tbody>';
            $return_string .= '</table>';
            $return_string .= '</div>';

            $return_string .= '<div class="flexible-wrap" style="overflow-x: auto">';
            $return_string .= '<table class="' . $t_class . ' ' . $t_align . '" id="' . $table->id . '" summary="' . $table->summary . '" style="margin-bottom: 0px !important;">';
            $return_string .= $table_head;
            $return_string .= '<tbody>';
        }
    }
    $return_string .= '</tbody>';
    // ↑ telo tabulky

    $return_string .= '</table>';
    $return_string .= '</div>';

    return $return_string;
}

/**
 * Prevede retezec na pole znaku (akceptuje ceske znaky)
 * 
 * @param string $string
 * @return array
 */
function getCharArray($string) {
    $len = mb_strlen($string, 'UTF-8');
    if (mb_strlen($string, 'UTF-8') == 0)
        return array();

    $ret = array();
    for ($i = 0; $i < $len; $i++) {
        $char = mb_substr($string, $i, 1, 'UTF-8');
        array_push($ret, $char);
    }

    return $ret;
}

/**
 * Kontrola emailu. Zda neobsahuje nepovolene znaky
 * 
 * @param string $mail
 * @return array
 */
function checkMailErrors($mail) {
    $return = array('status' => true, 'string' => '', 'error_array' => array());
    $err_span_style = 'background-color: #ff7777; padding: 0px 1px; margin: 0px 1px; color: #000;';

    // Pole povolenych znaku
    $allowed = array(
        '-', '!', '#', '$', '%', '&', '\'', '*', '.', '_', '^', '~', '{', '}', '|',
        'a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z',
        'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z',
        '1', '2', '3', '4', '5', '6', '7', '8', '9', '0'
    );

    // Rozdeleni mailu na pole podle zavinace
    $divided = explode('@', $mail);

    if (count($divided) == 1) {
        return false;
    }

    // Leva a prava cast retezce
    $left = getCharArray($divided[0]);
    $right = getCharArray($divided[1]);

    // Navratove stringy jednotlivych casti
    $ret_left = array();
    $ret_right = array();

    // Kontrola leve casti emailu
    foreach ($left as $lft) {
        $ret_char = '';
        if (!in_array($lft, $allowed)) {
            $ret_char = '<span style="' . $err_span_style . '">' . $lft . '</span>';
            $return['status'] = false;
        } else {
            $ret_char = $lft;
        }
        $ret_left[] = $ret_char;
    }

    // Kontrola prave casti emailu
    foreach ($right as $rgt) {
        $ret_char = '';
        if (!in_array($rgt, $allowed)) {
            $ret_char = '<span style="' . $err_span_style . '">' . $rgt . '</span>';
            $return['status'] = false;
        } else {
            $ret_char = $rgt;
        }
        $ret_right[] = $ret_char;
    }

    // CHYBA : Cast za zavinacem musi obsahovat aleson jednu tecku
    if (mb_strpos($divided[1], '.') === false) {
        $return['status'] = false;
        $return['error_array'][] = get_string('invalid_email_missing_dot', 'tool_uploaduservalidator');
    }

    // CHYBA : Retezec obsahuje nepovolene znaky
    if ($return['status'] === false) {
        $return['error_array'][] = get_string('invalid_email_invalid_chars', 'tool_uploaduservalidator');
    }

    $return['string'] = implode('', $ret_left) . '@' . implode('', $ret_right);

    return $return;
}

/**
 * Kontrola uzivatelskeho jmena. Zda neobsahuje nepovolene znaky
 * 
 * @param string $username
 * @return array
 */
function checkUsernameErrors($username) {
    $return = array('status' => true, 'string' => '', 'error_array' => array());
    $err_span_style = 'background-color: #ff7777; padding: 0px 1px; margin: 0px 1px; color: #000;';

    // Pole povolenych znaku
    $allowed = array(
        '-', '!', '#', '$', '%', '&', '\'', '*', '.', '_', '^', '~', '{', '}', '|',
        'a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z',
        'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z',
        '1', '2', '3', '4', '5', '6', '7', '8', '9', '0'
    );

    // Rozdeleni mailu na pole podle zavinace
    $divided = getCharArray($username);

    // Navratove stringy jednotlivych casti
    $ret_div = array();

    // Kontrola leve casti emailu
    foreach ($divided as $div) {
        $ret_char = '';
        if (!in_array($div, $allowed)) {
            $ret_char = '<span style="' . $err_span_style . '">' . $div . '</span>';
            $return['status'] = false;
        } else {
            $ret_char = $div;
        }
        $ret_div[] = $ret_char;
    }

    // CHYBA : Retezec obsahuje nepovolene znaky
    if ($return['status'] === false) {
        $return['error_array'][] = get_string('invalid_username_invalid_chars', 'tool_uploaduservalidator');
    }

    $return['string'] = implode('', $ret_div);

    return $return;
}

/**
 * Zjisteni, zda je radek s chybou prazdny
 * 
 * @param array $line
 * @return array
 */
function isErrLineEmpty($line) {
    $return = array();

    foreach ($line as $key => $value) {
        if ($value !== '') {
            $return[] = $key;
        }
    }

    return $return;
}

/**
 * Funkce, ktera zjisti, zda dokument neobsahuje zadne chyby
 * 
 * @param array $csv_rows
 * @param string $is_valid
 * @return boolean
 */
function hasNoErrors($csv_rows, $is_valid = null) {
    $return = true;

    if (!empty($is_valid)) {
        $return = false;
    }

    foreach ($csv_rows as $csvr) {
        foreach ($csvr as $l) {
            if ($l !== '') {
                $return = false;
            }
        }
    }
    return $return;
}

/**
 * Kontrola pripony souboru
 * 
 * @param string $file_str
 * @return boolean
 */
function checkFileExtension($file_str) {
    $return = array('status' => true, 'file_ext' => '');
    $allowed_ext = array('csv', 'txt');
    $file_str_expl = explode('.', $file_str);
    $last_arr_index = count($file_str_expl) - 1;
    $return['file_ext'] = $file_str_expl[$last_arr_index];

    if (!in_array(strtolower($file_str_expl[$last_arr_index]), $allowed_ext)) {
        $return['status'] = false;
    }

    return $return;
}

/**
 * Vypis seznamu obci
 * 
 * @param array $city_list
 * @return null
 */
function getCityNameList($city_list) {
    if (!empty($city_list)) {
        $city_list_array = array_map('trim', explode(PHP_EOL, $city_list));

        // Prevedeme hodnoty na kodovani UTF-8
        $cla_utf8 = array();
        foreach ($city_list_array as $cla) {
            $cla_utf8[] = autoUTF($cla);
        }

        $city_list_array = $cla_utf8;
    } else {
        $city_list_array = null;
    }

    return $city_list_array;
}

/**
 * Validace nazvu obce
 * 
 * @param string $row_value
 * @param array $city_list
 * @return boolean
 */
function checkCityName($row_value, $city_list) {
    $return = true;

    if ($city_list != null) {
        if (!in_array($row_value, $city_list)) {
            $return = false;
        }
    }

    return $return;
}