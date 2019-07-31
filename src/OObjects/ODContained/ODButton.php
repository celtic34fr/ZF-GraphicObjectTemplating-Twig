<?php

namespace GraphicObjectTemplating\OObjects\ODContained;

use Exception;
use GraphicObjectTemplating\OObjects\ODContained;
use GraphicObjectTemplating\OObjects\OObject;
use ReflectionException;
use Zend\Session\Container;

/**
 * Class ODButton
 * @package GraphicObjectTemplating\OObjects\ODContained
 *
 * __construct($id)         constructeur de l'objet, obligation de fournir $id identifiant de l'objet
 * setLabel(string $label)  affectation du texte affiché dans le bouton
 * getLabel()
 * setIcon(string $icon)    affectation de la classe CSS pour affichage d'une icône à gauche du label (glyphicon, ...)
 * setImage(string $pathFile)
 *                          affectation d'une image comme icône du bouton à gauche du label (.ico-custom)
 * getIcon()                récupère suivant le cas la classe associée (setIcon()) ou le chemin de l'image (setImage())
 * setForm(string $form = null)
 *                          rattachement du bouton à un 'formulaire' (cadre de l'objet OSForm) avec traitements induits
 * setType(string $type = self::BUTTONTYPE_CUSTOM)
 *                          affectation du type du bouton (= mode de fonctionnement) par défaut type 'CUSTOM'
 * getType()
 * evtClick(string $class, string $method, bool $stopEvent = false)
 *                          déclaration et paramétrage de l'évènement onclick sur le bouton avec traitements induits
 * getClick()               récupération des paramètres de l'évènement onclick sur le bouton
 * disClick()               suppression / déactivation de l'évènement onclick sur le bouton
 * setNature(string $nature = self::BUTTONNATURE_DEFAULT)
 *                          affecation de la nature du bouton (= couleur graphique) par deefaut 'DEFAULT' blanc
 *                          remarque : la nature (LINK' présente le bouton comme un lien hypertexte
 * getNature()
 * enaDefault()
 * disDefault()
 * createSimpleControl(Container $sessionObj, $ord)
 * setNatureCustom(string $custom)
 * getNatureCustom()
 * getNatureCustomBackground()
 * getNatureCustomColor()
 * getNatureCustomBorder()
 * setWidth(string $width)  surcharge de l'affectation de la largeur du bouton et de l'image servant d'icône en
 *                          directives CSS
 * setLeft(string $left)    affectation du déport à gauche de l'image servant d'icône
 * getLeft()                récupération du déport à gauche de l'image servant d'icône
 * setTop(string $top)      affectation du déport en haut de l'image servant d'icône
 * getTop()                 récupération du déport en haut de l'image servant d'icône
 *
 * méthodes privées de la classe
 * -----------------------------
 * getTypeConstants()
 * getNatureConstants()
 * getLinkTargetConstants()
 */

class ODButton extends ODContained
{
    const BUTTONTYPE_CUSTOM = 'custom';
    const BUTTONTYPE_SUBMIT = 'submit';
    const BUTTONTYPE_RESET  = 'reset';
    const BUTTONTYPE_LINK   = 'link';

    const BUTTONNATURE_DEFAULT  = 'btn btn-default';
    const BUTTONNATURE_PRIMARY  = 'btn btn-primary';
    const BUTTONNATURE_SUCCESS  = 'btn btn-success';
    const BUTTONNATURE_INFO     = 'btn btn-info';
    const BUTTONNATURE_WARNING  = 'btn btn-warning';
    const BUTTONNATURE_DANGER   = 'btn btn-danger';
    const BUTTONNATURE_LINK     = 'btn btn-link';
    const BUTTONNATURE_BLACK    = 'btn btn-black';
    const BUTTONNATURE_CUSTOM   = 'btn btn-custom';

    const BUTTONLINK_TARGET_BLANK   = '_blank';
    const BUTTONLINK_TARGET_SELF    = '_self';
    const BUTTONLINK_TARGET_PARENT  = '_parent';
    const BUTTONLINK_TARGET_TOP     = '_top';

    private $const_type;
    private $const_nature;
    private $const_linkTarget;

    /**
     * ODButton constructor.
     * @param string $id
     * @throws ReflectionException
     */
    public function __construct(string $id, $pathObjArray = [])
    {
        $pathObjArray[] = "oobjects/odcontained/odbutton/odbutton";
		parent::__construct($id, $pathObjArray);

        if ($this->getId() != 'dummy') {
            if (!$this->getWidthBT() || empty($this->getWidthBT())) {
                $this->setWidthBT(12);
            }
            $this->setDisplay(self::DISPLAY_BLOCK);
            $this->enable();
        }

        $this->saveProperties();
        return $this;
    }

    /**
     * @param string $label
     * @return $this
     */
    public function setLabel(string $label)
    {
        $properties = $this->getProperties();
        $properties['label'] = $label;
        $this->setProperties($properties);
        return $this;
    }

    /**
     * @return bool
     */
    public function getLabel()
    {
        $properties = $this->getProperties();
        return array_key_exists('label', $properties) ? $properties['label'] : false;
    }

