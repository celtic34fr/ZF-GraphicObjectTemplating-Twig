<?php

namespace GraphicObjectTemplatingTest\OObjects;

use Exception;
use GraphicObjectTemplating\OObjects\OObject;
use PHPUnit\Framework\TestCase;

class OObjectTest  extends TestCase
{
    protected $traceError   = false;
    protected $object       = "";
    protected $objectArray  = [];

    /**
     * @throws Exception
     */
    public function setUp() :void
    {
        OObject::destroyObject('test', true);
        $this->object       = new OObject('test', []);
        $this->objectArray  = $this->object_to_array($this->object);
    }
    /**
     * @throws Exception
     * @testdox Test du constructeur
     */
    public function testContructor()
    {
        /** test compoaraison tableau attribut direct et via getProperties */
        $attrbProperties    = $this->objectArray['properties'];
        $properties         = $this->object->getProperties();

        $this->assertTrue($this->arrays_are_similar($attrbProperties, $properties));

        /** test retour faux si id vide ou null */
//        $this->objectArray['id']    = null;
//        $this->object               = json_decode(json_encode($this->objectArray));
//        $this->assertFalse($this->object->getProperties());
//        $this->objectArray['id']   = '';
//        $this->assertFalse(!empty($this->object->getProperties()));

        $this->objectArray['id']   = 'test';
        $properties['display']  = $this->object::DISPLAY_NONE;
        $this->object->setProperties($properties);
        $this->assertTrue($this->arrays_are_similar($this->object->getProperties(), $properties));

        $properties['id']       = "suite";
        $this->assertFalse($this->object->setProperties($properties));
    }

    /**
     * @throws Exception
     * @testdox Test attribut id, name
     */
    public function testIdName()
    {
        $properties = $this->objectArray['properties'];

        $this->assertTrue($properties['id'] == 'test');
        $this->assertTrue($properties['name'] == 'test');
        $this->assertTrue($this->object->getProperty('id') == 'test');
        $this->assertTrue($this->object->getProperty('name') == 'test');
        $this->assertTrue($this->object->getId() == 'test');
        $this->assertTrue($this->object->getName() == 'test');
    }

    /**
     * @throws Exception
     * @testdox Test attribut className, template
     */
    public function testClassNameTemplate()
    {
        $properties = $this->object->getProperties();

        $this->assertTrue($properties['className'] == "GraphicObjectTemplating\OObjects".chr(92).chr(92));
        $this->assertTrue($properties['template'] == "zf3-graphic-object-templating/oobjects///");
    }

    /**
     * @throws Exception
     * @testdox Test attribut display
     */
    public function testDisplay()
    {
        $properties = $this->object->getProperties();

        $this->assertTrue($properties['display'] == OObject::DISPLAY_BLOCK);
    }

    /**
     * @throws Exception
     * @testdox Test setId(), getId()
     */
    public function testSetGetId()
    {
        $properties = $this->object->getProperties();
        $this->assertTrue($properties['id'] == $this->object->getId());

        $this->object->setId('suite');
        $properties = $this->object->getProperties();
        $this->assertTrue($properties['id'] == 'suite');
        $this->assertTrue($this->object->getId() == 'suite');
    }

    /**
     * @throws Exception
     * @testdox Test setName(), getName()
     */
    public function testSetGetName()
    {
        $properties = $this->object->getProperties();
        $this->assertTrue($properties['name'] == $this->object->getName());

        $this->object->setName('suite');
        $properties = $this->object->getProperties();
        $this->assertTrue($properties['name'] == 'suite');
        $this->assertTrue($this->object->getId() != 'suite');
        $this->assertTrue($this->object->getName() == 'suite');
    }

    /**
     * @throws Exception
     * @testdox Test setDisplay(), getDisplay()
     */
    public function testSetGetDisplay()
    {
        /** test 1 bonne valeur via référence */
        $this->object->setDisplay($this->object::DISPLAY_BLOCK);
        $properties = $this->object->getProperties();
        $display    = $properties['display'];
        $this->assertTrue($display == $this->object::DISPLAY_BLOCK);
        $this->assertTrue($this->object->getDisplay() == $this->object::DISPLAY_BLOCK);

        /** test 2 bonne valeur via texte */
        $this->object->setDisplay('inline');
        $properties = $this->object->getProperties();
        $display    = $properties['display'];
        $this->assertTrue($display == 'inline');
        $this->assertTrue($this->object->getDisplay() == 'inline');

        /** test 3 mauvaise valeur via référence */
        $this->object->setDisplay($this->object::BOOLEAN_TRUE);
        $properties = $this->object->getProperties();
        $display    = $properties['display'];
        $this->assertFalse($display == $this->object::BOOLEAN_TRUE);
        $this->assertTrue($display == $this->object->getDisplay());
        $this->assertTrue($display == $this->object::DISPLAY_BLOCK);
        $this->assertTrue($this->object->getDisplay() == $this->object::DISPLAY_BLOCK);

        /** test 4 mauvaise valeur via texte */
        $this->object->setDisplay('bonjour');
        $properties = $this->object->getProperties();
        $display    = $properties['display'];
        $this->assertFalse($display == 'bonjour');
        $this->assertTrue($display == $this->object->getDisplay());
        $this->assertTrue($display == $this->object::DISPLAY_BLOCK);
        $this->assertTrue($this->object->getDisplay() == $this->object::DISPLAY_BLOCK);
    }

    /**
     * @throws Exception
     * @testdox Test enable(), disable(), getState()
     */
    public function testEnableDisable()
    {
        $properties = $this->object->getProperties();

        $baseState  = $this->object->getState();
        $this->assertTrue($baseState);

        $this->object->disable();
        $baseState  = $this->object->getState();
        $this->assertFalse($baseState);

        $this->object->enable();
        $baseState  = $this->object->getState();
        $this->assertTrue($baseState);
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