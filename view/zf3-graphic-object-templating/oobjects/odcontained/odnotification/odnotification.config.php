<?php

return [
    'object'        => 'odnotification',
    'typeObj'       => 'odcontained',
    'template'      => 'odnotification.twig',

    'type'              => 'info',
    'title'             => '',
    'body'              => '',
    'size'              => 'normal',
    'action'            => 'init',
    'sound'             => true,
    'soundPath'         => 'graphicobjecttemplating/objects/odcontained/odnotification/sounds/',
    'delay'             => 3000, // en millisecondes
    'position'          => 'bottom right',
    'showAfterPrevious' => false,
    'delayMessage'      => 2000,

    'resources' => [
        'css' => [
                'lobibox.css' => 'css/lobibox.css'
        ],
        'js'  => [
            'notifications.js' => 'js/lobibox.js'
        ],
    ]
];