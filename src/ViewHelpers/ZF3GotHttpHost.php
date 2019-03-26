<?php

namespace GraphicObjectTemplating\ViewHelpers;

use Zend\Form\View\Helper\AbstractHelper;

class ZF3GotHttpHost extends AbstractHelper
{

    protected $http_host;

    public function __construct()
    {
        $this->http_host = $_SERVER['HTTP_HOST'];
    }

    public function __invoke()
    {
        return $this->http_host;
    }

}