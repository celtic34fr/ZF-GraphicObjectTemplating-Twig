<?php

use GraphicObjectTemplating\OObjects\ODContained\ODTreeview;

return [
    'object'            => 'odtreeview',
    'typeObj'           => 'odcontained',
    'template'          => 'odtreeview.twig',


    'dataTree'      => [],
    'dataPath'      => [],
    'dataSelected'  => [],
    'icon'          => false,
    'leafIco'       => 'fa fa-file',
    'nodeClosedIco' => 'fa fa-folder',
    'nodeOpenedIco' => 'fa fa-folder-open',
    'multiSelect'   => false,
    'title'         => '',
    'sortable'      => true,
    'selection'     => true,

    'colorClasses'  => [
        0   => [
            'normal'    => [
                'fg-color'      => ODTreeview::COLORCLASS_NAVY,
                'bg-color'      => ODTreeview::COLORCLASS_YELLOW,
            ],
            'hover'     => [
                'bg-color'      => ODTreeview::COLORCLASS_MAROON,
            ],
        ],
        1   => [
            'normal'    => [
                'fg-color'      => ODTreeview::COLORCLASS_BLACK,
                'bg-color'      => ODTreeview::COLORCLASS_GRAY,
            ],
            'hover'     => [
                'bg-color'      => ODTreeview::COLORCLASS_NAVY,
            ],
        ],
        2   => [
            'normal'    => [
                'fg-color'      => ODTreeview::COLORCLASS_BLACK,
                'bg-color'      => ODTreeview::COLORCLASS_SILVER,
            ],
            'hover'     => [
                'bg-color'      => ODTreeview::COLORCLASS_GREEN,
            ],
        ],
        3   => [
            'normal'    => [
                'fg-color'      => ODTreeview::COLORCLASS_BLACK,
                'bg-color'      => ODTreeview::COLORCLASS_WHITE,
            ],
            'hover'     => [
                'bg-color'      => ODTreeview::COLORCLASS_MAROON,
            ],
        ],
    ],

    'btnActions'    => [],
];
