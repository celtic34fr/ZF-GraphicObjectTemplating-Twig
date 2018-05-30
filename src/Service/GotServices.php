<?php

namespace GraphicObjectTemplating\Service;

use GraphicObjectTemplating\OObjects\OObject;
use GraphicObjectTemplating\OObjects\OSContainer;
use GraphicObjectTemplating\OObjects\OESContainer;
use Zend\View\Model\JsonModel;
use Zend\View\Model\ViewModel;

/**
 * Class GotServices
 * @package GraphicObjectTemplating\Service
 *
 * Service pour exécution des méthode utilises en services et viewHelper
 *
 * render($object) : rendu HTML d'un objet avec gestion des types usuels
 */

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

    public function render($object)
    {
            if ($object != null) {
            $html       = new ViewModel();
            if (!($object instanceof OObject)) {
                $object = OObject::buildObject($object);
            }
            if ($object instanceof OObject) {
                $properties = $object->getProperties();
                $template   = $properties['template'];

                switch($properties['typeObj']) {
                    case 'odcontained' :
                    case 'oedcontained':
                        $html->setTemplate($template);
                        $html->setVariable('objet', $properties);
                        break;
                    case 'oscontainer':
                    case 'oescontainer':
                        $content  = "";
                        $children = $object->getChildren();
                        if (!empty($children)) {
                            foreach ($children as $child) {
                                $rendu    = $this->render($child);
                                $content .= $rendu;
                            }
                        }
                        $html->setTemplate($template);
                        $html->setVariable('objet', $properties);
                        $html->setVariable('content', $content);
                        break;
                }
                $renduHtml = $this->_twigRender->render($html);
                return str_replace(array("\r\n", "\r", "\n"), "", $renduHtml);
            }
            return false;
        }
    }
}