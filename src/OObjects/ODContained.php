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
 */
use GraphicObjectTemplating\OObjects\OObject;
use GraphicObjectTemplating\OObjects\OSContainer\OSForm;

class ODContained extends OObject
{
    /**
     * ODContained constructor.
     * @param $id
     * @param $pathObjArray
     * @throws \Exception
     */
    public function __construct($id, $pathObjArray)
    {
        parent::__construct($id, $pathObjArray);

        /** ajout des attributs spécifiques à l'objet */
        $properties = include __DIR__ . '/../../view/zf3-graphic-object-templating/oobjects/odcontained/odcontained.config.php';
        foreach ($this->getProperties() as $key => $objProperty) {
            if (!array_key_exists($key, $properties)) { $properties[$key] = $objProperty; }
        }

        $this->setProperties($properties);
        $this->saveProperties();
        return $this;
    }

    /**
     * @param null $value
     * @return $this
     * @throws \Exception
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
     * @param null $form
     * @return $this|bool
     */
    public function setForm($form = null)
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
    public function setDisplay($display = self::DISPLAY_BLOCK)
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
}