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
 * setErrMessage($errMessage)
 *                          affectation du message d'eerue à afficher
 * getErrMessage()
 * setIcon($icon)           affectation de la classe CSS pour affichage d'une icône à gauche du label (glyphicon, ...)
 * getIcon()
 * evtChange($class, $method, $stopEvent = false)
 *                          déclaration et paramétrage de l'évènement onChange sur la zone de saisie
 * getChange()              récupération des paramètres de l'évènement onChange sur la zone de saisie
 * disChange()              suppression / déactivation de l'évènement onChange sur la zone de saisie
 *
 * méthodes privées
 * getTypeConstants()       récupération des constantes 'BUTTONTYPE_*' dans un tableau associatif
 *
 * méthodes privées de la classe
 * -----------------------------
 * getTypeConstants()
 */
class ODInput extends ODContained
{
    const INPUTTYPE_HIDDEN = 'hidden';
    const INPUTTYPE_TEXT = 'text';
    const INPUTTYPE_PASSWORD = 'password';

    private $const_type;

    public function __construct($id)
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

    public function setMaxlength($maxlength)
    {
        $maxlength = (int) $maxlength;
        if ($maxlength > 0) {
            $properties = $this->getProperties();
            $properties['maxlength'] = $maxlength;
            $this->setProperties($properties);
            return $this;
        }
        return false;
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
/*
            $properties = $this->getProperties();
            if (!array_key_exists('event', $properties)) { $properties['event'] = []; }
            $event = $properties['event'];
            if (!array_key_exists('change', $event)) { $event['change'] = []; }
            $change = $event['change'];
            if (class_exists($class)) {
                $obj = new $class();
                if (method_exists($obj, $method)) {
                    $change['class'] = $class;
                    $change['method'] = $method;
                    $change['stopEvent'] = ($stopEvent) ? 'OUI' : 'NON';

                    $event['change'] = $change;
                    $properties['event'] = $event;
                    $this->setProperties($properties);
                    return $this;
                }
            }*/
        }
        return false;
    }

    public function getChange()
    {
        return $this->getEvent('change');

/*        $properties = $this->getProperties();
        if (array_key_exists('event', $properties)) {
            $event = $properties['event'];
            if (array_key_exists('change', $event)) {
                return $event['change'];
            }
        }
        return false;*/
    }

    public function disChange()
    {
        return $this->disEvent('change');

/*        $properties = $this->getProperties();
        if (array_key_exists('event', $properties)) {
            $event = $properties['event'];
            if (array_key_exists('change', $event)) {
                unset($event['change']);
                $properties['event'] = $event;
                $this->setProperties($properties);
                return $this;
            }
        }
        return false;*/
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