    /**
     * @param $icon
     * @return $this
     */
    public function setIcon(string $icon)
    {
        $properties = $this->getProperties();
        $properties['icon'] = $icon;
        $this->setProperties($properties);
        return $this;
    }

    /**
     * @param string $pathFile chemin relatif à partir de $_SERVER["DOCUMENT_ROOT"]
     * @return ODButton|bool
     */
    public function setImage(string $pathFile)
    {
        if (file_exists($_SERVER["DOCUMENT_ROOT"]."/".$pathFile)) {
            $properties = $this->getProperties();
            $properties['pathFile'] = 'http://'.$_SERVER['HTTP_HOST']."/".$pathFile;
            $this->setProperties($properties);
            return $this;
        }
        return false;
    }

    /**
     * @return bool
     */
    public function getIcon()
    {
        $properties = $this->getProperties();
        switch (true) {
            case (array_key_exists('icon', $properties) && !empty($properties['icon'])):
                return $properties['icon'];
                break;
            case (array_key_exists('pathFile', $properties) && !empty($properties['pathFile'])):
                return $properties['pathFile'];
                break;
            case (!array_key_exists('icon', $properties) || !array_key_exists('filePath', $properties)):
                return false;
                break;
            default:
                return '';
                break;
        }
    }

    /**
     * @param string $form
     * @return ODButton|bool
     */
    public function setForm(string $form = null)
    {
        parent::setForm($form);
        $properties = $this->getProperties();
        $callback   = array_key_exists('click', $properties['event']);
        switch ($properties['type']) {
            case self::BUTTONTYPE_LINK:
                if (!empty($properties['form'])) { $properties['form'] = ''; }
                break;
            default:
                if ($callback) {
                    $properties['type'] = self::BUTTONTYPE_SUBMIT;
                } else {
                    $properties['type'] = self::BUTTONTYPE_CUSTOM;
                }
                break;
        }
        $this->setProperties($properties);
        return $this;
    }

    /**
     * @param string $type
     * @return $this
     * @throws ReflectionException
     */
    public function setType(string $type = self::BUTTONTYPE_CUSTOM)
    {
        $properties = $this->getProperties();
        $types      = $this->getTypeConstants();
        $callback   = array_key_exists('click', $properties['event']);

        if (!in_array($type, $types)) { $type = self::BUTTONTYPE_CUSTOM; }
        switch ($properties['type']) {
            case self::BUTTONTYPE_LINK:
                if (!empty($properties['form'])) { $properties['form'] = ''; }
                if ($callback) {
                    $method = $properties['event']['click']['method'];
                    if (!is_array($method)) {
                        $method = explode('|', $method);
                        $params = [];
                        foreach ($method as $item) {
                            $item = explode(':', $item);
                            $params[$item[0]] = $item[1];
                        }
                        $method = $params;
                        $properties['event']['click']['method'] = $method;
                    }
                }
                break;
            case self::BUTTONTYPE_RESET:
                if (!empty($properties['form'])) { $type = self::BUTTONTYPE_CUSTOM; }
                break;
            case self::BUTTONTYPE_SUBMIT:
                if ($callback && !empty($properties['form'])) { $type = self::BUTTONTYPE_CUSTOM; }
                break;
        }
        $properties['type'] = $type;
        $this->setProperties($properties);
        return $this;
    }

    /**
     * @return bool
     */
    public function getType()
    {
        $properties = $this->getProperties();
        return array_key_exists('type', $properties) ? $properties['type'] : false;
    }

    /**
     * @param string $class
     * @param string $method
     * @param bool $stopEvent
     * @return bool|ODButton
     */
    public function evtClick(string $class, string $method, bool $stopEvent = false)
    {
        if (!empty($class) && !empty($method)) {
            // TODO; manque gestion bouton RESET cas méthode spécifique
            return $this->setEvent('click', $class, $method, $stopEvent);
        }
        return false;
    }

    /**
     * @return bool
     */
    public function getClick()
    {
        return $this->getEvent('click');
    }

    /**
     * @return bool|ODButton
     */
    public function disClick()
    {
        return $this->disEvent('click');
    }

    /**
     * @param string $nature
     * @return ODButton
     * @throws ReflectionException
     */
    public function setNature(string $nature = self::BUTTONNATURE_DEFAULT)
    {
        $nature  = (string) $nature;
        $natures = $this->getNatureConstants();
        if (!in_array($nature, $natures)) { $nature = self::BUTTONNATURE_DEFAULT; }

        $properties = $this->getProperties();
        $properties['nature'] = $nature;
        $this->setProperties($properties);
        return $this;
    }

    /**
     * @return bool
     */
    public function getNature()
    {
        $properties = $this->getProperties();
        return array_key_exists('nature', $properties) ? $properties['nature'] : false;
    }

    /**
     * @return ODButton
     */
    public function enaDefault()
    {
        $properties = $this->getProperties();
        $properties['default'] = true;
        $this->setProperties($properties);
        return $this;
    }

    /**
     * @return ODButton
     */
    public function disDefault()
    {
        $properties = $this->getProperties();
        $properties['default'] = true;
        $this->setProperties($properties);
        return $this;
    }

