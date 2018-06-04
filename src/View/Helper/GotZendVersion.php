<?php

namespace GraphicObjectTemplating\View\Helper;

use Zend\View\Helper\AbstractHelper;
use Application\Module;

class GotZendVersion extends AbstractHelper
{
    public function __invoke()
    {
        return Module::VERSION;
    }
}