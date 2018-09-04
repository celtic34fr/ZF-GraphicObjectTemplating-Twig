<?php

namespace GraphicObjectTemplating\ViewHelpers\Factory;


use GraphicObjectTemplating\Service\ZF3GotServices;
use GraphicObjectTemplating\ViewHelpers\ZF3GotBootstrap;
use Interop\Container\ContainerInterface;
use Interop\Container\Exception\ContainerException;
use Zend\ServiceManager\Exception\ServiceNotCreatedException;
use Zend\ServiceManager\Exception\ServiceNotFoundException;
use Zend\ServiceManager\Factory\FactoryInterface;

class ZF3GotBootstrapFactory implements FactoryInterface
{
    /**
     * Create an object
     *
     * @param  ContainerInterface $container
     * @param  string $requestedName
     * @param  null|array $options
     * @return ZF3GotBootstrap
     * @throws ServiceNotFoundException if unable to resolve the service.
     * @throws ServiceNotCreatedException if an exception is raised when
     *     creating a service.
     * @throws ContainerException if any other error occurs
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        /** @var GotServices $gotServices*/
        $gotServices =  $container->get('graphic.object.templating.services');
        return new ZF3GotBootstrap($gotServices);
    }
}
