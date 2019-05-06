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
        if ($object instanceof OObject) {
            $properties = $object->getProperties();
            $object = $object->getId();
        } else {
            $objects    = $sessionObjects->objects;
            if (array_key_exists($object, $objects)) {
                $properties = unserialize($objects[$object]);
            }
        }

        if (!empty($properties)) {
            if ($properties['display'] == OObject::NO_DISPLAY) {
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
     * @return array|bool : tableau de ressources si traitement OK, sinon boolée false
     * @throws \Exception
     *
     * 2018-08 GARM : Ajout de la mise en session des références des ressources pour éviter de les charger
     * plusieurs fois
     */
    public static function rscs($object, $objects = null, $rscsSession = null)
    {
        $tmpResources           = [];

        if ($object instanceof OObject) { $object = $object->getId(); }
        if (empty($objects)) {
            $gotObjList         = OObject::validateSession();
            $objects            = $gotObjList->objects;
        }
        if (empty($rscsSession)) { $rscsSession    = $sessionObj->resources ?? []; }

        if (!empty($object) && $object != null && array_key_exists($object, $objects)) {
            $properties = unserialize($objects[$object]);

            $objName    = $properties['object'];

            if (!empty($rscsSession)) {
                foreach ($rscsSession as $type => $resource) {
                    foreach ($resource as $name => $path) {
                        $posObjName     = strpos($path, $objName);
                        if ($posObjName !== false) {
                            if (!array_key_exists($type, $tmpResources)) {$tmpResources[$type] = []; }
                            $tmpResources[$type][$name] = $path;
                        }
                    }
                }

                foreach ($properties['children'] as $child) {
                    $childProperties    = unserialize($objects[$child]);
                    $objName            = $childProperties['object'];
                    foreach ($rscsSession as $type => $resource) {
                        foreach ($resource as $name => $path) {
                            $posObjName     = strpos($path, $objName);
                            if ($posObjName !== false) {
                                if (!array_key_exists($type, $tmpResources)) {$tmpResources[$type] = []; }
                                $tmpResources[$type][$name] = $path;
                            }
                        }
                    }
                }
            } else {
                $pathRscs   = __DIR__ ;
                $pathRscs  .= '/../../view/zf3-graphic-object-templating/oobjects/'.$properties['typeObj'].'/'.$properties['object'];
                $pathRscs  .= '/'.$properties['object'].'.rscs.php';
                if (is_file($pathRscs)) {
                    $rscsObj        = include $pathRscs;
                    $prefix         = 'graphicobjecttemplating/oobjects/';
                    if (array_key_exists('prefix', $rscsObj)) {
                        $prefix         = 'gotextension/'.$rscsObj['prefix'].'oeobjects/';
                        unset($rscsObj['prefix']);
                    }
                    foreach ($rscsObj as $type => $filesInfo) {
                        if (!array_key_exists($type, $rscsSession)) { $rscsSession[$type] = []; }
                        foreach ($filesInfo as $name => $path) {
                            if (!array_key_exists($type, $tmpResources)) {$tmpResources[$type] = []; }
                            $tmpResources[$type][$name] = $prefix.$path;
                        }
                    }
                }

                if (!empty($properties['children'])) {
                    foreach ($properties['children'] as $child) {
                        $childRscs = self::rscs($child, $objects);
//                        if (!$childRscs) {
//                            throw new \Exception("objet $child non trouvé, veuillez avertir l'administrateur");
//                        }
                        foreach ($childRscs as $type => $childRsc) {
                            foreach ($childRsc as $name => $path) {
                                $tmpResources[$type][$name] = $path;
                            }
                        }
                    }
                }
            }

            return $tmpResources;

//            $rscsTab                = [];
//            $rscsTab['cssScripts']  = [];
//            $rscsTab['jsScripts']   = [];
//            $rscsTab['fontsStyles'] = [];
//
//            /** cas des objets OSContainer -> contenant d'autres objets */
//            if (in_array($properties['typeObj'] ,['oscontainer', 'oescontainer'] )) {
//                $children = $properties['children'];
//                if (!empty($children)) {
//                    foreach ($children as $child => $value) {
//                        $newRscsTab = self::rscs($child);
//                        $rscsTab['jsScripts']   = array_merge($rscsTab['jsScripts'], $newRscsTab['jsScripts']);
//                        $rscsTab['cssScripts']  = array_merge($rscsTab['cssScripts'], $newRscsTab['cssScripts']);
//                        $rscsTab['fontsStyles'] = array_merge($rscsTab['fontsStyles'], $newRscsTab['fontsStyles']);
////                        foreach ($newRscsTab as $name => $path) {
////                            if (!array_key_exists($name, $rscsTab['jsScripts'])) {
////                                $rscsTab['jsScripts'][$name]    = $path;
////                            }
////                        }
////                        foreach ($newRscsTab['cssScripts'] as $name => $path) {
////                            if (!array_key_exists($name, $rscsTab['cssScripts'])) {
////                                $rscsTab['cssScripts'][$name]   = $path;
////                            }
////                        }
////                        foreach ($newRscsTab['fontsStyles'] as $name => $path) {
////                            if (!array_key_exists($name, $rscsTab['fontsStyles'])) {
////                                $rscsTab['fontsStyles'][$name]   = $path;
////                            }
////                        }
//                    }
//                }
//            }
//
//            /** traitement de l'objet courrant $object */
//            if (!empty($properties['resources'])) {
//                $cssList = [];
//                $jsList = [];
//                $localRscs = $properties['resources'];
//
//                if (array_key_exists('prefix', $localRscs)) {
//                    $prefix = 'gotextension/'.$localRscs['prefix'].'oeobjects/';
//                } else {
//                    $prefix = 'graphicobjecttemplating/oobjects/';
//                }
//                $prefix .= $properties['typeObj'].'/'.$properties['object'].'/';
//
//                if (array_key_exists('css', $localRscs)) {
//                    foreach ($localRscs['css'] as $nomCss => $pathCss) {
//                        if (!array_key_exists($nomCss, $rscsTab['cssScripts'])) {
//                            $rscsTab['cssScripts'][$nomCss] = $prefix.$pathCss;
//                        }
//                    }
//                }
//                if (array_key_exists('js', $localRscs)) {
//                    foreach ($localRscs['js'] as $nomJs => $pathJs) {
//                        if (!array_key_exists($nomCss, $rscsTab['jsScripts'])) {
//                            $rscsTab['jsScripts'][$nomJs]   = $prefix.$pathJs;
//                        }
//                    }
//                }
//                if (array_key_exists('fonts', $localRscs)) {
//                    foreach ($localRscs['fonts'] as $nomFont => $pathFont) {
//                        if (!array_key_exists($nomFont, $rscsTab['fontsStyles'])) {
//                            $rscsTab['fontsStyles'][$nomFont] = $prefix.$pathFont;
//                        }
//                    }
//                }
//
////                if (!empty($cssList)) {
////                    foreach ($cssList as $nomCss => $pathCss) {
////                        if (!array_key_exists($nomCss, $resources)) {
////                            $rscsTab['cssScripts'][$nomCss] = $prefix.$pathCss;
////                            $resources[$nomCss]               = $prefix.$pathCss;
////                        }
////                    }
////                }
////                if (!empty($jsList)) {
////                    foreach ($jsList as $nomJs => $pathJs) {
////                        if (!array_key_exists($nomJs, $resources)) {
////                            $rscsTab['jsScripts'][$nomJs] = $prefix.$pathJs;
////                            $resources[$nomJs]            = $prefix.$pathJs;
////                        }
////                    }
////                }
////                if (!empty($fontsList)) {
////                    foreach ($fontsList as $nomFont => $pathFont) {
////                        if (!array_key_exists($nomFont, $resources)) {
////                            $rscsTab['fontsStyles'][$nomFont]   = $prefix.$pathFont;
////                            $resources[$nomFont]                = $prefix.$pathFont;
////                        }
////                    }
////                }
//
//            }
//
//            return $rscsTab;
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
}