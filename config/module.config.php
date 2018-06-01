<?php

namespace GraphicObjectTemplating;

use GraphicObjectTemplating\Service\Factory\GotServicesFactory;
use GraphicObjectTemplating\Service\GotServices;
use GraphicObjectTemplating\View\Helper\Factory\GotBootstrapFactory;
use GraphicObjectTemplating\View\Helper\Factory\GotHeaderFactory;
use GraphicObjectTemplating\View\Helper\Factory\GotRenderFactory;
use GraphicObjectTemplating\View\Helper\GotBootstrap;
use GraphicObjectTemplating\View\Helper\GotHeader;
use GraphicObjectTemplating\View\Helper\GotRender;

return [

    'service_manager' => array(
        'factories' => array(
            GotServices::class                      => GotServicesFactory::class,
            'graphic.object.templating.services'    => GotServicesFactory::class,
        )
    ),

    'view_helpers' => [
        'factories' => [
            GotRender::class     => GotRenderFactory::class,
            GotBootstrap::class  => GotBootstrapFactory::class,
            GotHeader::class     => GotHeaderFactory::class,
        ],
        'aliases' => [
            'gotRender'     => GotRender::class,
            'gotBootstrap'  => GotBootstrap::class,
            'gotHeader'     => GotHeader::class,
        ],
    ],
];