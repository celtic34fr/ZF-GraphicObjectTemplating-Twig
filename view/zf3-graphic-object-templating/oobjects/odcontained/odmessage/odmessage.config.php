<?php

return [
    'object'        => 'odmessage',
    'typeObj'       => 'odcontained',
    'template'      => 'odmessage.twig',

    /** confirm attributes */
    'title'         => '',
    'width'         => '',
    /** prompt attributes */
    'attrs'         => [],
    'value'         => '',
    'multiline'     => false,
    'lines'         => 1,
    'type'          => 'text',
    'label'         => '',
    'required'      => true,
    'errorMessage'  => '',
    /** progress attributes */
    'showProgressLabel' => true,
    'progressTpl'       => false,
    /** windows attributes */
    'height'        => '',
    'content'       => '',
    'url'           => '',
    'graggable'     => true,
    'autoload'      => true,
    'loadMethod'    => 'GET',
    'showAfterLoad' => true,
    'params'        => [],


    'resources' => [
        'css' => [
            'lobibox.css' => 'css/lobibox.css'
        ],
        'js'  => [
            'messageboxes.js' => 'js/messageboxes.js'
        ],
    ]
];