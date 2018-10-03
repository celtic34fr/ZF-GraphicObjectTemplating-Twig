<?php

namespace GraphicObjectTemplating\OObjects\ODContained;

use GraphicObjectTemplating\OObjects\ODContained;

/**
 * Class ODTreeview
 * @package GraphicObjectTemplating\OObjects\ODContained
 *
 * __construct($id)         constructeur de l'objet, obligation de fournir $id identifiant de l'objet
 * addLeaf($libel, $ord = null, $parent = null)
 * setLeaf($libel, $path)
 * getLeaf($refs)
 * enaIcon()
 * disIcon()
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

    public function addLeaf($libel, $ord = null, $parent = null)
    {
        $properties = $this->getProperties();
        $ord        = (int) $ord;
        $parent     = (string) $parent;

        $dataTree   = $properties['dataTree'];
        $dataPath   = $properties['dataPath'];
        $validAct   = false;

        if (empty($parent)) {
            if ($ord == 0) { $ord = sizeof($dataTree) + 1; }
            if (!isset($dataTree[$ord])) {
                $item = [];
                $item['libel']      = $libel;
                $item['ord']        = $ord;
                $item['ref']        = $ord;
                $item['icon']       = 'none';
                $item['link']       = 'none';
                $item['targetL']    = 'none';

                $dataTree[$ord]     = $item;
                $dataPath[$ord]     = $ord;
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
                $item['ref']        = $parent.'.'.$ord;
                $item['icon']       = 'none';
                $item['link']       = 'none';
                $item['targetL']    = 'none';

                $path[0]            = $path0;
                $dataTree           = $this->updateTree($dataTree, $path, $item);
                $dataPath[$ord]     = $parent.'.'.$ord;
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

    public function getLeaf($refs)
    {
        $properties = $this->getProperties();
        $refs       = explode('.', $refs);
        $leaf       = $properties['dataTree'];
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