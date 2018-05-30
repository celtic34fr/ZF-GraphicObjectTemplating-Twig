<?php

namespace GraphicObjectTemplating\View\Helper;

use GraphicObjectTemplating\Service\GotServices;
use Zend\View\Helper\AbstractHelper;

class GotRender extends AbstractHelper
{
    /** @var GotServices $gs */
    protected $gs;

    public function __construct($gs)
    {
        $this->gs = $gs;
        return $this;
    }

    public function __invoke($object)
    {
        $html = $this->gs->render($object);
        return $html;
    }
}
?>