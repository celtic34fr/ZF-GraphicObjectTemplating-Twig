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

    /** rendu de l'objet en code HTML */
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

    /** récupération et formatage des enttêtes chargement ressources CSS & Js */
    public function header($object)
    {
        $view = new ViewModel();

        $scripts = $this->rscs($objets); // méthode dde récupération filtrage des ressources

        if ($scripts) {
            $view->setTemplate('graphic-object-templating/got/got-header.twig');
            $view->setVariable('scripts', array('css' => $scripts['cssScripts'], 'js' => $scripts['jsScripts']));
            $renduHtml = $this->_twigRender->render($view);
            return $renduHtml;
        }
        return false;
    }

    public function rscs($objects)
    {
        if ($objects != null) {
            if (!($objects instanceof OObject)) {
                $objects = OObject::buildObject($objects);
            }
            $cssScripts = $jsScripts = [];
            $rscs = "";
            if (!is_array($objects)) {
                $objects = array(0 => $objects);
            }

            foreach ($objects as $object) {
                if ($object != null) {
                    $properties = $object->getProperties();
                    $prefix = 'graphicobjecttemplating/oobjects/';
                    if (array_key_exists('extension', $properties) && $properties['extension']) {
                        $prefix = $properties['resources']['prefix'];
                    }
                    $rscs = (isset($properties['resources'])) ? $properties['resources'] : "";
                    if (!empty($rscs) && ($rscs !== false)) {
                        $cssList = $rscs['css'];
                        $jsList = $rscs['js'];
                        if (!empty($cssList)) {
                            foreach ($cssList as $item) {
                                if (!in_array($item, $cssScripts)) {
                                    $cssScripts[] = $prefix . $properties['typeObj'] . '/' . $properties['object'] . '/' . $item;
                                }
                            }
                        }
                        if (!empty($jsList)) {
                            foreach ($jsList as $item) {
                                if (!in_array($item, $jsScripts)) {
                                    $jsScripts[] = $prefix . $properties['typeObj'] . '/' . $properties['object'] . '/' . $item;
                                }
                            }
                        }
                    }

                    if ($object instanceof OSContainer || $object instanceof OESContainer) {
                        $children = $object->getChildren();
                        if (!empty($children)) {
                            foreach ($children as $child) {
                                $tmpArray = $this->headerChild($child);
                                foreach ($tmpArray['css'] as $css) {
                                    if (!in_array($css, $cssScripts)) {
                                        $cssScripts[] = $css;
                                    }
                                }
                                foreach ($tmpArray['js'] as $js) {
                                    if (!in_array($js, $jsScripts)) {
                                        $jsScripts[] = $js;
                                    }
                                }
                            }
                        }
                    }
                }
            }
            return ['cssScripts' => $cssScripts, 'jsScripts' => $jsScripts];
        }
        return false;
    }
}