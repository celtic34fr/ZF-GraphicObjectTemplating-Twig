<?php

use GraphicObjectTemplating\OObjects\ODContained\ODMenuOld;

return [
    'object'        => 'odmenuold',
    'typeObj'       => 'odcontained',
    'template'      => 'odmenuold.twig',

    'dataTree'		=> [],
    'dataPath'		=> [],
    'activeMenu'    => false,
    'mode'          => ODMenuOld::ODMENUMODE_CLICK,
];
