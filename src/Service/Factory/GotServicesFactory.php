<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 29/05/18
 * Time: 12:59
 */

namespace GraphicObjectTemplating\Service\Factory;


use GraphicObjectTemplating\Service\GotServices;
use Interop\Container\ContainerInterface;
use Interop\Container\Exception\ContainerException;
use Zend\ServiceManager\Exception\ServiceNotCreatedException;
use Zend\ServiceManager\Exception\ServiceNotFoundException;
use Zend\ServiceManager\Factory\FactoryInterface;
use Zend\ServiceManager\ServiceManager;
use ZfcTwig\View\TwigRenderer;

class GotServicesFactory implements FactoryInterface
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
        return new GotServices($serviceManager, $twigRender);
    }
}
?>
