<?php

use GraphicObjectTemplating\OObjects\ODContained\ODInput;

return [
    'object'        => 'odinput',
    'typeObj'       => 'odcontained',
    'template'      => 'odinput.twig',

    'type'          => ODInput::INPUTTYPE_TEXT,
    'size'          => 0,
    'maxlength'     => 0,
    'label'         => '',
    'placeholder'   => '',
    'labelWidthBT'  => '',
    'errMessage'    => '',
    'icon'          => '',

    'resources' => [
        'js'		=> [
            'odinput.js' => 'js/odinput/odinput.js',
        ],
    ],
];