<?php

use GraphicObjectTemplating\OObjects\ODContained\ODCaptcha;

return [
    'object'            => 'odcaptcha',
    'typeObj'           => 'odcontained',
    'template'          => 'odcaptcha.twig',

    'label'             => 'CAPTCHA',
    'placeholder'       => 'saisir les caractères',
    'baseCaracters'     => ODCaptcha::BASE_CARACTERS_ALPHAUP,
    'baseLength'        => 5,
    'generatedString'   => '',
    'generatedCaptcha'  => '',
    'fonts'             => ['Cookie'                => __DIR__.'/../../../../../public/fonts/Cookie-Regular.ttf',
                            'EuropeanTypewriter'    => __DIR__.'/../../../../../public/fonts/EuropeanTypewriter.ttf'],

    'imgWidth'          => 300,
    'imgHeight'         => 75,
    'charSize'          => 35,

    'resources' => [
        'css'		=> [],
        'js'		=> [
            'odcaptcha.js' => 'js/odcaptcha.js',
        ],
    ],
];