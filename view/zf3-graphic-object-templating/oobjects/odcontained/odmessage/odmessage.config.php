<?php

use GraphicObjectTemplating\OObjects\ODContained\ODMessage;

return [
    'object'        => 'odmessage',
    'typeObj'       => 'odcontained',
    'template'      => 'odmessage.twig',

    'action'            => ODMessage::ODMESSAGEACTION_INIT,
    'horizontalOffset'  => 5,
    'verticalOffset'    => 5,
    'width'             => '600',
    'height'            => 'auto',
    'closeButton'       => 'true',
    'draggable'         => 'false',
    'customBtnClass'    => 'lobibox-btn lobibox-btn-default',
    'modal'             => 'true',
    'debug'             => 'false',
    'buttonAlign'       => ODMessage::ODMESSAGEBTNALIGN_CENTER,
    'closeOnEsc'        => 'true',
    'delayToRemove'     => 200,
    'delay'             => 'false',
    'baseClass'         => 'animated-super-fast',
    'showClass'         => 'zoomIn',
    'hideClass'         => 'zoomOut',
    'iconSource'        => ODMessage::ODMESSAGEICON_BOOTSTRAP,

    'msgType'           => ODMessage::ODMESSAGETYPE_CONFIRM,

    /** confirm & alert attributes */
    'title'         => '',
    'nature'        => ODMessage::ODMESSAGEMSGNATURE_INFO,
    /** prompt attributes */
    'attrs'         => [],
    'value'         => '',
    'multiline'     => 'false',
    'lines'         => 1,
    'type'          => ODMessage::ODMESSAGEPROMPT_TEXT,
    'label'         => '',                                  // utilisé également par progress
    'required'      => 'true',
    'errorMessage'  => '',
    /** progress attributes */
    'showProgressLabel' => 'true',
    'progressTpl'       => 'false',
    /** windows attributes */
    'content'       => '',
    'url'           => '',
    'autoload'      => 'true',
    'loadMethod'    => ODMessage::ODMESSAGEWINDOWLOAD_GET,
    'showAfterLoad' => 'true',
    'params'        => [],


    'resources' => [
        'css' => [
            'lobibox.css' => 'css/lobibox.css'
        ],
        'js'  => [
            'messageboxes.js' => 'js/messageboxes.js'
        ],
    ]
];