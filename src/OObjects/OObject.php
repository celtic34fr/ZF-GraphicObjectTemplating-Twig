<?php

namespace GraphicObjectTemplating\OObjects;

/**
 * classe initiale de création d'objet G.O.T.
 *
 * attributs                                                                                        tests unitaires
 * ---------
 * id                                                                                                   ** **
 * name                                                                                                 ** **
 * className                                                                                            **
 * display                                                                                              **
 * object
 * typObj
 * template                                                                                             **
 * widthBT
 * lastAccess
 * state                                                                                                **
 * classes
 * width
 * height
 * autoCenter
 * acPx
 * acPy
 * infoBulle
 *  setIB
 *  type
 *  animation
 *  delay
 *      show
 *      hide
 *  html
 *  placement
 *  title
 *  content
 *  trigger
 * properties                                                                                           **
 *
 * méthodes
 * --------
 * __construct($id, $pathObjArray)                                                                      **
 * static function validateSession()
 * static function existObject($id, $sessionObj)
 * static function buildObject($id, $valeur = null)
 * static function destroyObject($id)
 * static function clearObjects()
 * static function cloneObject($object)
 * static function formatBootstrap($widthBT)
 * static function formatRetour($idSource, $idCible, $mode, $code = null)
 * static function getPersistantObjs()
 * static function putInComm(OObject $object, bool $crypt= false)
 * static function pullInComm(OObject $object, bool $crypt= false)
 * static function cryptComm()
 * static function decryptComm()
 * static function pullOutComm(bool $crypt = false)
 *
 * getProperty(string $name)                                                                            **
 * getProperties()                                                                                      **
 * setProperties(array $properties)                                                                     **
 * getId()                                                                                              **
 * setId(string $id)                                                                                    **
 * getName()                                                                                            **
 * setName(string $name)                                                                                **
 * setDisplay($display = OObject::DISPLAY_BLOCK)                                                        **
 * getDisplay()                                                                                         **
 * setWidthBT(string $widthBT)
 * getWidthBT()
 * setClassName(string $className = null)                                                               **
 * getClassName()                                                                                       **
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
 * enable()                                                                                             **
 * disable()                                                                                            **
 * getState()                                                                                           **
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
 * isPersistantObjs()
 * addPersistantObjs()
 *
 * méthodes de gestion des infobulles mis sur les objets
 * -----------------------------------------------------
 * getIBType()
 * setIBType($IBtype = self::IBTYPE_TOOLTIP)
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

use DateTime;
use Exception;
use GraphicObjectTemplating\Service\ZF3GotServices;
use ReflectionClass;
use ReflectionException;
use Zend\Session\Container;
use GraphicObjectTemplating\OObjects\ODContained\ODButton;

class OObject
{
    private $id;
    private $name;
    private $properties;
    private $lastAccess;
    private static $zoneCommName = null;
    private static $zoneCommData = null;

    const DISPLAY_NONE    = 'none';
    const DISPLAY_BLOCK   = 'block';
    const DISPLAY_INLINE  = 'inline';
    const DISPLAY_INBLOCK = 'inline-block';
    const NO_DISPLAY      = 'noDisplay';

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

    private $constants = [];
    private $const_display;
    private $const_state;
    private $const_IBtype;
    private $const_IBplacement;
    private $const_IBtrigger;
    private $const_color;

    /**
     * OObject constructor.
     *
     * @param string $id            identifiant de l'objet
     * @param $pathObjArray array chemin partiel du fichier config de l'objet étendu
     * @throws Exception
     */
    public function __construct(string $id, array $pathObjArray)
    {

        if (empty($id)) {
            $id = 'dummy';
            self::destroyObject($id, false);
        }
        $sessionObj = self::validateSession();
        $object = $sessionObj->objects;
        $path = __DIR__;
        $path .= '/../../view/zf3-graphic-object-templating/';
        $pathObjArray[] = 'oobjects/oobject';

        if (!($object && array_key_exists($id, $object))) {
            $objProperties = [];
            while ($name = array_pop($pathObjArray)) {
                $path_properties = $path . $name . '.config.php';
                $path_rscs = $path . $name . '.rscs.php';
                $objProperties = array_merge($objProperties, include $path_properties);
                if (is_file($path_rscs)) {
                    $rscsObj = include $path_rscs;
                    if ($rscsObj) {
                        $rscsSession = $sessionObj->resources ?? [];
                        $prefix = 'graphicobjecttemplating/oobjects/';
                        if (array_key_exists('prefix', $rscsObj)) {
                            $prefix = 'gotextension/' . $rscsObj['prefix'] . 'oeobjects/';
                            unset($rscsObj['prefix']);
                        }
                        foreach ($rscsObj as $type => $filesInfo) {
                            if (!array_key_exists($type, $rscsSession)) {
                                $rscsSession[$type] = [];
                            }
                            foreach ($filesInfo as $name => $rsc_path) {
                                $rscsSession[$type][$name] = $prefix . $objProperties['typeObj'] . '/' . $objProperties['object'] . '/' . $rsc_path;
                            }
                        }
                        $sessionObj->resources = $rscsSession;
                    }
                }
            }

            $objProperties['id'] = $id;
            $objProperties['name'] = $id;
            $this->id = $id;
            $this->name = $id;
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
            $this->setProperties($objProperties);
            $this->properties   = $objProperties;
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

    /**
     * @return Container
     * @throws Exception
     */
    public static function validateSession()
    {
        $now        = new DateTime();
        $gotObjList = new Container('gotObjList');
        $lastAccess = new DateTime($gotObjList->lastAccess);

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

    /**
     * @param $id
     * @param Container $sessionObj
     * @return bool
     */
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
     * @throws Exception
     */
    public static function buildObject($id, Container $sessionObj, $valeur = null)
    {
        if (!empty($id) && self::existObject($id, $sessionObj)) {
            $objects = $sessionObj->objects;
            $pObj    = $objects[$id];
            $properties = unserialize($pObj);
            if (!empty($properties)) {
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

    /**
     * @param OObject $object
     * @param Container $sessionObj
     * @return OObject|bool
     * @throws Exception
     */
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
        return false;
    }

    /**
     * @param $id
     * @param bool $session
     * @return bool
     * @throws Exception
     */
    public static function destroyObject($id, $session = false)
    {
        $now    = new DateTime();
        $sessionObj = self::validateSession();

        if ($session) {
            $objects                = $sessionObj->objects;
            $persistantObjs         = $sessionObj->persistObjs;

            $tmpObjects             = [];
            $tmpResources           = [];

            if (is_array($persistantObjs)) {
                $objIds = [];
                foreach ($persistantObjs as $id => $classe) {
                    $tmpObjects[$id]    = $objects[$id];
                    $objIds[]           = $id;
                }
                $tmpResources       = ZF3GotServices::rscs($objIds);
            }

            $sessionObj->objects    = $tmpObjects;
            $sessionObj->resources  = $tmpResources;
            $sessionObj->lastAccess = $now->format("Y-m-d H:i:s");

            return true;
        } else {
            if (self::existObject($id, $sessionObj)) {
                $objects = $sessionObj->objects;
                $properties = unserialize($objects[$id]);
                if ($properties['typeObj'] == 'oscontainer') {
                    $objet = self::buildObject($id, $sessionObj);
                    $children = $objet->getChildren();
                    foreach ($children as $child) {
                        self::destroyObject($child->getId());
                        $persistantObjs = $sessionObj->persistObjs;
                        if (array_key_exists($id, $persistantObjs)) { unset($persistantObjs[$id]); }
                        $sessionObj->persistObjs    = $persistantObjs;
                    }
                }
                $objects = $sessionObj->objects;
                $resources = $sessionObj->resources;
                $properties = unserialize($objects[$id]);
                $persistantObjs = $sessionObj->persistObjs;
                unset($objects[$id]);
                $notfound = true;
                foreach ($objects as $object) {
                    if ($properties["object"] == unserialize($object)["object"]) {
                        $notfound = false;
                        break;
                    }
                }
                if ($notfound) {
                    $pathRscs = __DIR__;
                    $pathRscs .= '/../../view/zf3-graphic-object-templating/oobjects/' . $properties['typeObj'];
                    $pathRscs .= '/' . $properties['object'] . '/' . $properties['object'] . '.rscs.php';
                    if (is_file($pathRscs)) {
                        $rscsObj = include $pathRscs;
                        if ($rscsObj) {
                            if (array_key_exists('prefix', $rscsObj)) {
                                unset($rscsObj['prefix']);
                            }
                            foreach ($rscsObj as $type => $filesInfo) {
                                foreach ($filesInfo as $name => $path) {
                                    unset($resources[$type][$name]);
                                }
                            }
                        }
                    }
                }

                if (array_key_exists($id, $persistantObjs)) { unset($persistantObjs[$id]); }
                $sessionObj->objects        = $objects;
                $sessionObj->persistObjs    = $persistantObjs;
                $sessionObj->resources      = $resources;
                $sessionObj->lastAccess     = $now->format("Y-m-d H:i:s");
                return true;
            }
            return false;
        }
    }

    /**
     * @return bool
     * @throws Exception
     */
    public static function clearObjects()
    {
        $now        = new DateTime();
        $gotObjList = self::validateSession();
        unset($gotObjList->objects);
        $gotObjList->objects = [];
        $gotObjList->persistObjs = [];
        $gotObjList->resources  = [];
        $gotObjList->lastAccess = $now->format("Y-m-d H:i:s");
        return true;
    }

    /**
     * @param string $widthBT
     * @return bool|string
     */
    public static function formatBootstrap(string $widthBT)
    {
        if (!empty($widthBT)) {
            $ret = [];
            switch (true) {
                case (is_numeric($widthBT)):
                    $ret['WL'] = 'WL'.$widthBT;
                    $ret['WM'] = 'WM'.$widthBT;
                    $ret['WS'] = 'WS'.$widthBT;
                    $ret['WX'] = 'WX'.$widthBT;
                    break;
                case (strpos($widthBT, ':') !== false):
                    $widthBTs = explode(':', $widthBT);
                    foreach ($widthBTs as $item) {
                        if ((int) ($val = substr($item, 1)) > 0) {
                            $k = substr($item, 0, 1);
                            $ret[$k.'L'] = $k.'L'.$val;
                            $ret[$k.'M'] = $k.'M'.$val;
                            $ret[$k.'S'] = $k.'S'.$val;
                            $ret[$k.'X'] = $k.'X'.$val;
                        } else {
                            $key = substr($item, 0, 2);
                            $ret[$key] = $item;
                        }
                    }
                    break;
            }
            if (sizeof($ret) > 0) { return implode(':', $ret); }
            else { $ret = ''; }
            return $ret;
        }
        return false;
    }

    /**
     * @param $labelWidthBT
     * @return mixed
     */
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
                    case 'WL' :
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
     * @param $idSource
     * @param $idCible
     * @param $mode
     * @param null $code
     * @return array
     */
    public static function formatRetour($idSource, $idCible, $mode, $code = null)
    {
        if (empty($idCible)) { $idCible = $idSource; }
        return ['idSource'=>$idSource, 'idCible'=>$idCible, 'mode'=>$mode, 'code'=>$code];
    }

    /**
     * @return array
     * @throws Exception
     */
    public static function getPersistantObjs()
    {
        $gotObjList = self::validateSession();
        $persistantObjs = $gotObjList->persistObjs;
        return $persistantObjs;
    }

    /**
     * @param OObject $object
     * @param bool $crypt
     */
    public static function putInComm(OObject $object = null, bool $crypt = false) : void
    {
        $zoneComm   = self::getZoneComm();
        $data       = $zoneComm['data'];

        if (is_string($data)) {
            self::decryptComm();
            $zoneComm = self::getZoneComm();
            $data       = $zoneComm['data'];
        }
        if ($object === null) {
            $data       = [];
            $crypt      = false;
        } else {
            if (array_key_exists($object->getId(), $data)) { unset($data[$object->getId()]); }
            $data[$object->getId()] = self::buildDataArray($object);
        }
        self::setZoneComm($zoneComm['name'], $data);

        if ($crypt) { self::cryptComm(); }
    }

    /**
     * @param OObject $object
     * @param bool $crypt
     * @return bool
     */
    public function pullInComm(OObject $object, bool $crypt = false)
    {
        $zoneComm   = self::getZoneComm();
        if ($crypt) {
            self::decryptComm();
            $zoneComm   = self::getZoneComm();
        }
        $data       = $zoneComm['data'];
        if (!empty($data) && is_array($data)) {
            if (array_key_exists($object->getId(), $data)) {
                unset($data[$object->getId()]);
                self::setZoneComm($zoneComm['name'], $data);
                if ($crypt) { self::cryptComm(); }
                return true;
            }
        }
        return false;
    }

    /**
     *
     */
    public static function cryptComm() : void
    {
        $zoneComm = self::getZoneComm();
        $data       = $zoneComm['data'];
        if (!is_string($data) && null !== $data) {
            $data   = json_encode($data);
            self::setZoneComm($zoneComm['name'], $data);
        }
   }

    /**
     *
     */
    public static function decryptComm() : void
    {
        $zoneComm   = self::getZoneComm();
        $data       = $zoneComm['data'];
        if (!is_array($data) && null !== $data) {
            $data   = json_decode($data);
            self::setZoneComm($zoneComm['name'], $data);
        }
    }

    /**
     * @param bool $crypt
     * @return array|string
     */
    public static function pullOutComm(bool $crypt = false)
    {
        if ($crypt) { self::decryptComm(); }
        return self::getZoneComm();
    }

    /**
     * @return array|string
     */
    public static function getZoneComm()
    {
        $zoneComm   = [];
        $zoneComm['name'] = self::$zoneCommName;
        $zoneComm['data'] = self::$zoneCommData;
        return $zoneComm;
    }

    /**
     * @param string $name
     * @param mixed $data
     */
    public static function setZoneComm(string $name = null, $data = null): void
    {
        self::$zoneCommName = $name;
        self::$zoneCommData = $data;
    }

    /** **************************************************************************************************
     * méthodes de l'objet proprement dites                                                              *
     * *************************************************************************************************** */

    /**
     * @param string $name
     * @return mixed|bool
     */
    public function getProperty(string $name)
    {
        return (array_key_exists($name, $this->properties)) ? $this->properties[$name] : false;
    }

    /**
     * @return bool|mixed
     */
    public function getProperties()
    {
        if (strlen($this->id) > 0 && $this->id != null) {
            return $this->properties;
        }

        return false;
    }

    /**
     * @param array $properties
     * @return $this|bool
     * @throws Exception
     */
    public function setProperties(array $properties)
    {
        switch (true) {
            case ($this->id == null):
            case empty($properties):
            case !array_key_exists('id', $properties):
            case $this->id != $properties['id']:
                return false;
                break;
        }

        $this->properties   = $properties;
        $this->lastAccess   = (new DateTime())->format('Y-m-d H:i:s');
        return $this;
    }

    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param string $id
     * @return $this|bool
     * @throws Exception
     */
    public function setId(string $id)
    {
        if (null !== $this->id) {
            $id                 = (string) $id;
            $gotObjList         = self::validateSession();
            $objects            = $gotObjList->objects;
            $properties         = unserialize($objects[$this->id]);

            $properties['id']   = $id;
            unset($objects[$this->id]);
            $objects[$id]       = serialize($properties);

            $gotObjList->objects = $objects;
            $gotObjList->lastAccess = (new DateTime())->format('Y-m-d H:i:s');
            $this->properties   = $properties;
            $this->lastAccess   = (new DateTime())->format('Y-m-d H:i:s');
            $this->id           = $id;

            return $this;
        }
        return false;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return $this|bool
     * @throws Exception
     */
    public function setName(string $name)
    {
        if (null !== $this->id) {
            $properties = $this->getProperties();
            $properties['name'] = $name;
            $this->name         = $name;
            $this->setProperties($properties);
            return $this;
        }
        return false;
    }

    /**
     * @return bool|string
     */
    public function getDisplay()
    {
        $properties = $this->getProperties();
        if ($properties) {
            return array_key_exists('display', $properties) ? $properties['display'] : false;
        }
        return false;
    }

    /**
     * @param string $display
     * @return $this|bool
     * @throws ReflectionException
     * @throws Exception
     */
    public function setDisplay(string $display = self::DISPLAY_BLOCK)
    {
        if (null !== $this->id) {
            $displays = $this->getDisplayConstants();
            if (in_array($display, $displays) === false) { $display = self::DISPLAY_BLOCK; }

            $properties = $this->getProperties();
            $properties['display'] = $display;
            $this->setProperties($properties);
            return $this;
        }
        return false;
    }

    /**
     * @return bool
     */
    public function getWidthBT()
    {
        $properties = $this->getProperties();
        return array_key_exists('widthBT', $properties) ? $properties['widthBT'] : false;
    }

    /**
     * @param string $widthBT
     * @return $this|bool
     * @throws Exception
     */
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

    /**
     * @return bool
     */
    public function getClassName()
    {
        $properties = $this->getProperties();
        if ($properties) {
            return array_key_exists('className', $properties) ? $properties['className'] : false;
        }
        return false;
    }

    /**
     * @param string|null $className
     * @return $this|bool
     * @throws Exception
     */
    public function setClassName(string $className = null)
    {
        if (!empty($className) && $this->id != null) {
            if (class_exists($className)) {
                $properties = $this->getProperties();
                $properties['className'] = $className;
                $this->setProperties($properties);
                return $this;
            }
        }
        return false;
    }

    /**
     * @return bool
     */
    public function getTemplate()
    {
        $properties = $this->getProperties();
        return array_key_exists('template', $properties) ? $properties['template'] : false;
    }

    /**
     * @param string|null $template
     * @return $this|bool
     * @throws Exception
     */
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

    /**
     * @return bool
     */
    public function getObject()
    {
        $properties = $this->getProperties();
        return array_key_exists('object', $properties) ? $properties['object'] : false;
    }

    /**
     * @param string|null $object
     * @return $this|bool
     * @throws Exception
     */
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

    /**
     * @return bool
     */
    public function getTypeObj()
    {
        $properties = $this->getProperties();
        return array_key_exists('typeObj', $properties) ? $properties['typeObj'] : false;
    }

    /**
     * @param string|null $typeObj
     * @return $this|bool
     * @throws Exception
     */
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

    /**
     * @return mixed
     */
    public function getLastAccess()
    {
        return $this->lastAccess;
    }

    /**
     * @return bool
     */
    public function getClasses()
    {
        $properties = $this->getProperties();
        return array_key_exists('classes', $properties) ? $properties['classes'] : false;
    }

    /**
     * @param null $classes
     * @return $this|bool
     * @throws Exception
     */
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

    /**
     * @param string $class
     * @return $this|bool
     * @throws Exception
     */
    public function addClass(string $class = null)
    {
        if (!empty($class)) {
            $properties = $this->getProperties();
            $classes    = $properties['classes'] ?? '';
            if (strpos($classes, $class) === false) {
                $classes .= ' '.$class;
                $properties['classes'] = $classes;
                $this->setProperties($properties);
                return $this;
            }
        }
        return false;
    }

    /**
     * @param string $class
     * @return $this|bool
     * @throws Exception
     */
    public function removeClass(string $class = null)
    {
        if (!empty($class)) {
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
        return false;
    }

    /**
     * @param string $nameFile
     * @param string $pathFile
     * @return $this|bool
     * @throws Exception
     */
    public function addCssFile(string $nameFile, string $pathFile)
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

    /**
     * @param string $nameFile
     * @return $this|bool
     * @throws Exception
     */
    public function removeCssFile(string $nameFile)
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

    /**
     * @param string $nameFile
     * @return bool
     */
    public function getPathCssFile(string $nameFile)
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

    /**
     * @param string $nameFile
     * @return $this|bool
     * @throws Exception
     */
    public function enaCssFile(string $nameFile)
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

    /**
     * @param string $nameFile
     * @return $this|bool
     * @throws Exception
     */
    public function disCssFile(string $nameFile)
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

    /**
     * @param string $nameFile
     * @return bool|string
     */
    public function getCssFileStatus(string $nameFile)
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

    /**
     * @param string $nameFile
     * @param string $pathFile
     * @return $this|bool
     * @throws Exception
     */
    public function addJsFile(string $nameFile, string $pathFile)
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

    /**
     * @param string $nameFile
     * @return $this|bool
     * @throws Exception
     */
    public function removeJsFile(string $nameFile)
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

    /**
     * @param string $nameFile
     * @return bool
     */
    public function getPathJsFile(string $nameFile)
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

    /**
     * @param string $nameFile
     * @return $this|bool
     * @throws Exception
     */
    public function enaJsFile(string $nameFile)
    {
        if (!empty($nameFile)) {
            $properties = $this->getProperties();
            if (array_key_exists('resources', $properties)) {
                $resources  = $properties['resources'];
                if (!array_key_exists('js', $resources)) {
                    $js        = $resources['js'];
                    if (array_key_exists($nameFile, $js)) {
                        if (!in_array($nameFile, $js['enable'])) {
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

    /**
     * @param string $nameFile
     * @return $this|bool
     * @throws Exception
     */
    public function disJsFile(string $nameFile)
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

    /**
     * @param string $nameFile
     * @return bool|string
     */
    public function getJsFileStatus(string $nameFile)
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

    /**
     * @return $this|bool
     * @throws Exception
     */
    public function enable()
    {
        if ($this->id != null) {
            $properties = $this->getProperties();
            $properties['state'] = self::STATE_ENABLE;
            $this->setProperties($properties);
            return $this;
        }
        return false;
    }

    /**
     * @return $this|bool
     * @throws Exception
     */
    public function disable()
    {
        if ($this->id != null) {
            $properties = $this->getProperties();
            $properties['state'] = self::STATE_DISABLE;
            $this->setProperties($properties);
            return $this;
        }
        return false;
    }

    /**
     * @return bool
     */
    public function getState()
    {
        $properties = $this->getProperties();
        if ($properties) {
            return array_key_exists('state', $properties) ? $properties['state'] : false;
        }
        return false;
    }

    /**
     * @return $this
     * @throws Exception
     */
    public function enaAutoCenter()
    {
        $properties = $this->getProperties();
        $properties['autoCenter'] = true;
        $this->setProperties($properties);
        return $this;
    }

    /**
     * @return $this
     * @throws Exception
     */
    public function disAutoCenter()
    {
        $properties = $this->getProperties();
        $properties['autoCenter'] = false;
        $this->setProperties($properties);
        return $this;
    }

    /**
     * @return bool
     */
    public function getStateAC()
    {
        $properties = $this->getProperties();
        return array_key_exists('autoCenter', $properties) ? $properties['autoCenter'] : false;
    }

    /**
     * @return bool
     */
    public function getACWidth()
    {
        $properties = $this->getProperties();
        return array_key_exists('acPx', $properties) ? $properties['acPx'] : false;
    }

    /**
     * @param string $width
     * @return $this
     * @throws Exception
     */
    public function setACWidth(string $width)
    {
        $properties = $this->getProperties();
        $properties['acPx'] = $width;
        $this->setProperties($properties);
        return $this;
    }

    /**
     * @return bool
     */
    public function getACHeight()
    {
        $properties = $this->getProperties();
        return array_key_exists('acPy', $properties) ? $properties['acPy'] : false;
    }

    /**
     * @param string $height
     * @return $this
     * @throws Exception
     */
    public function setACHeight(string $height)
    {
        $properties = $this->getProperties();
        $properties['acPy'] = $height;
        $this->setProperties($properties);
        return $this;
    }

    /**
     * @return array
     */
    public function getACWidthHeight()
    {
        $properties = $this->getProperties();
        $acPx       = (array_key_exists('acPx', $properties) ? $properties['acPx'] : false);
        $acPy       = (array_key_exists('acPy', $properties) ? $properties['acPy'] : false);
        return ['width' => $acPx, 'height' => $acPy];
    }

    /**
     * @param string $width
     * @param string $height
     * @return $this
     * @throws Exception
     */
    public function setACWidthHeight(string $width, string $height)
    {
        $width = (string) $width;
        $height = (string) $height;
        $properties = $this->getProperties();
        $properties['acPx'] = $width;
        $properties['acPy'] = $height;
        $this->setProperties($properties);
        return $this;
    }

    /**
     * @param string $event
     * @return bool|array
     */
    public function getEvent(string $event = null)
    {
        if (!empty($event)) {
            $properties = $this->getProperties();
            if (array_key_exists('event', $properties) && !empty($properties['event'])) {
                return array_key_exists($event, $properties['event']) ? $properties['event'][$event] : false;
            }
        }
        return false;
    }

    /**
     * @return bool|array
     */
    public function getEvents()
    {
        $properties = $this->getProperties();
        return array_key_exists('event', $properties) ? $properties['event'] : false;
    }

    /**
     * @param string $event
     * @param string $class
     * @param string $method
     * @param bool $stopEvent
     * @return $this|bool
     * @throws Exception
     */
    public function setEvent(string $event, string $class, string $method, bool $stopEvent = false)
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
                    break;
            }
            $events[$event]      = $evtDef;
            $properties['event'] = $events;
            $this->setProperties($properties);
            return $this;
        }
        return false;
    }

    /**
     * @param string $event
     * @return $this|bool
     * @throws Exception
     */
    public function disEvent(string $event)
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

    /**
     * @return Container
     * @throws Exception
     */
    public function saveProperties()
    {
        $sessionObj = self::validateSession();
        $objects    = $sessionObj->objects;
        $objects[$this->id] = serialize($this->properties);
        $sessionObj->objects = $objects;

        $sessionObj->lastAccess = (new DateTime())->format('Y-m-d H:i:s');
        $this->lastAccess   = (new DateTime())->format('Y-m-d H:i:s');

        return $sessionObj;
    }

    /**
     * @return bool
     */
    public function getWidth()
    {
        $properties = $this->getProperties();
        return array_key_exists('width', $properties) ? $properties['width'] : false;
    }

    /**
     * @param string $width
     * @return $this
     * @throws Exception
     */
    public function setWidth(string $width)
    {
        $properties = $this->getProperties();
        $properties['width'] = $width;
        $this->setProperties($properties);
        return $this;
    }

    /**
     * @return bool
     */
    public function getHeight()
    {
        $properties = $this->getProperties();
        return array_key_exists('height', $properties) ? $properties['height'] : false;
    }

    /**
     * @param string $height
     * @return $this
     * @throws Exception
     */
    public function setHeight(string $height)
    {
        $height = (string) $height;
        $properties = $this->getProperties();
        $properties['height'] = $height;
        $this->setProperties($properties);
        return $this;
    }

    /**
     * @return bool
     * @throws Exception
     */
    public function isPersistantObjs()
    {
        $gotObjList = self::validateSession();
        $persistentObjs = $gotObjList->persistObjs;
        return (is_array($persistentObjs)) ? (array_key_exists($this->id, $persistentObjs)) : false;
    }

    /**
     * @return $this
     * @throws Exception
     */
    public function addPersistantObjs()
    {
        $gotObjList = self::validateSession();
        $persistantObjs = $gotObjList->persistObjs;
        $persistantObjs[$this->id] = $this->id;
        $gotObjList->persistObjs    = $persistantObjs;
        return $this;
    }

    /** **************************************************************************************************
     * méthodes de gestion des infobulles mis sur les objets                                             *
     * *************************************************************************************************** */

    /**
     * @return bool
     */
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

    /**
     * @param string $IBtype
     * @return $this
     * @throws ReflectionException
     * @throws Exception
     */
    public function setIBType(string $IBtype = self::IBTYPE_TOOLTIP)
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

    /**
     * @return $this
     * @throws Exception
     */
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

    /**
     * @return $this
     * @throws Exception
     */
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

    /**
     * @return bool
     */
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

    /**
     * @return bool
     */
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

    /**
     * @param array|null $delay
     * @return $this|bool
     * @throws Exception
     */
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

    /**
     * @return $this
     * @throws Exception
     */
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

    /**
     * @return $this
     * @throws Exception
     */
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

    /**
     * @return bool
     */
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

    /**
     * @return bool
     */
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

    /**
     * @param string $IBplacement
     * @return $this
     * @throws ReflectionException
     */
    public function setIBPlacement(string $IBplacement = self::IBPLACEMENT_TOP)
    {
        $IBplacements = $this->getIBPlacementConstants();
        if (!in_array($IBplacement, $IBplacements)) { $IBplacement = self::IBPLACEMENT_TOP; }

        $properties     = $this->getProperties();
        if (!array_key_exists('infoBulle', $properties)) { $properties['infoBulle'] = []; }
        $infoBulle  = $properties['infoBulle'];
        $infoBulle['placement'] = $IBplacement;
        $properties['infoBulle'] = $infoBulle;
        $this->setProperties($properties);
        return $this;
    }

    /**
     * @return bool
     */
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

    /**
     * @param string $IBtitle
     * @return $this
     * @throws Exception
     */
    public function setIBTitle(string $IBtitle = null)
    {
        $properties = $this->getProperties();
        if (!array_key_exists('infoBulle', $properties)) { $properties['infoBulle'] = []; }
        $infoBulle  = $properties['infoBulle'];
        if (!empty($IBtitle)) {
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

    /**
     * @return bool
     */
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

    /**
     * @param string $IBContent
     * @return $this
     * @throws Exception
     */
    public function setIBContent(string $IBContent = null)
    {
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

    /**
     * @return bool
     */
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

    /**
     * @param string $IBtrigger
     * @return $this
     * @throws ReflectionException
     */
    public function setIBTrigger(string $IBtrigger = self::IBTRIGGER_HOVER)
    {
        $IBtriggers = $this->getIBTriggerConstants();
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


    /** **************************************************************************************************
     * méthodes privées de la classe                                                                     *
     * *************************************************************************************************** */

    /**
     * @return array
     * @throws ReflectionException
     */
    protected static function getConstants()
    {
        $ref = new ReflectionClass(static::class);
        return $ref->getConstants();
    }

    /**
     * @return array
     * @throws ReflectionException
     */
    private function getDisplayConstants()
    {
        $retour = [];
        if (empty($this->constants)) { $this->constants = $this->getConstants(); }
        if (empty($this->const_display)) {
            foreach ($this->constants as $key => $constant) {
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

    /**
     * @return array
     * @throws ReflectionException
     */
    public function getStateConstants()
    {
        $retour = [];
        if (empty($this->constants)) { $this->constants = $this->getConstants(); }
        if (empty($this->const_state)) {
            foreach ($this->constants as $key => $constant) {
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

    /**
     * @return array
     * @throws ReflectionException
     */
    public function getIBTypeConstants()
    {
        $retour = [];
        if (empty($this->constants)) { $this->constants = $this->getConstants(); }
        if (empty($this->const_IBtype)) {
            foreach ($this->constants as $key => $constant) {
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

    /**
     * @return array
     * @throws ReflectionException
     */
    public function getIBPlacementConstants()
    {
        $retour = [];
        if (empty($this->constants)) { $this->constants = $this->getConstants(); }
        if (empty($this->const_IBplacement)) {
            foreach ($this->constants as $key => $constant) {
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

    /**
     * @return array
     * @throws ReflectionException
     */
    public function getIBTriggerConstants()
    {
        $retour = [];
        if (empty($this->constants)) { $this->constants = $this->getConstants(); }
        if (empty($this->const_IBtrigger)) {
            foreach ($this->constants as $key => $constant) {
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

    /**
     * @return array
     * @throws ReflectionException
     */
    public function getColorConstants()
    {
        $retour = [];
        if (empty($this->constants)) { $this->constants = $this->getConstants(); }
        if (empty($this->const_color)) {
            foreach ($this->constants as $key => $constant) {
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


    /** méthode(s) privée(s) de l'objet **/

    /**
     * @param array $array1
     * @param array $array2
     * @return array
     */
    private function arrayMerge(array $array1, array $array2)
    {
        $resltArray     = [];

        foreach ($array2 as $cle => $item) {
            if (array_key_exists($cle, $array1)) { // prise valeur array2 comme finale
                $resltArray[$cle]   = $item;
                unset($array1[$cle]);
            } else {
                $resltArray[$cle]   = $item;
            }
        }

        foreach ($array1 as $cle => $item) {
            $resltArray[$cle]   = $item;
        }

        return $resltArray;
    }
}
