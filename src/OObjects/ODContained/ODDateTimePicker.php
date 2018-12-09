<?php

namespace GraphicObjectTemplating\OObjects\ODContained;

use GraphicObjectTemplating\OObjects\ODContained;

/**
 * Class ODDateTimePicker
 * @package GraphicObjectTemplating\OObjects\ODContained
 *
 * setFormatDate($formatDate = self::DATETIMEPICKER_LONGTIME)
 * getFormatDate()
 * setDefaultDate($defaultDate = null)
 * getDefaultDate($formatDate = null)
 * setLocale($locale = 'fr')
 * getLocale()
 * setViewMode($viewMode = self::DATETIMEPICKER_VMODEDAYS)
 * getViewMode()
 * enaInline()
 * disInline()
 *
 * méthodes privées de la classe
 * -----------------------------
 * getViewModeConstants()
 */

class ODDateTimePicker extends ODContained
{
    const DATETIMEPICKER_LONGTIME           = 'LT';
    const DATETIMEPICKER_LONGTIMESECOND     = 'LTS';
    const DATETIMEPICKER_DATE               = 'L';
    const DATETIMEPICKER_FULLDATE           = 'LL';
    const DATETIMEPICKER_FULLDATETIME       = 'LLL';
    const DATETIMEPICKER_DWEEKFULLDATETIME  = 'LLLL';

    const DATETIMEPICKER_VMODEDAYS          = 'days';
    const DATETIMEPICKER_VMODEDECADES       = 'decades';
    const DATETIMEPICKER_VMODEYEARS         = 'years';
    const DATETIMEPICKER_VMODEMONTHS        = 'months';

    private $const_viewMode;

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

    public function setFormatDate($formatDate = self::DATETIMEPICKER_LONGTIME)
    {
        $formatDate = (string) $formatDate;
        $properties = $this->getProperties();
        $properties['formatDate'] = $formatDate;
        $this->setProperties($properties);
        return $this;
    }

    public function getFormatDate()
    {
        $properties = $this->getProperties();
        return array_key_exists('formatDate', $properties) ? $properties['formatDate'] : false;
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