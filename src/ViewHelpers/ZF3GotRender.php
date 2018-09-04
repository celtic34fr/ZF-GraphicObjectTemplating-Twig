<?php

namespace ZF3_GOT\ViewHelpers;

use ZF3_GOT\Service\ZF3GotServices;
use Zend\View\Helper\AbstractHelper;

class ZF3GotRender extends AbstractHelper
{
    /** @var ZF3GotServices $gs */
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