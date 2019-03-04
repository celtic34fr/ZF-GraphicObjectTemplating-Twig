<?php
return [
    "object"        => "oddropzone",
    "typeObj"       => "odcontained",
    "template"      => "oddropzone.twig",

    "maxFile"       => "",
    "acceptedFiles" => "",
    "maxFilesize"   => 5,
    "loadedFiles"   => [],

    'view'          => true,
    'download'      => false,
    'remove'        => false,

    'message'       => '',
    'width'         => '',
    'heigth'        => '',

    "resources"     => array(
        "css"           => array(
            "dropzone.css"  => "DropZone/css/dropzone.css",
        ),
        "js"            => array(
            "dropzone.js"   => "DropZone/js/dropzone.js"
        ),
    ),
];