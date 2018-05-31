<?php

namespace GraphicObjectTemplating\View\Helper;

use GraphicObjectTemplating\Service\GotServices;
use Zend\View\Helper\AbstractHelper;

class GotHeader extends AbstractHelper
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
        $html = $this->gs->header($object);
        return $html;
    }
}
?>