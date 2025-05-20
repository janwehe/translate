var $language;
var $translation;
var $origin_id;
var $translate;
var $save;

// make sure the page is fully loaded
if (document.readyState !== 'loading') {
    translate();
}
else {
    document.addEventListener('DOMContentLoaded', translate);
}

// code to handle the form
function translate()
{
    $language = document.getElementById("translation_language");
    $translation = document.getElementById("translation_translation");
    $origin_id = document.getElementById("translation_origin_id");

    // Check translation for language
    $language.addEventListener("change", function () {
        const url = '/translation/load/' + $origin_id.value + '/' + $language.value;

        if ($language.value == "") {
            $translation.value = "";
        }
        else {
            loadTranslation(url);
        }
    });

    // send text to DeepL for translation
    $translate = document.getElementById("translation_translate");
    $save = document.getElementById("translation_save");

    // hide save button for now
    $save.parentNode.hidden = true;

    $translate.addEventListener("click", function () {
        const url = '/translation/translate/' + $origin_id.value + '/' + $language.value;

        if ($language.value == "") {
            alert("Bitte eine Sprache wählen");
        }
        else {
            loadTranslation(url);
        }
    });
}

function loadTranslation(url)
{
    fetch(url)
        .then((response) => response.json())
        .then((transl) => {
            $translation.value = transl.text.trim();
            $save.parentNode.hidden = false;
            $translate.hidden = true;
        })
        .catch(console.error);
}