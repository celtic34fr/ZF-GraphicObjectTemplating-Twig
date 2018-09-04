<?php

use GraphicObjectTemplating\OObjects\ODContained\ODSelect;

return [
    'object'        => 'odselect',
    'typeObj'       => 'odcontained',
    'template'      => 'odselect.twig',
    'options'       => [],
    'multiple'      => false,
    'label'         => '',
    'labelClass'    => '',
    'selectClass'   => '',
    'placeholder'   => '',
    'format'        => '',
    'bgColor'       => ODSelect::ODSELECTCOLOR_WHITE,
    'fgColor'       => ODSelect::ODSELECTCOLOR_BLACK,
    
    'resources' => [
        'css'       => [
            'dropdown.css' => 'css/dropdown.css',
        ],
        'js'		=> [
            'odselect.js' => 'js/odselect.js',
            'dropdown.js' => 'js/dropdown.js',
        ],
    ],
];