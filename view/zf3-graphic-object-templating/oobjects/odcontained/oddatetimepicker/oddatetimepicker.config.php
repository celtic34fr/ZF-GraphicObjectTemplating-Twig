<?php

use GraphicObjectTemplating\OObjects\ODContained\ODDatetimepicker;

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
    'dateFormat'    => ODDatetimepicker::DATETIMEPICKER_DATEFR,
    'time_24hr'     => false,
    'noCalendar'    => false,
    'inline'        => false,
    'altInput'      => false,
    'altFormat'     => 'F j, Y',
    'mode'          => ODDatetimepicker::DATETIMEPICKER_MODESINGLE,
    'defaultDate'   => '',
    'label'         => '',
    'labelWidthBT'  => '',
    'inputWidthBT'  => '',
    'btnClear'      => false,

    'resources' => [
        'css'		=> [
            'flatpickr.css' => 'flatpickr/flatpickr.css'
        ],
        'js'		=> [
            'flatpickr.js'  => 'flatpickr/flatpickr.js',
        ],
    ],
];
