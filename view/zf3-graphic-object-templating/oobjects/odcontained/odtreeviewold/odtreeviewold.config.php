<?php

return array(
    'object'        => 'odtreeviewold',
    'typeObj'       => 'odcontained',
    'template'      => 'odtreeviewold.twig',

    'dataTree'      => [],
    'dataPath'      => [],
    'dataSelected'  => [],
    'icon'          => false,
    'leafIco'       => 'fa fa-file',
    'nodeClosedIco' => 'fa fa-folder',
    'nodeOpenedIco' => 'fa fa-folder-open',
    'multiSelect'   => false,
    'title'         => '',

    'resources' => [
        'css' => [
            'odtreeviewold.css' => 'css/odtreeviewold.css',
//            'hummingbird_treeview.css' => 'css/hummingbird_treeview.css',
            ],
        'js'  => [
            'odtreeviewold.js' => 'js/odtreeviewold.js',
//            'hummingbird_treeview.js' => 'js/hummingbird_treeview.js',
        ],
    ],
);
