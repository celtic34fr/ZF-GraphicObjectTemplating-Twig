<?php

namespace GraphicObjectTemplating\OObjects\ODContained;


use GraphicObjectTemplating\OObjects\ODContained;

class ODMessage extends ODContained
{
    public function __construct($id) {
        parent::__construct($id, 'oobjects/odcontained/odmessage/odmessage.config.php');

        $properties = $this->getProperties();
        if ($properties['id']) {
            $this->setDisplay(self::DISPLAY_BLOCK);
            $this->enable();
        }
        return $this;
    }

}