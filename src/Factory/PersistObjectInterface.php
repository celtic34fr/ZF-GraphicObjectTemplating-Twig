<?php

namespace GraphicObjectTemplating\Factory;

use Zend\ServiceManager\ServiceManager;

interface PersistObjectInterface
{
    /**
     * PersistObjectInterface constructor.
     * @param string $id
     */
    public function __construct($id = 'dummy');

    /**
     * @param ServiceManager $serviceManager
     * @return mixed
     */
    public function init(ServiceManager $serviceManager);
}