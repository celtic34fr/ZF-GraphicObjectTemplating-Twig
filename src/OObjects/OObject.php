<?php

namespace GraphicObjectTemplating\OObjects;

/**
 * classe initiale de création d'objet G.O.T.
 *
 * attributs
 * ---------
 * id
 * name
 * properties
 * lastAcces
 *
 * méthodes
 * --------
 * __construct($id, $pathObjArray)
 * static function validateSession()
 * static function existObject($id, $sessionObj)
 * static function buildObject($id, $valeur = null)
 * static function destroyObject($id)
 * static function clearObjects()
 * static function cloneObject($object)
 * static function formatBootstrap($widthBT)
 * static function formatRetour($idSource, $idCible, $mode, $code = null)
 *
 * getProperties()
 * setProperties(array $properties)
 * getId()
 * setId(string $id)
 * getName()
 * setName(string $name)
 * setDisplay($display = OObject::DISPLAY_BLOCK)
 * getDisplay()
 * setWidthBT(string $widthBT)
 * getWidthBT()
 * setClassName(string $className = null)
 * getClassName()
 * setTemplate(string $template = null)
 * getTemplate()
 * setObject(string $object = null)
 * getObject()
 * setTypeObj(string $typeObj = null)
 * getTypeObj()
 * getLastAccess()
 * setClasses($classes = null)
 * addClass($class = null)
 * removeClass($class = null)
 * getClasses()
 * addCssFile($nameFile, $pathFile)
 * removeCssFile($nameFile)
 * getPathCssFile($nameFile)
 * enaCssFile($nameFile)
 * disCssFile($nameFile)
 * getCssFileStatus($nameFile)
 * addJsFile($nameFile, $pathFile)
 * removeJsFile($nameFile)
 * getPathJsFile($nameFile)
 * enaJsFile($nameFile)
 * disJsFile($nameFile)
 * getJsFileStatus($nameFile)
 * enable()
 * disable()
 * getState()
 * enaAutoCenter()
 * disAutoCenter()
 * getStateAC()
 * setACWidth($width)
 * getACWidth()
 * setACHeight($height)
 * getACHeight()
 * setACWidthHeight($width, $height)
 * getACWidthHeight()
 * setEvent($event, $class, $method, $stopEvent = false)
 * getEvent($event)
 * getEvents()
 * disEvent($event)
 * saveProperties()
 *
 * méthodes privées de la classe
 * -----------------------------
 * getConstants()
 * getDisplayConstants()
 * getStateConstants()
 *
 */

use Zend\Session\Container;
use GraphicObjectTemplating\OObjects\ODContained\ODButton;
use GraphicObjectTemplating\OObjects\OSContainer;
use GraphicObjectTemplating\OObjects\OESContainer;

class OObject
{
    private $id;
    private $name;
    private $properties;
    private $lastAccess;

    private $const_display;
    private $const_state;

    const DISPLAY_NONE    = 'none';
    const DISPLAY_BLOCK   = 'block';
    const DISPLAY_INLINE  = 'inline';
    const DISPLAY_INBLOCK = 'inline-block';

    const STATE_ENABLE    = true;
    const STATE_DISABLE   = false;

