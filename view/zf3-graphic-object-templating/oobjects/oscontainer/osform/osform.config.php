<?php
return [
    'object'            => 'osform',
    'typeObj'           => 'oscontainer',
    'template'          => 'osform.twig',

    'fields'            => [],
    'origine'           => [],
    'btnControls'       => [],
    'submitEnter'       => true,
    'validateMethod'    => [
        'classObj'  => '',
        'methodObj' => '',
    ],
    'hidden'            => [],
    'title'             => '',

    'resources' => [
        'css'		=> [
            'odbutton.css' => '../../odcontained/odbutton/css/odbutton.css',
        ],
        'js'		=> [
            'osform.js' => 'js/osform.js',
            'odbutton.js' => '../../odcontained/odbutton/js/odbutton.js',
        ],
    ],
];