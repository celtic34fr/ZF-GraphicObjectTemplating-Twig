<?php

namespace GraphicObjectTemplating\OObjects\ODContained;

use GraphicObjectTemplating\OObjects\ODContained;

/**
 * Class ODSelect
 * @package GraphicObjectTemplating\Objects\ODContained
 *
 * addOption($value, $libel, $selected = false, $enable = true)
 * rmOption($value)
 * setOptions(array $options)
 * getOptions()
 * clearOptions()
 * enaOption($value)
 * disOption($value)
 * getStateOption($value)
 * setSelectedOption($value)
 * unsetSelecteOption($value)
 * getSelectedOption()
 * unselectAll()
 * isSelectedOption($value)
 * enaMultiple($number)
 * disMultiple()
 * isMultiple()
 * setLabel($label)
 * getLabel()
 * setPlaceholder($placeholder)
 * getPlaceholder()
 * evtChange($class, $method, $stopEvent = false)
 * getChange()
 * disChange()
 * setFormat($format = self::ODSELECTFORMAT_NORMAL)
 * getFormat()
 * setBgColor($bgColor = self::ODSELECTCOLOR_WHITE)
 * getBgColor()
 * setFgColor($fgColor = self::ODSELECTCOLOR_BLACK)
 * getFgColor()
 *
 * méthodes privées de la classe
 * -----------------------------
 * getFormatConstants()
 * getColorConstants()
 */

class ODSelect extends ODContained
{
    const ODSELECTFORMAT_BIG        = " big";
    const ODSELECTFORMAT_NORMAL     = '';
    const ODSELECTFORMAT_SMALL      = ' small';

    const ODSELECTCOLOR_BLACK       = 'black';
    const ODSELECTCOLOR_WHITE       = 'white';
    const ODSELECTCOLOR_LIME        = 'lime';
    const ODSELECTCOLOR_GREEN       = 'green';
    const ODSELECTCOLOR_EMERALD     = 'emerald';
    const ODSELECTCOLOR_TEAL        = 'teal';
    const ODSELECTCOLOR_BLUE        = 'blue';
    const ODSELECTCOLOR_CYAN        = 'cyan';
    const ODSELECTCOLOR_COBALT      = 'cobalt';
    const ODSELECTCOLOR_INDIGO      = 'indigo';
    const ODSELECTCOLOR_VIOLET      = 'violet';
    const ODSELECTCOLOR_PINK        = 'pink';
    const ODSELECTCOLOR_MAGENTA     = 'magenta';
    const ODSELECTCOLOR_CRIMSON     = 'crimson';
    const ODSELECTCOLOR_RED         = 'red';
    const ODSELECTCOLOR_ORANGE      = 'orange';
    const ODSELECTCOLOR_AMBER       = 'amber';
    const ODSELECTCOLOR_YELLOW      = 'yellow';
    const ODSELECTCOLOR_BROWN       = 'brown';
    const ODSELECTCOLOR_OLIVE       = 'olive';
    const ODSELECTCOLOR_STEEL       = 'steel';
    const ODSELECTCOLOR_MAUVE       = 'mauve';
    const ODSELECTCOLOR_TAUPE       = 'taupe';
    const ODSELECTCOLOR_GRAY        = 'gray';
    const ODSELECTCOLOR_DARK        = 'dark';
    const ODSELECTCOLOR_DARKER      = 'darker';
    const ODSELECTCOLOR_DARKBROWN   = 'darkBrown';
    const ODSELECTCOLOR_DARKCRIMSON = 'darkCrimson';
    const ODSELECTCOLOR_DARKMAGENTA = 'darkMagenta';
    const ODSELECTCOLOR_DARKINDIGO  = 'darkIndigo';
    const ODSELECTCOLOR_DARKCYAN    = 'darkCyan';
    const ODSELECTCOLOR_DARKCOBALT  = 'darkCobalt';
    const ODSELECTCOLOR_DARKTEAL    = 'darkTeal';
    const ODSELECTCOLOR_DARKEMERALD = 'darkEmerald';
    const ODSELECTCOLOR_DARKGREEN   = 'darkGreen';
    const ODSELECTCOLOR_DARKORANGE  = 'darkOrange';
    const ODSELECTCOLOR_DARKRED     = 'darkRed';
    const ODSELECTCOLOR_DARKPINK    = 'darkPink';
    const ODSELECTCOLOR_DARKVIOLET  = 'darkViolet';
    const ODSELECTCOLOR_DARKBLUE    = 'darkBlue';
    const ODSELECTCOLOR_LIGHTBLUE   = 'lightBlue';
    const ODSELECTCOLOR_LIGHTRED    = 'lightRed';
    const ODSELECTCOLOR_LIGHTGREEN  = 'lightGreen';
    const ODSELECTCOLOR_LIGHTERBLUE = 'lighterBlue';
    const ODSELECTCOLOR_LIGHTTEAL   = 'lightTeal';
    const ODSELECTCOLOR_LIGHTOLIVE  = 'lightOlive';
    const ODSELECTCOLOR_LIGHTORANGE = 'lightOrange';
    const ODSELECTCOLOR_LIGHTPINK   = 'lightPink';
    const ODSELECTCOLOR_GRAYDARK    = 'grayDark';
    const ODSELECTCOLOR_GRAYDARKER  = 'grayDarker';
    const ODSELECTCOLOR_GRAYLIGHT   = 'grayLight';
    const ODSELECTCOLOR_GRAYLIGHTER = 'grayLighter';