    public function __construct($id, $pathObjArray)
    {
        if (empty($id)) {
            $id     = 'dummy';
            OObject::destroyObject($id, false);
        }
        $sessionObj = self::validateSession();
        $object = $sessionObj->objects;
        if (!$object || !array_key_exists($id, $object)) {
            if (!empty($pathObjArray)) {
                $path  = __DIR__ ;
                $path .= '/../../view/zf3-graphic-object-templating/' . trim($pathObjArray);
                $objProperties = include $path;
            }
            $objProperties['id']    = $id;
            $objProperties['name']  = $id;
            $this->id               = $id;
            $this->name             = $id;


            if (array_key_exists('typeObj', $objProperties)) {
                $templateName = 'zf3-graphic-object-templating/oobjects/' . $objProperties['typeObj'];
                $templateName .= '/' . $objProperties['object'] . '/' . $objProperties['template'];
                $objProperties['template'] = $templateName;

                $objName = 'ZF3_GOT/OObjects/';
                $objName .= strtoupper(substr($objProperties['typeObj'], 0, 3));
                $objName .= strtolower(substr($objProperties['typeObj'], 3)) . '/';
                $objName .= strtoupper(substr($objProperties['object'], 0, 3));
                $objName .= strtolower(substr($objProperties['object'], 3));
                $objName = str_replace('/', chr(92), $objName);
                $objProperties['className'] = $objName;
            }

            /** ajout des attributs de base à l'objet */
            $properties = include __DIR__ . '/../../view/zf3-graphic-object-templating/oobjects/oobject.config.php';
            foreach ($objProperties as $key => $objProperty) {
                $properties[$key] = $objProperty;
            }
            $this->setProperties($properties);
        } else {
            $this->id = $id;
            $properties = unserialize($object[$id]);
            $this->properties = $properties;
        }
        $this->saveProperties();
        return $this;
    }

    /** **************************************************************************************************
     * méthodes statiques                                                                                *
     * *************************************************************************************************** */

    public static function validateSession()
    {
        $now        = new \DateTime();
        $gotObjList = new Container('gotObjList');
        $lastAccess = new \DateTime($gotObjList->lastAccess);

        if ($lastAccess) {
            $interval   = $lastAccess->diff($now);
            if ((int) $interval->format('%h') > 2) {
                $gotObjList->getManager()->getStorage()->clear('gotObjList');
                $gotObjList = new Container('gotObjList');
            }
        }
        $gotObjList->lastAccess = $now->format("Y-m-d H:i:s");
        return $gotObjList;
    }

    public static function existObject($id, Container $sessionObj)
    {
        if (!empty($id)) {
            /** @var Container $sessionObj */
            $objects = $sessionObj->objects;
            return (array_key_exists($id, $objects));
        }
        return false;
    }

    public static function buildObject($id, Container $sessionObj, $valeur = null)
    {
        if (!empty($id)) {
            $objects = $sessionObj->objects;
            $properties = unserialize($objects[$id]);
            if (!empty($properties)) {
                // TODO: pb boucle sans fin sur création de l'instance de l'objet
                $object = new $properties['className']($id);
                $object->setProperties($properties);
                if ($object instanceof ODContained && !empty($value)) {
                    $object->setValue($valeur);
                }
                return $object;
            }
            throw new \Exception('objet sans atrribut, identifiant '.$id);
        }
        return false;
    }

    public static function cloneObject(OObject $object)
    {
        $sessionObj = self::validateSession();
        if (self::existObject($object->getId(), $sessionObj)) {
            $tmpObj = clone $object;
            $properties = $tmpObj->getProperties();
            $tmpObj->id = 'tmpObj';
            $properties['id'] = 'tmpObj';
            $tmpObj->setProperties($properties);
            return $tmpObj;
        }
    }

    public static function destroyObject($id, $session = false)
    {
        $now    = new \DateTime();
        $sessionObj = self::validateSession();

        if ($session) {
            $sessionObj->objects = [];
            $sessionObj->resources = [];
            $sessionObj->lastAccess = $now->format("Y-m-d H:i:s");
            return true;
        } else {
            if (self::existObject($id, $sessionObj)) {
                $objects = $sessionObj->objects;
                $properties = unserialize($objects[$id]);
                if ($properties['type'] == 'oscontainer') {
                    $objet = self::buildObject($id, $sessionObj);
                    $children = $objet->getChildren();
                    foreach ($children as $child) {
                        self::destroyObject($child->getId(), $session);
                    }
                }
                $objects = $sessionObj->objects;
                unset($objects[$id]);
                $sessionObj->objects = $objects;
                $sessionObj->lastAccess = $now->format("Y-m-d H:i:s");
                return true;
            }
            return false;
        }
    }

