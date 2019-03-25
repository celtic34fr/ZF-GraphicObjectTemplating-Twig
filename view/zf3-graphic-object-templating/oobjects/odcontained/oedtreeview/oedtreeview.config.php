<?php

use CmsCore\OEObjects\OEDContained\OEDTreeview;

return [
    'object'            => 'oedtreeview',
    'typeObj'           => 'oedcontained',
    'template'          => 'oedtreeview.twig',


    'dataTree'      => [],
    'dataPath'      => [],
    'dataSelected'  => [],
    'icon'          => false,
    'leafIco'       => 'fa fa-file',
    'nodeClosedIco' => 'fa fa-folder',
    'nodeOpenedIco' => 'fa fa-folder-open',
    'multiSelect'   => false,
    'title'         => '',
    'colorClasses'  => [
        0   => [
            'normal'    => [
                'fg-color'      => OEDTreeview::COLORCLASS_NAVY,
                'bg-color'      => OEDTreeview::COLORCLASS_YELLOW,
            ],
            'hover'     => [
                'bg-color'      => OEDTreeview::COLORCLASS_MAROON,
            ],
        ],
        1   => [
            'normal'    => [
                'fg-color'      => OEDTreeview::COLORCLASS_BLACK,
                'bg-color'      => OEDTreeview::COLORCLASS_GRAY,
            ],
            'hover'     => [
                'bg-color'      => OEDTreeview::COLORCLASS_NAVY,
            ],
        ],
        2   => [
            'normal'    => [
                'fg-color'      => OEDTreeview::COLORCLASS_BLACK,
                'bg-color'      => OEDTreeview::COLORCLASS_SILVER,
            ],
            'hover'     => [
                'bg-color'      => OEDTreeview::COLORCLASS_GREEN,
            ],
        ],
        3   => [
            'normal'    => [
                'fg-color'      => OEDTreeview::COLORCLASS_BLACK,
                'bg-color'      => OEDTreeview::COLORCLASS_WHITE,
            ],
            'hover'     => [
                'bg-color'      => OEDTreeview::COLORCLASS_MAROON,
            ],
        ],
    ],

    'resources' => [
        'prefix'            => 'cms-core/',
        'css' => [
            'oedtreeview.css' => 'css/oedtreeview.css',
            'basscss.css'     => 'css/basscss.css',
        ],
        'js'  => [
            'oedtreeview.js' => 'js/oedtreeview.js',
            'html5sortable.js' => 'js/html5sortable.js',
        ],
    ],
];
