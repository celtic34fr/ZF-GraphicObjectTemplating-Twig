<?php
/**
 * Created by PhpStorm.
 * User: candidat
 * Date: 17/05/18
 * Time: 14:08
 */

namespace GraphicObjectTemplating\OObjects;

use GraphicObjectTemplating\OObjects\OEObject;
use GraphicObjectTemplating\OObjects\ODContained;

class OEDContained extends OEObject
{
    private $_tExtends        = ODContained::class;
    private $_tExtendIntances = "";

    public function __construct($id, $pathConfig, $className) {
        parent::__construct($id, $pathConfig, $className);
        $this->_tExtendIntances = new $this->_tExtends($id);
        return $this;
    }

    public function __call($funcName, $tArgs)
    {
        if(method_exists($this->_tExtendIntances, $funcName))
        { return call_user_func_array(array($this->_tExtendIntances, $funcName), $tArgs); }
        throw new Exception("The $funcName method doesn't exist");
    }

    public function setTExtendInstances(OObject $object)
    {
        $this->_tExtendIntances = $object;
        return $this;
    }
}