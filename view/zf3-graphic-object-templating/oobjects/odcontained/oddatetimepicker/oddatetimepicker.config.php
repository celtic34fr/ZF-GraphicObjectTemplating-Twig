<?php

use GraphicObjectTemplating\OObjects\ODContained\ODDateTimePicker;

return [
    'object'        => 'oddatetimepicker',
    'typeObj'       => 'odcontained',
    'template'      => 'oddatetimepicker.twig',

    'minDate'       => '',
    'maxDate'       => '',
    'formatDate'    => ODDateTimePicker::DATETIMEPICKER_LONGTIME,
    'defaultDate'   => (new \DateTime())->format('m/d/Y'),
    'viewMode'      => ODDateTimePicker::DATETIMEPICKER_VMODEDAYS,
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