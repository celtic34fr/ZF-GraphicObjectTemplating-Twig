<?php

namespace GraphicObjectTemplating\OObjects\ODContained;

use GraphicObjectTemplating\OObjects\ODContained;

/**
 * Class ODRadio
 * @package GraphicObjectTemplating\OObjects\ODContained
 *
 * __construct($id)         constructeur de l'objet, obligation de fournir $id identifiant de l'objet
 * addOption($value, $libel, $state = self::ODRADIOSTATE_ENABLE)
 *                          ajoute une option (= un bouton radio) en le rendant actif ou non (State)
 * checkOption($value)      sélectionne l'option déterminée par $value, valeur de l'option
 * uncheckOption($value)    déselectionne l'option déterminée par $value, valeur de l'option
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
    const ODRADIOSTATE_ENABLE   = true;
    const ODRADIOSTATE_DISABLE  = false;

    const ODRADIOCHECK_CHECK    = "check";
    const ODRADIOCHECK_UNCHECK  = "uncheck";

    protected $const_state;
    protected $const_check;

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

    public function addOption($value, $libel, $state = self::ODRADIOSTATE_ENABLE, $check = self::ODRADIOCHECK_UNCHECK)
    {
        $value = (string) $value;
        if (!empty($value)) {
            $libel = (string) $libel;
            $properties = $this->getProperties();
            $states = $this->getStateConstants();
            $checks = $this->getCheckConstants();
            if (!in_array($state, $states)) { $stat = self::ODRADIOSTATE_ENABLE; }
            if (!in_array($check, $checks)) { $stat = self::ODRADIOCHECK_UNCHECK; }
            if (!array_key_exists('options', $properties)) { $properties['options'] = []; }
            $options = $properties['options'];
            if (!array_key_exists($value, $options)) {
                $item = [];
                $item['libel']  = $libel;
                $item['check']  = $check;
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

    public function checkOption($value)
    {
        $value = (string) $value;
        if (!empty($value)) {
            $properties = $this->getProperties();
            $options = $properties['options'];
            if (array_key_exists($value, $options)) {
                $options[$value]['check'] = self::ODRADIOCHECK_CHECK;
                $properties['options'] = $options;
                $this->setProperties($properties);
                return $this;
            }
        }
        return false;
    }

    public function uncheckOption($value)
    {
        $value = (string) $value;
        if (!empty($value)) {
            $properties = $this->getProperties();
            $options = $properties['options'];
            if (array_key_exists($value, $options)) {
                $options[$value]['check'] = self::CHECKBOX_UNCHECK;
                $properties['options'] = $options;
                $this->setProperties($properties);
                return $this;
            }
        }
        return false;
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

    public function getLabelWidthBT()
    {
        $properties = $this->getProperties();
        return array_key_exists('labelWidthBT', $properties) ? $properties['labelWidthBT'] : false;
    }

    /**
    public function rmOption($value)
    {
        $value = (string) $value;
        if (!empty($value)) {
            $properties = $this->getProperties();
            $options = $properties['options'];
            if (array_key_exists($value, $options)) {
                unset($options[$value]);
                $properties['options'] = $options;
                $this->setProperties($properties);
                return $this;
            }
        }
        return false;
    }

    public function setOption($value, $libel, $type = self::CHECKTYPE_DEFAULT, $state = self::STATE_ENABLE)
    {
        $value = (string) $value;
        if (!empty($value)) {
            $libel = (string) $libel;
            $properties = $this->getProperties();
            $types = $this->getTypeConstants();
            if (!in_array($type, $types)) { $type = self::CHECKTYPE_DEFAULT; }
            $states = $this->getStateConstants();
            if (!in_array($state, $states)) { $stat = self::STATE_ENABLE; }
            if (!array_key_exists('options', $properties)) { $properties['options'] = []; }
            $label = $properties['label'];
            $options = $properties['options'];
            if (empty($label) && empty($options)) {
                $label = $libel;
                $properties['label'] = $libel;
            } else {
                if (array_key_exists($value, $options)) {
                    $item = [];
                    $item['libel']  = $libel;
                    $item['check']  = self::CHECKBOX_UNCHECK;
                    $item['type']   = $type;
                    $item['state']  = $state;
                    $item['value']  = $value;
                    $options[$value]    = $item;
                    $properties['options']  = $options;
                    $this->setProperties($properties);
                    return $this;
                }
            }
        }
        return false;
    }

    public function getOption($value)
    {
        $value = (string) $value;
        if (!empty($value)) {
            $properties = $this->getProperties();
            $options = $properties['options'];
            if (array_key_exists($value, $options)) {
                return $options[$value];
            }
        }
        return false;
    }

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

    public function getOptions()
    {
        $properties = $this->getProperties();
        return array_key_exists('options', $properties) ? $properties['options'] : false;
    }


    public function checkAllOptions()
    {
        $properties = $this->getProperties();
        $options = $properties['options'];
        foreach ($options as $value => $item) {
            $item[‘check’] = self::CHECKBOX_CHECK;
            $options[$value] = $item;
        }
        $properties['options'] = $options;
        $this->setProperties($properties);
        return $this;
    }

    public function uncheckAllOptions()
    {
        $properties = $this->getProperties();
        $options = $properties['options'];
        foreach ($options as $value => $item) {
            $item[‘check’] = self::CHECKBOX_UNCHECK;
            $options[$value] = $item;
        }
        $properties['options'] = $options;
        $this->setProperties($properties);
        return $this;
    }

    public function enaOption($value)
    {
        $value = (string) $value;
        if (!empty($value)) {
            $properties = $this->getProperties();
            $options = $properties['options'];
            if (array_key_exists($value, $options)) {
                $options[$value][‘state’] = self::STATE_ENABLE;
                $properties['options'] = $options;
                $this->setProperties($properties);
                return $this;
            }
        }
        return false;
    }

    public function disOption($value)
    {
        $value = (string) $value;
        if (!empty($value)) {
            $properties = $this->getProperties();
            $options = $properties['options'];
            if (array_key_exists($value, $options)) {
                $options[$value][‘state’] = self::STATE_DISABLE;
                $properties['options'] = $options;
                $this->setProperties($properties);
                return $this;
            }
        }
        return false;
    }

    public function getStateOption($value)
    {
        $value = (string) $value;
        if (!empty($value)) {
            $properties = $this->getProperties();
            $options = $properties['options'];
            if (array_key_exists($value, $options)) {
                return $options[$value]['state'] ? 'enable' : 'disable';
            }
        }
        return false;
    }

    public function enaAllOptions()
    {
        $properties = $this->getProperties();
        $options = $properties['options'];
        foreach ($options as $value => $item) {
            $item[‘state’] = self::STATE_ENABLE;
            $options[$value] = $item;
        }
        $properties['options'] = $options;
        $this->setProperties($properties);
        return $this;
    }

    public function disAllOptions()
    {
        $properties = $this->getProperties();
        $options = $properties['options'];
        foreach ($options as $value => $item) {
            $item[‘state’] = self::STATE_DISABLE;
            $options[$value] = $item;
        }
        $properties['options'] = $options;
        $this->setProperties($properties);
        return $this;
    }

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
    **/

    /** méthodes privées */

    public function getStateConstants()
    {
        $retour = [];
        if (empty($this->const_state)) {
            $constants = $this->getConstants();
            foreach ($constants as $key => $constant) {
                $pos = strpos($key, 'ODRADIOSTATE_');
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
                $pos = strpos($key, 'ODRADIOCHECK_');
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
}