<?php

use GraphicObjectTemplating\OObjects\ODContained\ODNotification;

return [
    'object'        => 'odnotification',
    'typeObj'       => 'odcontained',
    'template'      => 'odnotification.twig',

    'type'              => 'info',
    'title'             => '',
    'body'              => '',
    'size'              => ODNotification::NOTIFICATIONSIZE_NORMAL,
    'action'            => 'init',
    'sound'             => true,
    'soundExt'          => '.ogg',
    'soundPath'         => 'graphicobjecttemplating/objects/odcontained/odnotification/sounds/',
    'delay'             => 3000, // en millisecondes
    'position'          => ODNotification::NOTIFICATIONPOSITION_BR,
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