/*
 * validator.js
 * verze 1.0
 *
 */

$(document).ready(function() {
    var aktualni_url = $(location).attr('href');
    var pozadovana_url = need_url;
    
    if(aktualni_url === pozadovana_url) {
        var tmp = $(document).find($('#region-main form input[name="iid"]'));

        if(tmp.length === 0) {
            $('#region-main form input[type="submit"]').after('<a href="' + validator_url + '" style="display: inline-block; margin-left: 10px;" class="val_a_goto_validator">' + val_js_button_text + '</a>');
        }
    }
});