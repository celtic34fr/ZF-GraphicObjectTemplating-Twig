<?php

use GraphicObjectTemplating\OObjects\ODContained\ODFileUpload;

return [
    "object"                => "odfileupload",
    "typeObj"               => "odcontained",
    "template"              => "odfileupload.twig",

    'multiple'              => false,
    "locale"                => ODFileUpload::LOCALE_FRANCAIS,
    "acceptedFiles"         => [],
    "loadedFiles"           => [],
    'userExtensions'        => [],
    'initialCaption'        => '',
    'caption'               => ODFileUpload::BOOLEAN_TRUE,
    'preview'               => ODFileUpload::BOOLEAN_TRUE,
    'remove'                => ODFileUpload::BOOLEAN_TRUE,
    'upload'                => ODFileUpload::BOOLEAN_TRUE,
    'cancel'                => ODFileUpload::BOOLEAN_TRUE,
    'close'                 => ODFileUpload::BOOLEAN_TRUE,
    'uploadedThumbs'        => ODFileUpload::BOOLEAN_TRUE,
    'browse'                => ODFileUpload::BOOLEAN_TRUE,
    'browseOnClick'         => ODFileUpload::BOOLEAN_FALSE,
    'dropZone'              => ODFileUpload::BOOLEAN_TRUE,
    'minFileSize'           => 0,
    'maxFileSize'           => 0,
    'maxFilePreviewSize'    => 25600,
    'minFileCount'          => 0,
    'maxFileCount'          => 0,
    'validateInitialCount'  => false,

    "resources"             => array(
        "css"                   => array(
            "fileinput.min.css"     => "css/fileinput.min.css",
            "fileinput-rtl.min.css" => "css/fileinput-rtl.min.css",
        ),
        "js"                    => array(
            "fileinput.js"      => "js/fileinput.js",
            "piexif.min.js"     => "js/plugins/piexif.min.js",
            "sortable.min.js"   => "js/plugins/sortable.min.js",
            "purify.min.js"     => "js/plugins/purify.min.js",
            "theme.js"          => "themes/fa/theme.js",
            // localisation par défaut France
            ODFileUpload::LOCALE_FRANCAIS.'.js' => 'js/locales/'.ODFileUpload::LOCALE_FRANCAIS.'.js',
        ),
    ),
];