    public static function clearObjects()
    {
        $now        = new \DateTime();
        $gotObjList = self::validateSession();
        unset($gotObjList->objects);
        $gotObjList->objects = [];
        $gotObjList->lastAccess = $now->format("Y-m-d H:i:s");
        return true;
    }

    public static function formatBootstrap($widthBT)
    {
        if (!empty($widthBT)) {
            $retour = '';
            switch (true) {
                case (is_numeric($widthBT)):
                    $retour .= 'WL' . $widthBT . ':WM' . $widthBT . ':WS' . $widthBT . ':WX' . $widthBT;
                    break;
                case (strpos($widthBT, ':') !== false):
                    $widthBTs = explode(':', $widthBT);
                    foreach ($widthBTs as $item) {
                        switch (true) {
                            case ((int)substr($item, 1) > 0):
                                $val = substr($item, 1);
                                if (substr($item, 0, 1) == 'W') {
                                    if (!empty($retour)) {
                                        $retour .= ':';
                                    }
                                    $retour .= 'WL' . $val . ':WM' . $val . ':WS' . $val . ':WX' . $val;
                                }
                                if (substr($item, 0, 1) == 'O') {
                                    if (!empty($retour)) {
                                        $retour .= ':';
                                    }
                                    $retour .= 'OL' . $val . ':OM' . $val . ':OS' . $val . ':OX' . $val;
                                }
                                break;
                            case ((int)substr($widthBT, 1) == 0):
                                $retour .= $item;
                                break;
                        }
                    }
                    break;
            }
            return $retour;
        }
        return false;
    }

    public static function formatLabelBT($labelWidthBT)
    {
        $lxs = $lsm = $lmd = $llg = 0;
        $ixs = $ism = $imd = $ilg = 0;
        if (is_numeric($labelWidthBT)) {
            $lxs = $lsm = $lmd = $llg = (int) $labelWidthBT;
            $ixs = $ism = $imd = $ilg = 12 - (int) $labelWidthBT;
        } else { // $labelWidthBT nb'est pas numérique
            $labelWidthBT = explode(':', $labelWidthBT);
            foreach ($labelWidthBT as $item) {
                $key = strtoupper($item);
                switch (substr($key, 0,2)) {
                    case 'WX' :
                        $lxs = (int) substr($key, 2);
                        $ixs = 12 - $lxs;
                        break;
                    case 'WS' :
                        $lsm = (int) substr($key, 2);
                        $ism = 12 - $lsm;
                        break;
                    case 'WM' :
                        $lmd = (int) substr($key, 2);
                        $imd = 12 - $lmd;
                        break;
                    case 'WX' :
                        $llg = (int) substr($key, 2);
                        $ilg = 12 - $llg;
                        break;
                    default:
                        if (substr($key, 0, 1) == 'W') {
                            $lxs = $lsm = $lmd = $llg = (int) $key;
                            $ixs = $ism = $imd = $ilg = 12 - (int) $key;
                        }
                }
            }
        }
        if (!empty($lxs)) {
            $lxs = 'WX'.$lxs.':';
            $ixs = 'WX'.$ixs.':';
        } else {
            $lxs = '';
            $ixs = '';
        }
        if (!empty($lsm)) {
            $lsm = 'WS'.$lsm.':';
            $ism = 'WS'.$ism.':';
        } else {
            $lsm = '';
            $ism = '';
        }
        if (!empty($lmd)) {
            $lmd = 'WM'.$lmd.':';
            $imd = 'WM'.$imd.':';
        } else {
            $lmd = '';
            $imd = '';
        }
        if (!empty($llg)) {
            $llg = 'WL'.$llg.':';
            $ilg = 'WL'.$ilg.':';
        } else {
            $llg = '';
            $ilg = '';
        }
        $labelWBT   = $llg.$lmd.$lsm.$lxs;
        if (strlen($labelWBT) > 0) { $labelWBT = substr($labelWBT, 0, strlen($labelWBT) - 1); }
        $inputWBT   = $ilg.$imd.$ism.$ixs;
        if (strlen($inputWBT) > 0) { $inputWBT = substr($inputWBT, 0, strlen($inputWBT) - 1); }

        $retour['labelWidthBT'] = $labelWBT;
        $retour['inputWidthBT'] = $inputWBT;

        return $retour;
    }

