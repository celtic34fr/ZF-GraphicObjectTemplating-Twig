<?php

namespace GraphicObjectTemplating\OObjects\ODContained;

use GraphicObjectTemplating\OObjects\ODContained;

class ODImage extends ODContained
{
    public function __construct($id) {
        parent::__construct($id, "oobjects/odcontained/odimage/odimage.config.php");

        $properties = $this->getProperties();
        if ($properties['id'] != 'dummy') {
            if (!$this->getWidthBT() || empty($this->getWidthBT())) {
                $this->setWidthBT(12);
            }
            $this->setDisplay(self::DISPLAY_BLOCK);
            $this->enable();
        }

        $this->saveProperties();
        return $this;
    }

    public function setUrl($url)
    {
        $url                 = (string) $url;
        $properties          = $this->getProperties();
        $properties['url']   = $url;
        $this->setProperties($properties);
        return $this;
    }

    public function getUrl()
    {
        $properties          = $this->getProperties();
        return ((!empty($properties['url'])) ? $properties['url'] : false) ;
    }

    public function setAlt($alt)
    {
        $alt                 = (string) $alt;
        $properties          = $this->getProperties();
        $properties['alt']   = $alt;
        $this->setProperties($properties);
        return $this;
    }

    public function getAlt()
    {
        $properties          = $this->getProperties();
        return ((!empty($properties['alt'])) ? $properties['alt'] : false) ;
    }

    public function setWidth($width)
    {
        $width               = (string) $width;
        $properties          = $this->getProperties();
        $properties['width'] = $width;
        $this->setProperties($properties);
        return $this;
    }

    public function getWidth()
    {
        $properties          = $this->getProperties();
        return ((!empty($properties['width'])) ? $properties['width'] : false) ;
    }

    public function setHeight($height)
    {
        $height               = (int) $height;
        $properties           = $this->getProperties();
        $properties['height'] = $height;
        $this->setProperties($properties);
        return $this;
    }

    public function getHeight()
    {
        $properties          = $this->getProperties();
        return ((!empty($properties['height'])) ? $properties['height'] : false) ;
    }

    public function evtClick($class, $method, $stopEvent = true)
    {
        $properties = $this->getProperties();
        if(!isset($properties['event'])) $properties['event'] = [];
        $properties['event']['click'] = [];
        $properties['event']['click']['class'] = $class;
        $properties['event']['click']['method'] = $method;
        $properties['event']['click']['stopEvent'] = ($stopEvent) ? 'OUI' : 'NON';
        $this->setProperties($properties);
        return $this;
    }

    public function disClick()
    {
        $properties             = $this->getProperties();
        if (isset($properties['event']['click'])) unset($properties['event']['click']);
        $this->setProperties($properties);
        return $this;
    }
}