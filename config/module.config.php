<?php

namespace GraphicObjectTemplating;

use GraphicObjectTemplating\Controller\Factory\MainControllerFactory;
use GraphicObjectTemplating\Controller\MainController;
use GraphicObjectTemplating\Service\Factory\ZF3GotServicesFactory;
use GraphicObjectTemplating\Service\ZF3GotServices;
use GraphicObjectTemplating\ViewHelpers\Factory\ZF3GotBootstrapFactory;
use GraphicObjectTemplating\ViewHelpers\Factory\ZF3GotHeaderFactory;
use GraphicObjectTemplating\ViewHelpers\Factory\ZF3GotRenderFactory;
use GraphicObjectTemplating\ViewHelpers\Factory\ZF3GotVersionFactory;
use GraphicObjectTemplating\ViewHelpers\ZF3GotBootstrap;
use GraphicObjectTemplating\ViewHelpers\ZF3GotHeader;
use GraphicObjectTemplating\ViewHelpers\ZF3GotRender;
use GraphicObjectTemplating\ViewHelpers\ZF3GotVersion;
use Zend\Router\Http\Literal;
//use Zend\Router\Http\Segment;
//use Zend\ServiceManager\Factory\InvokableFactory;

return [
    'parameters' => [
        'coreViewRoot' => __DIR__ . '/../view/zf3-graphic-object-templating',
    ],

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
            'gotDownload' => [
                'type' => Literal::class,
                'options' => [
                    'route'    => '/download/:idDND/:loadedFileID',
                    'defaults' => [
                        'controller' => MainController::class,
                        'action'     => 'gotDownload',
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