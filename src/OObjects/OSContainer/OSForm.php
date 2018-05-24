<?php

namespace GraphicObjectTemplating\OObjects\OSContainer;


use GraphicObjectTemplating\OObjects\ODContained;
use GraphicObjectTemplating\OObjects\OObject;
use GraphicObjectTemplating\OObjects\OSContainer;

class OSForm extends OSContainer
{
    public function __construct($id)
    {
        parent::__construct($id, "oobjects/oscontainer/osform/osform.config.php");
    }

    public function addNewField(OObject $child, bool $require, $mode =self::MODE_LAST, $params=null)
    {
        if ($this->propagateRequire($child, $require)) {
            parent::addChild($child, $mode, $params);
            foreach ($this->getChildren() as $aChild) {
                $this->propagateForm($aChild);
            }
            return $this;
        }
        return false;
    }

    public function setChild(OObject $child, $value = null)
    {
        parent::setChild($child, $value);
        $child->setForm($this->getId());
        return $this;
    }

    public function removeChild(OObject $child)
    {
        parent::removeChild($child);
        $this->removeField($child);
        return $this;
    }

    public function isChild(string $child)
    {
        $properties = $this->getProperties();
        $fields     = $properties['fields'];
        foreach ($fields as $field) {
            if ($field == $child) { return true; }
        }
        return false;
    }

    public function hasChild()
    {
        return ($this->countChildren() > 0);
    }

    public function countChildren()
    {
        $properties = $this->getProperties();
        return (int) sizeof($properties['fields']);
    }

    public function getChildren()
    {
        $properties = $this->getProperties();
        $fields     = $properties['fields'];
        $children   = [];
        foreach ($fields as $field) {
            $children[] = OObject::buildObject($field);
        }
        return $children;
    }

    public function setFormDatas(array $formDatas)
    {
    }

    public function getFormDatas()
    {
        $properties = $this->getProperties();
        return array_key_exists('formDatas', $properties) ? $properties['formDatas'] : false;
    }


    /** méthode privée de l'objet */
    private function propagateForm(OObject $object)
    {
        $object->setForm($this->getId());
        if ($object instanceof OSContainer) {
            foreach ($object->getChildren() as $child) {
                $this->propagateForm($child);
            }
        }
    }

    private function propagateRequire($object, bool $require)
    {
        $ret = false;
        if ($object instanceof OSContainer) {
            foreach ($object->getChildren() as $child) {
                $ret = $this->propagateRequire($child, $require);
            }
        } elseif ($object instanceof ODContained) {
            $ret = $this->addField($object, $require);
        } else {
            throw new \Exception('unknow type of object '.get_class($object));
        }

        return $ret;
    }

    private function addField(OObject $object, bool $require)
    {
        $properties = $this->getProperties();
        $fields     = $properties['fields'];
        $formDatas  = $properties['formDatas'];
        if (!array_key_exists($object->getId(), $fields)) {
            $fields[$object->getId()] = $require;
            $formDatas[$object->getId()] = $object->getValue();
            $properties['fields']     = $fields;
            $properties['formDatas']  = $formDatas;
            $this->setProperties($properties);
            return $this;
        }
        return false;
    }
}