<?php
/**
 * Created by PhpStorm.
 * User: candidat
 * Date: 17/05/18
 * Time: 10:35
 */

namespace GraphicObjectTemplating\OObjects;

use GraphicObjectTemplating\OObjects\OObject;

class OEObject extends OObject
{
    public function __construct($id, $pathConfig, $className)
    {
        parent::__construct($id);
    }
}