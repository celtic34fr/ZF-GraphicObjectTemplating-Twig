<?php

namespace GraphicObjectTemplating\OObjects\ODContained;

use GraphicObjectTemplating\OObjects\ODContained;
use GraphicObjectTemplating\OObjects\OEObject;
use GraphicObjectTemplating\OObjects\OObject;

/**
 * Class ODNotification
 * @package GraphicObjectTemplating\Objects\ODContained
 *
 * fait avec le plugin jQuery Lobibox
 * (http://lobianijs.com/site/lobibox)
 *
 * setAction($action = self::NOTIFICATIONACTION_INIT)
 * getAction
 * statusSound
 * enaSound
 * disSound
 * toggleSound
 * setPosition($position = self::NOTIFICATIONPOSITION_BR)
 * getPosition
 * setTitle($title = "")
 * getTitle
 * setBody($body = "")
 * getBody
 * setType($type = self::NOTIFICATIONTYPE_INFO)
 * getType
 * setDelay($delay = 3000)
 * getDelay
 * setSize($size = self::NOTIFICATIONSIZE_NORMAL)
 * getSize
 * enaDistinctMessage()
 * disDistinctMessage()
 * setDelayMessage($delayMessage = 2000)
 * getDelayMessage()
 * setWidth($width)
 * getWidth()
 * setHeight($height)
 * getHeight()
 *
 * méthodes privées de la classe
 * -----------------------------
 * getActionsContants()
 * getPositionsContants()
 * getTypesContants()
 * getSizesContants()
 **/
class ODNotification extends ODContained
{

    const NOTIFICATIONACTION_INIT   = 'init';
    const NOTIFICATIONACTION_SEND   = 'send';

    const NOTIFICATIONPOSITION_BR   = 'bottom right';
    const NOTIFICATIONPOSITION_BL   = 'bottom left';
    const NOTIFICATIONPOSITION_TR   = 'top right';
    const NOTIFICATIONPOSITION_TL   = 'top left';

    const NOTIFICATIONTYPE_INFO     = 'info';
    const NOTIFICATIONTYPE_SUCCESS  = 'success';
    const NOTIFICATIONTYPE_WARNING  = 'warning';
    const NOTIFICATIONTYPE_ERROR    = 'error';

    const NOTIFICATIONSIZE_MINI     = 'mini';
    const NOTIFICATIONSIZE_NORMAL   = 'normal';
    const NOTIFICATIONSIZE_LARGE    = 'large';

    protected $const_NotificationAction;
    protected $const_NotificationPosition;
    protected $const_NotificationType;
    protected $const_NotificationSize;

    public function __construct($id) {
        parent::__construct($id, 'oobjects/odcontained/odnotification/odnotification.config.php');

        $properties = $this->getProperties();
        if ($properties['id']) {
            $this->setDisplay(OObject::DISPLAY_BLOCK);
            $this->enable();
        }
        return $this;
    }

