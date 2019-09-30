<?php

namespace GraphicObjectTemplating\OObjects\ODContained;

use Exception;
use GraphicObjectTemplating\OObjects\ODContained;
use GraphicObjectTemplating\OObjects\OObject;
use ReflectionException;
use Zend\ServiceManager\ServiceManager;

/**
 * Class ODMessage
 * @package GraphicObjectTemplating\OObjects\ODContained
 *
 * setAction($action = self::ODMESSAGEACTION_INIT)
 *                  : méthode de positionnement de l'action à réaliser en focntion de celles autorisées
 * getAction()      : méthode de récupération de l'action à réaliser
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
 * setBody($body)
 * getBody()
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
 * evtCallback($type, $class, $method, $stopEvent = false)
 * disCallback($type)
 * disCallbacks()
 *
 * méthodes de customisation des boutons
 * -------------------------------------
 * setOkButton($label, $value = null, $classView = self::ODMESSAGEBTNCLASSES_DEFAULT, $closeOnClick = true)
 * getOkButton()
 * setCancelButton($label, $value = null, $classView = self::ODMESSAGEBTNCLASSES_DEFAULT, $closeOnClick = true)
 * getCancelButton()
 * setYesButton($label, $value = null, $classView = self::ODMESSAGEBTNCLASSES_DEFAULT, $closeOnClick = true)
 * getYesButton()
 * setNoButton($label, $value = null, $classView = self::ODMESSAGEBTNCLASSES_DEFAULT, $closeOnClick = true)
 * setNoButton()
 * setCustomButton($label, $value, $classView = self::ODMESSAGEBTNCLASSES_DEFAULT, $closeOnClick = true)
 * getCustomButton()
 * setButton($type, $label, $classView, $closeOnClick = true)
 * clearButton();
 *
 * méthodes privées de la classe
 * -----------------------------
 * getActionsContants()
 * getTypesContants()
 * getPromptsContants()
 * getBtnAlignsContants()
 * getWindowLoadsContants()
 * getIconsContants()
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
    const ODMESSAGEBTNCLASSES_PRIMARY   = 'btn btn-PRIMAY';
    const ODMESSAGEBTNCLASSES_DEFAULT   = 'btn btn-default';

    const ODMESSAGEMSGNATURE_INFO       = 'info';
    const ODMESSAGEMSGNATURE_SUCCESS    = 'success';
    const ODMESSAGEMSGNATURE_ERROR      = 'error';
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


    /**
     * ODMessage constructor.
     * @param string $id
     * @param array|null $pathObjArray
     * @throws ReflectionException
     * @throws Exception
     */
    public function __construct(string $id, array $pathObjArray = []) {
        $pathObjArray[] = 'oobjects/odcontained/odmessage/odmessage';
        parent::__construct($id, $pathObjArray);

        $properties = $this->getProperties();
        if ($properties['id']) {
            $this->setDisplay(self::DISPLAY_BLOCK);
            $this->enable();
        }

        $this->saveProperties();
        return $this;
    }

    /**
     * méthode de positionnement de l'action à réaliser en focntion de celles autorisées
     * @param string $action
     * @return $this
     * @throws ReflectionException
     */
    public function setAction($action = self::ODMESSAGEACTION_INIT)
    {
        $actions = $this->getActionsContants();
        if (!in_array($action, $actions)) $action = self::ODMESSAGEACTION_INIT;

        $properties           = $this->getProperties();
        $properties['action'] = $action;
        $this->setProperties($properties);
        return $this;
    }

    /**
     * méthode de récupération de l'action à réaliser
     * @return bool|string
     */
    public function getAction()
    {
        $properties                              = $this->getProperties();
        return (array_key_exists('action', $properties)) ? $properties['action'] : false ;
    }

    /**
     * @param int $offset
     * @return ODMessage
     * @throws Exception
     */
    public function setHorizontalOffset($offset = 5)
    {
        $offset = (int) $offset;
        if ($offset < 1) { $offset = 5; }
        $properties = $this->getProperties();
        $properties['horizontalOffset'] = $offset;
        $this->setProperties($properties);
        return $this;
    }

    /**
     * @return bool|string
     */
    public function getHorizontalOffset()
    {
        $properties = $this->getProperties();
        return array_key_exists('horizontalOffset', $properties) ? $properties['horizontalOffset'] : false;
    }

    /**
     * @param int $offset
     * @return ODMessage
     * @throws Exception
     */
    public function setVerticalOffset($offset = 5)
    {
        $offset = (int) $offset;
        if ($offset < 1) { $offset = 5; }
        $properties = $this->getProperties();
        $properties['verticalOffset'] = $offset;
        $this->setProperties($properties);
        return $this;
    }

    /**
     * @return bool|string
     */
    public function getVerticalOffset()
    {
        $properties = $this->getProperties();
        return array_key_exists('verticalOffset', $properties) ? $properties['verticalOffset'] : false;
    }

    /**
     * @param $width
     * @return ODMessage
     * @throws Exception
     */
    public function setWidth($width)
    {
        if ($width != 'auto') { $width = ((int) $width > 0) ? (int) $width : 400; }
        $properties = $this->getProperties();
        $properties['width'] = $width;
        $this->setProperties($properties);
        return $this;
    }

    /**
     * @return bool|string
     */
    public function getWidth()
    {
        $properties = $this->getProperties();
        return array_key_exists('width', $properties) ? $properties['width'] : false;
    }

    /**
     * @param $height
     * @return ODMessage
     * @throws Exception
     */
    public function setHeight($height)
    {
        if ($height != 'auto') { $height = ((int) $height > 0) ? (int) $height : 400; }
        $properties = $this->getProperties();
        $properties['height'] = $height;
        $this->setProperties($properties);
        return $this;
    }

    /**
     * @return bool|string
     */
    public function getHeight()
    {
        $properties = $this->getProperties();
        return array_key_exists('height', $properties) ? $properties['height'] : false;
    }

    /**
     * @return ODMessage
     * @throws Exception
     */
    public function enaCloseButton()
    {
        $properties = $this->getProperties();
        $properties['closeButton'] = self::BOOLEAN_TRUE;
        $this->setProperties($properties);
        return $this;
    }

    /**
     * @return ODMessage
     * @throws Exception
     */
    public function disCloseButton()
    {
        $properties = $this->getProperties();
        $properties['closeButton'] = self::BOOLEAN_FALSE;
        $this->setProperties($properties);
        return $this;
    }

    /**
     * @return bool|string
     */
    public function getCloseButton()
    {
        $properties = $this->getProperties();
        return array_key_exists('closeButton', $properties) ? $properties['closeButton'] : false;
    }

    /**
     * @param string $buttonAlign
     * @return ODMessage
     * @throws ReflectionException
     */
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

    /**
     * @return bool|string
     */
    public function getButtonAlign()
    {
        $properties = $this->getProperties();
        return array_key_exists('buttonAlign', $properties) ? $properties['buttonAlign'] : false;
    }

    /**
     * @return ODMessage
     * @throws Exception
     */
    public function enaCloseOnEsc()
    {
        $properties = $this->getProperties();
        $properties['closeOnEsc'] = self::BOOLEAN_TRUE;
        $this->setProperties($properties);
        return $this;
    }

    /**
     * @return ODMessage
     * @throws Exception
     */
    public function disCloseOnEsc()
    {
        $properties = $this->getProperties();
        $properties['closeOnEsc'] = self::BOOLEAN_FALSE;
        $this->setProperties($properties);
        return $this;
    }

    /**
     * @return bool|bool
     */
    public function getCloseOnEsc()
    {
        $properties = $this->getProperties();
        return array_key_exists('closeOnEsc', $properties) ? $properties['closeOnEsc'] : false;
    }

    /**
     * @param int $delayToRemove
     * @return ODMessage
     * @throws Exception
     */
    public function setDelayToRemove($delayToRemove = 200)
    {
        $delayToRemove = (int) $delayToRemove;
        if ($delayToRemove == 0) { $delayToRemove = 200; }

        $properties = $this->getProperties();
        $properties['delayToRemove'] = $delayToRemove;
        $this->setProperties($properties);
        return $this;
    }

    /**
     * @return bool|int
     */
    public function getDelayToRemove()
    {
        $properties = $this->getProperties();
        return array_key_exists('delayToRemove', $properties) ? $properties['delayToRemove'] : false;
    }

    /**
     * @return ODMessage
     * @throws Exception
     */
    public function enaDelay()
    {
        $properties = $this->getProperties();
        $properties['delay'] = self::BOOLEAN_TRUE;
        $this->setProperties($properties);
        return $this;
    }

    /**
     * @return ODMessage
     * @throws Exception
     */
    public function disDelay()
    {
        $properties = $this->getProperties();
        $properties['delay'] = self::BOOLEAN_FALSE;
        $this->setProperties($properties);
        return $this;
    }

    /**
     * @return bool
     */
    public function getDelay()
    {
        $properties = $this->getProperties();
        return array_key_exists('delay', $properties) ? $properties['delay'] : false;
    }

    /**
     * @param string $iconSource
     * @return ODMessage
     * @throws ReflectionException
     */
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

    /**
     * @return bool|string
     */
    public function getIconSource()
    {
        $properties = $this->getProperties();
        return array_key_exists('iconSource', $properties) ? $properties['iconSource'] : false;
    }

    /**
     * @param string $msgType
     * @return ODMessage
     * @throws ReflectionException
     */
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

    /**
     * @return bool|string
     */
    public function getMsgType()
    {
        $properties = $this->getProperties();
        return array_key_exists('msgType', $properties) ? $properties['msgType'] : false;
    }

    /** **************************************************************************************************
     * méthodes de gestion du type de message confirmation                                               *
     * *************************************************************************************************** */

    /**
     * @param $title
     * @return ODMessage
     * @throws Exception
     */
    public function setTitle($title)
    {
        $title = (string) $title;
        $properties = $this->getProperties();
        $properties['title'] = $title;
        $this->setProperties($properties);
        return $this;
    }

    /**
     * @return bool|string
     */
    public function getTitle()
    {
        $properties = $this->getProperties();
        return array_key_exists('title', $properties) ? $properties['title'] : false;
    }

    /**
     * @param $body
     * @return ODMessage
     * @throws Exception
     */
    public function setBody($body)
    {
        $body = (string) $body;
        $properties = $this->getProperties();
        $properties['body'] = $body;
        $this->setProperties($properties);
        return $this;
    }

    /**
     * @return bool|string
     */
    public function getBody()
    {
        $properties = $this->getProperties();
        return array_key_exists('body', $properties) ? $properties['body'] : false;
    }

    /**
     * @param string $nature
     * @return ODMessage
     * @throws ReflectionException
     */
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

    /**
     * @return bool|string
     */
    public function getNature()
    {
        $properties = $this->getProperties();
        return array_key_exists('nature', $properties) ? $properties['nature'] : false;
    }

    /**
     * @param $type
     * @param $class
     * @param $method
     * @param bool $stopEvent
     * @return ODMessage|bool
     * @throws Exception
     */
    public function evtCallback($type, $class, $method, $stopEvent = false)
    {
        $type       = (string) $type;
        $class      = (string) $class;
        $method     = (string) $method;

        if (!empty($class) && !empty($method) && !empty($type)) {
            $rslt = $this->setEvent('click', $class, $method, $stopEvent);
            if ($rslt) {
                $properties     = $this->getProperties();
                $click          = $properties['event']['click'];
                unset($properties['event']['click']);
                if (!array_key_exists($type, $properties['event'])) { $properties['event'][$type] = []; }
                $properties['event'][$type] = $click;

                $this->setProperties($properties);
                return $this;
            }
        }
        return false;
    }

    /**
     * @param $type
     * @return ODMessage|bool
     * @throws Exception
     */
    public function disCallback($type)
    {
        $properties     = $this->getProperties();
        $event          = $properties['event'];
        if (array_key_exists($type, $event)) {
            unset($event[$type]);
            $properties['event']    = $event;

            $this->setProperties($properties);
            return $this;
        }
        return false;
    }

    /**
     * @return ODMessage
     * @throws Exception
     */
    public function disCallbacks()
    {
        $properties     = $this->getProperties();
        $properties['event'] = [];
        $this->setProperties($properties);
        return $this;
    }

    /** **************************************************************************************************
     * méthodes de gestion du type de message prompt                                                     *
     * *************************************************************************************************** */

    /**
     * @param string $type
     * @return ODMessage
     * @throws ReflectionException
     */
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

    /**
     * @return bool|string
     */
    public function getType()
    {
        $properties = $this->getProperties();
        return array_key_exists('type', $properties) ? $properties['type'] : false;
    }

    /**
     * @return ODMessage
     * @throws Exception
     */
    public function enaMultiline()
    {
        $properties = $this->getProperties();
        $properties['multiline'] = self::BOOLEAN_TRUE;
        $this->setProperties($properties);
        return $this;
    }

    /**
     * @return ODMessage
     * @throws Exception
     */
    public function disMultiline()
    {
        $properties = $this->getProperties();
        $properties['multiline'] = self::BOOLEAN_FALSE;
        $this->setProperties($properties);
        return $this;
    }

    /**
     * @return bool
     */
    public function getMultiline()
    {
        $properties = $this->getProperties();
        return array_key_exists('multiline', $properties) ? $properties['multiline'] : false;
    }

    /**
     * @param int $lineNumber
     * @return ODMessage|bool
     * @throws Exception
     */
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

    /**
     * @return bool|int
     */
    public function getLineNumber()
    {
        $properties = $this->getProperties();
        return array_key_exists('lines', $properties) ? $properties['lines'] : false;
    }

    /**
     * @param $label
     * @return ODMessage
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
     * @return ODMessage
     * @throws Exception
     */
    public function enaRequired()
    {
        $properties = $this->getProperties();
        $properties['required'] = self::BOOLEAN_TRUE;
        $this->setProperties($properties);
        return $this;
    }

    /**
     * @return ODMessage
     * @throws Exception
     */
    public function disRequired()
    {
        $properties = $this->getProperties();
        $properties['required'] = self::BOOLEAN_FALSE;
        $this->setProperties($properties);
        return $this;
    }

    /**
     * @return bool
     */
    public function getRequired()
    {
        $properties = $this->getProperties();
        return array_key_exists('required', $properties) ? $properties['required'] : false;
    }

    /**
     * @param string $errorMessage
     * @return ODMessage
     * @throws Exception
     */
    public function setErrorMessage($errorMessage = '')
    {
        $errorMessage = (string) $errorMessage;
        $properties = $this->getProperties();
        $properties['errorMessage'] = $errorMessage;
        $this->setProperties($properties);
        return $this;
    }

    /**
     * @return bool|string
     */
    public function getErrorMessage()
    {
        $properties = $this->getProperties();
        return array_key_exists('errorMessage', $properties) ? $properties['errorMessage'] : false;
    }

    /**
     * @param array $attrs
     * @return ODMessage
     * @throws Exception
     */
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

    /**
     * @return bool|array
     */
    public function getAttrs()
    {
        $properties = $this->getProperties();
        return array_key_exists('attrs', $properties) ? $properties['attrs'] : false;
    }

    /** **************************************************************************************************
     * méthodes de gestion du type de message progress                                                   *
     * *************************************************************************************************** */

    /**
     * @return ODMessage
     * @throws Exception
     */
    public function enaProgressLabel()
    {
        $properties = $this->getProperties();
        $properties['showProgressLabel'] = self::BOOLEAN_TRUE;
        $this->setProperties($properties);
        return $this;
    }

    /**
     * @return ODMessage
     * @throws Exception
     */
    public function disProgressLabel()
    {
        $properties = $this->getProperties();
        $properties['showProgressLabel'] = self::BOOLEAN_FALSE;
        $this->setProperties($properties);
        return $this;
    }

    /**
     * @return bool
     */
    public function getProgressLabel()
    {
        $properties = $this->getProperties();
        return array_key_exists('showProgressLabel', $properties) ? $properties['showProgressLabel'] : false;
    }

    /** **************************************************************************************************
     * méthodes de gestion du type de message window                                                     *
     * *************************************************************************************************** */

    /**
     * @param null $content
     * @return ODMessage
     * @throws Exception
     */
    public function setContent($content = null)
    {
        $content = (string) $content;
        $properties = $this->getProperties();
        if (!empty($content)) { $properties['url'] = ''; }
        $properties['content'] = $content;
        $this->setProperties($properties);
        return $this;
    }

    /**
     * @return bool|string
     */
    public function getContent()
    {
        $properties = $this->getProperties();
        return array_key_exists('content', $properties) ? $properties['content'] : false;
    }

    /**
     * @param null $url
     * @return ODMessage
     * @throws Exception
     */
    public function setUrl($url = null)
    {
        $url = (string) $url;
        $properties = $this->getProperties();
        if (!empty($url)) { $properties['content'] = ''; }
        $properties['url'] = $url;
        $this->setProperties($properties);
        return $this;
    }

    /**
     * @return bool|string
     */
    public function getUrl()
    {
        $properties = $this->getProperties();
        return array_key_exists('url', $properties) ? $properties['url'] : false;
    }

    /**
     * @return ODMessage
     * @throws Exception
     */
    public function enaAutoload()
    {
        $properties = $this->getProperties();
        $properties['autoload'] = self::BOOLEAN_TRUE;
        $this->setProperties($properties);
        return $this;
    }

    /**
     * @return ODMessage
     * @throws Exception
     */
    public function disAutoload()
    {
        $properties = $this->getProperties();
        $properties['autoload'] = self::BOOLEAN_FALSE;
        $this->setProperties($properties);
        return $this;
    }

    /**
     * @return bool
     */
    public function getAutoload()
    {
        $properties = $this->getProperties();
        return array_key_exists('autoload', $properties) ? $properties['autoload'] : false;
    }

    /**
     * @param string $method
     * @return ODMessage
     * @throws ReflectionException
     */
    public function setLoadMethod($method = self::ODMESSAGEWINDOWLOAD_GET)
    {
        $methods    = $this->getWindowLoadsContants();
        $method     = (string) $method;
        if (!in_array($method, $methods)) { $method = self::ODMESSAGEWINDOWLOAD_GET; }

        $properties = $this->getProperties();
        $properties['loadMethod'] = $method;
        $this->setProperties($properties);
        return $this;
    }

    /**
     * @return bool|string
     */
    public function getLoadMethod()
    {
        $properties = $this->getProperties();
        return array_key_exists('loadMethod', $properties) ? $properties['loadMethod'] : false;
    }

    /**
     * @return ODMessage
     * @throws Exception
     */
    public function enaShowAfterLoad()
    {
        $properties = $this->getProperties();
        $properties['showAfterLoad'] = self::BOOLEAN_TRUE;
        $this->setProperties($properties);
        return $this;
    }

    /**
     * @return ODMessage
     * @throws Exception
     */
    public function disShowAfterLoad()
    {
        $properties = $this->getProperties();
        $properties['showAfterLoad'] = self::BOOLEAN_FALSE;
        $this->setProperties($properties);
        return $this;
    }

    /**
     * @return bool
     */
    public function getShowAfterLoad()
    {
        $properties = $this->getProperties();
        return array_key_exists('showAfterLoad', $properties) ? $properties['showAfterLoad'] : false;
    }

    /** **************************************************************************************************
     * méthodes de customisation des boutons                                                             *
     * *************************************************************************************************** */

    /**
     * @param $label
     * @param string $classView
     * @param bool $closeOnClick
     * @return ODMessage
     * @throws ReflectionException
     */
    public function setOkButton($label, $classView = self::ODMESSAGEBTNCLASSES_DEFAULT, $closeOnClick = true)
    {
        $label          = (string) $label;
        $classView      = (string) $classView;
        $closeOnClick   = ($closeOnClick && true);

        return $this->setButton('ok', $label, $classView, $closeOnClick);
    }

    /**
     * @return bool|array
     */
    public function getOkButton()
    {
        $properties = $this->getProperties();
        if (array_key_exists('buttons', $properties)) {
            $buttons = $properties['buttons'];
            if (array_key_exists('ok', $buttons)) { return $buttons['ok']; }
        }
        return false;
    }

    /**
     * @param $label
     * @param string $classView
     * @param bool $closeOnClick
     * @return ODMessage
     * @throws ReflectionException
     */
    public function setCancelButton($label, $classView = self::ODMESSAGEBTNCLASSES_DEFAULT, $closeOnClick = true)
    {
        $label          = (string) $label;
        $classView      = (string) $classView;
        $closeOnClick   = ($closeOnClick && true);

        return $this->setButton('cancel', $label, $classView, $closeOnClick);
    }

    /**
     * @return bool|array
     */
    public function getCancelButton()
    {
        $properties = $this->getProperties();
        if (array_key_exists('buttons', $properties)) {
            $buttons = $properties['buttons'];
            if (array_key_exists('cancel', $buttons)) { return $buttons['cancel']; }
        }
        return false;
    }

    /**
     * @param $label
     * @param null $value
     * @param string $classView
     * @param bool $closeOnClick
     * @return ODMessage
     * @throws ReflectionException
     */
    public function setYesButton($label, $value = null, $classView = self::ODMESSAGEBTNCLASSES_DEFAULT, $closeOnClick = true)
    {
        $label          = (string) $label;
        $classView      = (string) $classView;
        $closeOnClick   = ($closeOnClick && true);

        return $this->setButton('yes', $label, $value, $classView, $closeOnClick);
    }

    /**
     * @return bool|array
     */
    public function getYesButton()
    {
        $properties = $this->getProperties();
        if (array_key_exists('buttons', $properties)) {
            $buttons = $properties['buttons'];
            if (array_key_exists('yes', $buttons)) { return $buttons['cancel']; }
        }
        return false;
    }

    /**
     * @param $label
     * @param null $value
     * @param string $classView
     * @param bool $closeOnClick
     * @return ODMessage
     * @throws ReflectionException
     */
    public function setNoButton($label, $value = null, $classView = self::ODMESSAGEBTNCLASSES_DEFAULT, $closeOnClick = true)
    {
        $label          = (string) $label;
        $classView      = (string) $classView;
        $closeOnClick   = ($closeOnClick && true);

        return $this->setButton('no', $label, $value, $classView, $closeOnClick);
    }

    /**
     * @return bool|array
     */
    public function getNoButton()
    {
        $properties = $this->getProperties();
        if (array_key_exists('buttons', $properties)) {
            $buttons = $properties['buttons'];
            if (array_key_exists('no', $buttons)) { return $buttons['cancel']; }
        }
        return false;
    }

    /**
     * @param string $label
     * @param $value
     * @param string $type
     * @param string $classView
     * @param bool $closeOnClick
     * @return ODMessage
     * @throws ReflectionException
     */
    public function setCustomButton(string $label, $value, string $type = 'custom',
                                    string $classView = self::ODMESSAGEBTNCLASSES_DEFAULT, bool $closeOnClick = true)
    {
        $properties = $this->getProperties();
        $buttons    = [];
        if (array_key_exists('buttons', $properties)) {
            $buttons = $properties['buttons'];
            if (array_key_exists('yes', $buttons))      { unset($buttons['yes']); }
            if (array_key_exists('no', $buttons))       { unset($buttons['no']); }
            if (array_key_exists('ok', $buttons))       { unset($buttons['ok']); }
            if (array_key_exists('cancel', $buttons))   { unset($buttons['cancel']); }
        }
        if ($type == 'custom') { $type =$type.sizeof($buttons); }
        return $this->setButton($type, $label, $value = null, $classView, $closeOnClick);
    }

    /**
     * @return bool|array
     */
    public function getCustomButton()
    {
        $properties = $this->getProperties();
        if (array_key_exists('buttons', $properties)) {
            $buttons = $properties['buttons'];
            if (array_key_exists('yes', $buttons))      { unset($buttons['yes']); }
            if (array_key_exists('no', $buttons))       { unset($buttons['no']); }
            if (array_key_exists('ok', $buttons))       { unset($buttons['ok']); }
            if (array_key_exists('cancel', $buttons))   { unset($buttons['cancel']); }

            return $buttons;
        }
        return false;
    }

    /**
     * @param $type
     * @param $label
     * @param null $value
     * @param string $classView
     * @param bool $closeOnClick
     * @return ODMessage
     * @throws ReflectionException
     */
    public function setButton($type, $label, $value = null, $classView = self::ODMESSAGEBTNCLASSES_DEFAULT, $closeOnClick = true)
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
        if (!empty($value)) { $btn['value']     = $value; }

        $properties['buttons'][$type] = $btn;
        $this->setProperties($properties);
        return $this;
    }

    /**
     * @return ODMessage
     * @throws Exception
     */
    public function clearButton()
    {
        $properties = $this->getProperties();
        $properties['buttons'] = [];
        $this->setProperties($properties);
        return $this;
    }

    /** **************************************************************************************************
     * méthodes de gestion de retour de callback                                                         *
     * *************************************************************************************************** */

    /**
     * @param ServiceManager $serviceManager
     * @param array $params
     * @return array|bool
     * @throws Exception
     */
    public function dispatchEvents(ServiceManager $serviceManager, array $params)
    {
        $sessionObj     = OObject::validateSession();
        /** @var ODMessage $message */
        $message        = OObject::buildObject($params['id'], $sessionObj);
        $type           = (string) $params['type'];
        $events         = $message->getEvents();
        $ret            = [];
        if (!empty($events)) {
            $keys = array_keys($events);
            if (array_key_exists($type, $events)) {
                $event      = $events[$type];

                $class      = (array_key_exists('class', $event)) ? $event['class'] : "";
                $method     = (array_key_exists('method', $event)) ? $event['method'] : "";
                if (!empty($class) && !empty($method)) {
                    $callObj = new $class();
                    $retCallObj = call_user_func_array([$callObj, $method], [$serviceManager, $params]);
                    foreach ($retCallObj as $item) {
                        array_push($ret, $item);
                    }

                    return $ret;
                }
            }
        }
        return false;
    }

    /** **************************************************************************************************
     * méthodes privées de la classe                                                                     *
     * *************************************************************************************************** */

    /**
     * @return array
     * @throws ReflectionException
     */
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

    /**
     * @return array
     * @throws ReflectionException
     */
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

    /**
     * @return array
     * @throws ReflectionException
     */
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

    /**
     * @return array
     * @throws ReflectionException
     */
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

    /**
     * @return array
     * @throws ReflectionException
     */
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

    /**
     * @return array
     * @throws ReflectionException
     */
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

    /**
     * @return array
     * @throws ReflectionException
     */
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

    /**
     * @return array
     * @throws ReflectionException
     */
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