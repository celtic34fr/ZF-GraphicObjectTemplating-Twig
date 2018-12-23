<?php

namespace GraphicObjectTemplating\OObjects\ODContained;

use GraphicObjectTemplating\OObjects\ODContained;
use GraphicObjectTemplating\OObjects\OObject;

/**
 * Class ODInput
 * @package GraphicObjectTemplating\OObjects\ODContained
 *
 * __construct($id)         constructeur de l'objet, obligation de fournir $id identifiant de l'objet
 * setType($type = self::INPUTTYPE_TEXT)
 *                          type de la zone de saisie, par défaut 'TEXT' (texte)
 * getType()
 * setSize($size)           affectation de la taille visible de la zone de saisie
 * getSize()
 * setMinlength($minlength) affectation de la taille minimale de la zone de saisie
 * getMinlength()
 * setMaxlength($maxlength) affectation de la taille maximale de la zone de saisie
 * getMaxlength()
 * setLabel($label)         affectation du texte affiché à droite de la zone de saisie
 * getLabel()
 * setPlaceholder($placeholder)
 *                          fixe le texte affiché dans la zone sz saisie quand elle est vide
 * getPlaceholder()
 * setLabelWidthBT($labelWidthBT)
 *                          fixe la taille du label par rapport à la zone de saisie
 * getLabelWidthBT()
 * getInputWidthBT()
 * enaDispBySide()          disposition label à coté zone de saisie
 * enaDispUnder()           disposition label, et dessous zone de saisie
 *                  ATTENTION : un setLabelWidthBT après ces 2 dernières commandes annule l'effet attendu pour exécuter
 *                  la commande demandée (setLabelWidthBT)
 * setErrMessage($errMessage)
 *                          affectation du message d'erreur à afficher
 * getErrMessage()
 * setIcon($icon)           affectation de la classe CSS pour affichage d'une icône à gauche du label (glyphicon, ...)
 * getIcon()
 * evtChange($class, $method, $stopEvent = false)
 *                          déclaration et paramétrage de l'évènement onChange sur la zone de saisie
 * getChange()              récupération des paramètres de l'évènement onChange sur la zone de saisie
 * disChange()              suppression / déactivation de l'évènement onChange sur la zone de saisie
 * evtKeyup($class, $method, $stopEvent = false)
 *                          déclaration et paramétrage de l'évènement onKeyup sur la zone de saisie
 * getKeyup()               récupération des paramètres de l'évènement onKeyup sur la zone de saisie
 * disKeyup()               suppression / déactivation de l'évènement onKeyup sur la zone de saisie
 * enaAutoFocus()
 * disAutoFocus()
 * getAutoFocus()
 * enaMask($mask)
 * disMask()
 * getMask()
 *
 * méthodes privées de la classe
 * -----------------------------
 * getTypeConstants()       récupération des constantes 'BUTTONTYPE_*' dans un tableau associatif
 */
class ODInput extends ODContained
{
    const INPUTTYPE_HIDDEN      = 'hidden';
    const INPUTTYPE_TEXT        = 'text';
    const INPUTTYPE_PASSWORD    = 'password';
    const INPUTTYPE_NUMBER      = 'number';
    const INPUTTYPE_EMAIL       = 'email';

    private $const_type;

    public function __construct($id, $core = true)
    {
        parent::__construct($id, "oobjects/odcontained/odinput/odinput.config.php");

        $properties = $this->getProperties();
        if ($properties['id'] != 'dummy') {
            if (!$this->getWidthBT() || empty($this->getWidthBT())) {
                $this->setWidthBT(12);
            }
            $this->setDisplay(OObject::DISPLAY_BLOCK);
            $this->enable();
        }

        if ($core){ $this->saveProperties(); }
        return $this;
    }

    public function setType($type = self::INPUTTYPE_TEXT)
    {
        $type   = (string) $type;
        $types  = $this->getTypeConstants();
        if (!in_array($type, $types)) { $type = self::INPUTTYPE_TEXT; }

        $properties = $this->getProperties();
        $properties['type'] = $type;
        $this->setProperties($properties);
        return $this;
    }

    public function getType()
    {
        $properties = $this->getProperties();
        return array_key_exists('type', $properties) ? $properties['type'] : false;
    }

    public function setSize($size)
    {
        $size = (int) $size;
        if ($size > 0) {
            $properties = $this->getProperties();
            $properties['size'] = $size;
            $this->setProperties($properties);
            return $this;
        }
        return false;
    }

    public function getSize()
    {
        $properties = $this->getProperties();
        return array_key_exists('size', $properties) ? $properties['size'] : false;
    }

    public function setMinlength($minlength)
    {
        $properties = $this->getProperties();
        $maxlength  = (int) $properties['maxlength'];
        $minlength = (int) $minlength;

        if ($maxlength < $minlength) { return false; }

        $properties['minlength'] = $minlength;
        $this->setProperties($properties);
        return $this;
    }

    public function getMinlength()
    {
        $properties = $this->getProperties();
        return array_key_exists('minlength', $properties) ? $properties['minlength'] : false;
    }

    public function setMaxlength($maxlength)
    {
        $properties = $this->getProperties();
        $minlength  = (int) $properties['minlength'];
        $maxlength = (int) $maxlength;

        if ($maxlength < $minlength) { return false; }

        $properties = $this->getProperties();
        $properties['maxlength'] = $maxlength;
        $this->setProperties($properties);
        return $this;
    }

