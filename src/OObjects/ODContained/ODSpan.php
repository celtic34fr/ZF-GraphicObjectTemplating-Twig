<?php

namespace GraphicObjectTemplating\OObjects\ODContained;

use GraphicObjectTemplating\OObjects\ODContained;

/**
 * Class ODSpan
 * @package ZF3_GOT\OObjects\ODContained
 *
 * setContent($content)
 * getContent()
 */
class ODSpan extends ODContained
{
    public function __construct($id) {
        parent::__construct($id, "oobjects/odcontained/odspan/odspan.config.php");

        $properties = $this->getProperties();
        if ($properties['id'] != 'dummy') {
            $this->setDisplay();
            $width = $this->getWidthBT();
            if (!is_array($width) || empty($width)) $this->setWidthBT(12);
            $this->enable();
        }

        $this->saveProperties();
        return $this;
    }

    public function setContent($content)
    {
        $content    = (string) $content;
        $properties = $this->getProperties();
        $properties['content'] = $content;
        $this->setProperties($properties);
        return $this;
    }

    public function getContent()
    {
        $properties = $this->getProperties();
        return array_key_exists('content', $properties) ? $properties['content'] : false;
    }
}
