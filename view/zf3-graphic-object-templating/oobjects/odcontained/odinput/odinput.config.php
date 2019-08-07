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
    'autoFocus'     => false,
    'mask'          => '',
    'valMin'        => '',
    'valMax'        => '',
];