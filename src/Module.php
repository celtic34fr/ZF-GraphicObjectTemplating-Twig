<?php

namespace GraphicObjectTemplating;

use GraphicObjectTemplating\Factory\PersistObjectInterface;
use GraphicObjectTemplating\OObjects\OObject;
use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\ModuleManager\Feature\ConfigProviderInterface;
use Zend\ModuleManager\Feature\ViewHelperProviderInterface;
use Zend\Mvc\MvcEvent;
use Zend\ServiceManager\ServiceManager;
use Zend\Session\Config\SessionConfig;
use Zend\Session\Container;
use Zend\Session\SessionManager;

class Module implements AutoloaderProviderInterface, ConfigProviderInterface,
    ViewHelperProviderInterface
{
    /**
     * @param MvcEvent $e
     */
    public function onBootstrap(MvcEvent $e)
    {
        $serviceManager = $e->getApplication()->getServiceManager();
        $config = $serviceManager->get('Config');
        $gotParams = $config['gotParameters'] ?? [];
        if (!empty($gotParams)) {
            $paramsSession = $gotParams['sessionParms'] ?? [];
            $persistantObjects = $gotParams["persistantObjects"] ?? [];
            if (empty($paramsSession)) {
                $paramsSession = [
                    'remember_me_seconds' => 3600, // 2 heures de temps de vie (rememberMe)
                    'gc_maxlifetime' => 14400,     // 4 heures de temps de vie max
                    'gc_divisor' => 1,
                    'use_cookies' => true,
                    'cookie_httponly' => true,
                ];
            }
            $this->initSession($paramsSession);
            if (!empty($persistantObjects)) {
                $this->initPersistantObjs($serviceManager, $persistantObjects);
            }
        }
    }

    /**
     * Returns configuration to merge with application configuration
     *
     * @return array|\Traversable
     */
    public function getConfig()
    {
        return include __DIR__ . '/../config/module.config.php';
    }

    /**
     * Return an array for passing to Zend\Loader\AutoloaderFactory.
     *
     * @return array
     */
    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    // Autoload all classes from namespace 'GraphicObjectTemplating' from '/module/GraphicObjectTemplating/src/GraphicObjectTemplating'
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                )
            )
        );
    }

    /**
     * @return array|void|\Zend\ServiceManager\Config
     */
    public function getViewHelperConfig()
    {
    }

    /*
     * impltentation de Session
     */
    public function initSession($config)
    {
        $sessionConfig = new SessionConfig();
        $sessionConfig->setOptions($config);
        $sessionManager = new SessionManager($sessionConfig);
        $sessionManager->start();
        Container::setDefaultManager($sessionManager);
    }

    /**
     * @param ServiceManager $sm
     * @param array $persistantObjects
     * @throws \Exception
     */
    public function initPersistantObjs(ServiceManager $sm, array $persistantObjects)
    {
        $container = new Container('gotObjList');
        $container->persistObjs = $persistantObjects;

        foreach ($persistantObjects as $id => $class) {
            if (is_subclass_of($class, PersistObjectInterface::class)) {
                /** @var OObject|PersistObjectInterface $tmpObj */
                $tmpObj = new $class($id);
                $tmpObj->init($sm);
                $tmpObj->saveProperties();
            }
        }
    }
}