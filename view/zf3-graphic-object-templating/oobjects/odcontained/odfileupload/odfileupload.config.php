<?php

use GraphicObjectTemplating\OObjects\ODContained\ODFileUpload;

return [
    "object"        => "odfileupload",
    "typeObj"       => "odcontained",
    "template"      => "odfileupload.twig",

    "locale"        => ODFileUpload::LOCALE_FRANCAIS,
    "acceptedFiles" => [],
    "loadedFiles"   => [],
    'placeholder'   => '',

    "resources"     => array(
        "css"           => array(
            "fileinput.min.css"     => "css/fileinput.min.css",
            "fileinput-rtl.min.css" => "css/fileinput-rtl.min.css",
        ),
        "js"            => array(
            "fileinput.js"      => "js/fileinput.js",
            "piexif.min.js"     => "js/plugins/piexif.min.js",
            "sortable.min.js"   => "js/plugins/sortable.min.js",
            "purify.min.js"     => "js/plugins/purify.min.js",
            "theme.js"          => "themes/fa/theme.js",
            // localisation par défaut France
            ODFileUpload::LOCALE_FRANCAIS.'.js' => 'js/locale/'.ODFileUpload::LOCALE_FRANCAIS.'.js',
        ),
    ),
];