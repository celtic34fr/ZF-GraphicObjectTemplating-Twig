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
    'width'         => '',
    'height'        => '',

    'autoCenter'    => false,
    'acPx'          => '',
    'acPy'          => '',

    'infoBulle'     => [
        'setIB'         => false,
        'type'          => OObject::IBTYPE_TOOLTIP,
        'animation'     => true,
        'delay'         => [
            'show'          => 500,
            'hide'          => 100,
        ],
        'html'          => OObject::BOOLEAN_FALSE,
        'placement'     => OObject::IBPLACEMENT_TOP,
        'title'         => '',
        'content'       => '',
        'trigger'       => OObject::IBTRIGGER_HOVER,
    ],
];