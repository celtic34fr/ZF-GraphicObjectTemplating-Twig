<?php

use GraphicObjectTemplating\OObjects\ODContained\ODDropzone;

return [
    "object"        => "oddropzone",
    "typeObj"       => "odcontained",
    "template"      => "oddropzone.twig",

    "maxFile"       => "",
    "acceptedFiles" => "",
    "maxFileSize"   => 5,
    "loadedFiles"   => [],

    'view'          => true,
    'download'      => false,
    'remove'        => false,

    'message'       => '',
    'width'         => '',
    'heigth'        => '',

    'event'         => [
        'dropIn'        => [
            'class'         => ODDropzone::class,
            'method'        => 'evtAddFile',
            'stopEvent'     => 'NON',
        ],
        'dropOut'        => [
            'class'         => ODDropzone::class,
            'method'        => 'evtRmFile',
            'stopEvent'     => 'NON',
        ],
    ],

    'dict'          => [
        'defaultMessage'    =>
            'Glissez et déposez les fichiers ici&hellip;<br>(ou cliquez pour sélectionner manuellement)',
        'responseError'     => 'Erreur au téléchargement du fichier',
    ],

    "resources"     => array(
        "css"           => array(
            "dropzone.css"  => "DropZone/css/dropzone.css",
        ),
        "js"            => array(
            "dropzone.js"   => "DropZone/js/dropzone.js"
        ),
    ),
];