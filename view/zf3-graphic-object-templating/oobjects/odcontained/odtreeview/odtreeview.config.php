<?php

return array(
    'object'        => 'odtreeview',
    'typeObj'       => 'odcontained',
    'template'      => 'odtreeview.twig',

    'dataTree'      => [],
    'dataPath'      => [],
    'icon'          => false,
    'leafIco'       => 'fa fa-file',
    'nodeClosedIco' => 'fa fa-folder',
    'nodeOpenedIco' => 'fa fa-folder-open',

    'resources' => [
        'css' => [ 'odtreeview.css' => 'css/odtreeview.css', ],
        'js'  => [ 'odtreeview.css' => 'js/odtreeview.js',],
    ],
);