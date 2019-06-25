<?php

use GraphicObjectTemplating\OObjects\ODContained\ODDragNDrop;

return [
    'object'                => 'oddragndrop',
    'typeObj'               => 'odcontained',
    'template'              => 'oddragndrop.twig',

    'locale'                => 'fr',
    'theme'                 => ODDragNDrop::OEDND_THEME_FAS,
    'showClose'             => ODDragNDrop::STATE_ENABLE,
    'showBrowse'            => ODDragNDrop::STATE_ENABLE,
    'showCaption'           => ODDragNDrop::STATE_ENABLE,
    'showPreview'           => ODDragNDrop::STATE_ENABLE,
    'showRemove'            => ODDragNDrop::STATE_DISABLE,
    'showUpload'            => ODDragNDrop::STATE_ENABLE,
    'clickOnZone'           => ODDragNDrop::STATE_DISABLE,
    'acceptedFiles'         => [],
    'multiple'              => false,
    'dispatchEvents'        => true,
    'overwriteInitial'      => ODDragNDrop::STATE_DISABLE,
    'loadedPaths'           => [],
    'loadedPreview'         => [],
    'loadedFiles'           => [],
    'uploadedFilesPath'     => "../data/uploadedFiles",
];