    protected $const_format;
    protected $const_color;

    public function __construct($id) {
        parent::__construct($id, "oobjects/odcontained/odselect/odselect.config.php");
        $this->setDisplay();
        $width = $this->getWidthBT();
        if (!is_array($width) || empty($width)) $this->setWidthBT(12);
        $this->enable();

        $this->saveProperties();
        return $this;
    }

    public function addOption($value, $libel, $selected = false, $enable = true)
    {
        $value      = (string) $value;
        $libel      = (string) $libel;
        $selected   = ($selected and true);
        $enable     = ($enable and true);
        if (!empty($value) && !empty($libel)) {
            $properties = $this->getProperties();
            if (!array_key_exists('options', $properties)) { $properties['options'] = []; }
            $options    = $properties['options'];
            if (!array_key_exists($value, $options)) {
                $item = [];
                $item['libel']      = $libel;
                $item['selected']   = $selected;
                $item['enable']     = $enable;
                $options[$value]    = $item;
                $properties['options'] = $options;
                $this->setProperties($properties);
                return $this;
            }
        }
        return false;
    }

    public function setOption($value, $libel, $selected = false, $enable = true)
    {
        $value      = (string) $value;
        $libel      = (string) $libel;
        $selected   = ($selected or true);
        $enable     = ($enable or true);
        if (!empty($value) && !empty($libel)) {
            $properties = $this->getProperties();
            $options    = $properties['options'];
            if (array_key_exists($value, $options)) {
                $item = [];
                $item['libel']      = $libel;
                $item['selected']   = $selected;
                $item['enable']     = $enable;
                $options[$value]    = $item;
                $properties['options'] = $options;
                $this->setProperties($properties);
                return $this;
            }
        }
        return false;
    }

    public function rmOption($value)
    {
        $value      = (string) $value;
        if (!empty($value)) {
            $properties = $this->getProperties();
            $options    = $properties['options'];
            if (array_key_exists($value, $options)) {
                unset($options[$value]);
                $properties['options'] = $options;
                $this->setProperties($properties);
                return $this;
            }
        }
        return false;
    }

