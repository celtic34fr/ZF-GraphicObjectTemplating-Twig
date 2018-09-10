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
 * enaCloseButton()
 * disCloseButton()
 * setButtonAlign($buttonAlign = self::ODMESSAGEBTNALIGN_CENTER)
 * getButtonAlign()
 * enaCloseOnEsc()
 * disCloseOnEsc()
 * setDelayToRemove($delayToRemove = 200)
 * getDelayToRemove()
 * enaDelay()
 * disDelay()
 * setIconSource($iconSource = self::ODMESSAGEICON_BOOTSTRAP)
 * getIconSource()
 * setMsgType($msgType = self::ODMESSAGETYPE_CONFIRM)
 * getMsgType()
 *
 * méthodes de gestion du type de message confirmation ou alerte
 * -------------------------------------------------------------
 * setTitle($title)
 * getTitle()
 *
 * méthodes de gestion du type de message prompt
 * ---------------------------------------------
 * setType($type = self::ODMESSAGEPROMPT_TEXT)
 * getType()
 * enaMultiline()
 * disMultiline()
 * setLineNumber($lineNumber = 1);
 * getLineNumber()
 * setLabel($label)
 * getLabel()
 * enaRequired()
 * disRequired()
 * setErrorMessage($errorMessage = '')
 * getErrorMessage()
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

    public function enaCloseButton()
    {
        $properties = $this->getProperties();
        $properties['closeButton'] = true;
        $this->setProperties($properties);
        return $this;
    }

    public function disCloseButton()
    {
        $properties = $this->getProperties();
        $properties['closeButton'] = false;
        $this->setProperties($properties);
        return $this;
    }

    public function setButtonAlign($buttonAlign = self::ODMESSAGEBTNALIGN_CENTER)
    {
        $buttonsAlign   = $this->getBtnAlignsContants();
        $buttonAlign    = (string) $buttonAlign;
        if (!in_array($buttonAlign, $buttonsAlign)) { $buttonAlign = self::ODMESSAGEBTNALIGN_CENTER; }

        $properties = $this->getProperties();
        $properties['buttonAlign'] = $buttonAlign;
        $this->setProperties($properties);
        return $this;
    }

    public function getButtonAlign()
    {
        $properties = $this->getProperties();
        return array_key_exists('buttonAlign', $properties) ? $properties['buttonAlign'] : false;
    }

    public function enaCloseOnEsc()
    {
        $properties = $this->getProperties();
        $properties['closeOnEsc'] = true;
        $this->setProperties($properties);
        return $this;
    }

    public function disCloseOnEsc()
    {
        $properties = $this->getProperties();
        $properties['closeOnEsc'] = false;
        $this->setProperties($properties);
        return $this;
    }

    public function setDelayToRemove($delayToRemove = 200)
    {
        $delayToRemove = (int) $delayToRemove;
        if ($delayToRemove == 0) { $delayToRemove = 200; }

        $properties = $this->getProperties();
        $properties['delayToRemove'] = $delayToRemove;
        $this->setProperties($properties);
        return $this;
    }

    public function getDelayToRemove()
    {
        $properties = $this->getProperties();
        return array_key_exists('delayToRemove', $properties) ? $properties['delayToRemove'] : false;
    }

    public function enaDelay()
    {
        $properties = $this->getProperties();
        $properties['delay'] = true;
        $this->setProperties($properties);
        return $this;
    }

    public function disDelay()
    {
        $properties = $this->getProperties();
        $properties['delay'] = false;
        $this->setProperties($properties);
        return $this;
    }

    public function setIconSource($iconSource = self::ODMESSAGEICON_BOOTSTRAP)
    {
        $iconsSource    = $this->getIconsContants();
        $iconSource     = (string) $iconSource;
        if (!in_array($iconSource, $iconsSource)) { $iconSource = self::ODMESSAGEICON_BOOTSTRAP; }

        $properties = $this->getProperties();
        $properties['iconSource'] = $iconSource;
        $this->setProperties($properties);
        return $this;
    }

    public function getIconSource()
    {
        $properties = $this->getProperties();
        return array_key_exists('iconSource', $properties) ? $properties['iconSource'] : false;
    }

    public function setMsgType($msgType = self::ODMESSAGETYPE_CONFIRM)
    {
        $msgTypes  = $this->getTypesContants();
        $msgType   = (string) $msgType;
        if (!in_array($msgType, $msgTypes)) { $msgType = self::ODMESSAGETYPE_CONFIRM; }

        $properties = $this->getProperties();
        $properties['msgType'] = $msgType;
        $this->setProperties($properties);
        return $this;
    }

    public function getMsgType()
    {
        $properties = $this->getProperties();
        return array_key_exists('msgType', $properties) ? $properties['msgType'] : false;
    }

    /** **************************************************************************************************
     * méthodes de gestion du type de message confirmation                                               *
     * *************************************************************************************************** */

    public function setTitle($title)
    {
        $title = (string) $title;
        $properties = $this->getProperties();
        $properties['title'] = $title;
        $this->setProperties($properties);
        return $this;
    }

    public function getTitle()
    {
        $properties = $this->getProperties();
        return array_key_exists('title', $properties) ? $properties['title'] : false;
    }

    /** **************************************************************************************************
     * méthodes de gestion du type de message prompt                                                     *
     * *************************************************************************************************** */

    public function setType($type = self::ODMESSAGEPROMPT_TEXT)
    {
        $types  = $this->getPromptsContants();
        $type   = (string) $type;
        if (!in_array($type, $types)) { $type = self::ODMESSAGEPROMPT_TEXT; }

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
    
    public function enaMultiline()
    {
        $properties = $this->getProperties();
        $properties['multiline'] = true;
        $this->setProperties($properties);
        return $this;
    }

    public function disMultiline()
    {
        $properties = $this->getProperties();
        $properties['multiline'] = false;
        $this->setProperties($properties);
        return $this;
    }

    public function setLineNumber($lineNumber = 1)
    {
        $properties = $this->getProperties();
        if ($properties['multiline']) {
            $lineNumber = (int) $lineNumber;
            if ($lineNumber == 0) { $lineNumber = 1; }

            $properties = $this->getProperties();
            $properties['lines'] = $lineNumber;
            $this->setProperties($properties);
            return $this;
        }
        return false;
    }

    public function getLineNumber()
    {
        $properties = $this->getProperties();
        return array_key_exists('lines', $properties) ? $properties['lines'] : false;
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

    public function enaRequired()
    {
        $properties = $this->getProperties();
        $properties['required'] = true;
        $this->setProperties($properties);
        return $this;
    }

    public function disRequired()
    {
        $properties = $this->getProperties();
        $properties['required'] = false;
        $this->setProperties($properties);
        return $this;
    }

    public function setErrorMessage($errorMessage = '')
    {
        $errorMessage = (string) $errorMessage;
        $properties = $this->getProperties();
        $properties['errorMessage'] = $errorMessage;
        $this->setProperties($properties);
        return $this;
    }

    public function getErrorMessage()
    {
        $properties = $this->getProperties();
        return array_key_exists('errorMessage', $properties) ? $properties['errorMessage'] : false;
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