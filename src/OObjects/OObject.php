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
 * setWidth($width)
 * getWidth()
 * setHeight($height)
 * getHeight()
 *
 * méthodes de gestion des infobulles mis sur les objets
 * -----------------------------------------------------
 * setIBType($IBtype = self::IBTYPE_TOOLTIP)
 * getIBType()
 * enaIBAnimation()
 * disIBAnimation()
 * getIBAnimation()
 * setIBDelay(array $delay = null)
 * getIBDelay()
 * enaIBHtml()
 * disIBHtml()
 * getIBHtml()
 * setIBPlacement($IBplacement = self::IBPLACEMENT_TOP)
 * getIBPlacement()
 * setIBTitle($title = null)
 * getIBTitle()
 * setIBContent($IBContent = null)
 * getIBContent()
 * setIBTrigger($IBtrigger = self::IBTRIGGER_HOVER)
 * getIBTrigger()
 *
 * méthodes privées de la classe
 * -----------------------------
 * getConstants()
 * getDisplayConstants()
 * getStateConstants()
 *
 */

use GraphicObjectTemplating\OObjects\ODContained\ODMenu;
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

    const DISPLAY_NONE    = 'none';
    const DISPLAY_BLOCK   = 'block';
    const DISPLAY_INLINE  = 'inline';
    const DISPLAY_INBLOCK = 'inline-block';

    const STATE_ENABLE    = true;
    const STATE_DISABLE   = false;

    const IBTYPE_TOOLTIP    = 'tooltip';
    const IBTYPE_POPOVER    = 'popover';

    const IBPLACEMENT_TOP       = 'top';
    const IBPLACEMENT_BOTTOM    = 'bottom';
    const IBPLACEMENT_LEFT      = 'left';
    const IBPLACEMENT_RIGHT     = 'right';
    const IBPLACEMENT_AUTO      = 'auto';

    const IBTRIGGER_CLICK       = 'click';
    const IBTRIGGER_HOVER       = 'hover';
    const IBTRIGGER_FOCUS       = 'focus';
    const IBTRIGGER_MANUEL      = 'manuel';

    private $const_display;
    private $const_state;
    private $const_IBtype;
    private $const_IBplacement;
    private $const_IBtrigger;

    const BOOLEAN_TRUE    = 'true';
    const BOOLEAN_FALSE   = 'false';

    const COLOR_BLACK         = 'black';
    const COLOR_WHITE         = 'white';
    const COLOR_LIME          = 'lime';
    const COLOR_GREEN         = 'green';
    const COLOR_EMERALD       = 'emerald';
    const COLOR_TEAL          = 'teal';
    const COLOR_BLUE          = 'blue';
    const COLOR_CYAN          = 'cyan';
    const COLOR_COBALT        = 'cobalt';
    const COLOR_INDIGO        = 'indigo';
    const COLOR_VIOLET        = 'violet';
    const COLOR_PINK          = 'pink';
    const COLOR_MAGENTA       = 'magenta';
    const COLOR_CRIMSON       = 'crimson';
    const COLOR_RED           = 'red';
    const COLOR_ORANGE        = 'orange';
    const COLOR_AMBER         = 'amber';
    const COLOR_YELLOW        = 'yellow';
    const COLOR_BROWN         = 'brown';
    const COLOR_OLIVE         = 'olive';
    const COLOR_STEEL         = 'steel';
    const COLOR_MAUVE         = 'mauve';
    const COLOR_TAUPE         = 'taupe';
    const COLOR_GRAY          = 'gray';
    const COLOR_DARK          = 'dark';
    const COLOR_DARKER        = 'darker';
    const COLOR_DARKBROWN     = 'darkBrown';
    const COLOR_DARKCRIMSON   = 'darkCrimson';
    const COLOR_DARKMAGENTA   = 'darkMagenta';
    const COLOR_DARKINDIGO    = 'darkIndigo';
    const COLOR_DARKCYAN      = 'darkCyan';
    const COLOR_DARKCOBALT    = 'darkCobalt';
    const COLOR_DARKTEAL      = 'darkTeal';
    const COLOR_DARKEMERALD   = 'darkEmerald';
    const COLOR_DARKGREEN     = 'darkGreen';
    const COLOR_DARKORANGE    = 'darkOrange';
    const COLOR_DARKRED       = 'darkRed';
    const COLOR_DARKPINK      = 'darkPink';
    const COLOR_DARKVIOLET    = 'darkViolet';
    const COLOR_DARKBLUE      = 'darkBlue';
    const COLOR_LIGHTBLUE     = 'lightBlue';
    const COLOR_LIGHTRED      = 'lightRed';
    const COLOR_LIGHTGREEN    = 'lightGreen';
    const COLOR_LIGHTERBLUE   = 'lighterBlue';
    const COLOR_LIGHTTEAL     = 'lightTeal';
    const COLOR_LIGHTOLIVE    = 'lightOlive';
    const COLOR_LIGHTORANGE   = 'lightOrange';
    const COLOR_LIGHTPINK     = 'lightPink';
    const COLOR_GRAYDARK      = 'grayDark';
    const COLOR_GRAYDARKER    = 'grayDarker';
    const COLOR_GRAYLIGHT     = 'grayLight';
    const COLOR_GRAYLIGHTER   = 'grayLighter';

    /**
     * OObject constructor.
     * @param $id           identifiant de l'objet
     * @param $pathObjArray chemin partiel du fichier config de l'objet étendu
     */
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

                $objName = 'GraphicObjectTemplating/OObjects/';
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

