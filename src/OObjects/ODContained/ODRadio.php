<?php

namespace GraphicObjectTemplating\OObjects\ODContained;

use GraphicObjectTemplating\OObjects\ODContained;

/**
 * Class ODRadio
 * @package GraphicObjectTemplating\OObjects\ODContained
 *
 * __construct($id)         constructeur de l'objet, obligation de fournir $id identifiant de l'objet
 * addOption(string $value, string $libel, string $type = self::RADIOTYPE_DEFAULT,
 *                          bool $state = self::RADIOSTATE_ENABLE, string $check = self::RADIOCHECK_UNCHECK)
 *                          ajoute une option (= un bouton radio) en le rendant actif ou non (State)
 * rmOption(string $value)
 * getOption(string $value)
 * setOption(string $value, string $libel, string $type = self::RADIOTYPE_DEFAULT,
 *                          bool $state = self::RADIOSTATE_ENABLE, string $check = self::RADIOCHECK_UNCHECK)
 * setOptions(array $options = null)
 * getOptions()
 * checkOption($value)      sélectionne l'option déterminée par $value, valeur de l'option
 * uncheckOption()          déselectionne l'option actuellement sélectionnée
 * getCheckedOption()       restitue la valeur associé à l'option sé"lectionnée ou fals si rien n'est sélectionné
 * enaOption(string $value)
 * disOption(string $value)
 * getStateOption(string $value)
 * enaAllOptions()
 * disAllOptions()
 * getStateOptions()
 * setLabel($label)
 * getLabel()
 * setLabelWidthBT($labelWidthBT)
 * getLabelWidthBT()
 *
 * méthodes privées
 * getStateConstants()
 * getCheckConstants()
 */
class ODRadio extends ODContained
{
    const RADIOSTATE_ENABLE   = true;
    const RADIOSTATE_DISABLE  = false;

    const RADIOPLACEMENT_LEFT  = "left";
    const RADIOPLACEMENT_RIGHT = "right";

    const RADIOCHECK_CHECK    = "check";
    const RADIOCHECK_UNCHECK  = "uncheck";

    const RADIOTYPE_DEFAULT = "radio";
    const RADIOTYPE_PRIMARY = "radio radio-primary";
    const RADIOTYPE_SUCCESS = "radio radio-success";
    const RADIOTYPE_INFO    = "radio radio-info";
    const RADIOTYPE_WARNING = "radio radio-warning";
    const RADIOTYPE_DANGER  = "radio radio-danger";

    const RADIOFORM_HORIZONTAL  = 'radio-horizontal';
    const RADIOFORM_VERTICAL    = 'radio-vertical';

    private $const_state;
    private $const_check;
    private $const_type;

    /**
     * ODRadio constructor.
     * @param $id
     * @throws \ReflectionException
     */
    public function __construct($id) {
        parent::__construct($id, "oobjects/odcontained/odradio/odradio.config.php");

        $properties = $this->getProperties();
        if ($properties['id'] != 'dummy') {
            $this->setDisplay();
            $width = $this->getWidthBT();
            if (!is_array($width) || empty($width)) $this->setWidthBT(12);
            $this->enable();
            $this->setName($this->getId());
        }

        $this->saveProperties();
        return $this;
    }

    /**
     * @param $value
     * @param $libel
     * @param string $type
     * @param bool $state
     * @param string $check
     * @return ODRadio|bool
     */
    public function addOption(string $value, string $libel, string $type = self::RADIOTYPE_DEFAULT,
                              bool $state = self::RADIOSTATE_ENABLE, string $check = self::RADIOCHECK_UNCHECK)
    {
        if (!empty($value)) {
            $properties = $this->getProperties();
            $states = $this->getStateConstants();
            $checks = $this->getCheckConstants();
            $types  = $this->getTypeConstants();

            if (!in_array($state, $states)) { $state    = self::RADIOSTATE_ENABLE; }
            if (!in_array($check, $checks)) { $check    = self::RADIOCHECK_UNCHECK; }
            if (!in_array($type, $types))   { $type     = self::RADIOTYPE_DEFAULT; }
            if (!array_key_exists('options', $properties)) { $properties['options'] = []; }
            $options = $properties['options'];
            if (!array_key_exists($value, $options)) {
                $item = [];
                $item['libel']  = $libel;
                $item['check']  = $check;
                $item['type']   = $type;
                $item['state']  = $state;
                $item['value']  = $value;
                $options[$value]    = $item;
                $properties['options']  = $options;
                $this->setProperties($properties);
                return $this;
            }
        }
        return false;
    }

