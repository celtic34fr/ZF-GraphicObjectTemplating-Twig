<?php

return array(
    'object'        => 'odtreeview',
    'typeObj'       => 'odcontained',
    'template'      => 'odtreeview.twig',

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
            'odtreeview.css' => 'css/odtreeview.css',
            'hummingbird_treeview.css' => 'css/hummingbird_treeview.css',
            ],
        'js'  => [
            'odtreeview.js' => 'js/odtreeview.js',
            'hummingbird_treeview.js' => 'js/hummingbird_treeview.js',
        ],
    ],
);