    public function setOptions(array $options)
    {
        /**
         * le controle de la structure de $options
         * -> cle : tableau (libel, selected, enable) pour chaque occurance
         */
        $top = true;
        foreach ($options as $option) {
            if (is_array($option)) {
                $top = $top && array_key_exists('libel', $option);
                $top = $top && array_key_exists('selected', $option);
                $top = $top && array_key_exists('enable', $option);
            }
        }
        /** réelle affectation du tableau si tout ok */
        if ($top) {
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

    public function getOption($valeur = null)
    {
        if (!empty($valeur)) {
            $properties = $this->getProperties();
            $options    = $properties['options'];
            if (array_key_exists($valeur, $options)) {
                return $options[$valeur];
            }
        }
        return false;
    }

    public function clearOptions()
    {
        $properties = $this->getProperties();
        $properties['options'] = [];
        $this->setProperties($properties);
        return $this;
    }

    public function enaOption($value)
    {
        $value      = (string) $value;
        if (!empty($value)) {
            $properties = $this->getProperties();
            $options    = $properties['options'];
            if (array_key_exists($value, $options)) {
                $options[$value]['enable'] = true;
                $properties['options'] = $options;
                $this->setProperties($properties);
                return $this;
            }
        }
        return false;
    }

    public function disOption($value)
    {
        $value      = (string) $value;
        if (!empty($value)) {
            $properties = $this->getProperties();
            $options    = $properties['options'];
            if (array_key_exists($value, $options)) {
                $options[$value]['enable'] = false;
                $properties['options'] = $options;
                $this->setProperties($properties);
                return $this;
            }
        }
        return false;
    }

    public function getStateOption($value)
    {
        $value      = (string) $value;
        if (!empty($value)) {
            $properties = $this->getProperties();
            $options    = $properties['options'];
            if (array_key_exists($value, $options)) {
                if ($options[$value]['enable'] == true) { return 'enable'; };
                if ($options[$value]['enable'] == false) { return 'disable'; };
            }
        }
        return false;
    }

    public function setSelectedOption($value)
    {
        $value      = (string) $value;
        if (!empty($value)) {
            $properties = $this->getProperties();
            $options    = $properties['options'];
            if (array_key_exists($value, $options)) {
                if ($properties['multiple'] === false) { $this->unselectAll(); }
                $options[$value]['selected'] = true;
                $properties['options'] = $options;
                $this->setProperties($properties);
                return $this;
            }
        }
        return false;
    }

    public function unsetSelectedOption($value)
    {
        $value      = (string) $value;
        if (!empty($value)) {
            $properties = $this->getProperties();
            $options    = $properties['options'];
            if (array_key_exists($value, $options)) {
                $options[$value]['selected'] = false;
                $properties['options'] = $options;
                $this->setProperties($properties);
                return $this;
            }
        }
        return false;
    }

    public function unselectAll()
    {
        $properties = $this->getProperties();
        if (array_key_exists('options', $properties) && !empty($properties['options'])) {
            $options = $properties['options'];
            foreach ($options as $key => $option) {
                $options[$key]['selected'] = false;
            }
            $properties['options'] = $options;
            $this->setProperties($properties);
            return $this;
        }
        return false;
    }

    public function getSelectedOption()
    {
        $properties = $this->getProperties();
        $selection  = [];
        if (array_key_exists('options', $properties) && !empty($properties['options'])) {
            $options = $properties['options'];
            foreach ($options as $value => $option) {
                if ($options[$value]['selected']) {
                    $selection[] = $value;
                }
            }
            return $selection;
        }
        return false;
    }

    public function isSelectedOption($value)
    {
        $value      = (string) $value;
        if (!empty($value)) {
            $properties = $this->getProperties();
            $options    = $properties['options'];
            if (array_key_exists($value, $options)) {
                if ($options[$value]['selected'] == true) { return 'selected'; };
                if ($options[$value]['selected'] == false) { return 'unselected'; };
            }
        }
        return false;
    }

    public function enaMultiple($number)
    {
        /** $number nombre de sélection valable pour mode select2 */
        $number = (int) $number;
        $properties = $this->getProperties();
        $properties['multiple'] = ($number == 0) ? true : $number;
        $this->setProperties($properties);
        return $this;
    }

    public function disMultiple()
    {
        $properties = $this->getProperties();
        $properties['multiple'] = false;
        $this->setProperties($properties);
        return $this;
    }

    public function isMultiple()
    {
        if (!empty($value)) {
            $properties = $this->getProperties();
            $options    = $properties['options'];
            if (array_key_exists('multplie', $options)) {
                if ($options['multiple'] !== false ) { return 'multiple'; };
                if ($options['multiple'] === false) { return 'single'; };
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
            $widthLabSelBT = self::formatLabelBT($labelWidthBT);

            $properties     = $this->getProperties();
            $properties['labelWidthBT']     = $widthLabSelBT['labelWidthBT'];
            $properties['selectWidthBT']    = $widthLabSelBT['inputWidthBT'];
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

    public function getSelectWidthBT()
    {
        $properties = $this->getProperties();
        return array_key_exists('selectWidthBT', $properties) ? $properties['selectWidthBT'] : false;
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

    public function setFormat($format = self::ODSELECTFORMAT_NORMAL)
    {
        $format = (string) $format;
        $formats = $this->getFormatConstants();
        if (!in_array($format, $formats)) { $format = self::ODSELECTFORMAT_NORMAL; }
        $properties = $this->getProperties();
        $properties['format'] = $format;
        $this->setProperties($properties);
        return $this;
    }

    public function getFormat()
    {
        $properties = $this->getProperties();
        return array_key_exists('format', $properties) ? $properties['format'] : false;
    }

    public function setBgColor($bgcolor = self::ODSELECTCOLOR_WHITE)
    {
        $bgcolor = (string) $bgcolor;
        $bgcolors = $this->getColorConstants();
        if (!in_array($bgcolor, $bgcolors)) { $bgcolor = self::ODSELECTCOLOR_WHITE; }

        $properties = $this->getProperties();
        $properties['bgColor'] = $bgcolor;
        $this->setProperties($properties);
        return $this;
    }

    public function getBgColor()
    {
        $properties = $this->getProperties();
        return array_key_exists('bgColor', $properties) ? $properties['bgColor'] : false;
    }

    public function setFgColor($fgcolor = self::ODSELECTCOLOR_BLACK)
    {
        $fgcolor = (string) $fgcolor;
        $fgcolors = $this->getColorConstants();
        if (!in_array($fgcolor, $fgcolors)) { $fgcolor = self::ODSELECTCOLOR_WHITE; }

        $properties = $this->getProperties();
        $properties['fgColor'] = $fgcolor;
        $this->setProperties($properties);
        return $this;
    }

    public function getFgColor()
    {
        $properties = $this->getProperties();
        return array_key_exists('fgColor', $properties) ? $properties['fgColor'] : false;
    }

    /** **************************************************************************************************
     * méthodes privées de la classe                                                                     *
     * *************************************************************************************************** */

    private function getFormatConstants()
    {
        $retour = [];
        if (empty($this->const_format)) {
            $constants = $this->getConstants();
            foreach ($constants as $key => $constant) {
                $pos = strpos($key, 'ODSELECTFORMAT_');
                if ($pos !== false) {
                    $retour[$key] = $constant;
                }
            }
            $this->const_format = $retour;
        } else {
            $retour = $this->const_format;
        }
        return $retour;
    }

    public function getColorConstants()
    {
        $retour = [];
        if (empty($this->const_color)) {
            $constants = $this->getConstants();
            foreach ($constants as $key => $constant) {
                $pos = strpos($key, 'ODSELECTCOLOR_');
                if ($pos !== false) {
                    $retour[$key] = $constant;
                }
            }
            $this->const_color = $retour;
        } else {
            $retour = $this->const_color;
        }
        return $retour;
    }

}