    public function getMaxlength()
    {
        $properties = $this->getProperties();
        return array_key_exists('maxlength', $properties) ? $properties['maxlength'] : false;
    }

    public function setLabel($label)
    {
        $label = (string) $label;
        $properties = $this->getProperties();
        $properties['label'] = $label;
        $this->setProperties($properties);
        return $this;
    }

    public function getLabel()
    {
        $properties = $this->getProperties();
        return array_key_exists('label', $properties) ? $properties['label'] : false;
    }

    public function setPlaceholder($placeholder)
    {
        $placeholder = (string) $placeholder;
        $properties = $this->getProperties();
        $properties['placeholder'] = $placeholder;
        $this->setProperties($properties);
        return $this;
    }

    public function getPlaceholder()
    {
        $properties = $this->getProperties();
        return array_key_exists('placeholder', $properties) ? $properties['placeholder'] : false;
    }

    public function setLabelWidthBT($labelWidthBT)
    {
        if (!empty($labelWidthBT)) {
            $widthLabChkBT  = self::formatLabelBT($labelWidthBT);

            $properties     = $this->getProperties();
            $properties['labelWidthBT'] = $widthLabChkBT['labelWidthBT'];
            $properties['inputWidthBT'] = $widthLabChkBT['inputWidthBT'];
            $this->setProperties($properties);
            return $this;
        }
        return false;
    }

    public function getLabelWidthBT()
    {
        $properties = $this->getProperties();
        return array_key_exists('labelWidthBT', $properties) ? $properties['labelWidthBT'] : false;
    }

    public function getInputWidthBT()
    {
        $properties = $this->getProperties();
        return array_key_exists('inputWidthBT', $properties) ? $properties['inputWidthBT'] : false;
    }

    public function enaDispBySide()
    {
        $properties = $this->getProperties();
        $properties['labelWidthBT'] = '';
        $properties['inputWidthBT'] = '';

        $this->setProperties($properties);
        return $this;
    }

    public function enaDispUnder()
    {
        $properties = $this->getProperties();
        $widthLabChkBT  = self::formatLabelBT(12);
        $properties['labelWidthBT'] = $widthLabChkBT['labelWidthBT'];
        $properties['inputWidthBT'] = $widthLabChkBT['labelWidthBT'];

        $this->setProperties($properties);
        return $this;
    }

    public function setErrMessage($errMessage)
    {
        $errMessage     = (string) $errMessage;
        $properties     = $this->getProperties();
        $properties['errMessage'] = $errMessage;
        $this->setProperties($properties);
        return $this;
    }

    public function getErrMessage()
    {
        $properties = $this->getProperties();
        return array_key_exists('errMessage', $properties) ? $properties['errMessage'] : false;
    }

    public function setIcon($icon)
    {
        $icon = (string) $icon;
        $properties = $this->getProperties();
        $properties['icon'] = $icon;
        $this->setProperties($properties);
        return $this;
    }

    public function getIcon()
    {
        $properties = $this->getProperties();
        return array_key_exists('icon', $properties) ? $properties['icon'] : false;
    }

    public function evtChange($class, $method, $stopEvent = false)
    {
        if (!empty($class) && !empty($method)) {
            return $this->setEvent('change', $class, $method, $stopEvent);
        }
        return false;
    }

    public function getChange()
    {
        return $this->getEvent('change');
    }

    public function disChange()
    {
        return $this->disEvent('change');

    }

    public function evtKeyup($class, $method, $stopEvent = false)
    {
        if (!empty($class) && !empty($method)) {
            return $this->setEvent('keyup', $class, $method, $stopEvent);
        }
        return false;
    }

    public function getKeyup()
    {
        return $this->getEvent('keyup');
    }

    public function disKeyup()
    {
        return $this->disEvent('keyup');

    }

    public function enaAutoFocus()
    {
        $properties = $this->getProperties();
        $properties['autoFocus'] = true;
        $this->setProperties($properties);
        return $this;
    }

    public function disAutoFocus()
    {
        $properties = $this->getProperties();
        $properties['autoFocus'] = false;
        $this->setProperties($properties);
        return $this;
    }

    public function getAutoFocus()
    {
        $properties = $this->getProperties();
        return array_key_exists('autoFocus', $properties) ? $properties['autoFocus'] : false;
    }

    public function enaMask($mask)
    {
        $mask = (string) $mask;
        if (!empty($mask)) {
            $properties = $this->getProperties();
            $properties['mask'] = $mask;
            $this->setProperties($properties);
            return $this;
        }
        return false;
    }

    public function disMask()
    {
        $properties = $this->getProperties();
        $properties['mask'] = '';
        $this->setProperties($properties);
        return $this;
    }

    public function getMask()
    {
        $properties = $this->getProperties();
        return array_key_exists('mask', $properties) ? $properties['mask'] : false;
    }

    /** **************************************************************************************************
     * méthodes privées de la classe                                                                     *
     * *************************************************************************************************** */

    private function getTypeConstants()
    {
        $retour = [];
        if (empty($this->const_type)) {
            $constants = $this->getConstants();
            foreach ($constants as $key => $constant) {
                $pos = strpos($key, 'INPUTTYPE');
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
}
