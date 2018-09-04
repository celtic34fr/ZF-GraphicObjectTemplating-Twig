<?php

use GraphicObjectTemplating\OObjects\ODContained\ODInput;

return [
    'object'        => 'odinput',
    'typeObj'       => 'odcontained',
    'template'      => 'odinput.twig',

    'type'          => ODInput::INPUTTYPE_TEXT,
    'size'          => '',
    'maxlength'     => '',
    'label'         => '',
    'placeholder'   => '',
    'labelWidthBT'  => '',
    'inputWidthBT'  => '',
    'errMessage'    => '',
    'icon'          => '',

    'resources' => [
        'js'		=> [
            'odinput.js' => 'js/odinput.js',
        ],
    ],
];