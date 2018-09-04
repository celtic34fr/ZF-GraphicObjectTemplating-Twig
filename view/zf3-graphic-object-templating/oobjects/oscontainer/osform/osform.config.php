<?php
return [
    'object'            => 'osform',
    'typeObj'           => 'oscontainer',
    'template'          => 'osform.twig',

    'fields'            => [],
    'origine'           => [],
    'btnControle'       => [],
    'validateMethod'    => [
        'classObj'  => '',
        'methodObj' => '',
    ],

    'resources' => [
        'js'		=> [
            'osform.js' => 'js/osform.js',
            'odbutton.js' => '../../odcontained/odbutton/js/odbutton.js',
        ],
    ],
];