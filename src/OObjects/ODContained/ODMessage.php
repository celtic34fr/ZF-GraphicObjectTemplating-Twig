<?php

namespace GraphicObjectTemplating\OObjects\ODContained;


use GraphicObjectTemplating\OObjects\ODContained;

/**
 * Class ODMessage
 * @package GraphicObjectTemplating\OObjects\ODContained
 *
 * setHorizontalOffset($offset = 5)
 * getHorizontalOffset()
 * setVerticalOffset($offset = 5)
 * getVerticalOffset()
 *
 * méthodes privées de la classe
 * -----------------------------
 * getTypesContants()
 * getPromptsContants()
 * getBtnAlignsContants()
 * getWindowLoadsContants()
 * getIconsContants()
 * setWidth($width)
 * getWidth()
 * setHeight($height)
 * getHeight()
 */
class ODMessage extends ODContained
{
    const ODMESSAGETYPE_CONFIRM     = 'confirm';
    const ODMESSAGETYPE_PROMPT      = 'prompt';
    const ODMESSAGETYPE_ALERT       = 'alert';
    const ODMESSAGETYPE_PROGRESS    = 'progress';
    const ODMESSAGETYPE_WINDOW      = 'window';

    const ODMESSAGEPROMPT_TEXT      = 'text';
    const ODMESSAGEPROMPT_NUMBER    = 'number';
    const ODMESSAGEPROMPT_COLOR     = 'color';

    const ODMESSAGEBTNALIGN_LEFT    = 'left';
    const ODMESSAGEBTNALIGN_CENTER  = 'center';
    const ODMESSAGEBTNALIGN_RIGHT   = 'right';

    const ODMESSAGEWINDOWLOAD_GET   = 'GET';
    const ODMESSAGEWINDOWLOAD_POST  = 'POST';

    const ODMESSAGEICON_BOOTSTRAP   = 'bootstrap';
    const ODMESSAGEICON_FONTAWESOME = 'fontAwesome';

    protected $const_type;
    protected $const_prompt;
    protected $const_btnAlign;
    protected $const_windowLoad;
    protected $const_icon;


    public function __construct($id) {
        parent::__construct($id, 'oobjects/odcontained/odmessage/odmessage.config.php');

        $properties = $this->getProperties();
        if ($properties['id']) {
            $this->setDisplay(self::DISPLAY_BLOCK);
            $this->enable();
        }
        return $this;
    }

    public function setHorizontalOffset($offset = 5)
    {
        $offset = (int) $offset;
        if ($offset < 1) { $offset = 5; }
        $properties = $this->getProperties();
        $properties['horizontalOffset'] = $offset;
        $this->setProperties($properties);
        return $this;
    }

    public function getHorizontalOffset()
    {
        $properties = $this->getProperties();
        return array_key_exists('horizontalOffset', $properties) ? $properties['horizontalOffset'] : false;
    }

    public function setVerticalOffset($offset = 5)
    {
        $offset = (int) $offset;
        if ($offset < 1) { $offset = 5; }
        $properties = $this->getProperties();
        $properties['verticalOffset'] = $offset;
        $this->setProperties($properties);
        return $this;
    }

    public function getVerticalOffset()
    {
        $properties = $this->getProperties();
        return array_key_exists('verticalOffset', $properties) ? $properties['verticalOffset'] : false;
    }

    public function setWidth($width)
    {
        if ($width != 'auto') { $width = ((int) $width > 0) ? (int) $width : 400; }
        $properties = $this->getProperties();
        $properties['width'] = $width;
        $this->setProperties($properties);
        return $this;
    }

    public function getWidth()
    {
        $properties = $this->getProperties();
        return array_key_exists('width', $properties) ? $properties['width'] : false;
    }

    public function setHeight($height)
    {
        if ($height != 'auto') { $height = ((int) $height > 0) ? (int) $height : 400; }
        $properties = $this->getProperties();
        $properties['height'] = $height;
        $this->setProperties($properties);
        return $this;
    }

    public function getHeight()
    {
        $properties = $this->getProperties();
        return array_key_exists('height', $properties) ? $properties['height'] : false;
    }

    /** **************************************************************************************************
     * méthodes privées de la classe                                                                     *
     * *************************************************************************************************** */

    private function getTypesContants()
    {
        $retour = [];
        if (empty($this->const_type)) {
            $constants = $this->getConstants();
            foreach ($constants as $key => $constant) {
                $pos = strpos($key, 'ODMESSAGETYPE_');
                if ($pos !== false) $retour[$key] = $constant;
            }
            $this->const_type = $retour;
        } else {
            $retour = $this->const_type;
        }
        return $retour;
    }

    private function getPromptsContants()
    {
        $retour = [];
        if (empty($this->const_prompt)) {
            $constants = $this->getConstants();
            foreach ($constants as $key => $constant) {
                $pos = strpos($key, 'ODMESSAGEPROMPT_');
                if ($pos !== false) $retour[$key] = $constant;
            }
            $this->const_prompt = $retour;
        } else {
            $retour = $this->const_prompt;
        }
        return $retour;
    }

    private function getBtnAlignsContants()
    {
        $retour = [];
        if (empty($this->const_btnAlign)) {
            $constants = $this->getConstants();
            foreach ($constants as $key => $constant) {
                $pos = strpos($key, 'ODMESSAGEBTNALIGN_');
                if ($pos !== false) $retour[$key] = $constant;
            }
            $this->const_btnAlign = $retour;
        } else {
            $retour = $this->const_btnAlign;
        }
        return $retour;
    }

    private function getWindowLoadsContants()
    {
        $retour = [];
        if (empty($this->const_windowLoad)) {
            $constants = $this->getConstants();
            foreach ($constants as $key => $constant) {
                $pos = strpos($key, 'ODMESSAGEWINDOWLOAD_');
                if ($pos !== false) $retour[$key] = $constant;
            }
            $this->const_windowLoad = $retour;
        } else {
            $retour = $this->const_windowLoad;
        }
        return $retour;
    }

    private function getIconsContants()
    {
        $retour = [];
        if (empty($this->const_icon)) {
            $constants = $this->getConstants();
            foreach ($constants as $key => $constant) {
                $pos = strpos($key, 'ODMESSAGEICON_');
                if ($pos !== false) $retour[$key] = $constant;
            }
            $this->const_icon = $retour;
        } else {
            $retour = $this->const_icon;
        }
        return $retour;
    }
}