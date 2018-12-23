<?php

use GraphicObjectTemplating\OObjects\ODContained\ODInput;

return [
    'object'        => 'odinput',
    'typeObj'       => 'odcontained',
    'template'      => 'odinput.twig',

    'type'          => ODInput::INPUTTYPE_TEXT,
    'size'          => '',
    'minlength'     => '',
    'maxlength'     => '',
    'label'         => '',
    'placeholder'   => '',
    'labelWidthBT'  => '',
    'inputWidthBT'  => '',
    'errMessage'    => '',
    'icon'          => '',
    'autoFocus'     => false,
    'mask'          => '',

    'resources' => [
        'js'		=> [
            'odinput.js' => 'js/odinput.js',
            'jquery.maskedinput.min.js' => 'js/jquery.maskedinput.min.js',
        ],
    ],
];