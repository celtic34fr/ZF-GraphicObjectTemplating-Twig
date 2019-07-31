<?php

namespace GraphicObjectTemplating\OObjects;

/**
 * classe extenstion d'objet G.O.T. type contenu
 *
 * attributs
 * ---------
 * value
 * form
 * default
 *
 * méthodes
 * --------
 * __construct($id, $pathObjArray)
 * setValue($value = null)
 * getValue()
 * setForm($form = null)
 * getForm()
 * setDefult($default ) null)
 * getDefault()
 * resetValue()
 */

use Exception;
use GraphicObjectTemplating\OObjects\OObject;
use GraphicObjectTemplating\OObjects\OSContainer\OSForm;

class ODContained extends OObject
{
    /**
     * ODContained constructor.
     * @param string $id
     * @param array $pathObjArray
     * @throws Exception
     */
    public function __construct(string $id, array $pathObjArray = [])
    {
        $pathObjArray[] = '/oobjects/odcontained/odcontained';
        parent::__construct($id, $pathObjArray);
        return $this;
    }

    /**
     * @param null $value
     * @return $this
     * @throws Exception
     */
    public function setValue($value = null)
    {
        $properties = $this->getProperties();
        $properties['value'] = $value;
        if (!empty($properties['form']) && $properties['display'] == self::NO_DISPLAY) {
            $sessionObjects = self::validateSession();
            /** @var OSForm $form */
            $form           = self::buildObject($properties['form'], $sessionObjects);
            if (!$form->addHiddenValue($this->getId(), $value)) {
                if (!$form->setHiddenValue($this->getId(), $value)) {
                    return false;
                }
            }
            $form->saveProperties();
        }
        $this->setProperties($properties);
        return $this;
    }

    /**
     * @return bool
     */
    public function getValue()
    {
        $properties = $this->getProperties();
        return array_key_exists('value', $properties) ? $properties['value'] : false;
    }

    /**
     * @param string $form
     * @return $this|bool
     */
    public function setForm(string $form = null)
    {
        if (!empty($form)) {
            $properties = $this->getProperties();
            $properties['form'] = $form;
            $this->setProperties($properties);
            return $this;
        }
        return false;
    }

    /**
     * @return bool
     */
    public function getForm()
    {
        $properties = $this->getProperties();
        return array_key_exists('form', $properties) ? $properties['form'] : false;
    }

    /**
     * @param null $default
     * @return $this|bool
     */
    public function setDefault($default = null)
    {
        if (!empty($default)) {
            $properties = $this->getProperties();
            $properties['default'] = $default;
            $this->setProperties($properties);
            return $this;
        }
        return false;
    }

    /**
     * @return bool
     */
    public function getDefault()
    {
        $properties = $this->getProperties();
        return array_key_exists('default', $properties) ? $properties['default'] : false;
    }

    /**
     * @param string $display
     * @return $this|bool|\GraphicObjectTemplating\OObjects\OObject
     * @throws \ReflectionException
     */
    public function setDisplay(string $display = self::DISPLAY_BLOCK)
    {
        $displayPrev    = $this->getDisplay();
        parent::setDisplay($display);
        $properties = $this->getProperties();
        if (!empty($properties['form']) && $displayPrev == self::NO_DISPLAY) {
            $sessionObjects = self::validateSession();
            /** @var OSForm $form */
            $form           = self::buildObject($properties['form'], $sessionObjects);
            if ($form->getHiddenValue($this->getId())) {
                if (!$form->rmHiddenValue($this->getId())) {
                    return false;
                }
            }
            $form->saveProperties();
        } elseif (!empty($properties['form']) && $display == self::NO_DISPLAY) {
            $sessionObjects = self::validateSession();
            /** @var OSForm $form */
            $form           = self::buildObject($properties['form'], $sessionObjects);
            $value = $this->getValue();
            if (!$form->addHiddenValue($this->getId(), $value)) {
                if (!$form->setHiddenValue($this->getId(), $value)) {
                    return false;
                }
            }
            $form->saveProperties();
        }
        $this->setProperties($properties);
        return $this;
    }

    /**
     * @return $this
     * @throws Exception
     */
    public function resetValue()
    {
    	$value	= $this->getDefault();
    	if (!$value) { $value = null; }
    	$this->setValue($value);
    	return $this;
    }
}
