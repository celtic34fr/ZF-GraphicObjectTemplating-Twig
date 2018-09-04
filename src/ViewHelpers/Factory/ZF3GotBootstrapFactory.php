<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 29/05/18
 * Time: 12:57
 */

namespace ZF3_GOT\ViewHelpers\Factory;


use ZF3_GOT\Service\ZF3GotServices;
use ZF3_GOT\ViewHelpers\ZF3GotBootstrap;
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