    public function setAction($action = self::NOTIFICATIONACTION_INIT)
    {
        $actions = $this->getActionsContants();
        if (!in_array($action, $actions)) $action = self::NOTIFICATIONACTION_INIT;

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

    public function statusSound()
    {
        $properties           = $this->getProperties();
        $sound   = $properties['sound'];
        return (($sound === true) ? 'enable' : 'disable');
    }

    public function enaSound()
    {
        $properties          = $this->getProperties();
        $properties['sound'] = true;
        $this->setProperties($properties);
        return $this;
    }

    public function disSound()
    {
        $properties          = $this->getProperties();
        $properties['sound'] = false;
        $this->setProperties($properties);
        return $this;
    }

    public function toggleSound()
    {
        $properties          = $this->getProperties();
        $properties['sound'] = !$properties['sound'];
        $this->setProperties($properties);
        return $this;
    }

    public function setPosition($position = self::NOTIFICATIONPOSITION_BR)
    {
        $positions = $this->getPositionsContants();
        if(!in_array($position, $positions)) $position = self::NOTIFICATIONPOSITION_BR;

        $properties             = $this->getProperties();
        $properties['position'] = $position;
        $this->setProperties($properties);
        return $this;
    }

    public function getPosition()
    {
        $properties             = $this->getProperties();
        return (array_key_exists('position', $properties)) ? $properties['position'] : false ;
    }

    public function setTitle($title = "")
    {
        $title = (string) $title;
        $properties = $this->getProperties();
        $properties['title'] = $title;
        $this->setProperties($properties);
        return $this;
    }

    public function getTitle()
    {
        $properties             = $this->getProperties();
        return (array_key_exists('title', $properties)) ? $properties['title'] : false ;
    }

    public function setBody($body = "")
    {
        $body = (string) $body;
        $properties = $this->getProperties();
        $properties['body'] = $body;
        $this->setProperties($properties);
        return $this;
    }

    public function getBody()
    {
        $properties             = $this->getProperties();
        return (array_key_exists('body', $properties)) ? $properties['body'] : false ;
    }

    public function setType($type = self::NOTIFICATIONTYPE_INFO)
    {
        $types = $this->getTypesContants();
        if(!in_array($type, $types)) $type = self::NOTIFICATIONTYPE_INFO;

        $properties             = $this->getProperties();
        $properties['type']     = $type;
        $this->setProperties($properties);
        return $this;
    }

    public function getType()
    {
        $properties             = $this->getProperties();
        return (array_key_exists('type', $properties)) ? $properties['type'] : false ;
    }

    public function setDelay($delay = 3000)
    {
        $delay = (int) $delay;
        $properties = $this->getProperties();
        $properties['delay'] = $delay;
        $this->setProperties($properties);
        return $this;
    }

    public function getDelay()
    {
        $properties             = $this->getProperties();
        return (array_key_exists('delay', $properties)) ? $properties['delay'] : false ;
    }

    public function setSize($size = self::NOTIFICATIONSIZE_NORMAL)
    {
        $sizes = $this->getSizesContants();
        if(!in_array($size, $sizes)) $size = self::NOTIFICATIONSIZE_NORMAL;

        $properties             = $this->getProperties();
        $properties['size']     = $size;
        $this->setProperties($properties);
        return $this;
    }

    public function getSize()
    {
        $properties             = $this->getProperties();
        return ((!empty($properties['title'])) ? $properties['title'] : false) ;
    }

    public function enaDistinctMessage()
    {
        $properties = $this->getProperties();
        $properties['showAfterPrevious'] = true;
        $this->setProperties($properties);
        return $this;
    }

    public function disDistinctMessage()
    {
        $properties = $this->getProperties();
        $properties['showAfterPrevious'] = false;
        $this->setProperties($properties);
        return $this;
    }

    public function setDelayMessage($delayMessage = 2000)
    {
        $delayMessage = (int) $delayMessage;
        if ($delayMessage == 0) $delayMessage = 2000;

        $properties = $this->getProperties();
        $properties['delayMessage'] = $delayMessage;
        $this->setProperties($properties);
        return $this;
    }

    public function getDelayMessage()
    {
        $properties             = $this->getProperties();
        return (array_key_exists('delayMessage', $properties)) ? $properties['delayMessage'] : false ;
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

    private function getActionsContants()
    {
        $retour = [];
        if (empty($this->const_mesAction)) {
            $constants = $this->getConstants();
            foreach ($constants as $key => $constant) {
                $pos = strpos($key, 'NOTIFICATIONACTION_');
                if ($pos !== false) $retour[$key] = $constant;
            }
            $this->const_NotificationAction = $retour;
        } else {
            $retour = $this->const_NotificationAction;
        }
        return $retour;
    }

    private function getPositionsContants()
    {
        $retour = [];
        if (empty($this->const_NotificationPosition)) {
            $constants = $this->getConstants();
            foreach ($constants as $key => $constant) {
                $pos = strpos($key, 'NOTIFICATIONPOSITION_');
                if ($pos !== false) $retour[$key] = $constant;
            }
            $this->const_NotificationPosition = $retour;
        } else {
            $retour = $this->const_NotificationPosition;
        }
        return $retour;
    }

    private function getTypesContants()
    {
        $retour = [];
        if (empty($this->const_NotificationType)) {
            $constants = $this->getConstants();
            foreach ($constants as $key => $constant) {
                $pos = strpos($key, 'NOTIFICATIONTYPE_');
                if ($pos !== false) $retour[$key] = $constant;
            }
            $this->const_NotificationType = $retour;
        } else {
            $retour = $this->const_NotificationType;
        }
        return $retour;
    }

    private function getSizesContants()
    {
        $retour = [];
        if (empty($this->const_NotificationSize)) {
            $constants = $this->getConstants();
            foreach ($constants as $key => $constant) {
                $pos = strpos($key, 'NOTIFICATIONSIZE_');
                if ($pos !== false) $retour[$key] = $constant;
            }
            $this->const_NotificationSize = $retour;
        } else {
            $retour = $this->const_NotificationSize;
        }
        return $retour;
    }
}