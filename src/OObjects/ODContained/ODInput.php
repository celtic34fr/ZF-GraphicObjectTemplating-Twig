<?php

namespace GraphicObjectTemplating\OObjects\ODContained;

use Exception;
use GraphicObjectTemplating\OObjects\ODContained;
use GraphicObjectTemplating\OObjects\OObject;
use phpDocumentor\Reflection\Types\Self_;
use ReflectionException;

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
 * méthodes de gestion de retour de callback
 * -----------------------------------------
 * returnSetData()          alimentation pour retour de callback visant à réaffecter la valeur de l'objet
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

    /**
     * ODInput constructor.
     * @param string $id
     * @param array $pathObjArray
     * @throws ReflectionException
     */
    public function __construct(string $id, $pathObjArray = [])
    {
        $pathObjArray[] = "oobjects/odcontained/odinput/odinput";
		parent::__construct($id, $pathObjArray);

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
     * @param string $type
     * @return ODInput
     * @throws Exception
     */
    public function setType(string $type = self::INPUTTYPE_TEXT)
    {
        $types  = $this->getTypeConstants();
        if (!in_array($type, $types)) { $type = self::INPUTTYPE_TEXT; }

        $properties = $this->getProperties();
        $properties['type'] = $type;
        $this->setProperties($properties);
        return $this;
    }

    /**
     * @return bool|string
     */
    public function getType()
    {
        $properties = $this->getProperties();
        return array_key_exists('type', $properties) ? $properties['type'] : false;
    }

    /**
     * @param int $size
     * @return ODInput|bool
     * @throws Exception
     */
    public function setSize(int $size)
    {
        if ($size > 0) {
            $properties = $this->getProperties();
            $properties['size'] = $size;
            $this->setProperties($properties);
            return $this;
        }
        return false;
    }

    /**
     * @return bool|int
     */
    public function getSize()
    {
        $properties = $this->getProperties();
        return array_key_exists('size', $properties) ? $properties['size'] : false;
    }

    /**
     * @param int $minlength
     * @return ODInput|bool
     * @throws Exception
     */
    public function setMinlength(int $minlength)
    {
        $properties = $this->getProperties();
        $maxlength  = $properties['maxlength'];
        $type       = $properties['type'];

        if ($maxlength < $minlength || !in_array($type, [self::INPUTTYPE_TEXT, self::INPUTTYPE_PASSWORD])) { return false; }

        $properties['minlength'] = $minlength;
        $this->setProperties($properties);
        return $this;
    }

    /**
     * @return bool|int
     */
    public function getMinlength()
    {
        $properties = $this->getProperties();
        $minLength  = array_key_exists('minlength', $properties) ? $properties['minlength'] : false;
        if (!$minLength || empty($minLength)) { $minLength = -1; } else { $minLength = (int) $minLength; }
        return $minLength;
    }

    /**
     * @param $maxlength
     * @return ODInput|bool
     * @throws Exception
     */
    public function setMaxlength(int $maxlength)
    {
        $properties = $this->getProperties();
        $minlength  = $properties['minlength'];
        $type       = $properties['type'];

        if ($maxlength < $minlength || !in_array($type, [self::INPUTTYPE_TEXT, self::INPUTTYPE_PASSWORD])) { return false; }

        $properties = $this->getProperties();
        $properties['maxlength'] = $maxlength;
        $this->setProperties($properties);
        return $this;
    }

    /**
     * @return bool|int
     */
    public function getMaxlength()
    {
        $properties = $this->getProperties();
        $maxLength  = array_key_exists('maxlength', $properties) ? $properties['maxlength'] : false;
        if (!$maxLength || empty($maxLength)) { $maxLength = -1; } else { $maxLength = (int) $maxLength; }
        return $maxLength;
    }

    /**
     * @param string $label
     * @return ODInput
     * @throws Exception
     */
    public function setLabel(string $label)
    {
        $properties = $this->getProperties();
        $properties['label'] = $label;
        $this->setProperties($properties);
        return $this;
    }

    /**
     * @return bool|string
     */
    public function getLabel()
    {
        $properties = $this->getProperties();
        return array_key_exists('label', $properties) ? $properties['label'] : false;
    }

    /**
     * @param string $placeholder
     * @return ODInput
     * @throws Exception
     */
    public function setPlaceholder(string $placeholder)
    {
        $properties = $this->getProperties();
        $properties['placeholder'] = $placeholder;
        $this->setProperties($properties);
        return $this;
    }

    /**
     * @return bool|string
     */
    public function getPlaceholder()
    {
        $properties = $this->getProperties();
        return array_key_exists('placeholder', $properties) ? $properties['placeholder'] : false;
    }

    /**
     * @param string $labelWidthBT
     * @return ODInput|bool
     * @throws Exception
     */
    public function setLabelWidthBT(string $labelWidthBT)
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

    /**
     * @return bool|string
     */
    public function getLabelWidthBT()
    {
        $properties = $this->getProperties();
        return array_key_exists('labelWidthBT', $properties) ? $properties['labelWidthBT'] : false;
    }

    /**
     * @return bool|string
     */
    public function getInputWidthBT()
    {
        $properties = $this->getProperties();
        return array_key_exists('inputWidthBT', $properties) ? $properties['inputWidthBT'] : false;
    }

    /**
     * @return ODInput
     * @throws Exception
     */
    public function enaDispBySide()
    {
        $properties = $this->getProperties();
        $properties['labelWidthBT'] = '';
        $properties['inputWidthBT'] = '';

        $this->setProperties($properties);
        return $this;
    }

    /**
     * @return ODInput
     * @throws Exception
     */
    public function enaDispUnder()
    {
        $properties = $this->getProperties();
        $widthLabChkBT  = self::formatLabelBT(12);
        $properties['labelWidthBT'] = $widthLabChkBT['labelWidthBT'];
        $properties['inputWidthBT'] = $widthLabChkBT['labelWidthBT'];

        $this->setProperties($properties);
        return $this;
    }

    /**
     * @param string $errMessage
     * @return ODInput
     * @throws Exception
     */
    public function setErrMessage(string $errMessage)
    {
        $properties     = $this->getProperties();
        $properties['errMessage'] = $errMessage;
        $this->setProperties($properties);
        return $this;
    }

    /**
     * @return bool|string
     */
    public function getErrMessage()
    {
        $properties = $this->getProperties();
        return array_key_exists('errMessage', $properties) ? $properties['errMessage'] : false;
    }

    /**
     * @param string $class
     * @param string $method
     * @param bool $stopEvent
     * @return bool|ODInput
     * @throws Exception
     */
    public function evtChange(string $class, string $method, bool $stopEvent = false)
    {
        if (!empty($class) && !empty($method)) {
            return $this->setEvent('change', $class, $method, $stopEvent);
        }
        return false;
    }

    /**
     * @return bool|array
     */
    public function getChange()
    {
        return $this->getEvent('change');
    }

    /**
     * @return bool|ODInput
     * @throws Exception
     */
    public function disChange()
    {
        return $this->disEvent('change');

    }

    /**
     * @param string $class
     * @param string $method
     * @param bool $stopEvent
     * @return bool|ODInput
     * @throws Exception
     */
    public function evtKeyup(string $class, string $method, bool $stopEvent = false)
    {
        if (!empty($class) && !empty($method)) {
            return $this->setEvent('keyup', $class, $method, $stopEvent);
        }
        return false;
    }

    /**
     * @return bool|array
     */
    public function getKeyup()
    {
        return $this->getEvent('keyup');
    }

    /**
     * @return bool|ODInput
     * @throws Exception
     */
    public function disKeyup()
    {
        return $this->disEvent('keyup');

    }

    /**
     * @return ODInput
     * @throws Exception
     */
    public function enaAutoFocus()
    {
        $properties = $this->getProperties();
        $properties['autoFocus'] = true;
        $this->setProperties($properties);
        return $this;
    }

    /**
     * @return ODInput
     * @throws Exception
     */
    public function disAutoFocus()
    {
        $properties = $this->getProperties();
        $properties['autoFocus'] = false;
        $this->setProperties($properties);
        return $this;
    }

    /**
     * @return bool
     */
    public function getAutoFocus()
    {
        $properties = $this->getProperties();
        return array_key_exists('autoFocus', $properties) ? $properties['autoFocus'] : false;
    }

    /**
     * @param string $mask
     * @return ODInput|bool
     * @throws Exception
     */
    public function enaMask(string $mask)
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

    /**
     * @return ODInput
     * @throws Exception
     */
    public function disMask()
    {
        $properties = $this->getProperties();
        $properties['mask'] = '';
        $this->setProperties($properties);
        return $this;
    }

    /**
     * @return bool|string
     */
    public function getMask()
    {
        $properties = $this->getProperties();
        return array_key_exists('mask', $properties) ? $properties['mask'] : false;
    }

    /**
     * @param int $valMax
     * @return ODInput|bool
     * @throws Exception
     */
    public function setValMax(int $valMax = 0)
    {
        $properties = $this->getProperties();
        $valMin     = $properties['valMin'];
        $type       = $properties['type'];

        if ($valMax >= $valMin && $type == self::INPUTTYPE_NUMBER) {
            $properties['valMax'] = $valMax;
            $this->setProperties($properties);
            return $this;
        }
        return false;
    }

    /**
     * @return bool|int
     */
    public function getValMax()
    {
        $properties = $this->getProperties();
        $valmax     = array_key_exists('valMax', $properties) ? $properties['valMax'] : false;
        if (!$valmax) { $valmax = -1; } else { $valmax = (int) $valmax; }
        return ($properties['type'] == self::INPUTTYPE_NUMBER) ? $valmax : false;
    }

    /**
     * @param int $valMin
     * @return ODInput|bool
     * @throws Exception
     */
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

    /**
     * @return bool|int
     */
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
            case ODInput::INPUTTYPE_PASSWORD:
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
                    if ($valMin != -1 || $valMax != -1) {
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
                $email = strtolower($value);
                $regexPattern = '/^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/';

                if (!preg_match($regexPattern, $email)) {
                    $retour = 'Veuillez saisir une adresse courriel (email) valide';
                }
                break;
            default:
                $retour = 'Erreur inconnue';
        }
        return $retour;
    }

    /** **************************************************************************************************
     * Méthodes de gestion de retour de callback                                                         *
     * ***************************************************************************************************
     */

    /**
     * @return array
     */
    public function returnSetData()
    {
        $thisID        = $this->getId();
        return  self::formatRetour($thisID, $thisID, 'setData', $this->getValue());
    }

    /** **************************************************************************************************
     * Méthodes privées de la classe                                                                     *
     * ************************************************************************************************* */

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
