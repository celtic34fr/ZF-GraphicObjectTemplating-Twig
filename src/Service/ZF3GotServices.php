<?php

namespace GraphicObjectTemplating\Service;

use Application\Entity\Menus;
use Doctrine\ORM\EntityManager;
use GraphicObjectTemplating\OObjects\ODContained\ODMenu;
use Zend\ServiceManager\ServiceManager;
use Zend\View\Model\ViewModel;
use GraphicObjectTemplating\OObjects\OObject;
use ZfcTwig\View\TwigRenderer;

class ZF3GotServices
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
    /**
     * @param $object       string / OObject
     * @return bool|mixed   false si KO / code HTML
     * @throws \Exception
     */
    public function render($object)
    {
        if ($object instanceof OObject) { $object = $object->getId(); }

        if (!empty($object)) {
            $sessionObj = OObject::validateSession();
            $objects    = $sessionObj->objects;

            if (array_key_exists($object, $objects)) {
                $html       = new ViewModel();
                $properties = unserialize($objects[$object]);
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
                        $children = $properties['children'];
                        if (!empty($children)) {
                            foreach ($children as $child => $value) {
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
        }
        return false;
    }

    /** récupération et formatage des entêtes chargement ressources CSS & Js */
    public function header($object)
    {
        if ($object instanceof OObject) {
            $object = $object->getId();
        }
        if (!empty($object)) {
            $scripts = $this->rscs($object);

            if ($scripts) {
                $view = new ViewModel();
                $view->setTemplate('zf3-graphic-object-templating/main/got-header.twig');
                $view->setVariable('scripts', array('css' => $scripts['cssScripts'], 'js' => $scripts['jsScripts']));
                $renduHtml = $this->_twigRender->render($view);
                return $renduHtml;
            }
        }
        return false;
    }

    public function bootstrap($widthBT)
    {
        $classesObj = '';
        if (!empty($widthBT)) {
            $widthBT = explode(':', $widthBT);
            foreach ($widthBT as $item) {
                switch (strtoupper(substr($item,0,2))) {
                    case 'WL' : $classesObj .= ' col-lg-'.substr($item, 2); break;
                    case 'WM' : $classesObj .= ' col-md-'.substr($item, 2); break;
                    case 'WS' : $classesObj .= ' col-sm-'.substr($item, 2); break;
                    case 'WX' : $classesObj .= ' col-xs-'.substr($item, 2); break;
                    case 'OL' : $classesObj .= ' col-lg-offset-'.substr($item, 2); break;
                    case 'OM' : $classesObj .= ' col-md-offset-'.substr($item, 2); break;
                    case 'OS' : $classesObj .= ' col-sm-offset-'.substr($item, 2); break;
                    case 'OX' : $classesObj .= ' col-xs-offset-'.substr($item, 2); break;
                }
            }
        }
        $classesObj .= ' ';
        return $classesObj;
    }

    /**
     *
     * méthode de récupération filtrage des ressources
     *
     * @param $object : objet GOT passé (ODContained / OSContainer) ou ID
     * @return array|bool : tableau de ressources si traitement OK, sinon boolée false
     * @throws \Exception
     *
     * 2018-08 GARM : Ajout de la mise en session des références des ressources pour éviter de les charger
     * plusieurs fois
     */
    public function rscs($object)
    {
        if ($object instanceof OObject) { $object = $object->getId(); }
        $now                = new \DateTime();
        $gotObjList         = OObject::validateSession();
        $resources          = $gotObjList->resources;
        $objects            = $gotObjList->objects;
        if (empty($resources)) { $resources = []; }

        if (!empty($object) && $object != null && array_key_exists($object, $objects)) {
            $properties             = unserialize($objects[$object]);
            $rscsTab                = [];
            $rscsTab['cssScripts']  = [];
            $rscsTab['jsScripts']   = [];

            /** cas des objets OSContainer -> contenant d'autres objets */
            if ($properties['typeObj'] == 'oscontainer') {
                $children = $properties['children'];
                if (!empty($children)) {
                    foreach ($children as $child => $value) {
                        $newRscsTab = $this->rscs($child);
                        foreach ($newRscsTab['jsScripts'] as $name => $path) {
                            if (!array_key_exists($name, $resources)) {
                                $rscsTab['jsScripts'][$name]    = $path;
                                $resources[$name]               = $path;
                            }
                        }
                        foreach ($newRscsTab['cssScripts'] as $name => $path) {
                            if (!array_key_exists($name, $resources)) {
                                $rscsTab['cssScripts'][$name]   = $path;
                                $resources[$name]               = $path;
                            }
                        }
                    }
                }
            }

            /** traitement de l'objet courrant $object */
            if (!empty($properties['resources'])) {
                $cssList = [];
                $jsList = [];
                $localRscs = $properties['resources'];

                if (array_key_exists('prefix', $localRscs)) {
                    $prefix = 'gotextension/'.$localRscs['prefix'];
                } else {
                    $prefix = 'graphicobjecttemplating/oobjects/';
                }
                $prefix .= $properties['typeObj'].'/'.$properties['object'].'/';

                if (array_key_exists('css', $localRscs)) {
                    $cssList = $localRscs['css'];
                }
                if (array_key_exists('js', $localRscs)) {
                    $jsList = $localRscs['js'];
                }
                if (!empty($cssList)) {
                    foreach ($cssList as $nomCss => $pathCss) {
                        if (!array_key_exists($nomCss, $resources)) {
                            $rscsTab['cssScripts'][$nomCss] = $prefix.$pathCss;
                            $resources[$nomCss]               = $prefix.$pathCss;
                        }
                    }
                }
                if (!empty($jsList)) {
                    foreach ($jsList as $nomJs => $pathJs) {
                        if (!array_key_exists($nomJs, $resources)) {
                            $rscsTab['jsScripts'][$nomJs] = $prefix.$pathJs;
                            $resources[$nomJs]            = $prefix.$pathJs;
                        }
                    }
                }

            }
            $gotObjList->resources = $resources;
            $gotObjList->lastAccess = $now->format("Y-m-d H:i:s");

            return $rscsTab;
        }
        return false;
    }

    public function loadMainMenu($menuRef, $menuTableRef)
    {
        /** @var EntityManager $entityManager */
        $entityManager  = $this->_serviceManager->get('doctrine.entitymanager.orm_default');
        $menuGlobal = new ODMenu('menuGlobal');
        $menuGlobal->setTitle('Personal Test');
        $menus      = $entityManager->getRepository($menuTableRef)->findBy(['menuRef' => $menuRef], ['parent' => 'ASC', 'ord' => 'ASC']);
        /** @var Menus $menu */
        foreach ($menus as $menu) {
            $parent     = $menu->getParent();
            if (!empty($parent)) { $parent = $parent->getId(); }
            $menuGlobal->addLeaf($menu->getId(), $menu->getLabel(), $menu->getLink(), null, $parent);
        }
        $menuGlobal->saveProperties();
    }
}