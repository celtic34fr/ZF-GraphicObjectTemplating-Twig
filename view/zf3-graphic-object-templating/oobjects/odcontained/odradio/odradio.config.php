<?php

use GraphicObjectTemplating\OObjects\ODContained\ODRadio;

return [
    'object'            => 'odradio',
    'typeObj'           => 'odcontained',
    'template'          => 'odradio.twig',

    'label'             => '',
    'options'           => [],
    'forme'             => ODRadio::RADIOFORM_HORIZONTAL,
    'hMargin'           => '0',
    'vMargin'           => '0',
    'place'             => 'left',
    'event'             => [],
    'labelWidthBT'      => '',
    'inputWidthBT'      => '',
    'checkLabelWidthBT' => '',
    'checkInputWidthBT' => '',
    'placement'         => ODRadio::RADIOPLACEMENT_LEFT,
];