    /**
     * @param string $value
     * @return ODRadio|bool
     */
    public function rmOption(string $value)
    {
        if (!empty($value)) {
            $properties = $this->getProperties();
            $options = $properties['options'];
            if (array_key_exists($value, $options)) {
                unset($options[$value]);
                $properties['options']  = $options;
                $this->setProperties($properties);
                return $this;
            }
        }
        return false;
    }

    /**
     * @param string $value
     * @return bool
     */
    public function getOption(string $value)
    {
        if (!empty($value)) {
            $properties = $this->getProperties();
            $options = $properties['options'];
            if (array_key_exists($value, $options)) {
                return $options[$value];
            }
        }
        return false;
    }

    /**
     * @param string $value
     * @param string $libel
     * @param string $type
     * @param bool $state
     * @param string $check
     * @return ODRadio|bool
     */
    public function setOption(string $value, string $libel, string $type = self::RADIOTYPE_DEFAULT,
                              bool $state = self::RADIOSTATE_ENABLE, string $check = self::RADIOCHECK_UNCHECK)
    {
        if (!empty($value)) {
            $properties = $this->getProperties();
            $options = $properties['options'];
            if (array_key_exists($value, $options)) {
                $states = $this->getStateConstants();
                $checks = $this->getCheckConstants();
                $types  = $this->getTypeConstants();

                if (!in_array($state, $states)) { $state    = self::RADIOSTATE_ENABLE; }
                if (!in_array($check, $checks)) { $check    = self::RADIOCHECK_UNCHECK; }
                if (!in_array($type, $types))   { $type     = self::RADIOTYPE_DEFAULT; }
                if (!array_key_exists('options', $properties)) { $properties['options'] = []; }
                $item = [];
                $item['libel']  = $libel;
                $item['check']  = $check;
                $item['type']   = $type;
                $item['state']  = $state;
                $item['value']  = $value;
                $options[$value]    = $item;
                $properties['options']  = $options;
                $this->setProperties($properties);
                return $this;
            }
        }
        return false;
    }

    /**
     * @param array|null $options
     * @return ODRadio|bool
     */
    public function setOptions(array $options = null)
    {
        if (!empty($options)) {
            $properties = $this->getProperties();
            $properties['options'] = $options;
            $this->setProperties($properties);
            return $this;
        }
        return false;
    }

    /**
     * @return bool|array
     */
    public function getOptions()
    {
        $properties = $this->getProperties();
        return array_key_exists('options', $properties) ? $properties['options'] : false;
    }

    /**
     * @param $value
     * @return ODRadio|bool
     */
    public function checkOption(string $value)
    {
        if (!empty($value)) {
            $properties = $this->getProperties();
            $options = $properties['options'];
            if (array_key_exists($value, $options)) {
                $options[$value]['check'] = self::RADIOCHECK_CHECK;
                $properties['options'] = $options;
                $this->setProperties($properties);
                return $this;
            }
        }
        return false;
    }

    /**
     * @return ODRadio
     */
    public function uncheckOption()
    {
        $properties = $this->getProperties();
        $options = $properties['options'];
        foreach ($options as $value => $option) {
            $options[$value]['check'] = self::RADIOCHECK_UNCHECK;
        }
        $this->setProperties($properties);
        return $this;
    }

    /**
     * @return bool|int|string
     */
    public function getCheckedOption()
    {
        $properties = $this->getProperties();
        $options = $properties['options'];
        foreach ($options as $value => $option) {
            if ($options[$value]['check'] == self::RADIOCHECK_CHECK) { return $value; }
        }
        return false;
    }

