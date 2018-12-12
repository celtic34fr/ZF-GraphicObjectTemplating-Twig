<?php

namespace GraphicObjectTemplating\OObjects\ODContained;

use DateTime;
use GraphicObjectTemplating\OObjects\ODContained;

/**
 * Class ODDateTimePicker
 * @package GraphicObjectTemplating\OObjects\ODContained
 *
 * setLocale($locale = 'fr')
 * getLocale()
 * enaTime()
 * disTime()
 * enaSecond()
 * disSecond()
 * statusTime()
 * setDateFormat($dateFormat = self::DATETIMEPICKER_DATEFR)
 * getDateFormat()
 * setMinDate($minDate = null) date à null = aujourd'hui
 * getMinDate()
 * setMaxDate($maxDate = null) date à null = aujourd'hui
 * getMaxDate()
 * ena24h()
 * enaAmPm()
 * setMinTime($minTime = null)
 * getMinTime()
 * setMaxTime($maxTime = null)
 * getMaxTime()
 * enaCalendar()
 * disCalendar()
 * enaDatPicker()
 * enaTimePicker()
 * enaDatTimePicker()
 * enaInline()
 * disInline()
 * enaAltFormat($altFormat = 'F j, Y')
 * disAltFormat()
 *
 * méthodes privées de la classe
 * -----------------------------
 * getViewModeConstants()
 */

class ODDateTimePicker extends ODContained
{
    const DATETIMEPICKER_DATEFR             = "d/m/Y";

    const DATETIMEPICKER_AUJOURDHUI         = "today";

    const DATETIMEPICKER_MODESINGLE         = 'single';
    const DATETIMEPICKER_MODEMULTIPLE       = "multiple";
    const DATETIMEPICKER_MODERANGE          = "range";

    const DATETIMEPICKER_VMODEDAYS          = 'days';
    const DATETIMEPICKER_VMODEDECADES       = 'decades';
    const DATETIMEPICKER_VMODEYEARS         = 'years';
    const DATETIMEPICKER_VMODEMONTHS        = 'months';

    private $const_viewMode;
    private $const_mode;

