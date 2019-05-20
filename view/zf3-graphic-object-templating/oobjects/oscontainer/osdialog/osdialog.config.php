<?php

use GraphicObjectTemplating\OObjects\OSContainer\OSDialog;

return [
    'object'        => 'osdialog',
    'typeObj'       => 'oscontainer',
    'template'      => 'osdialog.twig',

    'animate'       => true,
    'btnClose'      => true,
    'closeBtnOnly'  => false,
    'title'         => '',
    'widthDialog'   => '',
    'minHeight'     => '',
    'size'          => OSDialog::SIZE_NORMAL,
    'bgColor'       => OSDialog::COLOR_WHITE,
    'fgColor'       => OSDialog::COLOR_BLACK,
    'contents'      => [],
];