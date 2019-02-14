<?php

namespace GraphicObjectTemplating\OObjects\ODContained;

use GraphicObjectTemplating\OObjects\ODContained;
use GraphicObjectTemplating\OObjects\OObject;
use Zend\Session\Container;

/**
 * Class ODButton
 * @package GraphicObjectTemplating\OObjects\ODContained
 *
 * __construct($id)         constructeur de l'objet, obligation de fournir $id identifiant de l'objet
 * setLabel($label)         affectation du texte affiché dans le bouton
 * getLabel()
 * setIcon($icon)           affectation de la classe CSS pour affichage d'une icône à gauche du label (glyphicon, ...)
 * getIcon()
 * setForm($form = null)    rattachement du bouton à un 'formulaire' (cadre de l'objet OSForm) avec traitements induits
 * setType($type = self::BUTTONTYPE_CUSTOM)
 *                          affectation du type du bouton (= mode de fonctionnement) par défaut type 'CUSTOM'
 * getType()
 * evtClick($class, $method, $stopEvent = false)
 *                          déclaration et paramétrage de l'évènement onclick sur le bouton avec traitements induits
 * getClick()               récupération des paramètres de l'évènement onclick sur le bouton
 * disClick()               suppression / déactivation de l'évènement onclick sur le bouton
 * setNature($nature = self::BUTTONNATURE_DEFAULT)
 *                          affecation de la nature du bouton (= couleur graphique) par deefaut 'DEFAULT' blanc
 *                          remarque : la nature (LINK' présente le bouton comme un lien hypertexte
 * getNature()
 * enaDefault()
 * disDefault()
 * createSimpleControl(Container $sessionObj, $ord)
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

    const BUTTONLINK_TARGET_BLANK   = '_blank';
    const BUTTONLINK_TARGET_SELF    = '_self';
    const BUTTONLINK_TARGET_PARENT  = '_parent';
    const BUTTONLINK_TARGET_TOP     = '_top';

    private $const_type;
    private $const_nature;
    private $const_linkTarget;

    /**
     * ODButton constructor.
     * @param $id
     * @throws \ReflectionException
     */
    public function __construct($id)
    {
        parent::__construct($id, "oobjects/odcontained/odbutton/odbutton.config.php");

        $properties = $this->getProperties();
        if ($properties['id'] != 'dummy') {
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
     * @param $label
     * @return $this
     */
    public function setLabel($label)
    {
        $label = (string) $label;
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
    public function setIcon($icon)
    {
        $icon = (string) $icon;
        $properties = $this->getProperties();
        $properties['icon'] = $icon;
        $this->setProperties($properties);
        return $this;
    }

    /**
     * @return bool
     */
    public function getIcon()
    {
        $properties = $this->getProperties();
        return array_key_exists('icon', $properties) ? $properties['icon'] : false;
    }

    /**
     * @param null $form
     * @return $this|bool|ODContained
     */
    public function setForm($form = null)
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
     * @throws \ReflectionException
     */
    public function setType($type = self::BUTTONTYPE_CUSTOM)
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
     * @param $class
     * @param $method
     * @param bool $stopEvent
     * @return bool|ODButton
     */
    public function evtClick($class, $method, $stopEvent = false)
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
     * @return $this
     * @throws \ReflectionException
     */
    public function setNature($nature = self::BUTTONNATURE_DEFAULT)
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
     * @return $this
     */
    public function enaDefault()
    {
        $properties = $this->getProperties();
        $properties['default'] = true;
        $this->setProperties($properties);
        return $this;
    }

    /**
     * @return $this
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
     * @return array
     * @throws \Exception
     */
    public function createSimpleControl(Container $sessionObj, $ord) {
    	$btn = self::cloneObject($this, $sessionObj);
		$sessionObjects = $btn->setId($this->getId().$ord)
			->setValue($ord)
			->setDisplay(self::DISPLAY_BLOCK)
			->saveProperties();
		return ['ctrl' => $btn, 'session' => $sessionObjects];
	}
    
    /** **************************************************************************************************
     * méthodes privées de la classe                                                                     *
     * *************************************************************************************************** */

    /**
     * @return array
     * @throws \ReflectionException
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
     * @throws \ReflectionException
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
     * @throws \ReflectionException
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