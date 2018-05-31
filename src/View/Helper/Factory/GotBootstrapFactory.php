<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 29/05/18
 * Time: 12:57
 */

namespace GraphicObjectTemplating\View\Helper\Factory;


use GraphicObjectTemplating\Service\GotServices;
use GraphicObjectTemplating\View\Helper\GotBootstrap;
use Interop\Container\ContainerInterface;
use Interop\Container\Exception\ContainerException;
use Zend\ServiceManager\Exception\ServiceNotCreatedException;
use Zend\ServiceManager\Exception\ServiceNotFoundException;
use Zend\ServiceManager\Factory\FactoryInterface;
use GraphicObjectTemplating\View\Helper\GotRender;

class GotBootstrapFactory implements FactoryInterface
{
    /**
     * Create an object
     *
     * @param  ContainerInterface $container
     * @param  string $requestedName
     * @param  null|array $options
     * @return GotRender
     * @throws ServiceNotFoundException if unable to resolve the service.
     * @throws ServiceNotCreatedException if an exception is raised when
     *     creating a service.
     * @throws ContainerException if any other error occurs
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        /** @var GotServices $gotServices*/
        $gotServices =  $container->get('graphic.object.templating.services');
        return new GotBootstrap($gotServices);
    }
}
