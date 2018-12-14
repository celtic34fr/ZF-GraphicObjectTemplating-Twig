<?php

use GraphicObjectTemplating\OObjects\ODContained\ODDatetimepicker;

return [
    'object'        => 'oddatetimepicker',
    'typeObj'       => 'odcontained',
    'template'      => 'oddatetimepicker.twig',

    'minDate'       => '',
    'maxDate'       => '',
    'formatDate'    => ODDatetimepicker::DATETIMEPICKER_LONGTIME,
    'defaultDate'   => (new \DateTime())->format('m/d/Y'),
    'viewMode'      => ODDatetimepicker::DATETIMEPICKER_VMODEDAYS,
    'inline'        => false,
    'disabledDates' => [],
    'locale'        => 'fr',

    'resources' => [
        'css'		=> [
            'bootstrap-datetimepicker.css' => 'css/bootstrap-datetimepicker.css',
            'bootstrap-datetimepicker-standalone.css' => 'css/bootstrap-datetimepicker-standalone.css',
        ],
        'js'		=> [
            'moment.js' => 'js/moment.js',
            'bootstrap-datetimepicker.js' => 'js/bootstrap-datetimepicker.js',
        ],
    ],
];