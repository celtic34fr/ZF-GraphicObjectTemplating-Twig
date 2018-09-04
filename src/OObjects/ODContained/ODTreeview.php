<?php

namespace GraphicObjectTemplating\OObjects\ODContained;


use GraphicObjectTemplating\OObjects\ODContained;

class ODTreeview extends ODContained
{
    public function __construct($id) {
        parent::__construct($id, "oobjects/odcontained/odtreeview/odtreeview.config.php");

        $properties = $this->getProperties();
        if ($properties['id']) {
            $this->setDisplay();
            $width = $this->getWidthBT();
            if (!is_array($width) || empty($width)) $this->setWidthBT(12);
            $this->enable();
        }
        return $this;
    }

    public function addLeaf($value, $libel, $parent = null)
    {
        $value = (string) $value;
        $libel = (string) $libel;
        if (!empty($value) & !empty($libel)) {
            $properties = $this->getProperties();
            $dataTree   = $properties['dataTree'];
            $datePlain  = $properties['datatPlain'];
        }
        return false;
    }
}