<?php

use GraphicObjectTemplating\OObjects\OObject;

return [
    'id'            => '',
    'name'          => '',
    'className'     => '',
    'display'       => OObject::DISPLAY_BLOCK,
    'object'        => '',
    'typeObj'       => '',
    'template'      => '',
    'widthBT'       => '',
    'lastAccess'    => '',
    'state'         => true,
    'classes'       => '',

    'autoCenter'    => false,
    'acPx'          => '',
    'acPy'          => '',

    'infoBulle'     => [
        'animation'     => true,
        'delay'         => [
            'show'          => 500,
            'hide'          => 100,
        ],
        'html'          => false,
        'placement'     => OObject::IBPLACEMENT_TOP,
        'body'          => '',
    ],

    'resources'     => [
        'css'           => [],
        'js'            => [],
    ],
];