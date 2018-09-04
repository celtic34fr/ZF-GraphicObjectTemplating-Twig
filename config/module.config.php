<?php

namespace GraphicObjectTemplating;

use GraphicObjectTemplating\Controller\Factory\MainControllerFactory;
use GraphicObjectTemplating\Controller\MainController;
use GraphicObjectTemplating\Service\Factory\ZF2GotServicesFactory;
use GraphicObjectTemplating\Service\ZF3GotServices;
use GraphicObjectTemplating\View\Helper\Factory\ZF3GotBootstrapFactory;
use GraphicObjectTemplating\View\Helper\Factory\ZF3GotHeaderFactory;
use GraphicObjectTemplating\View\Helper\Factory\ZF3GotRenderFactory;
use GraphicObjectTemplating\View\Helper\Factory\ZF3GotZendVersionFactory;
use GraphicObjectTemplating\View\Helper\ZF3GotBootstrap;
use GraphicObjectTemplating\View\Helper\ZF3GotHeader;
use GraphicObjectTemplating\View\Helper\ZF3GotRender;
use GraphicObjectTemplating\View\Helper\ZF3GotZendVersion;
use Zend\Router\Http\Literal;

return [

    'router' => [
        'routes' => [
            'gotDispatch' => [
                'type' => Literal::class,
                'options' => [
                    'route'    => '/gotDispatch',
                    'defaults' => [
                        'controller' => MainController::class,
                        'action'     => 'gotDispatch',
                    ],
                ],
            ],
        ],
    ],

    'controllers' => [
        'factories' => [
            MainController::class => MainControllerFactory::class,
        ],
    ],

    'service_manager' => [
        'factories' => [
            ZF3GotServices::class => ZF3GotServicesFactory::class,
        ],
        'aliases' => [
            'graphic.object.templating.services' => ZF3GotServices::class,
        ]
    ],

    'view_helpers' => [
        'factories' => [
            ZF3GotRender::class     => ZF3GotRenderFactory::class,
            ZF3GotBootstrap::class  => ZF3GotBootstrapFactory::class,
            ZF3GotHeader::class     => ZF3GotHeaderFactory::class,
            ZF3GotVersion::class    => ZF3GotVersionFactory::class,
        ],
        'aliases' => [
            'gotRender'     => ZF3GotRender::class,
            'gotBootstrap'  => ZF3GotBootstrap::class,
            'gotHeader'     => ZF3GotHeader::class,
            'gotversion'    => ZF3GotVersion::class,
        ],
    ],
    'view_manager' => [
        'template_path_stack' => [
            __DIR__ . '/../view',
        ],
    ],
];