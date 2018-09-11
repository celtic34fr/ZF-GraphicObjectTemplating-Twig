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
    'soundExt'          => '.ogg',
    'soundPath'         => 'graphicobjecttemplating/objects/odcontained/odnotification/sounds/',
    'delay'             => 3000, // en millisecondes
    'position'          => 'bottom right',
    'showAfterPrevious' => false,
    'delayMessage'      => 2000,
    'showClass'         => 'zoomIn',
    'hideClass'         => 'zoomOut',
    'icon'              => true,
    'width'             => 600,
    'height'            => 'auto',
    'closeOnClick'      => true,

    'resources' => [
        'css' => [
                'lobibox.css' => 'css/lobibox.css'
        ],
        'js'  => [
            'notifications.js' => 'js/notifications.js'
        ],
    ]
];