<?php

namespace ZF3_GOT\ViewHelpers\Factory;

use ZF3_GOT\Service\ZF3GotServices;
use Interop\Container\ContainerInterface;
use Interop\Container\Exception\ContainerException;
use Zend\ServiceManager\Exception\ServiceNotCreatedException;
use Zend\ServiceManager\Exception\ServiceNotFoundException;
use Zend\ServiceManager\Factory\FactoryInterface;
use ZF3_GOT\ViewHelpers\ZF3GotRender;

class ZF3GotRenderFactory implements FactoryInterface
{
    /**
     * Create an object
     *
     * @param  ContainerInterface $container
     * @param  string $requestedName
     * @param  null|array $options
     * @return ZF3GotRender
     * @throws ServiceNotFoundException if unable to resolve the service.
     * @throws ServiceNotCreatedException if an exception is raised when
     *     creating a service.
     * @throws ContainerException if any other error occurs
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        /** @var ZF3GotServices $gotServices*/
        $gotServices =  $container->get('graphic.object.templating.services');
        return new ZF3GotRender($gotServices);
    }
}