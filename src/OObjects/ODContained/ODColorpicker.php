<?php

namespace GraphicObjectTemplating\OObjects\ODContained;

use Exception;
use GraphicObjectTemplating\OObjects\ODContained;
use ReflectionException;

/**
 * Class ODColorpicker
 * @package GraphicObjectTemplating\OObjects\ODContained
 *
 * méthodes publiques
 * ------------------
 * __construct(string $id, array $pathObjArray = [])
 * setLabel($label)
 * getLabel()
 * setLabelWidthBT($labelWidthBT)
 * getLabelWidthBT()
 * evtChange($class, $method, $stopEvent = false)
 * getChange()
 * disChange()
 * setColorRGB(string $red, string $green, string $blue)
 * setColorDecRGB(int $red, int $green, int $blue)
 * getColorRGB()
 * setPalette(string $palette = self::PALETTE_WEB)
 * getPalette()
 * enaIndicator()
 * disIndicator()
 * getIndication()
 * showButton()
 * hideButton()
 * getButton()
 * enaHistory()
 * disHistory()
 * getHistory()
 * setInitialHistory(array $history = null)
 * getInitialHistory()
 * setShowOn(string $showOn = self::SHOWON_BOTH)
 * getShowOn()
 * setTranslation(string $translation = "")
 * getTranslation()
 * enaTransparentColor()
 * disTransparentColor()
 *
 * méthodes privées
 * ----------------
 * isHex(string $val)
 * getPaletteConstants()
 */
class ODColorpicker extends ODContained
{
    const PALETTE_WEB   = "web";
    const PALETTE_THEME = 'theme';

    const SHOWON_BOTH   = "both";
    const SHOWON_FOCUS  = "focus";
    const SHOWON_BUTTON = "button";

    private $const_palette;
    private $const_showOn;

