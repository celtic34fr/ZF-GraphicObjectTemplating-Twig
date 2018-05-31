<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 29/05/18
 * Time: 12:57
 */

namespace GraphicObjectTemplating\View\Helper;

use GraphicObjectTemplating\Service\GotServices;
use Zend\View\Helper\AbstractHelper;

class GotBootstrap extends AbstractHelper
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
        $html = $this->gs->bootstrap($object);
        return $html;
    }
}
?>
