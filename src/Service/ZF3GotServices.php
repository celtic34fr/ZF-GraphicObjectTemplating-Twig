<?php

namespace GraphicObjectTemplating\Service;

use Application\Entity\Menus;
use Doctrine\ORM\EntityManager;
use GraphicObjectTemplating\OObjects\ODContained\ODMenu;
use Zend\ServiceManager\ServiceManager;
use Zend\Session\Container;
use Zend\View\Model\ViewModel;
use GraphicObjectTemplating\OObjects\OObject;
use ZfcTwig\View\TwigRenderer;

class ZF3GotServices
{
    /** @var ServiceManager $_serviceManager */
    private $_serviceManager;
    /** @var TwigRenderer $_twigRender */
    private $_twigRender;
    private $_config;

    public function __construct($sm, $tr, $cfg)
    {
        $this->_serviceManager  = $sm;
        $this->_twigRender      = $tr;
        $this->_config          = $cfg;
        return $this;
    }


    /** rendu de l'objet en code HTML */
    /**
     * @param $object       string / OObject
     * @param Container $sessionObjects
     * @return bool|mixed   false si KO / code HTML
     * @throws \Exception
     */
    public function render($object, Container $sessionObjects = null)
    {
        if (empty($sessionObjects)) { $sessionObjects = OObject::validateSession(); }
        $properties     = [];
        $zoneComm       = null;
        if ($object instanceof OObject) {
            $zoneComm   = $object->getZoneComm();
            $properties = $object->getProperties();
            $object = $object->getId();
        } else {
            $objects    = $sessionObjects->objects;
            if (array_key_exists($object, $objects)) {
                $properties = unserialize($objects[$object]);
            }
        }

        if (!empty($properties)) {
            if (($properties['display'] ?? '') == OObject::NO_DISPLAY) {
                return '';
            }

            $html       = new ViewModel();
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
                            $rendu    = $this->render($child, $sessionObjects);
                            $content .= $rendu;
                        }
                    }
                    $html->setTemplate($template);
                    $html->setVariable('objet', $properties);
                    $html->setVariable('content', $content);
                    break;
            }
            $renduHtml = $this->_twigRender->render($html);

            if ($zoneComm !== null) {
                $zoneComm   = json_encode($zoneComm);
                $code       = "<script>";
                $code      .= '$(document).ready(function() {';
                $code      .= 'setZoneComm("'.$object.'", '.$zoneComm.');';
                $code      .= "});";
                $code      .= "</script>";
                $renduHtml .= $code;
            }

            $renduHtml = preg_replace('/(\s)\s+/', '$1', $renduHtml);
            $renduHtml =  str_replace(array("\r\n", "\r", "\n"), "", $renduHtml);
            return $renduHtml;
        }
        return false;
    }

    /** récupération et formatage des entêtes chargement ressources CSS & Js
     * @return bool|string|null
     * @throws \Exception
     */
    public function header()
    {
        $gotObjList             = OObject::validateSession();
        $now                    = new \DateTime();
        $scripts                = $gotObjList->resources;
        $gotObjList->lastAccess = $now->format("Y-m-d H:i:s");

        if ($scripts) {
            $view = new ViewModel();
            $view->setTemplate('zf3-graphic-object-templating/main/got-header.twig');
            $view->setVariable('scripts',
                ['css' => $scripts['css'] ?? [], 'js' => $scripts['js'] ?? [], 'font' => $scripts['fonts'] ?? []]);
            $renduHtml = $this->_twigRender->render($view);
            return $renduHtml;
        }
        return false;
    }

    /**
     * @param $widthBT
     * @return string
     */
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
     * @param null $objects
     * @return array|bool : tableau de ressources si traitement OK, sinon booléen false
     * @throws \Exception
     */
    public static function rscs($object, $objects = null)
    {
        $tmpObjects = [];
        $tmpRscs	= [];
        $gotObjList = OObject::validateSession();

        if (!is_array($object))     { $object   = [$object]; }
        if (empty($objects)) 		{ $objects  = $gotObjList->objects; }
        $rscsSession = $gotObjList->resources;

        if (!empty($object)) {
            foreach ($object as $item) {
                if ($item instanceof OObject) { $item   = $item->getId(); }

                if (!empty($item) && $item != null
                    && array_key_exists($item, $objects)) {
                    $properties = unserialize($objects[$item]);
                    $tmpObjects[$properties['object']] = $properties['typeObj'];
                    if (array_key_exists('children', $properties)) {
                        foreach ($properties['children'] as $idChild => $valChild) {
                            $tmpObjects = self::recupObject($idChild, $objects);
                        }
                    }
                }
                foreach ($tmpObjects as $object => $typeObj) {
                    $pathRscs   = __DIR__ . '/../../' ;
                    $pathRscs  .= 'view/zf3-graphic-object-templating/oobjects/';
                    $pathRscs  .= $typeObj.'/'.$object.'/'.$object.'.rscs.php';

                    if (is_file($pathRscs)) {
                        $rscsObj        = include $pathRscs;
                        foreach ($rscsObj as $type => $arrayFiles) {
                            foreach ($arrayFiles as $name => $path) {
                                if (!array_key_exists($type, $tmpRscs)) { $tmpRscs[$type] = []; }

                                $tmpRscs[$type][$name] = $rscsSession[$type][$name];
                            }
                        }
                    }
                }
            }
            return $tmpRscs;
        }
        return false;
    }

    /**
     * @param $menuRef
     * @param $menuTableRef
     * @throws \Exception
     */
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

    /**
     * @return string
     */
    public function getTheme()
    {
        $gotCfg = $this->_config['gotParameters'];
        return $gotCfg['theme'] ?? 'layout';
    }



    /**
     * méthode(s) privée(s) de l'objet
     */

    private static function recupObject($idObj, $objects)
    {
        $objRefs    = [];
        $properties = unserialize($objects[$idObj]);

        switch ($properties['typeObj']) {
            case 'odcontained':
                $objRefs[$properties['object']] = $properties['typeObj'];
                break;
            case 'oscontainer':
                foreach ($properties['children'] as $child => $val) {
                    $objRefs = array_merge($objRefs, self::recupObject($child, $objects));
                }
                break;
        }
         return $objRefs;
    }
}