    /**
     * ODColorpicker constructor.
     * @param $id
     * @throws \ReflectionException
     */
    public function __construct(string $id, array $pathObjArray = []) {
        $pathObjArray[] = "oobjects/odcontained/odcolorpicker/odcolorpicker";
		parent::__construct($id, $pathObjArray);

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

    /**
     * @param $label
     * @return ODColorPicker
     * @throws Exception
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
     * @return ODColorpicker|bool
     * @throws Exception
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

    public function enaDispBySide()
    {
        $properties = $this->getProperties();
        if ($properties['labelWidthBT'] == self::formatLabelBT(12) ) {
            $properties['labelWidthBT'] = '';
            $properties['inputWidthBT'] = '';
        }
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


    /**
     * @param $class
     * @param $method
     * @param bool $stopEvent
     * @return ODColorpicker|bool
     * @throws Exception
     */
    public function evtChange(string $class, $method, $stopEvent = false)
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
     * @return ODColorpicker|bool
     * @throws Exception
     */
    public function disChange()
    {
        return $this->disEvent('change');
    }

    /**
     * @param string $red
     * @param string $green
     * @param string $blue
     * @return ODColorpicker|bool
     * @throws Exception
     */
    public function setColorRGB(string $red, string $green, string $blue)
    {
        if ($this->isHex($red) && $this->isHex($green) && $this->isHex($blue)) {
            $properties = $this->getProperties();
            $properties['colorRGB'] = sprintf("#%'02s%'02s%'02s", $red, $green, $blue);
            $this->setProperties($properties);
            return $this;
        }

        return false;
    }

    /**
     * @param int $red
     * @param int $green
     * @param int $blue
     * @return bool|ODColorpicker
     * @throws Exception
     */
    public function setColorDecRGB(int $red, int $green, int $blue)
    {
        $testRed    = (-1 < $red && $red < 256);
        $testGreen  = (-1 < $green && $green < 256);
        $testBlue   = (-1 < $blue && $blue < 256);

        if ($testRed && $testGreen && $testBlue) {
            $red    = sprintf("%02X",$red);
            $green  = sprintf("%02X",$green);
            $blue   = sprintf("%02X",$blue);
            return $this->setColorRGB($red, $green, $blue);
        }
        return false;
    }

    /**
     * @return bool|string
     */
    public function getColorRGB()
    {
        $properties = $this->getProperties();
        return array_key_exists('colorRGB', $properties) ? $properties['colorRGB'] : false;
    }

    /**
     * @param string $palette
     * @return ODColorpicker
     * @throws ReflectionException
     */
    public function setPalette(string $palette = self::PALETTE_THEME)
    {
        $palettes = $this->getPaletteConstants();
        if (!in_array($palette, $palettes)) { $palette = self::PALETTE_THEME; }
        $properties = $this->getProperties();
        $properties['defaultPalette'] = $palette;
        $this->setProperties($properties);
        return $this;
    }

    /**
     * @return bool|string
     */
    public function getPalette()
    {
        $properties = $this->getProperties();
        return array_key_exists('defaultPalette', $properties) ? $properties['defaultPalette'] : false;
    }

    /**
     * @return ODColorpicker
     * @throws Exception
     */
    public function enaIndicator()
    {
        $properties = $this->getProperties();
        $properties['displayIndicator'] = self::BOOLEAN_TRUE;
        $this->setProperties($properties);
        return $this;
    }

    /**
     * @return ODColorpicker
     * @throws Exception
     */
    public function disIndicator()
    {
        $properties = $this->getProperties();
        $properties['displayIndicator'] = self::BOOLEAN_TRUE;
        $this->setProperties($properties);
        return $this;
    }

    /**
     * @return bool|string
     */
    public function getIndication()
    {
        $properties = $this->getProperties();
        return array_key_exists('displayIndicator', $properties) ? $properties['displayIndicator'] : false;
    }

    /**
     * @return ODColorpicker
     * @throws Exception
     */
    public function showButton()
    {
        $properties = $this->getProperties();
        $properties['hideButton'] = self::BOOLEAN_FALSE;
        $this->setProperties($properties);
        return $this;
    }

    /**
     * @return ODColorpicker
     * @throws Exception
     */
    public function hideButton()
    {
        $properties = $this->getProperties();
        $properties['hideButton'] = self::BOOLEAN_TRUE;
        $this->setProperties($properties);
        return $this;
    }

    public function showInput()
    {
        $properties = $this->getProperties();
        $properties['hideInput'] = self::BOOLEAN_FALSE;
        $this->setProperties($properties);
        return $this;
    }

    public function hideInput()
    {
        $properties = $this->getProperties();
        $properties['hideInput'] = self::BOOLEAN_TRUE;
        $this->setProperties($properties);
        return $this;
    }

    /**
     * @return bool|string
     */
    public function getButton()
    {
        $properties = $this->getProperties();
        return array_key_exists('hideButton', $properties) ? $properties['hideButton'] : false;
    }

    /**
     * @return ODColorpicker
     * @throws Exception
     */
    public function enaHistory()
    {
        $properties = $this->getProperties();
        $properties['history'] = self::BOOLEAN_TRUE;
        $this->setProperties($properties);
        return $this;
    }

    /**
     * @return ODColorpicker
     * @throws Exception
     */
    public function disHistory()
    {
        $properties = $this->getProperties();
        $properties['history'] = self::BOOLEAN_TRUE;
        $this->setProperties($properties);
        return $this;
    }

    /**
     * @return bool|string
     */
    public function getHistory()
    {
        $properties = $this->getProperties();
        return array_key_exists('history', $properties) ? $properties['history'] : false;
    }

    /**
     * @param array|null $history
     * @return ODColorpicker|bool
     * @throws Exception
     */
    public function setInitialHistory(array $history = null)
    {
        $top    = true;
        if ($history != null && sizeof($history) > 0) {
            foreach ($history as $color) {
                if (substr($color, 0, 1) == "#") {
                    $valHex = substr($color, 1);
                    $valLen = strlen($valHex);
                    $top &= $valLen == 3 || $valLen == 6;
                    ctype_xdigit($valHex);
                } else {
                    // ?????????
                    $valHex = dechex(hexdec($color, 1));
                }
                if (strcasecmp($valHex,substr($color, 1)) != 0) {
                    $top = false;
                }
                if (!$top) break;
            }
        }

        if ($top) {
            $initialHistory = [];
            foreach ($history as $color) {
                if (substr($color, 0, 1) != "#") {
                    $color  = "#".$color;
                }
                $initialHistory[] = $color;
            }
            $properties = $this->getProperties();
            $properties['initialHistory']   = $initialHistory;
            $this->setProperties($properties);
            return $this;
        }
        return false;
    }

    /**
     * @return bool|string
     */
    public function getInitialHistory()
    {
        $properties = $this->getProperties();
        return array_key_exists('initialHistory', $properties) ? $properties['initialHistory'] : false;
    }

    /**
     * @param string $showOn
     * @return ODColorpicker
     * @throws ReflectionException
     */
    public function setShowOn(string $showOn = self::SHOWON_BOTH)
    {
        $showOns    = $this->getShowOnConstants();
        if (!in_array($showOn, $showOns)) { $showOn = self::SHOWON_BOTH; }
        $properties = $this->getProperties();
        $properties['showOn'] = $showOn;
        $this->setProperties($properties);
        return $this;
    }

    /**
     * @return bool|string
     */
    public function getShowOn()
    {
        $properties = $this->getProperties();
        return array_key_exists('showOn', $properties) ? $properties['showOn'] : false;
    }

    /**
     * @param string $translation
     * @return ODColorpicker|bool
     * @throws Exception
     */
    public function setTranslation(string $translation = "")
    {
        if (!empty($translation)) {
            if (substr_count($translation, ',') == 6 ) {
                $properties = $this->getProperties();
                $properties['strings']  = $translation;
                $this->setProperties($properties);
                return $this;
            }
        }
        return false;
    }

    /**
     * @return bool|string
     */
    public function getTranslation()
    {
        $properties = $this->getProperties();
        return array_key_exists('strings', $properties) ? $properties['strings'] : false;
    }

    /**
     * @return ODColorpicker
     * @throws Exception
     */
    public function enaTransparentColor()
    {
        $properties = $this->getProperties();
        $properties['transparentColor'] = self::BOOLEAN_TRUE;
        $this->setProperties($properties);
        return $this;
    }

    /**
     * @return ODColorpicker
     * @throws Exception
     */
    public function disTransparentColor()
    {
        $properties = $this->getProperties();
        $properties['transparentColor'] = self::BOOLEAN_FALSE;
        $this->setProperties($properties);
        return $this;
    }

    /** ---------------------------------
     *  méthode(s) privée(s) de l'objet -
     ------------------------------------ */

    /**
     * @param string $r
     * @param string $g
     * @param string $b
     * @return bool|string
     */
    private function isHex(string $color)
    {
        $rlen = strlen($color);
        if (0 == $rlen || $rlen > 2 || !ctype_xdigit($color)) return false;
        return true;
    }

    /**
     * @return array
     * @throws ReflectionException
     */
    private function getPaletteConstants()
    {
        $retour = [];
        if (empty($this->const_palette)) {
            $constants = $this->getConstants();
            foreach ($constants as $key => $constant) {
                $pos = strpos($key, 'PALETTE_');
                if ($pos !== false) {
                    $retour[$key] = $constant;
                }
            }
            $this->const_palette = $retour;
        } else {
            $retour = $this->const_palette;
        }
        return $retour;
    }

    /**
     * @return array
     * @throws ReflectionException
     */
    private function getShowOnConstants()
    {
        $retour = [];
        if (empty($this->const_showOn)) {
            $constants = $this->getConstants();
            foreach ($constants as $key => $constant) {
                $pos = strpos($key, 'SHOWON_');
                if ($pos !== false) {
                    $retour[$key] = $constant;
                }
            }
            $this->const_showOn = $retour;
        } else {
            $retour = $this->const_showOn;
        }
        return $retour;
    }
}