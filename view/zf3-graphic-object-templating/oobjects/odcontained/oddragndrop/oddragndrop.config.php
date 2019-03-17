<?php

use GraphicObjectTemplating\OObjects\ODContained\ODDragNDrop;

return [
    'object'            => 'oddragndrop',
    'typeObj'           => 'odcontained',
    'template'          => 'oddragndrop.twig',
    'dispatchEvents'    => true,

    'maxFileCount'      => 0,   // 0 : pas de limite
    'minFileSize'       => 0,   // 0 : pas de taille minimale
    'maxFileSize'       => 0,   // 0 : pas de taille maximale
    'acceptedFiles'     => [],  // tableau des extensions de fichiers téléchargeables
    'message'           => '',  // texte à afficher dans la zone du Glisser/Deéposer
    'lineHeightDND'     => '05em',
    'heightDND'         => '06em',

    'loadedFiles'       => [],  // tableau des fichiers déjà téléchargés (pouvant être supprimés)
    'tempFolder'        => '',
    'thumbWidth'        => 150,
    'thumbHeight'       => 150,
    'thumbRatio'        => ODDragNDrop::BOOLEAN_TRUE,
    'thumbView'         => ODDragNDrop::BOOLEAN_TRUE,
    'thumbDload'        => ODDragNDrop::BOOLEAN_FALSE,
    'thumbRmove'        => ODDragNDrop::BOOLEAN_FALSE,
    'thumbFileName'     => ODDragNDrop::BOOLEAN_TRUE,

    'resources'         => [        // resources fichiers CSS et JS nécessaires au fonctionnement de lm'objet
        'css'		        => [
            'oddragndrop.css' => 'css/oddragndrop.css',
        ],
        'js'		        => [
            'oddragndrop.js' => 'js/oddragndrop.js',
        ],
        'fonts'             => [
            'MonospaceTypewriter.ttf'   => 'fonts/MonospaceTypewriter.ttf',
            'ufonts.com_courier.ttf'    => 'fonts/ufonts.com_courier.ttf'
        ]
    ],
];
