<?php

use GraphicObjectTemplating\OObjects\ODContained\ODDateTimePicker;

return [
    'object'        => 'oddatetimepicker',
    'typeObj'       => 'odcontained',
    'template'      => 'oddatetimepicker.twig',

    'minDate'       => '',
    'maxDate'       => '',
    'minTime'       => '',
    'maxTime'       => '',
    'locale'        => 'fr',
    'enableTime'    => false,
    'dateFormat'    => ODDateTimePicker::DATETIMEPICKER_DATEFR,
    'time_24hr'     => false,
    'noCalendar'    => false,
    'inline'        => false,

    'resources' => [
        'css'		=> [
            'flatpickr.css' => 'flatpickr/flatpickr.css'
        ],
        'js'		=> [
            'flatpickr.js'  => 'flatpickr/flatpickr.js',
        ],
    ],
];
