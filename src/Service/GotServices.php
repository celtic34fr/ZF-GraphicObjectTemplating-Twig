<?php

namespace GraphicObjectTemplating\Service;

use GraphicObjectTemplating\OObjects\OObject;
use GraphicObjectTemplating\OObjects\OSContainer;
use GraphicObjectTemplating\OObjects\OESContainer;
use Zend\ServiceManager\ServiceManager;
use Zend\View\Model\JsonModel;
use Zend\View\Model\ViewModel;
use ZfcTwig\View\TwigRenderer;

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
    /** @var ServiceManager $_serviceManager */
    private $_serviceManager;
    /** @var TwigRenderer $_twigRender */
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

        $scripts = $this->rscs($object); // méthode dde récupération filtrage des ressources

        if ($scripts) {
            $view->setTemplate('graphic-object-templating/got/got-header.twig');
            $view->setVariable('scripts', array('css' => $scripts['cssScripts'], 'js' => $scripts['jsScripts']));
            $renduHtml = $this->_twigRender->render($view);
            return $renduHtml;
        }
        return false;
    }

    public function bootstrap($object)
    {
        if (!($object instanceof OObject)) {
            $object = OObject::buildObject($object);
        }
        if ($object instanceof OObject) {
            $properties = $object->getProperties();
            $widthsBT = $properties['widthBT'] ?? '';
            $classesObj = '';
            if (!empty($widthsBT)) {
                $widthsBT = explode(':', $widthsBT);
                foreach ($widthsBT as $widthBt) {
                    switch (strtoupper(substr($widthBt,0,2))) {
                        case 'WL' : $classesObj .= ' col-lg-'.substr($widthBt, 2); break;
                        case 'WM' : $classesObj .= ' col-md-'.substr($widthBt, 2); break;
                        case 'WS' : $classesObj .= ' col-sm-'.substr($widthBt, 2); break;
                        case 'WX' : $classesObj .= ' col-xs-'.substr($widthBt, 2); break;
                        case 'OL' : $classesObj .= ' offset-lg-'.substr($widthBt, 2); break;
                        case 'OM' : $classesObj .= ' offset-md-'.substr($widthBt, 2); break;
                        case 'OS' : $classesObj .= ' offset-sm-'.substr($widthBt, 2); break;
                        case 'OX' : $classesObj .= ' offset-xs-'.substr($widthBt, 2); break;
                    }
                }
            }
            $classesObj .= ' ';
            return $classesObj;
        }
        return false;
    }


    private function rscs($objects)
    {
        if (!empty($objects) && $objects != null) {
            if (!($objects instanceof OObject)) {
                $objects = OObject::buildObject($objects);
            }
            if ($objects instanceof OObject) {
                $rscsTab = [];
                $rscsTab['css'] = [];
                $rscsTab['js'] = [];

                $properties = $objects->getProperties();
                if (!empty($properties['resources'])) {
                    $cssList = [];
                    $jsList = [];
                    $resources = $properties['resources'];
                    if (array_key_exists('css', $resources)) {
                        $cssList = $resources['css'];
                    }
                    if (array_key_exists('js', $resources)) {
                        $jsList = $resources['css'];
                    }
                    if (!empty($cssList)) {
                        foreach ($cssList as $nomCss => $pathCss) {
                            $rscsTab['css'][$nomCss] = $pathCss;
                        }
                    }
                    if (!empty($jsList)) {
                        foreach ($jsList as $nomJs => $pathJs) {
                            $rscsTab['js'][$nomJs] = $pathJs;
                        }
                    }

                    if ($objects instanceof OSContainer || $objects instanceof OESContainer) {
                        $children = $objects->getChildren();
                        foreach ($children as $child) {
                            array_unique(array_merge($rscsTab, $this->rscs($child)), SORT_REGULAR);
                        }
                    }
                }
                return $rscsTab;
            }
        }
        return false;
    }
}