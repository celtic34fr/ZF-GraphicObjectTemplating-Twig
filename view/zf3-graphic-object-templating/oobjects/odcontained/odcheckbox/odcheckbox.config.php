<?php

use GraphicObjectTemplating\OObjects\ODContained\ODCheckbox;

return [
    'object'        => 'odcheckbox',
    'typeObj'       => 'odcontained',
    'template'      => 'odcheckbox.twig',

    'label'         => '',
    'options'       => [],
    'forme'         => 'horizontal',
    'hMargin'       => '0',
    'vMargin'       => '0',
    'place'         => 'left',
    'event'         => [],
    'labelWidthBT'  => '',
    'inputWidthBT'  => '',
    'placement'     => ODCheckbox::CHECKPLACEMENT_LEFT,

    'resources' => [
        'js'		=> [
            'odcheckbox.js' => 'js/odcheckbox.js',
        ],
    ],
];
