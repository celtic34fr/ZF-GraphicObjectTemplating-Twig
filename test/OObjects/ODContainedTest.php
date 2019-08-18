<?php

namespace GraphicObjectTemplatingTest\OObjects;

use Exception;
use GraphicObjectTemplating\OObjects\ODContained;
use PHPUnit\Framework\TestCase;

class ODContainedTest extends TestCase
{
    protected $traceError   = false;
    protected $object       = "";
    protected $objectArray  = [];

    /**
     * @throws Exception
     */
    public function setUp() :void
    {
        ODContained::destroyObject('test', true);
        $this->object       = new ODContained('test', []);
        $this->objectArray  = $this->object_to_array($this->object);
    }

    /** **************************************************************************************************************
     * méthodes privées
     *************************************************************************************************************** */

    /**
     * @param array $a
     * @param array $b
     * @return bool
     */
    private function arrays_are_similar(array $a, array $b) {
        if (sizeof($a) != sizeof($b)) {
            return false;
        }
        foreach($a as $k => $v) {
            if ($v !== $b[$k]) {
                return false;
            }
        }
        return true;
    }

    /**
     * @param $obj
     * @return array
     */
    private function object_to_array($obj) {
        $array  = (array) $obj;
        $tabObj = [];

        foreach ($array as $key => $attribute) {
            $key = substr($key, strrpos($key, chr(92) )+ 9);
            $tabObj[$key]   = $attribute;
        }
        return $tabObj;
    }

}