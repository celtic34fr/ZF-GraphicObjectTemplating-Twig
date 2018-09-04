<?php

namespace GraphicObjectTemplating\Service\Factory;

use Interop\Container\ContainerInterface;
use Interop\Container\Exception\ContainerException;
use Zend\ServiceManager\Exception\ServiceNotCreatedException;
use Zend\ServiceManager\Exception\ServiceNotFoundException;
use Zend\ServiceManager\Factory\FactoryInterface;
use Zend\ServiceManager\ServiceManager;
use GraphicObjectTemplating\Service\ZF3GotServices;
use ZfcTwig\View\TwigRenderer;

class ZF3GotServicesFactory implements FactoryInterface
{
    /**
     * Create an object
     *
     * @param  ContainerInterface $container
     * @param  string $requestedName
     * @param  null|array $options
     * @return object
     * @throws ServiceNotFoundException if unable to resolve the service.
     * @throws ServiceNotCreatedException if an exception is raised when
     *     creating a service.
     * @throws ContainerException if any other error occurs
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        /** @var ServiceManager $serviceManager */
        $serviceManager =  $container->get('ServiceManager');
        /** @var TwigRenderer $twigRender */
        $twigRender  = $container->get('ZfcTwigRenderer');

        return new ZF3GotServices($serviceManager, $twigRender);
    }
}
?>