//        if (!in_array($properties['object'] , ['osform', 'osdiv'])) {
//            var_dump("OObject =>");
//            var_dump($properties);
//            exit();
//        }

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
            if (empty($objects)) { $objects = []; }
            return (array_key_exists($id, $objects));
        }
        return false;
    }

    /**
     * @param $id
     * @param Container $sessionObj
     * @param null $valeur
     * @return mixed bool / OObject
     * @throws \Exception
     */
    public static function buildObject($id, Container $sessionObj, $valeur = null)
    {
        if (!empty($id)) {
            $objects = $sessionObj->objects;
            $pObj    = $objects[$id];
            $properties = unserialize($pObj);
            if (!empty($properties)) {
                // TODO: pb boucle sans fin sur création de l'instance de l'objet
                /** @var OObject $object */
                $object = new $properties['className']($id);
                $object->setProperties($properties);
                if ($object->getTypeObj() == 'odcontained' && !empty($valeur)) {
                    if (method_exists($object, 'setValue')) {
                        $object->setValue($valeur);
                    }
                }
                $objects[$id]           = serialize($object->getProperties());
                $sessionObj->objects    = $objects;
                return $object;
            }
            return null;
        }
        return false;
    }

    public static function cloneObject(OObject $object, Container $sessionObj)
    {
        if (self::existObject($object->getId(), $sessionObj)) {
            $tmpObj = clone $object;
            $properties = $tmpObj->getProperties();
            $tmpObj->id = 'tmpObj';
            $properties['id'] = 'tmpObj';
            $tmpObj->setProperties($properties);
            $tmpObj->saveProperties();
            return $tmpObj;
        }
    }

    public static function destroyObject($id, $session = false)
    {
        $now    = new \DateTime();
        $sessionObj = self::validateSession();

        if ($session) {
            $objects    = $sessionObj->objects;
            if (array_key_exists('menuGlobal', $objects)) {
                $menuGlobal = $objects['menuGlobal'];
            }
            $sessionObj->objects = [];
            $sessionObj->resources = [];
            $sessionObj->lastAccess = $now->format("Y-m-d H:i:s");
            if (isset($menuGlobal)) {
                $menu = new ODMenu('menuGlobal');
                $menu->setProperties(unserialize($menuGlobal));
                $menu->saveProperties();
            }
            return true;
        } else {
            if (self::existObject($id, $sessionObj)) {
                $objects = $sessionObj->objects;
                $properties = unserialize($objects[$id]);
                if ($properties['typeObj'] == 'oscontainer') {
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

    public static function formatRetour($idSource, $idCible, $mode, $code = null) {
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

    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        if (null !== $this->id) {
            $id                 = (string) $id;
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

    public function setWidthBT($widthBT)
    {
        $widthBT    = (string) $widthBT;
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
                    if ($class != $properties['className']) {
                        $obj = new $class();
                    } else {
                        $obj = $this;
                    }
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

    public function setWidth($width)
    {
        $width = (string) $width ;
        $properties = $this->getProperties();
        $properties['width'] = $width;
        $this->setProperties($properties);
        return $this;
    }

    public function getWidth()
    {
        $properties = $this->getProperties();
        return array_key_exists('width', $properties) ? $properties['width'] : false;
    }

    public function setHeight($height)
    {
        $height = (string) $height;
        $properties = $this->getProperties();
        $properties['height'] = $height;
        $this->setProperties($properties);
        return $this;
    }

    public function getHeight()
    {
        $properties = $this->getProperties();
        return array_key_exists('height', $properties) ? $properties['height'] : false;
    }

    /** **************************************************************************************************
     * méthodes de gestion des infobulles mis sur les objets                                             *
     * *************************************************************************************************** */

    public function setIBType($IBtype = self::IBTYPE_TOOLTIP)
    {
        $IBtypes    = $this->getIBTypeConstants();
        $IBtype     = (string) $IBtype;
        if (!in_array($IBtype, $IBtypes)) { $IBtype = self::IBTYPE_TOOLTIP; }

        $properties = $this->getProperties();
        if (!array_key_exists('infoBulle', $properties)) { $properties['infoBulle'] = []; }
        $infoBulle  = $properties['infoBulle'];
        $infoBulle['type'] = $IBtype;
        $properties['infoBulle'] = $infoBulle;
        $this->setProperties($properties);
        return $this;
    }

    public function getIBType()
    {
        $properties = $this->getProperties();
        if (array_key_exists('infoBulle', $properties)) {
            $infoBulle  = $properties['infoBulle'];
            if (array_key_exists('type', $infoBulle)) {
                return $infoBulle['type'];
            }
        }
        return false;
    }

    public function enaIBAnimation()
    {
        $properties = $this->getProperties();
        if (!array_key_exists('infoBulle', $properties)) { $properties['infoBulle'] = []; }
        $infoBulle  = $properties['infoBulle'];
        $infoBulle['animation'] = self::BOOLEAN_TRUE;
        $properties['infoBulle'] = $infoBulle;
        $this->setProperties($properties);
        return $this;
    }

    public function disIBAnimation()
    {
        $properties = $this->getProperties();
        if (!array_key_exists('infoBulle', $properties)) { $properties['infoBulle'] = []; }
        $infoBulle  = $properties['infoBulle'];
        $infoBulle['animation'] = self::BOOLEAN_FALSE;
        $properties['infoBulle'] = $infoBulle;
        $this->setProperties($properties);
        return $this;
    }

    public function getIBAnimation()
    {
        $properties = $this->getProperties();
        if (array_key_exists('infoBulle', $properties)) {
            $infoBulle = $properties['infoBulle'];
            if (array_key_exists('animation', $infoBulle)) {
                return $infoBulle['animation'];
            }
        }
        return false;
    }

    public function setIBDelay(array $delay = null)
    {
        if (empty($delay)) {
            $delay['show'] = 500; $delay['hide'] = 100;
        } else {
            if (!array_key_exists('show', $delay) || !array_key_exists('hide', $delay)) {
                return false;
            }
        }
        $properties = $this->getProperties();
        if (!array_key_exists('infoBulle', $properties)) { $properties['infoBulle'] = []; }
        $infoBulle  = $properties['infoBulle'];
        $infoBulle['delay'] = $delay;
        $properties['infoBulle'] = $infoBulle;
        $this->setProperties($properties);
        return $this;
    }

    public function getIBDelay()
    {
        $properties = $this->getProperties();
        if (array_key_exists('infoBulle', $properties)) {
            $infoBulle  = $properties['infoBulle'];
            if (array_key_exists('delay', $infoBulle)) {
                return $infoBulle['delay'];
            }
        }
        return false;
    }

    public function enaIBHtml()
    {
        $properties = $this->getProperties();
        if (!array_key_exists('infoBulle', $properties)) { $properties['infoBulle'] = []; }
        $infoBulle  = $properties['infoBulle'];
        $infoBulle['html'] = self::BOOLEAN_TRUE;
        $properties['infoBulle'] = $infoBulle;
        $this->setProperties($properties);
        return $this;
    }

    public function disIBHtml()
    {
        $properties = $this->getProperties();
        if (!array_key_exists('infoBulle', $properties)) { $properties['infoBulle'] = []; }
        $infoBulle  = $properties['infoBulle'];
        $infoBulle['html'] = self::BOOLEAN_FALSE;
        $properties['infoBulle'] = $infoBulle;
        $this->setProperties($properties);
        return $this;
    }

    public function getIBHtml()
    {
        $properties = $this->getProperties();
        if (array_key_exists('infoBulle', $properties)) {
            $infoBulle = $properties['infoBulle'];
            if (array_key_exists('html', $infoBulle)) {
                return $infoBulle['html'];
            }
        }
        return false;
    }

    public function setIBPlacement($IBplacement = self::IBPLACEMENT_TOP)
    {
        $IBplacements = $this->getIBPlacementConstants();
        $IBplacement  = (string) $IBplacement;
        if (!in_array($IBplacement, $IBplacements)) { $IBplacement = self::IBPLACEMENT_TOP; }

        $properties     = $this->getProperties();
        if (!array_key_exists('infoBulle', $properties)) { $properties['infoBulle'] = []; }
        $infoBulle  = $properties['infoBulle'];
        $infoBulle['placement'] = $IBplacement;
        $properties['infoBulle'] = $infoBulle;
        $this->setProperties($properties);
        return $this;
    }

    public function getIBPlacement()
    {
        $properties = $this->getProperties();
        if (array_key_exists('infoBulle', $properties)) {
            $infoBulle  = $properties['infoBulle'];
            if (array_key_exists('placement', $infoBulle)) {
                return $infoBulle['placement'];
            }
        }
        return false;
    }

    public function setIBTitle($IBtitle = null)
    {
        $IBtitle = (string) $IBtitle;
        $properties = $this->getProperties();
        if (!array_key_exists('infoBulle', $properties)) { $properties['infoBulle'] = []; }
        $infoBulle  = $properties['infoBulle'];
        if (!empty($IBbody)) {
            $infoBulle['title'] = $IBtitle;
            $infoBulle['setIB'] = true;
        } else {
            if (!$this->getIBContent()) {
                $infoBulle['setIB'] = false;
            }
        }
        $properties['infoBulle'] = $infoBulle;
        $this->setProperties($properties);
        return $this;
    }

    public function getIBTitle()
    {
        $properties = $this->getProperties();
        if (array_key_exists('infoBulle', $properties)) {
            $infoBulle = $properties['infoBulle'];
            if (array_key_exists('title', $infoBulle)) {
                return $infoBulle['title'];
            }
        }
        return false;
    }

    public function setIBContent($IBContent = null)
    {
        $IBContent = (string) $IBContent;
        $properties = $this->getProperties();
        if (!array_key_exists('infoBulle', $properties)) { $properties['infoBulle'] = []; }
        $infoBulle  = $properties['infoBulle'];
        if (!empty($IBContent)) {
            $infoBulle['content'] = $IBContent;
            $infoBulle['setIB'] = true;
        } else {
            if (!$this->getIBTitle()) {
                $infoBulle['setIB'] = false;
            }
        }
        $properties['infoBulle'] = $infoBulle;
        $this->setProperties($properties);
        return $this;
    }

    public function getIBContent()
    {
        $properties = $this->getProperties();
        if (array_key_exists('infoBulle', $properties)) {
            $infoBulle = $properties['infoBulle'];
            if (array_key_exists('content', $infoBulle)) {
                return $infoBulle['content'];
            }
        }
        return false;
    }

    public function setIBTrigger($IBtrigger = self::IBTRIGGER_HOVER)
    {
        $IBtriggers = $this->getIBTriggerConstants();
        $IBtrigger  = (string) $IBtrigger;
        if (!in_array($IBtrigger, $IBtriggers)) { $IBtrigger = self::IBTRIGGER_HOVER; }
        if ($this->getIBType() == self::IBTYPE_TOOLTIP && $IBtrigger == self::IBTRIGGER_MANUEL) {
            $IBtrigger = self::IBTRIGGER_HOVER;
        }

        $properties     = $this->getProperties();
        if (!array_key_exists('infoBulle', $properties)) { $properties['infoBulle'] = []; }
        $infoBulle  = $properties['infoBulle'];
        $infoBulle['trigger'] = $IBtrigger;
        $properties['infoBulle'] = $infoBulle;
        $this->setProperties($properties);
        return $this;
    }

    public function getIBTrigger()
    {
        $properties = $this->getProperties();
        if (array_key_exists('infoBulle', $properties)) {
            $infoBulle  = $properties['infoBulle'];
            if (array_key_exists('trigger', $infoBulle)) {
                return $infoBulle['trigger'];
            }
        }
        return false;
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

    public function getIBTypeConstants()
    {
        $retour = [];
        if (empty($this->const_IBtype)) {
            $constants = $this->getConstants();
            foreach ($constants as $key => $constant) {
                $pos = strpos($key, 'IBTYPE_');
                if ($pos !== false) {
                    $retour[$key] = $constant;
                }
            }
            $this->const_IBtype= $retour;
        } else {
            $retour = $this->const_IBtype;
        }

        return $retour;
    }

    public function getIBPlacementConstants()
    {
        $retour = [];
        if (empty($this->const_IBplacement)) {
            $constants = $this->getConstants();
            foreach ($constants as $key => $constant) {
                $pos = strpos($key, 'IBPLACEMENT_');
                if ($pos !== false) {
                    $retour[$key] = $constant;
                }
            }
            $this->const_IBplacement = $retour;
        } else {
            $retour = $this->const_IBplacement;
        }

        return $retour;
    }

    public function getIBTriggerConstants()
    {
        $retour = [];
        if (empty($this->const_IBtrigger)) {
            $constants = $this->getConstants();
            foreach ($constants as $key => $constant) {
                $pos = strpos($key, 'IBTRIGGER_');
                if ($pos !== false) {
                    $retour[$key] = $constant;
                }
            }
            $this->const_IBtrigger = $retour;
        } else {
            $retour = $this->const_IBtrigger;
        }

        return $retour;
    }

    public function getColorConstants()
    {
        $retour = [];
        if (empty($this->const_color)) {
            $constants = $this->getConstants();
            foreach ($constants as $key => $constant) {
                $pos = strpos($key, 'COLOR_');
                if ($pos !== false) {
                    $retour[$key] = $constant;
                }
            }
            $this->const_color = $retour;
        } else {
            $retour = $this->const_color;
        }

        return $retour;
    }
}
