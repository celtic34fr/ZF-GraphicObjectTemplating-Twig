<?php

namespace ZF3_GOT\ViewHelpers;

use Zend\View\Helper\AbstractHelper;
use Zend\ServiceManager\ServiceManager;

class ZF3GotVersion extends AbstractHelper
{
    /** @var ServiceManager $sm */
    protected $sm;

    public function __construct($sm)
    {
        $this->sm = $sm;
        return $this;
    }

    public function __invoke()
    {
        $config = $this->sm->get('Config');
        if (array_key_exists('gotParameters', $config)) { 
            $config = $config['gotParameters'];
            if (array_key_exists('version', $config)) {
                return $config['version'];
            }
        }
        return '';
    }
}