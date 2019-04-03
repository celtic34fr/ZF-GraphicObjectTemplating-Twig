<?php

use GraphicObjectTemplating\OObjects\ODContained\ODTextarea;

return array(
    "object"        => "odtextarea",
    "typeObj"       => "odcontained",
    "template"      => "odtextarea.twig",

    "cols"          => "",
    "rows"          => "",
    "maxLength"     => "",
    "placeholder"   => "",
    "text"          => "",
    'event'         => [],
    'textareaWidth' => '',
    'labelWidthBT'  => '',
    'resize'        => ODTextarea::TEXTAREA_RESIZEBOTH,
    'wysiwyg'       => false,
    'plugins'       => '',
    'toolbar'       => '',
    'imgListUrl'    => '',
    'lnkListUrl'    => '',
);