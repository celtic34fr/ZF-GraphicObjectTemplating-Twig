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

    'resources' => [
        'css' => [ 'odtreeview.css' => 'css/odtreeview.css', ],
        'js'  => [ 'odtreeview.css' => 'js/odtreeview.js',],
    ],
);