    public function __construct($id) {
        parent::__construct($id, "oobjects/odcontained/oddatetimepicker/oddatetimepicker.config.php");

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

    public function setLocale($locale = 'fr')
    {
        $locale = (string) $locale;
        $properties = $this->getProperties();
        $properties['locale'] = $locale;
        $this->setProperties($properties);
        return $this;
    }

    public function getLocale()
    {
        $properties = $this->getProperties();
        return array_key_exists('locale', $properties) ? $properties['locale'] : false;
    }

    public function enaTime()
    {
        $properties = $this->getProperties();
        $properties['enableTime'] = true;
        $this->setProperties($properties);
        return $this;
    }

    public function disTime()
    {
        $properties = $this->getProperties();
        $properties['enableTime'] = false;
        $this->setProperties($properties);
        return $this;
    }

    public function enaSeconds()
    {
        $properties = $this->getProperties();
        $properties['enableSeconds'] = true;
        $this->setProperties($properties);
        return $this;
    }

    public function disSeconds()
    {
        $properties = $this->getProperties();
        $properties['enableSeconds'] = false;
        $this->setProperties($properties);
        return $this;
    }

    public function statusTime()
    {
        $properties = $this->getProperties();
        return array_key_exists('enableTime', $properties) ? $properties['enableTime'] : false;
    }

    public function setDateFormat($dateFormat = self::DATETIMEPICKER_DATEFR)
    {
        $dateFormat = (string) $dateFormat;
        $properties = $this->getProperties();
        $properties['dateFormat'] = $dateFormat;

        /** traitement de date minimale et/ou maximale */
        $minDate    = $properties['minDate'];
        $maxDate    = $properties['maxDate'];
        if (!empty($minDate) && $minDate != self::DATETIMEPICKER_AUJOURDHUI) {
            $date = new DateTime($minDate);
            $properties['minDate'] = $date->format($dateFormat);
        }
        if (!empty($maxDate) && $maxDate != self::DATETIMEPICKER_AUJOURDHUI) {
            $date = new DateTime($maxDate);
            $properties['maxDate'] = $date->format($dateFormat);
        }

        $this->setProperties($properties);
        return $this;
    }

    public function getDateFormat()
    {
        $properties = $this->getProperties();
        return array_key_exists('dateFormat', $properties) ? $properties['dateFormat'] : false;
    }

    public function setMinDate($minDate = null)
    {
        $minDate    = (string) $minDate;
        $properties = $this->getProperties();
        if (empty($minDate)) { $minDate = self::DATETIMEPICKER_AUJOURDHUI; }
        if ($minDate != self::DATETIMEPICKER_AUJOURDHUI) {
            $date = new DateTime($minDate);
            $dateFormat = $properties['dateFormat'];
            $minDate    = $date->format($dateFormat);
        }
        $properties['minDate']  = $minDate;
        $this->setProperties($properties);
        return $this;
    }

    public function getMinDate()
    {
        $properties = $this->getProperties();
        return array_key_exists('minDate', $properties) ? $properties['minDate'] : false;
    }

    public function setMaxDate($maxDate = null)
    {
        $maxDate    = (string) $maxDate;
        $properties = $this->getProperties();
        if (empty($maxDate)) { $maxDate = self::DATETIMEPICKER_AUJOURDHUI; }
        if ($maxDate != self::DATETIMEPICKER_AUJOURDHUI) {
            $date = new DateTime($maxDate);
            $dateFormat = $properties['dateFormat'];
            $maxDate    = $date->format($dateFormat);
        }
        $properties['maxDate']  = $maxDate;
        $this->setProperties($properties);
        return $this;
    }

    public function getMaxDate()
    {
        $properties = $this->getProperties();
        return array_key_exists('maxDate', $properties) ? $properties['maxDate'] : false;
    }

    public function ena24h()
    {
        $properties = $this->getProperties();
        $properties['time_24hr'] = true;
        $this->setProperties($properties);
        return $this;
    }

    public function enaAmPm()
    {
        $properties = $this->getProperties();
        $properties['time_24hr'] = false;
        $this->setProperties($properties);
        return $this;
    }

    public function setMinTime($minTime = null)
    {
        $minTime    = (string) $minTime;
        $properties = $this->getProperties();
        if (empty($minTime)) { $minTime = '00:00'; }
        $properties['minTime']  = $minTime;
        $this->setProperties($properties);
        return $this;
    }

    public function getMinTime()
    {
        $properties = $this->getProperties();
        return array_key_exists('minTime', $properties) ? $properties['minTime'] : false;
    }

    public function setMaxTime($maxTime = null)
    {
        $maxTime    = (string) $maxTime;
        $properties = $this->getProperties();
        if (empty($maxTime)) { $maxTime = '23:59'; }
        $properties['maxTime']  = $maxTime;
        $this->setProperties($properties);
        return $this;
    }

    public function getMaxTime()
    {
        $properties = $this->getProperties();
        return array_key_exists('maxTime', $properties) ? $properties['maxTime'] : false;
    }

    public function enaCalendar()
    {
        $properties = $this->getProperties();
        $properties['noCalendar'] = false;
        $this->setProperties($properties);
        return $this;
    }

    public function disCalendar()
    {
        $properties = $this->getProperties();
        $properties['noCalendar'] = true;
        $this->setProperties($properties);
        return $this;
    }

    public function enaDatePicker()
    {
        $properties = $this->getProperties();
        $properties['noCalendar'] = false;
        $properties['enableTime'] = false;
        $this->setProperties($properties);
        return $this;
    }

    public function enaTimePicker()
    {
        $properties = $this->getProperties();
        $properties['noCalendar'] = true;
        $properties['enableTime'] = true;
        $this->setProperties($properties);
        return $this;
    }

    public function enaDateTimePicker()
    {
        $properties = $this->getProperties();
        $properties['noCalendar'] = false;
        $properties['enableTime'] = true;
        $this->setProperties($properties);
        return $this;
    }

    public function enaInline()
    {
        $properties = $this->getProperties();
        $properties['inline'] = true;
        $this->setProperties($properties);
        return $this;
    }

    public function disInline()
    {
        $properties = $this->getProperties();
        $properties['inline'] = false;
        $this->setProperties($properties);
        return $this;
    }

    public function enaAltFormat($altFormat = 'F j, Y')
    {
        $altFormat  = (string) $altFormat;
        $proerties  = $this->getProperties();
        $properties['altInpuit'] = true;
        $properties['altFormat'] = $altFormat;
        $this->setProperties($proerties);
        return $this;
    }

    public function disAltFormat()
    {
        $proerties  = $this->getProperties();
        $properties['altInpuit'] = false;
        $properties['altFormat'] = '';
        $this->setProperties($proerties);
        return $this;
    }

    public function setMode($mode = self::DATETIMEPICKER_MODESINGLE)
    {
        $mode = (string) $mode;
        $modes  = $this->getModeConstants();
        if (!in_array($mode, $modes)) { $mode = self::DATETIMEPICKER_MODESINGLE; }
        $proerties  = $this->getProperties();
        $proerties['mode']  = $mode;
        $this->setProperties($proerties);
        return $this;
    }

    public function getMode()
    {
        $properties = $this->getProperties();
        return array_key_exists('mode', $properties) ? $properties['mode'] : false;
    }


    private function getModeConstants()
    {
        $retour = [];
        if (empty($this->const_mode)) {
            $constants = $this->getConstants();
            foreach ($constants as $key => $constant) {
                $pos = strpos($key, 'DATETIMEPICKER_MODE');
                if ($pos !== false) {
                    $retour[$key] = $constant;
                }
            }
            $this->const_mode = $retour;
        } else {
            $retour = $this->const_mode;
        }
        return $retour;
    }







    public function setDefaultDate($defaultDate = null)
    {
        if (empty($defaultDate)) { $defaultDate = (new \DateTime())->format('Y-m-d'); }
        $defaultDate = (string) $defaultDate;

        $date = new \DateTime($defaultDate);
        $properties = $this->getProperties();
        $properties['defaultDate'] = $date->format('m/d/Y');
        $this->setProperties($properties);
        return $this;
    }

    public function getDefaultDate($formatDate = null)
    {
        $properties = $this->getProperties();
        $date = array_key_exists('defaultDate', $properties) ? $properties['defaultDate'] : false;
        if (empty($formatDate)) { $formatDate = 'm/d/Y'; }
        if ($date) {
            return (new \DateTime($date))->format($formatDate);
        }
        return false;
    }

    public function setViewMode($viewMode = self::DATETIMEPICKER_VMODEDAYS)
    {
        $viewModes  = $this->getViewModeConstants();
        $viewMode   = (string) $viewMode;
        if (!in_array($viewMode, $viewModes)) { $viewMode = self::DATETIMEPICKER_VMODEDAYS; }
        $properties = $this->getProperties();
        $properties['viewMode'] = $viewMode;
        $this->setProperties($properties);
        return $this;
    }

    public function getViewMode()
    {
        $properties = $this->getProperties();
        return array_key_exists('viewMode', $properties) ? $properties['viewMode'] : false;
    }


    private function getViewModeConstants()
    {
        $retour = [];
        if (empty($this->const_viewMode)) {
            $constants = $this->getConstants();
            foreach ($constants as $key => $constant) {
                $pos = strpos($key, 'DATETIMEPICKER_VMODE');
                if ($pos !== false) {
                    $retour[$key] = $constant;
                }
            }
            $this->const_viewMode = $retour;
        } else {
            $retour = $this->const_viewMode;
        }
        return $retour;
    }
}