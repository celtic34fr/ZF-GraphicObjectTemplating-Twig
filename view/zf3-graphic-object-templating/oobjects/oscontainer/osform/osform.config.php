<?php

use GraphicObjectTemplating\OObjects\OSContainer\OSForm;

return [
    'object'            => 'osform',
    'typeObj'           => 'oscontainer',
    'template'          => 'osform.twig',

    'fields'            => [],
    'origine'           => [],
    'btnControls'       => [],
    'submitEnter'       => true,
    'validateMethod'    => [
        'classObj'  => '',
        'methodObj' => '',
    ],
    'hidden'            => [],
    'title'             => '',
    'btnsDisplay'       => OSForm::DISP_BTN_HORIZONTAL,
    'btnsWidthBT'       => 2,
    'widthBTbody'       => '',
    'widthBTctrls'      => '',
];