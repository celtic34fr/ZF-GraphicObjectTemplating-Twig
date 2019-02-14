<?php

use GraphicObjectTemplating\OObjects\ODContained\ODCaptcha;

return [
    'object'            => 'odcaptcha',
    'typeObj'           => 'odcontained',
    'template'          => 'odcaptcha.twig',

    'baseCaracters'     => ODCaptcha::BASE_CARACTERS_ALPHAUP,
    'baseLength'        => 5,
    'generatedString'   => '',
    'generatedCaptcha'  => '',
    'fonts'             => [__DIR__.'/../../../../../public/fonts/icomoon.ttf',
                            __DIR__.'/../../../../../public/fonts/fontawesome-webfont.ttf'],

    'imgWidth'          => '200pt',
    'imgHeight'         => '50pt',

    'resources' => [
        'css'		=> [],
        'js'		=> [
            'odcaptcha.js' => 'js/odcaptcha.js',
        ],
    ],
];