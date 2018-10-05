<?php

namespace GraphicObjectTemplating\OObjects\ODContained;

use GraphicObjectTemplating\OObjects\ODContained;
use GraphicObjectTemplating\OObjects\OObject;

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
 * setSelectedLeaves(array $selectedLeaves)
 * getSelectedLeaves()
 * #evtClick($class, $method, $stopEvent = false)
 * #getClick()
 * #disClick()
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

        if ($this->validRefUnique($ref)) {
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
                    $item['parent']     = '1';

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
                    $item['parent']     = $parent;

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

        return $this->getLeafByPath($dataPath[$ref]);
    }

    public function getLeafByPath($path = null)
    {
        $properties = $this->getProperties();
        $leaf       = $properties['dataTree'];
        $found      = true;
        if (!empty($path)) {
            $first      = true;
            $refs       = explode('.', $path);
            foreach ($refs as $ref) {
                if ($first) {
                    $leaf   = $leaf[$ref];
                    $first  = false;
                } else {
                    if (array_key_exists('children', $leaf)) {
                        $children   = $leaf['children'];
                        if (array_key_exists($ref, $children)) {
                            $leaf = $children[$ref];
                        } else {
                            $found = false;
                            break;
                        }
                    } else {
                        $found = false;
                        break;
                    }
                }
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

    public function setSelectedLeaves(array $selectedLeaves)
    {
        $properties = $this->getProperties();
        $properties['dataSelected'] = $selectedLeaves;
        $this->setProperties($properties);
        return $this;
    }

    public function getSelectedLeaves()
    {
        $properties = $this->getProperties();
        return array_key_exists('dataSelected', $properties) ? $properties['dataSelected'] : false;
    }

    public function evtClick($class, $method, $stopEvent = false)
    {
        if (!empty($class) && !empty($method)) {
            return $this->setEvent('click', $class, $method, $stopEvent);
        }
        return false;
    }

    public function getClick()
    {
        return $this->getEvent('click');
    }

    public function disClick()
    {
        return $this->disEvent('click');
    }

    /** **************************************************************************************************
     * méthodes de gestion de retour de callback                                                         *
     * *************************************************************************************************** */

    public function returnAddLeaf($parentPath, $ord)
    {
        if ($parentPath == "1" || empty($parentPath)) {
            $pathChild  = $ord;
            $parent     = null;
            $parentPath = "1";
        } else {
            $pathChild  =  $parentPath.'.'.$ord;
            $parent     = $this->getLeafByPath($parentPath);
        }
        $child      = $this->getLeafByPath($pathChild);

        // traitement ajout de feuille enfant
        $line  = '<li class="leaf" data-lvl="'.$parentPath.'" data-ord="'.$ord.'">';
        $itemIco = ($child['icon'] == 'non') ? $this->getLeafIco() : $child['icon'];
        $line .= '<i class="'.$itemIco.' icon leaf"></i>';
        $line .= $child['libel'].'</li>';

        $ord        = ($parentPath == "1") ? 0 : (int) $parent['ord'];
        $selector   = '[data-lvl="'.$parentPath.'"][data-ord="'.$ord.'"] ul';

        if ($parentPath != "1" && $parent && sizeof($parent['children']) == 1) {
            $node   = '<li class="node" data-lvl="{{ path[item.ref] }}" data-ord="'.$ord.'">';
            $node  .= '<input type="checkbox" id="lvl_'.$ord.'">';
            $node  .= '<i class="{{ objet.nodeClosedIco }} icon closed"></i>';
            $node  .= '<i class="{{ objet.nodeOpenedIco }} icon opened"></i>';
            $node  .= '<label for="lvl_'.$ord.'">'.$parent['libel'].'</label><ul>';
            $node  .= $line.'</ul>';

            $code   = ['html' => $node, 'selector' => $selector];
            $mode   = 'updtTreeLeaf';
            /* mode update supprime - remplace sur sélecteur enfant */
        } else {
            // traitement ajout nouvelle feuille enfant
            // mode append sur sélecteur parent
            $code   = ['html' => $line, 'selector' => $selector];
            $mode       = 'appendTreeNode';
        }
        return [OObject::formatRetour($this->getId(), $this->getId(), $mode, $code)];
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

    private function validRefUnique($ref)
    {
        $properties = $this->getProperties();
        $dataPath   = $properties['dataPath'];
        return (!array_key_exists($ref, $dataPath));
    }
}