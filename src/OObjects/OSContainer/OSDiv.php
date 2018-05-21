<?php

namespace GraphicObjectTemplating\OObjects\OSContainer;


use GraphicObjectTemplating\OObjects\OSContainer;

class OSDiv extends OSContainer
{
    public function __construct($id)
    {
        parent::__construct($id, "oobjects/oscontainer/osdiv/osdiv.config.php");
    }
}