<?php

namespace GraphicObjectTemplating\OObjects;


use Zend\Session\Container;
use GraphicObjectTemplating\OObjects\OSContainer;
use GraphicObjectTemplating\OObjects\OESContainer;

class OObject
{
    private $id;
    private $name;
    private $properties;
    private $lastAccess;

    public function __construct($id, $pathObjArray)
    {
        $obj = self::buildObject($id);
        if (!$obj) {
            if (!empty($pathArrayData)) {
                $path  = __DIR__ ;
                $path .= '/../../view/graphic-object-templating/' . trim($pathArrayData);
                $objProperties = include $path;
            }
            $objProperties['id'] = $id;
            $this->id = $id;
            $objProperties['name'] = $id;
            $this->name = $id;


            if (array_key_exists('typeObj', $objProperties)) {
                $templateName = 'graphic-object-templating/oobjects/' . $objProperties['typeObj'];
                $templateName .= '/' . $objProperties['object'] . '/' . $objProperties['template'];
                $objProperties['template'] = $templateName;

                $objName = 'GraphicObjectTemplating/OObjects/';
                $objName .= strtoupper(substr($objProperties['typeObj'], 0, 3));
                $objName .= strtolower(substr($objProperties['typeObj'], 3)) . '/';
                $objName .= strtoupper(substr($objProperties['object'], 0, 3));
                $objName .= strtolower(substr($objProperties['object'], 3));
                $objName = str_replace('/', chr(92), $objName);
                $objProperties['className'] = $objName;
            }

            /** ajout des attribut de base de chaque objet */
            $properties = include __DIR__ . '/../../view/graphic-object-templating/oobjects/oobject.config.php';
            foreach ($objProperties as $key => $objProperty) {
                $properties[$key] = $objProperty;
            }

            $obj->setProperties($properties);
            return $this;
        }
    }

    public static function validateSession()
    {
        $now        = new \DateTime();
        $gotObjList = new Container('gotObnjList');
        $lastAccess = '';
        $lastAccess = new \DateTime($gotObjList->offsetGet('lastAccess'));

        if ($lastAccess) {
            $interval   = $lastAccess->diff($now);
            if ((int) $interval->format('%h') > 2) {
                $gotObjList->getManager()->getStorage()->clear('gotObjList');
                $gotObjList = new Container('gotObjList');
            }
        }
        $gotObjList->offsetSet('lastAccess', $now->format("Y-m-d H:i:s"));
        return $gotObjList;
    }

    public static function existObject($id)
    {
        if (!empty($id)) {
            /** @var Container $gotObjList */
            $gotObjList = self::validateSession();
            if ($gotObjList->offsetExists('objects')) {
                $objects = $gotObjList->offsetGet('objects');
                if (array_key_exists($id, $objects)) { return $objects; }
            }
        }
        return false;
    }

    public static function buildObject($id, $valeur = null)
    {
        if (!empty($id)) {
            $objects = self::existObject($id);
            if ($objects) {
                $properties = unserialize($objects[$id]);
                if (!empty($properties)) {
                    $object = new $properties['className']($id);
                    $object->setProperties($properties);
                    $object->setValue($valeur);
                    return $object;
                }
                throw new \Exception('objet dans atrribut, identifiant '.$id);
            }
        }
        return false;
    }

    public static function destroyObject($id)
    {
        $now        = new \DateTime();
        $objet = self::buildObject($id);
        if ($objet) {
            $objects = self::existObject($id);
            if ($objet instanceof OSContainer || $objet instanceof OESContainer) {
                foreach ($objet->getChildren() as $child) {
                    $ret = self::destroyObject($child->getId());
                    if (!$ret) { break; }
                }
                return $ret;
            }
            unset($objects[$id]);
            $gotObjList = new Container('gotObjList');
            $gotObjList->offsetSet('objets', $objects);
            $gotObjList->offsetSet('lastAccess', $now->format("Y-m-d H:i:s"));
            return true;
        }
        return false;
    }

    public static function clearObnjects()
    {
        $now        = new \DateTime();
        $gotObjList = self::validateSession();
        $gotObjList->offsetSet('objects', []);
        $gotObjList->offsetSet('lastAccess', $now->format("Y-m-d H:i:s"));
        return true;
    }

    public function getProperties()
    {
        if (null !== $this->id) {
            if (OObject::existObject($this->id)) {
                $gotObjList = OObject::validateSession();
                $lastAccessS = new \DateTime($gotObjList->offsetGet('lastAccess'));
                $lastAccessO = new \DateTime($this->lastAccess);
                $interval = $lastAccessO->diff($lastAccessS);
                if ((int) $interval->format('%s') > 2) {
                    $objects            = $gotObjList->offsetGet('objects');
                    $properties         = unserialize($objects[$this->id]);
                    $this->properties   = $properties;
                    $gotObjList->offsetSet('lastAccess', (new \DateTime())->format('Y-m-d H:i:s'));
                    $this->lastAccess   = (new \DateTime())->format('Y-m-d H:i:s');
                    return $properties;
                } else {
                    return $this->properties;
                }
            }
        }
        return false;
    }

    public function setProperties($properties)
    {
        if (null !== $this->id && !empty($properties) && array_key_exists('id', $properties)) {
            $gotObjList         = OObject::validateSession();
            $objects            = $gotObjList->offsetGet('objects');
            $objects[$this->id] = serialize($properties);

            $gotObjList->offsetSet('objects', $objects);
            $gotObjList->offsetSet('lastAccess', (new \DateTime())->format('Y-m-d H:i:s'));
            $this->lastAccess   = (new \DateTime())->format('Y-m-d H:i:s');
            $this->properties   = $properties;

            return $this;
        }
        return false;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        if (null !== $this->id) {
            $gotObjList         = OObject::validateSession();
            $objects            = $gotObjList->offsetGet('objects');
            $properties         = unserialize($objects[$this->id]);

            $properties['id']   = $id;
            unset($objects[$this->id]);
            $objects[$id]       = serialize($properties);

            $gotObjList->offsetSet('objects', $objects);
            $gotObjList->offsetSet('lastAccess', (new \DateTime())->format('Y-m-d H:i:s'));
            $this->properties   = $properties;
            $this->lastAccess   = (new \DateTime())->format('Y-m-d H:i:s');

            return $this;
        }
        return false;
    }
}