<?php

use GraphicObjectTemplating\OObjects\ODContained\ODMessage;

return [
    'object'            => 'odmessage',
    'typeObj'           => 'odcontained',
    'template'          => 'odmessage.twig',

    'action'            => ODMessage::ODMESSAGEACTION_INIT,
    'horizontalOffset'  => 5,
    'verticalOffset'    => 5,
    'width'             => '600',
    'height'            => "'auto'",
    'closeButton'       => ODMessage::BOOLEAN_TRUE,
    'draggable'         => ODMessage::BOOLEAN_FALSE,
    'customBtnClass'    => 'lobibox-btn lobibox-btn-default',
    'modal'             => ODMessage::BOOLEAN_TRUE,
    'debug'             => ODMessage::BOOLEAN_FALSE,
    'buttonAlign'       => ODMessage::ODMESSAGEBTNALIGN_CENTER,
    'closeOnEsc'        => ODMessage::BOOLEAN_FALSE,
    'delayToRemove'     => '200',
    'delay'             => ODMessage::BOOLEAN_FALSE,
    'baseClass'         => 'animated-super-fast',
    'showClass'         => 'zoomIn',
    'hideClass'         => 'zoomOut',
    'iconSource'        => ODMessage::ODMESSAGEICON_BOOTSTRAP,

    'msgType'           => ODMessage::ODMESSAGETYPE_CONFIRM,

    /** confirm & alert attributes */
    'title'             => '',
    'body'              => '',
    'nature'            => ODMessage::ODMESSAGEMSGNATURE_INFO,
    /** prompt attributes */
    'attrs'             => [],
    'value'             => '',
    'multiline'         => ODMessage::BOOLEAN_FALSE,
    'lines'             => 1,
    'type'              => ODMessage::ODMESSAGEPROMPT_TEXT,
    'label'             => '',                                  // utilisé également par progress
    'required'          => ODMessage::BOOLEAN_TRUE,
    'errorMessage'      => '',
    /** progress attributes */
    'showProgressLabel' => ODMessage::BOOLEAN_TRUE,
    'progressTpl'       => ODMessage::BOOLEAN_FALSE,
    /** windows attributes */
    'content'           => '',
    'url'               => '',
    'autoload'          => ODMessage::BOOLEAN_TRUE,
    'loadMethod'        => ODMessage::ODMESSAGEWINDOWLOAD_GET,
    'showAfterLoad'     => ODMessage::BOOLEAN_TRUE,
    'params'            => [],
];