    /**
     * static public function formatRetour
     * @param type string $idSource
     * @param type string $idCible
     * @param type string $mode
     * @param type string $code
     * @return type array
     */
    static public function formatRetour($idSource, $idCible, $mode, $code = null) {
        if (empty($idCible)) { $idCible = $idSource; }
        return ['idSource'=>$idSource, 'idCible'=>$idCible, 'mode'=>$mode, 'code'=>$code];
    }

    /** **************************************************************************************************
     * méthodes de l'objet proprement dites                                                              *
     * *************************************************************************************************** */

    public function getProperties()
    {
        if (null !== $this->id) {
            return $this->properties;
        }
        return false;
    }

    public function setProperties(array $properties)
    {
        if (null !== $this->id && !empty($properties) && array_key_exists('id', $properties)) {
            $this->properties   = $properties;
            return $this;
        }
        return false;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId(string $id)
    {
        if (null !== $this->id) {
            $gotObjList         = OObject::validateSession();
            $objects            = $gotObjList->objects;
            $properties         = unserialize($objects[$this->id]);

            $properties['id']   = $id;
            unset($objects[$this->id]);
            $objects[$id]       = serialize($properties);

            $gotObjList->objects = $objects;
            $gotObjList->lastAccess = (new \DateTime())->format('Y-m-d H:i:s');
            $this->properties   = $properties;
            $this->lastAccess   = (new \DateTime())->format('Y-m-d H:i:s');
            $this->id           = $id;

            return $this;
        }
        return false;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName(string $name)
    {
        if (null !== $this->id) {
            $gotObjList         = OObject::validateSession();
            $objects            = $gotObjList->objects;
            $properties         = unserialize($objects[$this->id]);

            $properties['name'] = $name;
            $objects[$this->id] = serialize($properties);

            $gotObjList->objects = $objects;
            $gotObjList->lastAccess = (new \DateTime())->format('Y-m-d H:i:s');
            $this->properties   = $properties;
            $this->lastAccess   = (new \DateTime())->format('Y-m-d H:i:s');
            $this->name         = $name;

            return $this;
        }
        return false;
    }

    public function setDisplay($display = OObject::DISPLAY_BLOCK)
    {
        $displays = $this->getDisplayConstants();
        if (!in_array($display, $displays, true)) { $display = OObject::DISPLAY_BLOCK; }
        $properties = $this->getProperties();
        $properties['display'] = $display;
        $this->setProperties($properties);
        return $this;
    }

    public function getDisplay()
    {
        $properties = $this->getProperties();
        return array_key_exists('display', $properties) ? $properties['display'] : false;
    }

    public function setWidthBT(string $widthBT)
    {
        if (!empty($widthBT)) {
            $retour = self::formatBootstrap($widthBT);
            $properties = $this->getProperties();
            $properties['widthBT'] = $retour;
            $this->setProperties($properties);
            return $this;
        }
        return false;
    }

    public function getWidthBT()
    {
        $properties = $this->getProperties();
        return array_key_exists('widthBT', $properties) ? $properties['widthBT'] : false;
    }

    public function setClassName(string $className = null)
    {
        if (!empty($className)) {
            if (class_exists($className)) {
                $properties = $this->getProperties();
                $properties['className'] = $className;
                $this->setProperties($properties);
                return $this;
            }
        }
        return false;
    }

    public function getClassName()
    {
        $properties = $this->getProperties();
        return array_key_exists('className', $properties) ? $properties['className'] : false;
    }

    public function setTemplate(string $template = null)
    {
        if (!empty($template)) {
            if (file_exists($template)) {
                $properties = $this->getProperties();
                $properties['template'] = $template;
                $this->setProperties($properties);
                return $this;
            }
        }
        return false;
    }

    public function getTemplate()
    {
        $properties = $this->getProperties();
        return array_key_exists('template', $properties) ? $properties['template'] : false;
    }

    public function setObject(string $object = null)
    {
        if (!empty($object)) {
            $properties = $this->getProperties();
            $properties['object'] = strtolower($object);
            $this->setProperties($properties);
            return $this;
        }
        return false;
    }

    public function getObject()
    {
        $properties = $this->getProperties();
        return array_key_exists('object', $properties) ? $properties['object'] : false;
    }

    public function setTypeObj(string $typeObj = null)
    {
        if (!empty($typeObj)) {
            $properties = $this->getProperties();
            $properties['typeObj'] = strtolower($typeObj);
            $this->setProperties($properties);
            return $this;
        }
        return false;
    }

    public function getTypeObj()
    {
        $properties = $this->getProperties();
        return array_key_exists('typeObj', $properties) ? $properties['typeObj'] : false;
    }

    public function getLastAccess()
    {
        return $this->lastAccess;
    }

    public function setClasses($classes = null)
    {
        if (!empty($classes)) {
            if (is_array($classes)) { $classes = implode(' ', $classes); }
            if (is_string($classes)) {
                $properties = $this->getProperties();
                $properties['classes'] = $classes;
                $this->setProperties($properties);
                return $this;
            }
        }
        return false;
    }

    public function addClass($class = null)
    {
        if (!empty($class)) {
            if (is_string($class)) {
                $properties = $this->getProperties();
                $classes    = $properties['classes'];
                if (!strpos($classes, $class)) {
                    $classes .= ' '.$class;
                    $properties['classes'] = $classes;
                    $this->setProperties($properties);
                    return $this;
                }
            }
        }
        return false;
    }

    public function removeClass($class = null)
    {
        if (!empty($class)) {
            if (is_string($class)) {
                $properties = $this->getProperties();
                $classes    = $properties['classes'];
                if (in_array($class, $classes)) {
                    $pos    = strpos($classes, $class);
                    $classes = substr($classes, 0, $pos) . substr($classes, $pos + strlen($class));
                    $properties['classes'] = $classes;
                    $this->setProperties($properties);
                    return $this;
                }
            }
        }
        return false;
    }

    public function getClasses()
    {
        $properties = $this->getProperties();
        return array_key_exists('classes', $properties) ? $properties['classes'] : false;
    }

    public function addCssFile($nameFile, $pathFile)
    {
        if (!empty($nameFile) && !empty($pathFile)) {
            if (file_exists($pathFile)) {
                $properties = $this->getProperties();
                if (!array_key_exists('resources', $properties)) { $properties['resources'] = []; }
                $resources  = $properties['resources'];
                if (!array_key_exists('css', $resources)) {
                    $resources['css'] = [];
                    $resources['css']['enable'] = [];
                }
                $css        = $resources['css'];
                $css[$nameFile] = $pathFile;
                $css['enable'][] = $nameFile;

                $resources['css'] = $css;
                $properties['resources'] = $resources;
                $this->setProperties($properties);
                return $this;
            }
        }
        return false;
    }

    public function removeCssFile($nameFile)
    {
        if (!empty($nameFile)) {
            $properties = $this->getProperties();
            if (array_key_exists('resources', $properties)) {
                $resources  = $properties['resources'];
                if (!array_key_exists('css', $resources)) {
                    $css        = $resources['css'];
                    if (array_key_exists($nameFile, $css)) {
                        unset($css[$nameFile]);
                        if (in_array($nameFile, $css['enable'])) {
                            unset($css['enable'][array_search($nameFile, $css['enable'])]);
                        }
                        $resources['css'] = $css;
                        $properties['resources'] = $resources;
                        $this->setProperties($properties);
                        return $this;
                    }
                }
            }
        }
        return false;
    }

    public function getPathCssFile($nameFile)
    {
        if (!empty($nameFile)) {
            $properties = $this->getProperties();
            if (array_key_exists('resources', $properties)) {
                $resources  = $properties['resources'];
                if (!array_key_exists('css', $resources)) {
                    $css        = $resources['css'];
                    if (array_key_exists($nameFile, $css)) {
                        return $css[$nameFile];
                    }
                }
            }
        }
        return false;
    }

    public function enaCssFile($nameFile)
    {
        if (!empty($nameFile)) {
            $properties = $this->getProperties();
            if (array_key_exists('resources', $properties)) {
                $resources  = $properties['resources'];
                if (!array_key_exists('css', $resources)) {
                    $css        = $resources['css'];
                    if (array_key_exists($nameFile, $css)) {
                        if (!in_array($nameFile, $css['enable'])) {
                            $css['enable'][] = $nameFile;
                            $resources['css'] = $css;
                            $properties['resources'] = $resources;
                            $this->setProperties($properties);
                            return $this;
                        }
                    }
                }
            }
        }
        return false;
    }

    public function disCssFile($nameFile)
    {
        if (!empty($nameFile)) {
            $properties = $this->getProperties();
            if (array_key_exists('resources', $properties)) {
                $resources  = $properties['resources'];
                if (!array_key_exists('css', $resources)) {
                    $css        = $resources['css'];
                    if (array_key_exists($nameFile, $css)) {
                        if (in_array($nameFile, $css['enable'])) {
                            unset($css['enable'][array_search($nameFile, $css['enable'])]);
                            $resources['css'] = $css;
                            $properties['resources'] = $resources;
                            $this->setProperties($properties);
                            return $this;
                        }
                    }
                }
            }
        }
        return false;
    }

    public function getCssFileStatus($nameFile)
    {
        if (!empty($nameFile)) {
            $properties = $this->getProperties();
            if (array_key_exists('resources', $properties)) {
                $resources  = $properties['resources'];
                if (!array_key_exists('css', $resources)) {
                    $css        = $resources['css'];
                    if (array_key_exists($nameFile, $css)) {
                        if (in_array($nameFile, $css['enable'])) {
                            return 'enable';
                        } else {
                            return 'disable';
                        }
                    }
                }
            }

        }
        return false;
    }

    public function addJsFile($nameFile, $pathFile)
    {
        if (!empty($nameFile) && !empty($pathFile)) {
            if (file_exists($pathFile)) {
                $properties = $this->getProperties();
                if (!array_key_exists('resources', $properties)) { $properties['resources'] = []; }
                $resources  = $properties['resources'];
                if (!array_key_exists('js', $resources)) {
                    $resources['js'] = [];
                    $resources['js']['enable'] = [];
                }
                $js             = $resources['js'];
                $js[$nameFile]  = $pathFile;
                $js['enable'][] = $nameFile;

                $resources['js'] = $js;
                $properties['resources'] = $resources;
                $this->setProperties($properties);
                return $this;
            }
        }
        return false;
    }

    public function removeJsFile($nameFile)
    {
        if (!empty($nameFile)) {
            $properties = $this->getProperties();
            if (array_key_exists('resources', $properties)) {
                $resources  = $properties['resources'];
                if (!array_key_exists('js', $resources)) {
                    $js        = $resources['js'];
                    if (array_key_exists($nameFile, $js)) {
                        unset($js[$nameFile]);
                        if (in_array($nameFile, $js['enable'])) {
                            unset($js['enable'][array_search($nameFile, $js['enable'])]);
                        }
                        $resources['js'] = $js;
                        $properties['resources'] = $resources;
                        $this->setProperties($properties);
                        return $this;
                    }
                }
            }
        }
        return false;
    }

    public function getPathJsFile($nameFile)
    {
        if (!empty($nameFile)) {
            $properties = $this->getProperties();
            if (array_key_exists('resources', $properties)) {
                $resources  = $properties['resources'];
                if (!array_key_exists('css', $resources)) {
                    $css        = $resources['css'];
                    if (array_key_exists($nameFile, $css)) {
                        return $css[$nameFile];
                    }
                }
            }
        }
        return false;
    }

    public function enaJsFile($nameFile)
    {
        if (!empty($nameFile)) {
            $properties = $this->getProperties();
            if (array_key_exists('resources', $properties)) {
                $resources  = $properties['resources'];
                if (!array_key_exists('js', $resources)) {
                    $js        = $resources['js'];
                    if (array_key_exists($nameFile, $js)) {
                        if (!in_array($nameFile, js['enable'])) {
                            $js['enable'][] = $nameFile;
                            $resources['js'] = $js;
                            $properties['resources'] = $resources;
                            $this->setProperties($properties);
                            return $this;
                        }
                    }
                }
            }
        }
        return false;
    }

    public function disJsFile($nameFile)
    {
        if (!empty($nameFile)) {
            $properties = $this->getProperties();
            if (array_key_exists('resources', $properties)) {
                $resources  = $properties['resources'];
                if (!array_key_exists('js', $resources)) {
                    $js        = $resources['js'];
                    if (array_key_exists($nameFile, $js)) {
                        if (in_array($nameFile, $js['enable'])) {
                            unset($js['enable'][array_search($nameFile, $js['enable'])]);
                            $resources['js'] = $js;
                            $properties['resources'] = $resources;
                            $this->setProperties($properties);
                            return $this;
                        }
                    }
                }
            }
        }
        return false;
    }

    public function getJsFileStatus($nameFile)
    {
        if (!empty($nameFile)) {
            $properties = $this->getProperties();
            if (array_key_exists('resources', $properties)) {
                $resources  = $properties['resources'];
                if (!array_key_exists('js', $resources)) {
                    $js        = $resources['js'];
                    if (array_key_exists($nameFile, $js)) {
                        if (in_array($nameFile, $js['enable'])) {
                            return 'enable';
                        } else {
                            return 'disable';
                        }
                    }
                }
            }

        }
        return false;
    }

    public function enable()
    {
        $properties = $this->getProperties();
        $properties['state'] = self::STATE_ENABLE;
        $this->setProperties($properties);
        return $this;
    }

    public function disable()
    {
        $properties = $this->getProperties();
        $properties['state'] = self::STATE_DISABLE;
        $this->setProperties($properties);
        return $this;
    }

    public function getState()
    {
        $properties = $this->getProperties();
        return array_key_exists('state', $properties) ? $properties['state'] : false;
    }

    public function enaAutoCenter()
    {
        $properties = $this->getProperties();
        $properties['autoCenter'] = true;
        $this->setProperties($properties);
        return $this;
    }

    public function disAutoCenter()
    {
        $properties = $this->getProperties();
        $properties['autoCenter'] = false;
        $this->setProperties($properties);
        return $this;
    }

    public function getStateAC()
    {
        $properties = $this->getProperties();
        return array_key_exists('autoCenter', $properties) ? $properties['autoCenter'] : false;
    }

    public function setACWidth($width)
    {
        $width = (string) $width;
        $properties = $this->getProperties();
        $properties['acPx'] = $width;
        $this->setProperties($properties);
        return $this;
    }

    public function getACWidth()
    {
        $properties = $this->getProperties();
        return array_key_exists('acPx', $properties) ? $properties['acPx'] : false;
    }

    public function setACHeight($height)
    {
        $height = (string) $height;
        $properties = $this->getProperties();
        $properties['acPy'] = $height;
        $this->setProperties($properties);
        return $this;
    }

    public function getACHeight()
    {
        $properties = $this->getProperties();
        return array_key_exists('acPy', $properties) ? $properties['acPy'] : false;
    }

    public function setACWidthHeight($width, $height)
    {
        $width = (string) $width;
        $height = (string) $height;
        $properties = $this->getProperties();
        $properties['acPx'] = $width;
        $properties['acPy'] = $height;
        $this->setProperties($properties);
        return $this;
    }

    public function getACWidthHeight()
    {
        $properties = $this->getProperties();
        $acPx       = (array_key_exists('acPx', $properties) ? $properties['acPx'] : false);
        $acPy       = (array_key_exists('acPy', $properties) ? $properties['acPy'] : false);
        return ['width' => $acPx, 'height' => $acPy];
    }

    public function setEvent($event, $class, $method, $stopEvent = false)
    {
        if (!empty($event) && !empty($class) && !empty($method)) {
            $properties = $this->getProperties();
            if (!array_key_exists('event', $properties)) { $properties['event'] = []; }
            $events = $properties['event'];
            if (!array_key_exists($event, $events)) { $events[$event] = []; }
            $evtDef = $events[$event];

            switch (true) {
                case (class_exists($class)) :
                    $obj = new $class();
                    if (method_exists($obj, $method)) {
                        $evtDef['class']        = $class;
                        $evtDef['method']       = $method;
                        $evtDef['stopEvent']    = ($stopEvent) ? 'OUI' : 'NON';
                    }
                    break;
                case ($class == "javascript:") :
                    $evtDef['class']        = $class;
                    $evtDef['method']       = $method;
                    $evtDef['stopEvent']    = ($stopEvent) ? 'OUI' : 'NON';
                    break;
                case ($properties['object'] == 'odbutton' && $properties['type'] == ODButton::BUTTONTYPE_LINK):
                    $params = [];
                    if ($method != 'none') {
                        $method = explode('|', $method);
                        foreach ($method as $item) {
                            $item = explode(':', $item);
                            $params[$item[0]] = $item[1];
                        }
                    }
                    $evtDef['class']        = $class;
                    $evtDef['method']       = $params;
                    $evtDef['stopEvent']    = ($stopEvent) ? 'OUI' : 'NON';
            }
            $events[$event]         = $evtDef;
            $properties['event'] = $events;
            $this->setProperties($properties);
            return $this;
        }
        return false;
    }

    public function getEvent($event = null)
    {
        if (!empty($event)) {
            $properties = $this->getProperties();
            if (array_key_exists('event', $properties) && !empty($properties['event'])) {
                return array_key_exists($event, $properties['event']) ? $properties['event'][$event] : false;
            }
        }
        return false;
    }

    public function getEvents()
    {
        $properties = $this->getProperties();
        return array_key_exists('event', $properties) ? $properties['event'] : false;
    }

    public function disEvent($event)
    {
        if (!empty($event)) {
            $properties = $this->getProperties();
            if (array_key_exists('event', $properties)) {
                $events = $properties['event'];
                if (array_key_exists($event, $events)) {
                    unset($events[$event]);
                    $properties['event'] = $events;
                    $this->setProperties($properties);
                    return $this;
                }
            }
        }
        return false;
    }

    public function saveProperties()
    {
        $sessionObj = OObject::validateSession();
        $objects    = $sessionObj->objects;
        $objects[$this->id] = serialize($this->properties);
        $sessionObj->objects = $objects;

        $sessionObj->lastAccess = (new \DateTime())->format('Y-m-d H:i:s');
        $this->lastAccess   = (new \DateTime())->format('Y-m-d H:i:s');

    }

    /** **************************************************************************************************
     * méthodes privées de la classe                                                                     *
     * *************************************************************************************************** */

    protected function getConstants()
    {
        $ref = new \ReflectionClass($this);
        return $ref->getConstants();
    }

    private function getDisplayConstants()
    {
        $retour = [];
        if (empty($this->const_display)) {
            $constants = $this->getConstants();
            foreach ($constants as $key => $constant) {
                $pos = strpos($key, 'DISPLAY');
                if ($pos !== false) {
                    $retour[$key] = $constant;
                }
            }
            $this->const_display = $retour;
        } else {
            $retour = $this->const_display;
        }

        return $retour;
    }

    public function getStateConstants()
    {
        $retour = [];
        if (empty($this->const_state)) {
            $constants = $this->getConstants();
            foreach ($constants as $key => $constant) {
                $pos = strpos($key, 'STATE');
                if ($pos !== false) {
                    $retour[$key] = $constant;
                }
            }
            $this->const_state = $retour;
        } else {
            $retour = $this->const_state;
        }

        return $retour;
    }


}
