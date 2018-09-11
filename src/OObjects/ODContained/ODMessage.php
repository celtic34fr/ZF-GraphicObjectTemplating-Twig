<?php

namespace GraphicObjectTemplating\OObjects\ODContained;


use GraphicObjectTemplating\OObjects\ODContained;

/**
 * Class ODMessage
 * @package GraphicObjectTemplating\OObjects\ODContained
 *
 * setAction($action = self::ODMESSAGEACTION_INIT)
 * getAction()
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
 * setWidth($width)
 * getWidth()
 * setHeight($height)
 * getHeight()
 *
 * méthodes de gestion du type de message confirmation ou alerte
 * -------------------------------------------------------------
 * setTitle($title)
 * getTitle()
 * setMsgNature($nature = self:ODMESSAGEMSGNATURE_INFO)
 * getMsgNature()
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
 * setAttrs(array $attrs)
 * getAttrs()
 *
 * méthodes de gestion du type de message progress
 * -----------------------------------------------
 * enaProgressLabel()
 * disProgressLabel()
 *
 * méthodes de gestion du type de message window
 * ---------------------------------------------
 * setContent($content = null)
 * getContent()
 * setUrl($url = null)
 * getUrl()
 * enaAutoload()
 * disAutoload()
 * setLoadMethod($method = self::ODMESSAGEWINDOWLOAD_GET)
 * getLoadMethod()
 * enaShowAfterLoad()
 * disShowAfterLoad()
 *
 * méthodes de customisation des boutons
 * -------------------------------------
 * setOkButton($label, $classView, $closeOnClick = true)
 * getOkButton()
 * setCancelButton($label, $classView, $closeOnClick = true)
 * getCancelButton()
 *
 * méthodes privées de la classe
 * -----------------------------
 * getActionsContants()
 * getTypesContants()
 * getPromptsContants()
 * getBtnAlignsContants()
 * getWindowLoadsContants()
 * getIconsContants()
 * setButton($type, $label, $classView, $closeOnClick = true)
 * getBtnClassesContants()
 * getMsgNatureConstants()
 */
class ODMessage extends ODContained
{

    const ODMESSAGEACTION_INIT      = 'init';
    const ODMESSAGEACTION_SEND      = 'send';

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

    const ODMESSAGEBTNCLASSES_SUCCESS   = 'btn btn-success';
    const ODMESSAGEBTNCLASSES_DANGER    = 'btn btn-danger';
    const ODMESSAGEBTNCLASSES_WARNING   = 'btn btn-warning';
    const ODMESSAGEBTNCLASSES_INFO      = 'btn btn-info';
    const ODMESSAGEBTNCLASSES_DEFAULT   = 'btn btn-default';

    const ODMESSAGEMSGNATURE_INFO       = 'info';
    const ODMESSAGEMSGNATURE_SUCCESS    = 'succes';
    const ODMESSAGEMSGNATURE_DANGER     = 'danger';
    const ODMESSAGEMSGNATURE_WARNING    = 'warning';

    const ODMESSAGEPROMPTATTRIBUTES     = ['label', 'placeholder', 'type', 'size', 'maxlength'];

    protected $const_action;
    protected $const_type;
    protected $const_prompt;
    protected $const_btnAlign;
    protected $const_windowLoad;
    protected $const_icon;
    protected $const_btnClasses;
    protected $const_msgNature;


    public function __construct($id) {
        parent::__construct($id, 'oobjects/odcontained/odmessage/odmessage.config.php');

        $properties = $this->getProperties();
        if ($properties['id']) {
            $this->setDisplay(self::DISPLAY_BLOCK);
            $this->enable();
        }
        return $this;
    }

    public function setAction($action = self::ODMESSAGEACTION_INIT)
    {
        $actions = $this->getActionsContants();
        if (!in_array($action, $actions)) $action = self::ODMESSAGEACTION_INIT;

        $properties           = $this->getProperties();
        $properties['action'] = $action;
        $this->setProperties($properties);
        return $this;
    }

    public function getAction()
    {
        $properties                              = $this->getProperties();
        return (array_key_exists('action', $properties)) ? $properties['action'] : false ;
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
        $properties['closeButton'] = self::BOOLEAN_TRUE;
        $this->setProperties($properties);
        return $this;
    }

