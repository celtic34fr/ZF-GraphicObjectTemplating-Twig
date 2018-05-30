<?php

namespace GraphicObjectTemplating\Service;

use GraphicObjectTemplating\OObjects\OObject;
use GraphicObjectTemplating\OObjects\OSContainer;
use GraphicObjectTemplating\OObjects\OESContainer;
use Zend\View\Model\JsonModel;
use Zend\View\Model\ViewModel;

class GotServices
{
    private $_serviceManager;
    private $_twigRender;

    public function __construct($sm, $tr)
    {
        $this->_serviceManager = $sm;
        $this->_twigRender = $tr;
        return $this;
    }

}