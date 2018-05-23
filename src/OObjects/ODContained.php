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

class ODContained extends OObject
{
    public function __construct($id, $pathObjArray)
    {
        parent::__construct($id, $pathObjArray);

        /** ajout des attributs spécifiques à l'objet */
        $properties = include __DIR__ . '/../../view/graphic-object-templating/oobjects/odcontained/odcontained.config.php';
        foreach ($this->getProperties() as $key => $objProperty) {
            $properties[$key] = $objProperty;
        }

        $this->setProperties($properties);
        return $this;
    }

    public function setValue($value = null)
    {
        if (!empty($value)) {
            $properties = $this->getProperties();
            $properties['value'] = $value;
            $this->setProperties($properties);
            return $this;
        }
        return false;
    }

    public function getValue()
    {
        $properties = $this->getProperties();
        return array_key_exists('value', $properties) ? $properties['value'] : false;
    }

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

    public function getForm()
    {
        $properties = $this->getProperties();
        return array_key_exists('form', $properties) ? $properties['form'] : false;
    }

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

    public function getDefault()
    {
        $properties = $this->getProperties();
        return array_key_exists('default', $properties) ? $properties['default'] : false;
    }
}