    public function disCloseButton()
    {
        $properties = $this->getProperties();
        $properties['closeButton'] = self::BOOLEAN_FALSE;
        $this->setProperties($properties);
        return $this;
    }

    public function getCloseButton()
    {
        $properties = $this->getProperties();
        return array_key_exists('closeButton', $properties) ? $properties['closeButton'] : false;
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
        $properties['closeOnEsc'] = self::BOOLEAN_TRUE;
        $this->setProperties($properties);
        return $this;
    }

    public function disCloseOnEsc()
    {
        $properties = $this->getProperties();
        $properties['closeOnEsc'] = self::BOOLEAN_FALSE;
        $this->setProperties($properties);
        return $this;
    }

    public function getCloseOnEsc()
    {
        $properties = $this->getProperties();
        return array_key_exists('closeOnEsc', $properties) ? $properties['closeOnEsc'] : false;
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
        $properties['delay'] = self::BOOLEAN_TRUE;
        $this->setProperties($properties);
        return $this;
    }

    public function disDelay()
    {
        $properties = $this->getProperties();
        $properties['delay'] = self::BOOLEAN_FALSE;
        $this->setProperties($properties);
        return $this;
    }

    public function getDelay()
    {
        $properties = $this->getProperties();
        return array_key_exists('delay', $properties) ? $properties['delay'] : false;
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

    public function setNature($nature = self::ODMESSAGEMSGNATURE_INFO)
    {
        $natures    = $this->getMsgNatureContants();
        $nature     = (string) $nature;
        if (!in_array($nature, $natures)) { $nature = self::ODMESSAGEMSGNATURE_INFO; }

        $properties = $this->getProperties();
        $properties['nature'] = $nature;
        $this->setProperties($properties);
        return $this;
    }

    public function getNature()
    {
        $properties = $this->getProperties();
        return array_key_exists('nature', $properties) ? $properties['nature'] : false;
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
        $properties['multiline'] = self::BOOLEAN_TRUE;
        $this->setProperties($properties);
        return $this;
    }

    public function disMultiline()
    {
        $properties = $this->getProperties();
        $properties['multiline'] = self::BOOLEAN_FALSE;
        $this->setProperties($properties);
        return $this;
    }

    public function getMultiline()
    {
        $properties = $this->getProperties();
        return array_key_exists('multiline', $properties) ? $properties['multiline'] : false;
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
        $properties['required'] = self::BOOLEAN_TRUE;
        $this->setProperties($properties);
        return $this;
    }

    public function disRequired()
    {
        $properties = $this->getProperties();
        $properties['required'] = self::BOOLEAN_FALSE;
        $this->setProperties($properties);
        return $this;
    }

    public function getRequired()
    {
        $properties = $this->getProperties();
        return array_key_exists('required', $properties) ? $properties['required'] : false;
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

    public function setAttrs(array $attrs)
    {
        $properties = $this->getProperties();
        foreach ($attrs as $key => $attr) { // suppression des attributs non autorisés
            if (!in_array($key, self::ODMESSAGEPROMPTATTRIBUTES)) {
                unset($attrs[$key]);
            }
        }

        $properties['attrs'] = $attrs;
        $this->setProperties($properties);
        return $this;
    }

    public function getAttrs()
    {
        $properties = $this->getProperties();
        return array_key_exists('attrs', $properties) ? $properties['attrs'] : false;
    }

    /** **************************************************************************************************
     * méthodes de gestion du type de message progress                                                   *
     * *************************************************************************************************** */

    public function enaProgressLabel()
    {
        $properties = $this->getProperties();
        $properties['showProgressLabel'] = self::BOOLEAN_TRUE;
        $this->setProperties($properties);
        return $this;
    }

    public function disProgressLabel()
    {
        $properties = $this->getProperties();
        $properties['showProgressLabel'] = self::BOOLEAN_FALSE;
        $this->setProperties($properties);
        return $this;
    }

    public function getProgressLabel()
    {
        $properties = $this->getProperties();
        return array_key_exists('showProgressLabel', $properties) ? $properties['showProgressLabel'] : false;
    }

    /** **************************************************************************************************
     * méthodes de gestion du type de message window                                                     *
     * *************************************************************************************************** */

    public function setContent($content = null)
    {
        $content = (string) $content;
        $properties = $this->getProperties();
        if (!empty($content)) { $properties['url'] = ''; }
        $properties['content'] = $content;
        $this->setProperties($properties);
        return $this;
    }

    public function getContent()
    {
        $properties = $this->getProperties();
        return array_key_exists('content', $properties) ? $properties['content'] : false;
    }

    public function setUrl($url = null)
    {
        $url = (string) $url;
        $properties = $this->getProperties();
        if (!empty($url)) { $properties['content'] = ''; }
        $properties['url'] = $url;
        $this->setProperties($properties);
        return $this;
    }

    public function getUrl()
    {
        $properties = $this->getProperties();
        return array_key_exists('url', $properties) ? $properties['url'] : false;
    }

    public function enaAutoload()
    {
        $properties = $this->getProperties();
        $properties['autoload'] = self::BOOLEAN_TRUE;
        $this->setProperties($properties);
        return $this;
    }

    public function disAutoload()
    {
        $properties = $this->getProperties();
        $properties['autoload'] = self::BOOLEAN_FALSE;
        $this->setProperties($properties);
        return $this;
    }

    public function getAutoload()
    {
        $properties = $this->getProperties();
        return array_key_exists('autoload', $properties) ? $properties['autoload'] : false;
    }

    public function setLoadMethod($method = self::ODMESSAGEWINDOWLOAD_GET)
    {
        $methods    = $this->getWindowLoadsContants();
        $method     = (string) $method;
        if (!in_array($method, $methods)) { $method = self::ODMESSAGEWINDOWLOAD_GET; }

        $properties = $this->getProperties();
        $properties['loadMethod'] = $errorMessage;
        $this->setProperties($properties);
        return $this;
    }

    public function getLoadMethod()
    {
        $properties = $this->getProperties();
        return array_key_exists('loadMethod', $properties) ? $properties['loadMethod'] : false;
    }

    public function enaShowAfterLoad()
    {
        $properties = $this->getProperties();
        $properties['showAfterLoad'] = self::BOOLEAN_TRUE;
        $this->setProperties($properties);
        return $this;
    }

    public function disShowAfterLoad()
    {
        $properties = $this->getProperties();
        $properties['showAfterLoad'] = self::BOOLEAN_FALSE;
        $this->setProperties($properties);
        return $this;
    }

    public function getShowAfterLoad()
    {
        $properties = $this->getProperties();
        return array_key_exists('showAfterLoad', $properties) ? $properties['showAfterLoad'] : false;
    }

    /** **************************************************************************************************
     * méthodes de customisation des boutons                                                             *
     * *************************************************************************************************** */

    public function setOkButton($label, $classView = self::ODMESSAGEBTNCLASSES_DEFAULT, $closeOnClick = true)
    {
        $label          = (string) $label;
        $classView      = (string) $classView;
        $closeOnClick   = ($closeOnClick && true);

        return $this->setButton('ok', $label, $classView, $closeOnClick);
    }

    public function getOkButton()
    {
        $properties = $this->getProperties();
        if (array_key_exists('buttons', $properties)) {
            $buttons = $properties['buttons'];
            if (array_key_exists('ok', $buttons)) { return $buttons['ok']; }
        }
        return false;
    }

    public function setCancelButton($label, $classView = self::ODMESSAGEBTNCLASSES_DEFAULT, $closeOnClick = true)
    {
        $label          = (string) $label;
        $classView      = (string) $classView;
        $closeOnClick   = ($closeOnClick && true);

        return $this->setButton('cancel', $label, $classView, $closeOnClick);
    }

    public function getCancelButton()
    {
        $properties = $this->getProperties();
        if (array_key_exists('buttons', $properties)) {
            $buttons = $properties['buttons'];
            if (array_key_exists('cancel', $buttons)) { return $buttons['cancel']; }
        }
        return false;
    }

    public function setYesButton($label, $classView = self::ODMESSAGEBTNCLASSES_DEFAULT, $closeOnClick = true)
    {
        $label          = (string) $label;
        $classView      = (string) $classView;
        $closeOnClick   = ($closeOnClick && true);

        return $this->setButton('yes', $label, $classView, $closeOnClick);
    }

    public function getYesButton()
    {
        $properties = $this->getProperties();
        if (array_key_exists('buttons', $properties)) {
            $buttons = $properties['buttons'];
            if (array_key_exists('yes', $buttons)) { return $buttons['cancel']; }
        }
        return false;
    }

    public function setNoButton($label, $classView = self::ODMESSAGEBTNCLASSES_DEFAULT, $closeOnClick = true)
    {
        $label          = (string) $label;
        $classView      = (string) $classView;
        $closeOnClick   = ($closeOnClick && true);

        return $this->setButton('no', $label, $classView, $closeOnClick);
    }

    public function getNoButton()
    {
        $properties = $this->getProperties();
        if (array_key_exists('buttons', $properties)) {
            $buttons = $properties['buttons'];
            if (array_key_exists('no', $buttons)) { return $buttons['cancel']; }
        }
        return false;
    }

    public function setCustomButton($label, $classView = self::ODMESSAGEBTNCLASSES_DEFAULT, $closeOnClick = true)
    {
        $label          = (string) $label;
        $classView      = (string) $classView;
        $closeOnClick   = ($closeOnClick && true);

        return $this->setButton('custom', $label, $classView, $closeOnClick);
    }

    public function getCustomButton()
    {
        $properties = $this->getProperties();
        if (array_key_exists('buttons', $properties)) {
            $buttons = $properties['buttons'];
            if (array_key_exists('custom', $buttons)) { return $buttons['cancel']; }
        }
        return false;
    }

    /** **************************************************************************************************
     * méthodes privées de la classe                                                                     *
     * *************************************************************************************************** */

    private function getActionsContants()
    {
        $retour = [];
        if (empty($this->const_action)) {
            $constants = $this->getConstants();
            foreach ($constants as $key => $constant) {
                $pos = strpos($key, 'ODMESSAGEACTION_');
                if ($pos !== false) $retour[$key] = $constant;
            }
            $this->const_action = $retour;
        } else {
            $retour = $this->const_action;
        }
        return $retour;
    }

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

    private function setButton($type, $label, $classView = self::ODMESSAGEBTNCLASSES_DEFAULT, $closeOnClick = true)
    {
        $label          = (string) $label;
        $classViews     = $this->getBtnClassesContants();
        $classView      = (string) $classView;
        if (!in_array($classView, $classViews)) { $classView = self::ODMESSAGEBTNCLASSES_DEFAULT; }
        $closeOnClick   = ($closeOnClick && true);

        $properties = $this->getProperties();
        if (!array_key_exists('buttons', $properties)) { $properties['buttons'] = []; }
        if (!array_key_exists($type, $properties['buttons'])) { $properties['buttons'][$type] = []; }

        $btn              = $properties['buttons'][$type];
        $btn['label']     = $label;
        $btn['classes']   = $classView;
        $btn['close']     = ($closeOnClick) ? self::BOOLEAN_TRUE : self::BOOLEAN_FALSE;
        $properties['buttons'][$type] = $btn;
        $this->setProperties($properties);
        return $this;

    }

    private function getBtnClassesContants()
    {
        $retour = [];
        if (empty($this->const_btnClasses)) {
            $constants = $this->getConstants();
            foreach ($constants as $key => $constant) {
                $pos = strpos($key, 'ODMESSAGEBTNCLASSES_');
                if ($pos !== false) $retour[$key] = $constant;
            }
            $this->const_btnClasses = $retour;
        } else {
            $retour = $this->const_btnClasses;
        }
        return $retour;
    }

    private function getMsgNatureContants()
    {
        $retour = [];
        if (empty($this->const_msgNature)) {
            $constants = $this->getConstants();
            foreach ($constants as $key => $constant) {
                $pos = strpos($key, 'ODMESSAGEMSGNATURE_');
                if ($pos !== false) $retour[$key] = $constant;
            }
            $this->const_msgNature = $retour;
        } else {
            $retour = $this->const_msgNature;
        }
        return $retour;
    }
}