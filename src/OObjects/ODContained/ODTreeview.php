<?php

namespace GraphicObjectTemplating\OObjects\ODContained;

use GraphicObjectTemplating\OObjects\ODContained;

/**
 * Class ODTreeview
 * @package GraphicObjectTemplating\OObjects\ODContained
 *
 * __construct($id)         constructeur de l'objet, obligation de fournir $id identifiant de l'objet
 * addLeaf($ref, $libel, $ord = null, $parent = null)
 * setLeaf($libel, $path)
 * getLeaf($ref)
 * enaIcon()
 * disIcon()
 * setLeafIco($leafIco)
 * getLeafIco()
 * setNodeOpenedIco($nodeOpenedIco)
 * getNodeOpenedIco()
 * setNodeClosedIco($nodeClosedIco)
 * getNodeClosedIco()
 *
 * méthodes privées de la classe
 * -----------------------------
 * updateTree($tree, $path, $item)
 */

class ODTreeview extends ODContained
{
    public function __construct($id) {
        parent::__construct($id, "oobjects/odcontained/odtreeview/odtreeview.config.php");

        $properties = $this->getProperties();
        if ($properties['id']) {
            $this->setDisplay();
            $width = $this->getWidthBT();
            if (!is_array($width) || empty($width)) $this->setWidthBT(12);
            $this->enable();
        }
        return $this;
    }

    public function addLeaf($ref, $libel, $ord = null, $parent = null)
    {
        $properties = $this->getProperties();
        $ord        = (int) $ord;
        $parent     = (string) $parent;
        $ref        = (string) $ref;
        $libel      = (string) $libel;

        $dataTree   = $properties['dataTree'];
        $dataPath   = $properties['dataPath'];
        $validAct   = false;

        if (empty($parent)) {
            if ($ord == 0) { $ord = sizeof($dataTree) + 1; }
            if (!isset($dataTree[$ord])) {
                $item = [];
                $item['libel']      = $libel;
                $item['ord']        = $ord;
                $item['ref']        = $ref;
                $item['icon']       = 'none';
                $item['link']       = 'none';
                $item['targetL']    = 'none';

                $dataTree[$ord]     = $item;
                $dataPath[$ref]     = $ord;
                $validAct           = true;
                ksort($dataTree);
            }
        } else {
            $path   = explode('.', $parent);
            $leaf   = $dataTree[$path[0]];
            $path0  = $path[0];
            unset($path[0]);
            foreach ($path as $id) {
                $leaf = $leaf['children'][$id];
            }

            if ($ord == 0 || !isset($leaf['children'][$ord])) {
                if ($ord == 0) { $ord = sizeof($leaf['children']) + 1; }
                $item = [];
                $item['libel']      = $libel;
                $item['ord']        = $ord;
                $item['ref']        = $ref;
                $item['icon']       = 'none';
                $item['link']       = 'none';
                $item['targetL']    = 'none';

                $path[0]            = $path0;
                $dataTree           = $this->updateTree($dataTree, $path, $item);
                $dataPath[$ref]     = $parent.'.'.$ord;
                $validAct           = true;
            }
        }

        if ($validAct) {
            $properties['dataTree'] = $dataTree;
            $properties['dataPath'] = $dataPath;
            $this->setProperties($properties);
            return $this;
        }
        return false;
    }

    public function setLeaf($libel, $path)
    {
        $properties = $this->getProperties();
        $refs       = explode('.', $path);
        $leaf       = $properties['dataTree'];
        $dataTree   = $properties['dataTree'];
        $found      = true;
        foreach ($refs as $ref) {
            if (array_key_exists('children', $leaf)) {
                if (isset($leaf['children'][$ref])) {
                    $leaf = $leaf['children'][$ref];
                } else {
                    $found = false;
                    break;
                }
            } else {
                $found = false;
                break;
            }
        }
        if ($found) {
            $leaf['libel']          = $libel;
            $dataTree               = $this->updateTree($dataTree, $path, $leaf);
            $properties['dataTree'] = $dataTree;
            $this->setProperties($properties);
            return $this;
        }
        return false;
    }

    public function getLeaf($ref)
    {
        $properties = $this->getProperties();
        $dataPath   = $properties['dataPath'];
        $leaf       = $properties['dataTree'];

        $refs       = explode('.', $dataPath[$ref]);
        $found      = true;
        foreach ($refs as $ref) {
            if (array_key_exists('children', $leaf)) {
                if (isset($leaf['children'][$ref])) {
                    $leaf = $leaf['children'][$ref];
                } else {
                    $found = false;
                    break;
                }
            } else {
                $found = false;
                break;
            }
        }
        return ($found) ? $leaf : false;
    }

    public function enaIcon()
    {
        $properties = $this->getProperties();
        $properties['icon'] = true;
        $this->setProperties($properties);
        return $this;
    }

    public function disIcon()
    {
        $properties = $this->getProperties();
        $properties['icon'] = false;
        $this->setProperties($properties);
        return $this;
    }

    public function setLeafIco($leafIco)
    {
        $properties = $this->getProperties();
        $leafIco    = (string) $leafIco;
        $properties['leafIco']  = $leafIco;
        $this->setProperties($properties);
        return $this;
    }

    public function getLeafIco()
    {
        $properties = $this->getProperties();
        return array_key_exists('leafIco', $properties) ? $properties['leafIco'] : false;
    }

    public function setNodeOpenedIco($nodeOpenedIco)
    {
        $properties     = $this->getProperties();
        $nodeOpenedIco  = (string) $nodeOpenedIco;
        $properties['nodeOpenedIco']  = $nodeOpenedIco;
        $this->setProperties($properties);
        return $this;
    }

    public function getNodeOpenedIco()
    {
        $properties = $this->getProperties();
        return array_key_exists('nodeOpenedIco', $properties) ? $properties['nodeOpenedIco'] : false;
    }

    public function setNodeClosedIco($nodeClosedIco)
    {
        $properties     = $this->getProperties();
        $nodeClosedIco  = (string) $nodeClosedIco;
        $properties['nodeClosedIco']  = $nodeClosedIco;
        $this->setProperties($properties);
        return $this;
    }

    public function getNodeClosedIco()
    {
        $properties = $this->getProperties();
        return array_key_exists('nodeClosedIco', $properties) ? $properties['nodeClosedIco'] : false;
    }

    /** **************************************************************************************************
     * méthodes privées de la classe                                                                     *
     * *************************************************************************************************** */

    private function updateTree($tree, $path, $item)
    {
        if (!empty($path)) {
            $id = array_shift($path);
            if (!isset($tree[$id]['children'])) { $tree[$id]['children'] = []; }
            $leaves = $tree[$id]['children'];
            $tree[$id]['children'] = $this->updateTree($leaves, $path, $item);
        } else {
            $tree[$item['ord']] = $item;
        }
        ksort($tree);
        return $tree;
    }
}