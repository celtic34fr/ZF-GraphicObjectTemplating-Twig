<?php

namespace GraphicObjectTemplating\OObjects\OSContainer;


use GraphicObjectTemplating\OObjects\ODContained;
use GraphicObjectTemplating\OObjects\ODContained\ODButton;
use GraphicObjectTemplating\OObjects\OObject;
use GraphicObjectTemplating\OObjects\OSContainer;

class OSForm extends OSContainer
{
    public function __construct($id)
    {
        parent::__construct($id, "oobjects/oscontainer/osform/osform.config.php");

        $reset = new ODButton($id.'Reset');
        if ($reset instanceof ODButton) {
            $properties = $this->getProperties();
            $properties['reset'] = $id.'Reset';
            $this->setProperties($properties);
            return $this;
        }
        return false;
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
        $properties = $this->getProperties();
        $fields     = $properties['fields'];
        $topOk      = true;
        foreach ($formDatas as $cle => $data) {
            if (!in_array($cle, $fields)) {
                $topOk = false;
                break;
            }
        }
        if ($topOk) {
            $formArrayDatas = $properties['formDatas'];
            foreach ($formDatas as $cle => $data) {
                $object = OObject::buildObject($cle);
                $object->setValue($data);
                $formArrayDatas[$cle] = $data;
            }
            $properties['formDatas'] = $formArrayDatas;
            $this->setProperties($properties);
            return $this;
        }
        return false;
    }

    public function getFormDatas()
    {
        $properties = $this->getProperties();
        return array_key_exists('formDatas', $properties) ? $properties['formDatas'] : false;
    }

    public function getResetBtn()
    {
        $properties = $this->getProperties();
        return OObject::buildObject($properties['reset']);
    }

    public function addSubmitBtn($className, $methodName, $label = null)
    {
        if (!empty($className) && !empty($methodName)) {
            if (class_exist($className) ) {
                $obj = new $className();
                if (method_exists($obj, $methodName)) {
                    $properties = $this->getProperties();
                    if (empty($label)) { $label = $this->getId().sizeof($properties['submits']); }
                    $submit = new ODButton($label);
                    $submit->setType(‘submit’);
                    $submit->setNature(‘success’);
                    $submit->setForm($this->getId());
			        $submit->evtClick($className, $methodName);
			        $properties[‘submits’][$label] = $label;
                    $this->setProperties($properties);
                    return $this;
                }
            }
        }
        return false;
    }

    public function removeSubmitBtn($label)
    {
        if (!empty($label)) {
            if (is_numeric($label)) { $label = $this->getId().$label; }
            $properties = $this->getProperties();
            $submits    = $properties['submits'];
            if (array_key_exists($label, $submits)) {
                unset($submits[$label]);
                OObject::destroyObject($label);
                $properties['submits'] = $submits;
                $this->setProperties($properties);
                return $this;
            }
        }
        return false;
    }

    public function setSubmitBtns(array $submitsDef)
    {
        if (!empty($submitsDef)) {
            if (is_array($submitsDef)) {
                $validateArray      = true;
                foreach ($submitsDef as $submitDef) {
                    if (!array_key_exists('className', $submitDef) || !array_key_exists('methodName', $submitDef) ) {
                        $validateArray = false;
                        break;
                    }
                }
                if ($validateArray) {
                    $properties = $this->getProperties();
                    foreach ($submitsDef as $submitDef => $event) {
                        $submit = new ODButton($submitDef);
                        $submit->setType(‘submit’);
                        $submit->setNature(‘success’);
                        $submit->setForm($this->getId());
                        $submit->evtClick($event[‘className’], $event[‘methodeName’]);
                        $properties[‘submits’][$submitDef] = $submitDef;                    }
                }
                $this->setProperties($properties);
                return $this;
            }
        }
        return false;
    }

    public function setSubmitBtn($label, $className, $methodName)
    {
        if (!empty($className) && !empty($methodName) && !empty($label)) {
            if (class_exist($className)) {
                $obj = new $className();
                if (method_exists($obj, $methodName)) {
                    $properties = $this->getProperties();
                    if (empty($label)) { $label = $this->getId().sizeof($properties['submits']); }
                    if (array_key_exists($label, $properties['submits'])) {
                        $submit = new ODButton($label);
                        $submit->evtClick($className, $methodName);
                        return $this;
                    }
                }
            }
        }
        return false;
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