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
    'enableSeconds' => false,
    'dateFormat'    => ODDateTimePicker::DATETIMEPICKER_DATEFR,
    'time_24hr'     => false,
    'noCalendar'    => false,
    'inline'        => false,
    'altInput'      => false,
    'altFormat'     => 'F j, Y',
    'mode'          => ODDateTimePicker::DATETIMEPICKER_MODESINGLE,
    'defaultDate'   => '',

    'resources' => [
        'css'		=> [
            'flatpickr.css' => 'flatpickr/flatpickr.css'
        ],
        'js'		=> [
            'flatpickr.js'  => 'flatpickr/flatpickr.js',
        ],
    ],
];