    /**
     * @param $value
     * @return $this|bool
     */
    public function enaOption(string $value)
    {
        if (!empty($value)) {
            $properties = $this->getProperties();
            $options = $properties['options'];
            if (array_key_exists($value, $options)) {
                $options[$value]['state'] = self::STATE_ENABLE;
                $properties['options'] = $options;
                $this->setProperties($properties);
                return $this;
            }
        }
        return false;
    }

    /**
     * @param string $value
     * @return $this|bool
     */
    public function disOption(string $value)
    {
        if (!empty($value)) {
            $properties = $this->getProperties();
            $options = $properties['options'];
            if (array_key_exists($value, $options)) {
                $options[$value]['state'] = self::STATE_DISABLE;
                $properties['options'] = $options;
                $this->setProperties($properties);
                return $this;
            }
        }
        return false;
    }

    /**
     * @param string $value
     * @return bool|string
     */
    public function getStateOption(string $value)
    {
        if (!empty($value)) {
            $properties = $this->getProperties();
            $options = $properties['options'];
            if (array_key_exists($value, $options)) {
                return $options[$value]['state'] ? 'enable' : 'disable';
            }
        }
        return false;
    }

    /**
     * @return $this
     */
    public function enaAllOptions()
    {
        $properties = $this->getProperties();
        $options = $properties['options'];
        foreach ($options as $value => $item) {
            $item['state'] = self::STATE_ENABLE;
            $options[$value] = $item;
        }
        $properties['options'] = $options;
        $this->setProperties($properties);
        return $this;
    }

    /**
     * @return $this
     */
    public function disAllOptions()
    {
        $properties = $this->getProperties();
        $options = $properties['options'];
        foreach ($options as $value => $item) {
            $item['state'] = self::STATE_DISABLE;
            $options[$value] = $item;
        }
        $properties['options'] = $options;
        $this->setProperties($properties);
        return $this;
    }

    /**
     * @return array
     */
    public function getStateOptions()
    {
        $states     = [];
        $properties = $this->getProperties();
        $options = $properties['options'];
        foreach ($options as $value => $item) {
            $states[$value] = $options[$value]['state'] ? 'enable' : 'disable';
        }
        return $states;
    }

    /**
     * @param $label
     * @return ODRadio
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
     * @return bool|string
     */
    public function getLabel()
    {
        $properties = $this->getProperties();
        return array_key_exists('label', $properties) ? $properties['label'] : false;
    }

    /**
     * @param $labelWidthBT
     * @return ODRadio|bool
     */
    public function setLabelWidthBT($labelWidthBT)
    {
        if (!empty($labelWidthBT)) {
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
            $properties     = $this->getProperties();
            $labelWBT   = $llg.$lmd.$lsm.$lxs;
            if (strlen($labelWBT) > 0) { $labelWBT = substr($labelWBT, 0, strlen($labelWBT) - 1); }
            $inputWBT   = $ilg.$imd.$ism.$ixs;
            if (strlen($inputWBT) > 0) { $inputWBT = substr($inputWBT, 0, strlen($inputWBT) - 1); }
            $properties['labelWidthBT'] = $labelWBT;
            $properties['inputWidthBT'] = $inputWBT;
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


    /** méthodes privées */

    public function getStateConstants()
    {
        $retour = [];
        if (empty($this->const_state)) {
            $constants = $this->getConstants();
            foreach ($constants as $key => $constant) {
                $pos = strpos($key, 'RADIOSTATE_');
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

    public function getCheckConstants()
    {
        $retour = [];
        if (empty($this->const_check)) {
            $constants = $this->getConstants();
            foreach ($constants as $key => $constant) {
                $pos = strpos($key, 'RADIOCHECK_');
                if ($pos !== false) {
                    $retour[$key] = $constant;
                }
            }
            $this->const_check = $retour;
        } else {
            $retour = $this->const_check;
        }

        return $retour;
    }

    private function getTypeConstants()
    {
        $retour = [];
        if (empty($this->const_type)) {
            $constants = $this->getConstants();
            foreach ($constants as $key => $constant) {
                $pos = strpos($key, 'RADIOTYPE');
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