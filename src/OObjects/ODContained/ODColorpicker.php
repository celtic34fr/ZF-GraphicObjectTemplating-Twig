<?php

namespace GraphicObjectTemplating\OObjects\ODContained;

use GraphicObjectTemplating\OObjects\ODContained;

/**
 * Class ODColorpicker
 * @package GraphicObjectTemplating\OObjects\ODContained
 *
 ** setTitle($title = null)
 ** getTitle()
 * setLabel($label)
 * getLabel()
 * setLabelWidthBT($labelWidthBT)
 * getLabelWidthBT()
 * evtChange($class, $method, $stopEvent = false)
 * getChange()
 * disChange()
 * setColorRGB(string $red, string $green, string $blue)
 * getColorRGB()
 */
class ODColorpicker extends ODContained
{
    /**
     * ODColorpicker constructor.
     * @param $id
     * @throws \ReflectionException
     */
    public function __construct($id) {
        parent::__construct($id, "oobjects/odcontained/odcolorpicker/odcolorpicker.config.php");

        $properties = $this->getProperties();
        if ($properties['id']) {
            $this->setDisplay();
            $width = $this->getWidthBT();
            if (!is_array($width) || empty($width)) $this->setWidthBT(12);
            $this->enable();
        }

        $this->saveProperties();
        return $this;
    }

//    public function setTitle($title = null)
//    {
//        $title = (string) $title;
//        if (!empty($title)) {
//            $properties = $this->getProperties();
//            $properties['title'] = $title;
//            $this->setProperties($properties);
//            return $this;
//        }
//        return false;
//    }
//
//    public function getTitle()
//    {
//        $properties = $this->getProperties();
//        return array_key_exists('title', $properties) ? $properties['title'] : false;
//    }

    /**
     * @param $label
     * @return ODColorPicker
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
     * @return ODColorPicker|bool
     */
    public function setLabelWidthBT($labelWidthBT)
    {
        if (!empty($labelWidthBT)) {
            $lxs = $lsm = $lmd = $llg = 0;
            $ixs = $ism = $imd = $ilg = 0;
            if (is_numeric($labelWidthBT)) {
                $lxs = $lsm = $lmd = $llg = (int) $labelWidthBT;
                $ixs = $ism = $imd = $ilg = 11 - (int) $labelWidthBT;
            } else { // $labelWidthBT nb'est pas numérique
                $labelWidthBT = explode(':', $labelWidthBT);
                foreach ($labelWidthBT as $item) {
                    $key = strtoupper($item);
                    switch (substr($key, 0,2)) {
                        case 'WX' :
                            $lxs = (int) substr($key, 2);
                            $ixs = 11 - $lxs;
                            break;
                        case 'WS' :
                            $lsm = (int) substr($key, 2);
                            $ism = 11 - $lsm;
                            break;
                        case 'WM' :
                            $lmd = (int) substr($key, 2);
                            $imd = 11 - $lmd;
                            break;
                        case 'WX' :
                            $llg = (int) substr($key, 2);
                            $ilg = 11 - $llg;
                            break;
                        default:
                            if (substr($key, 0, 1) == 'W') {
                                $lxs = $lsm = $lmd = $llg = (int) $key;
                                $ixs = $ism = $imd = $ilg = 11 - (int) $key;
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

    /**
     * @param $class
     * @param $method
     * @param bool $stopEvent
     * @return ODColorPicker|bool
     */
    public function evtChange($class, $method, $stopEvent = false)
    {
        if (!empty($class) && !empty($method)) {
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
            }
        }
        return false;
    }

    /**
     * @return bool|array
     */
    public function getChange()
    {
        $properties = $this->getProperties();
        if (array_key_exists('event', $properties)) {
            $event = $properties['event'];
            if (array_key_exists('change', $event)) {
                return $event['change'];
            }
        }
        return false;
    }

    /**
     * @return ODColorPicker|bool
     */
    public function disChange()
    {
        $properties = $this->getProperties();
        if (array_key_exists('event', $properties)) {
            $event = $properties['event'];
            if (array_key_exists('change', $event)) {
                unset($event['change']);
                $properties['event'] = $event;
                $this->setProperties($properties);
                return $this;
            }
        }
        return false;
    }

    /**
     * @param string $red
     * @param string $green
     * @param string $blue
     * @return ODColorPicker|bool
     */
    public function setColorRGB(string $red, string $green, string $blue)
    {
        $testRed    = $this->isHex($red);
        $testGreen  = $this->isHex($green);
        $testBlue   = $this->isHex($blue);

        if ($testRed == $red && $testGreen == $green && $testBlue == $blue) {
            $properties = $this->getProperties();
            $properties['colorRGB'] = '#'.$red.$green.$blue;
            $this->setProperties($properties);
            return $this;
        }

        return false;
    }

    public function getColorRGB()
    {
        $properties = $this->getProperties();
        return array_key_exists('colorRGB', $properties) ? $properties['colorRGB'] : false;
    }

    /**
     *  méthode(s) privée(s) de l'objet
     */

    /**
     * @param string $val
     * @return bool|string
     */
    private function isHex(string $val)
    {
        $hexStr = preg_replace("/[^0-9A-Fa-f]/", '', $val);
        if (strlen($hexStr) > 2) {
            return false;
        }
        $val = sprintf('%02d', $val);
        return $val;
    }
}