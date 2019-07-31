<?php

namespace GraphicObjectTemplating\OObjects\ODContained;

use GraphicObjectTemplating\OObjects\ODContained;

/**
 * Class ODSpan
 * @package GraphicObjectTemplating\OObjects\ODContained
 *
 * setContent($content)
 * getContent()
 */
class ODSpan extends ODContained
{
    public function __construct(string $id, array $pathObjArray = []) {
        $pathObjArray[] = "oobjects/odcontained/odspan/odspan";
        parent::__construct($id, $pathObjArray);

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
        $properties['contenu'] = $content;
        $this->setProperties($properties);
        return $this;
    }

    public function getContent()
    {
        $properties = $this->getProperties();
        return array_key_exists('contenu', $properties) ? $properties['content'] : false;
    }
}
