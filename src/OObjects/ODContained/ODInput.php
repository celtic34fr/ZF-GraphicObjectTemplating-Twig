<?php

namespace GraphicObjectTemplating\OObjects\ODContained;

use GraphicObjectTemplating\OObjects\ODContained;
use GraphicObjectTemplating\OObjects\OObject;
use phpDocumentor\Reflection\Types\Self_;

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
 * setValMax($valMax = 0)
 * getValMax()
 * setValMin($valMin = 0)
 * getValMin()
 * validateContent();
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
        $minlength  = (int) $minlength;
        $type       = $properties['type'];

        if ($maxlength < $minlength || !in_array($type, [self::INPUTTYPE_TEXT, self::INPUTTYPE_PASSWORD])) { return false; }

        $properties['minlength'] = $minlength;
        $this->setProperties($properties);
        return $this;
    }

    public function getMinlength()
    {
        $properties = $this->getProperties();
        $minLength  = array_key_exists('minlength', $properties) ? $properties['minlength'] : false;
        if (!$minLength || empty($minLength)) { $minLength = -1; } else { $minLength = (int) $minLength; }
        return $minLength;
    }

    public function setMaxlength($maxlength)
    {
        $properties = $this->getProperties();
        $minlength  = (int) $properties['minlength'];
        $maxlength  = (int) $maxlength;
        $type       = $properties['type'];

        if ($maxlength < $minlength || !in_array($type, [self::INPUTTYPE_TEXT, self::INPUTTYPE_PASSWORD])) { return false; }

        $properties = $this->getProperties();
        $properties['maxlength'] = $maxlength;
        $this->setProperties($properties);
        return $this;
    }

    public function getMaxlength()
    {
        $properties = $this->getProperties();
        $maxLength  = array_key_exists('maxlength', $properties) ? $properties['maxlength'] : false;
        if (!$maxLength || empty($maxLength)) { $maxLength = -1; } else { $maxLength = (int) $maxLength; }
        return $maxLength;
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
            $properties['type'] = self::INPUTTYPE_TEXT;
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

    public function setValMax($valMax = 0)
    {
        $valMax = (int) $valMax;
        $properties = $this->getProperties();
        $valMin     = (int) $properties['valMin'];
        $type       = $properties['type'];

        if ($valMax >= $valMin && $type == self::INPUTTYPE_NUMBER) {
            $properties['valMax'] = $valMax;
            $this->setProperties($properties);
            return $this;
        }
        return false;
    }

    public function getValMax()
    {
        $properties = $this->getProperties();
        $valmax     = array_key_exists('valMax', $properties) ? $properties['valMax'] : false;
        if (!$valmax) { $valmax = -1; } else { $valmax = (int) $valmax; }
        return ($properties['type'] == self::INPUTTYPE_NUMBER) ? $valmax : false;
    }

    public function setValMin($valMin = 0)
    {
        $valMin = (int) $valMin;
        $properties = $this->getProperties();
        $valMax     = (int) $properties['valMax'];
        $type       = $properties['type'];

        if ($valMax >= $valMin && $type == self::INPUTTYPE_NUMBER) {
            $properties['valMin'] = $valMin;
            $this->setProperties($properties);
            return $this;
        }
        return false;
    }

    public function getValMin()
    {
        $properties = $this->getProperties();
        $valmin     = array_key_exists('valMin', $properties) ? $properties['valMin'] : false;
        if (!$valmin) { $valmin = -1; } else { $valmin = (int) $valmin; }
        return ($properties['type'] == self::INPUTTYPE_NUMBER) ? $valmin : false;
    }

    /** ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
     * méthode de validation / invalidation du champ ODInput
     * si retour un champ vide  = champ valide
     * sinon retourne le message d'erreur
     *
     * cette méthode reproduit les mêmes traitements que ceux codés dans le fichier JavaScript
     * ./public/oobject/odcontained/odinput/js/odinput.js
     * dans la méthode invalidate
     *
     * TOUTE MODIFICATION DANS LES TRAITEMENTS CI-DESSOUS DEVRA ÊTRE IMPÉRATIVEMENT REPORTÉS DANS LE FICHIER JAVASCRIPT
     * DONT LE NOM ET LE CHEMIN D'ACCÈS À ÉTÉ DONNÉ CI-AVANT POUR GARANTIR L'INTÉGRITÉ DE L'APPLICATION
     ** +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ */
    public function validateContent()
    {
        $value  = $this->getValue();
        $type   = $this->getType();
        $retour = '';

        switch ($type) {
            case ODInput::INPUTTYPE_HIDDEN:
                break;
            case ODInput::INPUTTYPE_TEXT:
                if (!empty($this->getMask())) { break; }

                $minLength  = $this->getMinlength();
                $maxLength  = $this->getMaxlength();
                if ($minLength != -1 || $maxLength != -1) {
                    // si tous 2 = -1 rien à faire, sinon test
                    $length     = strlen($value);
                    if (!($minLength <= $length && $length <= $maxLength)) {
                        if ($minLength >= $length) {
                            $retour = "Le champs doit comprendre $minLength caractères minimum";
                        } else {
                            $retour = "Le champs doit comprendre $maxLength caractères maximum";
                        }
                    }
                }
                break;
            case ODInput::INPUTTYPE_NUMBER:
                if (!is_null($value)) {
                    $retour = 'Le champs doit être numérique seulement';
                } else {
                    $valMin = $this->getValMin();
                    $valMax = $this->getValMax();
                    if ($minLength != -1 || $maxLength != -1) {
                        // si tous 2 = -1 rien à faire, sinon test
                        $value = (int) $value;
                        if ($value < $valMin) {
                            $retour = "La valeur doit être au moins égale à $valMin";
                        }
                        if ($value > $valMax) {
                            $retour = "La valeur doit être au maximum égale à $valMax";
                        }
                    }
                }
                break;
            case ODInput::INPUTTYPE_EMAIL:
                if (!preg_match('/^\w+@[a-zA-Z_]+?\.[a-zA-Z]{2,3}$/', $value )) {
                    $retour = 'Veuillez saisir une adresse courriel (email) valide';
                }
                break;
            default:
                $retour = 'Erreur inconnue';
        }
        return $retour;
    }

    /** **************************************************************************************************
     * méthodes privées de la classe                                                                     *
     * ************************************************************************************************* */

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
