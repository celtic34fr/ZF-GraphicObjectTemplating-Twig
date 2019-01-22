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
 * méthodes
 * --------
 * __construct($id, $pathObjArray)
 * __get($nameChild)
 * getValue()
 * setForm($form = null)
 * getForm()
 * addChild(OObject $child, $mode =self::MODE_LAST, $params=null)
 * setChild(OObject $child, $value = null)
 * removeChild(OObject $child)
 * isChild(string $child)
 * hasChild()
 * countChildren()
 * getChildren()
 * removeChildren()
 * addCodeCss($selector, $code)
 * setCodeCss($selector, $code)
 * rmCodeCss($selector)
 * getCodeCss($selector)
 * setAllCss(array $allCss)
 * getAllCss()
*/

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
        $properties = include __DIR__ . '/../../view/zf3-graphic-object-templating/oobjects/oscontainer/oscontainer.config.php';
        foreach ($this->getProperties() as $key => $objProperty) {
            $properties[$key] = $objProperty;
        }

        $this->setProperties($properties);
        $this->saveProperties();
        return $this;
    }

    public function __get($nameChild) {
        $sessionObj = OObject::validateSession();
        $objects    = $sessionObj->objects;
        $properties = $this->getProperties();

        if (!empty($properties['children'])) {
            foreach ($properties['children'] as $idChild => $child) {
                $childProperties = unserialize($objects[$idChild]);
                if ($childProperties['name'] == $nameChild || $idChild = $nameChild) {
                    $obj = OObject::buildObject($idChild, $sessionObj);
                    return $obj;
                }
            }
        }
        return false;
    }


    public function __isset($nameChild) {
        $sessionObj = OObject::validateSession();
        $objects    = $sessionObj->objects;
        $properties = $this->getProperties();

        if (!empty($properties['children'])) {
            foreach ($properties['children'] as $idChild => $child) {
                $childProperties = unserialize($objects[$idChild]);
                if ($childProperties['name'] == $nameChild || $idChild = $nameChild) {
                    return true;
                }
            }
        }
        return false;
    }

    public function getValue()
    {
        $properties = $this->getProperties();
        return $properties['children'];
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
            if (!array_key_exists($child->getId(), $children)) {
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

    public function setChildValue(OObject $child, $value = null)
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
        $sessionObj = OObject::validateSession();
        foreach ($children as $id => $valeur) {
            /** @var OObject $objet */
            $objet = OObject::buildObject($id, $sessionObj);
//            if ($objet instanceof ODContained || $objet instanceof OEDContained) {
            if ($objet instanceof ODContained) {
                if (!empty($valeur)) {
                    $objet->setValue($valeur);
                }
            }
            $enfants[] = $objet;
        }
        return $enfants;
    }

    public function removeChildren()
    {
        $properties = $this->getProperties();
        $properties['children'] = [];
        $this->setProperties($properties);
        return $this;
    }

    public function addCodeCss($selector, $code)
    {
        $selector = (string) $selector;
        $code     = (string) $code;
        if (!empty($selector) && !empty($code)) {
            if ($selector == 'self') { $selector = ''; }
            $properties = $this->getProperties();
            $codeCss    = $properties['codeCss'];
            if (!empty($code) && !array_key_exists($selector, $codeCss)) {
                $codeCss[$selector] = $code;
                $properties['codeCss'] = $codeCss;
                $this->setProperties($properties);
                return $this;
            }
        }
        return false;
    }

    public function setCodeCss($selector, $code)
    {
        $selector = (string) $selector;
        $code     = (string) $code;
        if (!empty($selector) && !empty($codeCss)) {
            $properties = $this->getProperties();
            $codeCss    = $properties['codeCss'];
            if (!empty($codeCss) && array_key_exists($selector, $codeCss)) {
                $codeCss[$selector] = $code;
                $properties['codeCss'] = $codeCss;
                $this->setProperties($properties);
                return $this;
            }
        }
        return false;
    }

    public function rmCodeCss($selector)
    {
        $selector = (string) $selector;
        if (!empty($selector) && !empty($codeCss)) {
            $properties = $this->getProperties();
            $codeCss    = $properties['codeCss'];
            if (!empty($codeCss) && array_key_exists($selector, $codeCss)) {
                unset($codeCss[$selector]);
                $properties['codeCss'] = $codeCss;
                $this->setProperties($properties);
                return $this;
            }
        }
        return false;
    }

    public function getCodeCss($selector)
    {
        $selector = (string) $selector;
        if (!empty($selector) && !empty($codeCss)) {
            $properties = $this->getProperties();
            $codeCss    = $properties['codeCss'];
            if (!empty($codeCss) && array_key_exists($selector, $codeCss)) {
                return $codeCss[$selector];
            }
        }
        return false;
    }

    public function setAllCss(array $allCss)
    {
        if (!empty($allCss)) {
            $properties = $this->getProperties();
            $properties['codeCss'] = $allCss;
            $this->setProperties($properties);
            return $this;
    }
        return false;
    }

    public function getAllCss()
    {
        $properties = $this->getProperties();
        return array_key_exists('codeCss', $properties) ? $properties['codeCss'] : false;
    }
}
