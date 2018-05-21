<?php

namespace GraphicObjectTemplating\OObjects;

/**
 * classe extenstion d'objet G.O.T. type contenu
 *
 * attributs
 * ---------
 * children
 * form
 *
 *
 * méthodes
 * --------
 * __construct($id, $pathObjArray)
 * setForm($form = null)
 * getForm()
 */

use GraphicObjectTemplating\OObjects\OObject;

class OSContainer extends OObject
{
    const MODE_LAST     = 'last';
    const MODE_FIRST    = 'first';
    const MODE_BEFORE   = 'before';
    const MODE_AFTER    = 'after';
    const MODE_NTH      = 'nth';

    public function __construct($id, $pathObjArray)
    {
        parent::__construct($id, $pathObjArray);

        /** ajout des attributs spécifiques à l'objet */
        $properties = include __DIR__ . '/../../view/graphic-object-templating/oobjects/oscontainer/oscontainer.config.php';
        foreach ($this->getProperties() as $key => $objProperty) {
            $properties[$key] = $objProperty;
        }

        $this->setProperties($properties);
        return $this;
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

    public function addChild(OObject $child, $mode =self::MODE_LAST, $params=null)
    {
        if (!empty($child)) {
            $properties = $this->getProperties();
            $children   = $properties['children'];
            if (array_key_exists($child->getId(), $children)) {
                switch ($mode) {
                    case self::MODE_LAST:
                        $children[$child->getId()] = $child->getValue();
                        break;
                    case self::MODE_FIRST:
                        $newChild[$child->getId()] = $child->getValue();
                        $child = array_merge($newChild, $children);
                        break;
                    case self::MODE_BEFORE:
                    case self::MODE_AFTER:
                        if (!empty($params) && $this->isChild($params) && OObject::existObject($params) ) {
                            $newChildren = [];
                            foreach ($children as $id => $valeur) {
                                if ($params == $id && $mode == self::MODE_BEFORE) {
                                    $newChildren[$child->getId()] = $child->getvalue();
                                }
                                $newChildren[$id] = $valeur;
                                if ($params == $id && $mode == self::MODE_AFTER) {
                                    $newChildren[$child->getId()] = $child->getvalue();
                                }
                            }
                            $children = $newChildren;
                        }
                        break;
                    case self::MODE_NTH:
                        if (is_numeric($params) && (int) $params <= $this->countChildren()) {
                            $compteur = 0;
                            $newChildren = [];
                            foreach ($children as $id => $valeur) {
                                $compteur++;
                                if ($compteur == (int) $params) {
                                    $newChildren[$child->getId()] = $child->getvalue();
                                }
                                $newChildren[$id] = $valeur;
                            }
                            $children = $newChildren;
                        }
                }
                $properties['children'] = $children;
                $this->setProperties($properties);
                return $this;
            }
        }
        return false;
    }

    public function setChild(OObject $child, $value = null)
    {
        $properties = $this->getProperties();
        $children   = $properties['children'];
        if (array_key_exists($child->getId(), $children)) {
            $children[$child->getId()] = $value;
            $this->setProperties($properties);
            return $this;
        }
        return false;
    }

    public function removeChild(OObject $child)
    {
        $properties = $this->getProperties();
        $children   = $properties['children'];
        if (array_key_exists($child->getId(), $children)) {
            unset($children[$child->getId()]);
            $properties['children'] = $children;
            $this->setProperties($properties);
            return $this;
        }
        return false;
    }

    public function isChild(string $child)
    {
        $properties = $this->getProperties();
        $children   = $properties['children'];
        return array_key_exists($child, $children);
    }

    public function hasChild()
    {
        return ($this->countChildren() > 0);
    }

    public function countChildren()
    {
        $properties = $this->getProperties();
        return count($properties['children']);
    }

    public function getChildren()
    {
        $enfants = [];
        $properties = $this->getProperties();
        $children   = $properties['children'];
        /** @var OObject $child */
        foreach ($children as $id => $valeur) {
            $objet = OObject::buildObject($child->getId());
            if (!empty($valeur)) { $objet->setValue($valeur); }
            $enfants[] = $objet;
        }
        return $enfants;
    }
}