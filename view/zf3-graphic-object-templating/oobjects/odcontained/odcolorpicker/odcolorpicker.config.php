<?php

use GraphicObjectTemplating\OObjects\ODContained\ODColorpicker;

return [
    'object'            => 'odcolorpicker',
    'typeObj'           => 'odcontained',
    'template'          => 'odcolorpicker.twig',

    'label'             => '',
    'labelWidthBT'      => '',
    'inputWidthBT'      => '',
    'colorRGB'          => 'ffffff',
    'defaultPalette'    => 'theme',
    'displayIndicator'  => ODColorpicker::BOOLEAN_TRUE,
    'hideButton'        => ODColorpicker::BOOLEAN_FALSE,
    'history'           => ODColorpicker::BOOLEAN_TRUE,
    'initialHistory'    => null,
    'showOn'            => ODColorpicker::SHOWON_BOTH,
    'strings'           => "Theme Colors,Standard Colors,Web Colors,Theme Colors,Back to Palette,History,No history yet.",
    'transparentColor'  => ODColorpicker::BOOLEAN_FALSE,

];