    /**
     * @param Container $sessionObj
     * @param $ord
     * @return ODButton
     * @throws Exception
     */
    public function createSimpleControl(Container &$sessionObj, $ord)
    {
        /** @var $btn ODButton */
    	$btn = self::cloneObject($this, $sessionObj);
        $sessionObj = $btn->setId($this->getId().$ord)
			->setValue($ord)
			->setDisplay(self::DISPLAY_BLOCK)
			->saveProperties();
		return $btn;
	}

    /**
     * @param string $custom
     * @param string $customColor
     * @return ODButton|bool
     */
    public function setNatureCustom(string $custom, string $customColor)
    {
        if (!preg_match('/([a-f0-9]{3}){1,2}\b/i', $custom)) {
            return false;
        }
        if (!preg_match('/([a-f0-9]{3}){1,2}\b/i', $customColor)) {
            return false;
        }

        $properties = $this->getProperties();
        $properties['custom'] = $custom;

        $customBorder   = dechex(hexdec($custom)*.9);
        $properties['customBorder'] = $customBorder;

        $properties['customColor']  = $customColor;

        $properties['nature']       = self::BUTTONNATURE_CUSTOM;

        $this->setProperties($properties);
        return $this;
	}

    /**
     * @return array|array
     */
    public function getNatureCustom()
    {
        $properties = $this->getProperties();
        $retour     = [];
        $retour['custom']   = array_key_exists('custom', $properties) ? $properties['custom'] : false;
        $retour['customColor'] = array_key_exists('customColor', $properties) ? $properties['customColor'] : false;
        $retour['customBorder'] =
                                array_key_exists('customBorder', $properties) ? $properties['customBorder'] : false;
        return $retour;
    }

    /**
     * @return bool|string
     */
    public function getNatureCustomBackground()
    {
        $properties = $this->getProperties();
        return array_key_exists('custom', $properties) ? $properties['custom'] : false;
	}

    /**
     * @return bool|string
     */
    public function getNatureCustomColor()
    {
        $properties = $this->getProperties();
        return array_key_exists('customColor', $properties) ? $properties['customColor'] : false;
    }

    /**
     * @return bool|string
     */
    public function getNatureCustomBorder()
    {
        $properties = $this->getProperties();
        return array_key_exists('customBorder', $properties) ? $properties['customBorder'] : false;
	}

    /**
     * @param string $width
     * @return $this
     */
    public function setWidth(string $width)
    {
        $properties = $this->getProperties();
        $properties['width'] = $width;
        if (empty($properties['left'])) {
            $properties['left'] = ((int) $width / 2) . substr($width, strlen(strval((int) $width) ));
        }
        $this->setProperties($properties);
        return $this;
    }

    /**
     * @param string $left
     * @return ODButton
     */
    public function setLeft(string $left)
    {
        $properties = $this->getProperties();
        $properties['left'] = $left;
        $this->setProperties($properties);
        return $this;
    }

    /**
     * @return bool|string
     */
    public function getLeft()
    {
        $properties = $this->getProperties();
        return array_key_exists('left', $properties) ? $properties['left'] : false;
    }

    /**
     * @param string $top
     * @return ODButton
     */
    public function setTop(string $top)
    {
        $properties = $this->getProperties();
        $properties['top'] = $top;
        $this->setProperties($properties);
        return $this;
    }
    public function getTop()
    {
        $properties = $this->getProperties();
        return array_key_exists('top', $properties) ? $properties['top'] : false;
    }

    /** **************************************************************************************************
     * méthodes privées de la classe                                                                     *
     * *************************************************************************************************** */

    /**
     * @return array
     * @throws ReflectionException
     */
    private function getTypeConstants()
    {
        $retour = [];
        if (empty($this->const_type)) {
            $constants = $this->getConstants();
            foreach ($constants as $key => $constant) {
                $pos = strpos($key, 'BUTTONTYPE');
                if ($pos !== false) {
                    $retour[$key] = $constant;
                }
            }
            $this->const_type = $retour;
        } else {
            $retour = $this->const_type;
        }
        return $retour;
    }

    /**
     * @return array
     * @throws ReflectionException
     */
    private function getNatureConstants()
    {
        $retour = [];
        if (empty($this->const_nature)) {
            $constants = $this->getConstants();
            foreach ($constants as $key => $constant) {
                $pos = strpos($key, 'BUTTONNATURE');
                if ($pos !== false) {
                    $retour[$key] = $constant;
                }
            }
            $this->const_nature = $retour;
        } else {
            $retour = $this->const_nature;
        }
        return $retour;
    }

    /**
     * @return array
     * @throws ReflectionException
     */
    private function getLinkTargetConstants()
    {
        $retour = [];
        if (empty($this->const_linkTarget)) {
            $constants = $this->getConstants();
            foreach ($constants as $key => $constant) {
                $pos = strpos($key, 'BUTTONLINK_TARGET');
                if ($pos !== false) {
                    $retour[$key] = $constant;
                }
            }
            $this->const_linkTarget = $retour;
        } else {
            $retour = $this->const_linkTarget;
        }
        return $retour;
    }
}
