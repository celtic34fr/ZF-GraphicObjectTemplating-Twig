<?php

namespace GraphicObjectTemplatingTest\OObjects;

use Exception;
use GraphicObjectTemplating\OObjects\OObject;
use PHPUnit\Framework\TestCase;

class OObjectTest  extends TestCase
{
    protected $traceError = false;

    /**
     * @throws Exception
     */
    public function setUp() :void
    {
        $sessionObject  = OObject::validateSession();
        OObject::destroyObject('test', true);
    }
    /**
     * @throws Exception
     */
    public function testContructor()
    {
        $object             = new OObject('test', []);

        $attrbProperties    = $object->properties;
        $properties         = $object->getProperties();
        $this->assertTrue($this->arrays_are_similar($attrbProperties, $properties));
    }

    /**
     * @throws Exception
     */
    public function testIdName()
    {
        $object     = new OObject('test', []);
        $properties = $object->getProperties();

        $this->assertTrue($properties['id'] == 'test');
        $this->assertTrue($properties['name'] == 'test');
    }

    /**
     * @throws Exception
     */
    public function testClassNameTemplate()
    {
        $object     = new OObject('test', []);
        $properties = $object->getProperties();

        $this->assertTrue($properties['className'] == "GraphicObjectTemplating\OObjects".chr(92).chr(92));
        $this->assertTrue($properties['template'] == "zf3-graphic-object-templating/oobjects///");
    }

    /**
     * @throws Exception
     */
    public function testDisplay()
    {
        $object     = new OObject('test', []);
        $properties = $object->getProperties();

        $this->assertTrue($properties['display'] == OObject::DISPLAY_BLOCK);
    }

    /**
     * @throws Exception
     */
    public function testSetGetDisplay()
    {
        $object     = new OObject('test', []);

        /** test 1 bonne valeur via référence */
        $object->setDisplay($object::DISPLAY_BLOCK);
        $properties = $object->getProperties();
        $display    = $properties['display'];
        $this->assertTrue($display == $object::DISPLAY_BLOCK);
        $this->assertTrue($object->getDisplay() == $object::DISPLAY_BLOCK);

        /** test 2 bonne valeur via texte */
        $object->setDisplay('inline');
        $properties = $object->getProperties();
        $display    = $properties['display'];
        $this->assertTrue($display == 'inline');
        $this->assertTrue($object->getDisplay() == 'inline');

        /** test 3 mauvaise valeur via référence */
        $object->setDisplay($object::BOOLEAN_TRUE);
        $properties = $object->getProperties();
        $display    = $properties['display'];
        $this->assertFalse($display == $object::BOOLEAN_TRUE);
        $this->assertTrue($display == $object->getDisplay());
        $this->assertTrue($display == $object::DISPLAY_BLOCK);
        $this->assertTrue($object->getDisplay() == $object::DISPLAY_BLOCK);

        /** test 4 mauvaise valeur via texte */
        $object->setDisplay('bonjour');
        $properties = $object->getProperties();
        $display    = $properties['display'];
        $this->assertFalse($display == 'bonjour');
        $this->assertTrue($display == $object->getDisplay());
        $this->assertTrue($display == $object::DISPLAY_BLOCK);
        $this->assertTrue($object->getDisplay() == $object::DISPLAY_BLOCK);
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
}