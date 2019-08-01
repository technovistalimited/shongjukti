/**
 * Attachment Type Scripts
 *
 * @package    Laravel
 * @subpackage TechnoVistaLimited/Shongjukti
 */

document.addEventListener('DOMContentLoaded', function () {

    var scopeKeyChoice = document.getElementById('scope-key-choice');

    // --------------------------------------------------------------------------
    // LIST PAGE ----------------------------------------------------------------
    // --------------------------------------------------------------------------

    // Load UI based on Scope____________________________________________________
    // Load Respective Attachments based on Scope Key selection.

    function loadScopeData(scope_select) {
        var parameter = scope_select.value;
        var baseUrl = window.location.href;

        // hard-coded string to indicate from where it can append the slug string.
        var withoutLastChunk = baseUrl.slice(0, baseUrl.lastIndexOf('attachment-types'));
        window.location.href = withoutLastChunk + 'attachment-types/' + parameter;
    }

    if (scopeKeyChoice) {

        scopeKeyChoice.onchange = function (event) {
            loadScopeData(this);
        };

    }



    // --------------------------------------------------------------------------
    // CREATE PAGE --------------------------------------------------------------
    // --------------------------------------------------------------------------

    var scopeKey = document.getElementById('scope-key');

    // Remember the Scope choice from the last entry_____________________________
    // Using JavaScript Cookie.
    function setCookie(cname, cvalue, exdays) {
        var d = new Date();
        d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
        var expires = "expires=" + d.toUTCString();
        document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
    }

    function getCookie(cname) {
        var name = cname + "=";
        var ca = document.cookie.split(';');
        for (var i = 0; i < ca.length; i++) {
            var c = ca[i];
            while (c.charAt(0) == ' ') {
                c = c.substring(1);
            }
            if (c.indexOf(name) == 0) {
                return c.substring(name.length, c.length);
            }
        }
        return "";
    }

    if (scopeKey) {

        // Remember the value on choice.
        scopeKey.onchange = function (event) {
            setCookie('attachment-scope', this.value, 10);
        };

        // Set the value on page load.
        var attachmentScope = getCookie('attachment-scope');
        if (attachmentScope != '') {
            scopeKey.value = attachmentScope;
        }

    }


}, false);
