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
 * setSelectedLeaves(array $selectedLeaves)
 * getSelectedLeaves()
 * #evtClick($class, $method, $stopEvent = false)
 * #getClick()
 * #disClick()
 * enaMultiSelect
 * disMultiSelect
 * setTitle($title)
 * getTitle()
 * setLeafLink($ref, $link, $target)
 * getLeafLink($ref)
 * enaSortable()
 * disSortable()
 * enaSelection()
 * disSelection()
 * selectNode($ref)
 * unselectNode($ref)
 * enaSelectNode($ref)
 * disSelectNode($ref)
 * enaSortableNode($ref, $andChilmdren = false)
 * disSortableNode($ref, $andChilmdren = false)
 *
 * méthodes de gestion de retour de callback
 * -----------------------------------------
 * returnAddLeaf($parentPath, $ord)
 *
 * méthodes privées de la classe
 * -----------------------------
 * updateTree($tree, $path, $item)
 * validRefUnique($ref)
 * rmLeafTree($dataTree, $dataPath)
 * getTargetConstants()
 */
class ODTreeview extends ODContained
{

    const ODTREEVIEWTARGET_SELF     = '_self';
    const ODTREEVIEWTARGET_BLANK    = '_blank';
    const ODTREEVIEWTARGET_PARENT   = '_parent';
    const ODTREEVIEWTARGET_TOP      = '_top';

    const COLORCLASS_BLACK          = 'black';
    const COLORCLASS_DARKGREY       = 'dark-gray';
    const COLORCLASS_GRAY           = 'gray';
    const COLORCLASS_MIDGRAY        = 'mid-gray';
    const COLORCLASS_SILVER         = 'silver';
    const COLORCLASS_LIGHTGRAY      = 'light-gray';
    const COLORCLASS_WHITE          = 'white';

    const COLORCLASS_AQUA           = 'aqua';
    const COLORCLASS_BLUE           = 'blue';
    const COLORCLASS_NAVY           = 'navy';
    const COLORCLASS_TEAL           = 'teal';
    const COLORCLASS_GREEN          = 'green';
    const COLORCLASS_OLIVE          = 'olive';
    const COLORCLASS_LIME           = 'lime';

    const COLORCLASS_YELLOW         = 'yellow';
    const COLORCLASS_ORANGE         = 'orange';
    const COLORCLASS_RED            = 'red';
    const COLORCLASS_FUCHSIA        = 'fuchsia';
    const COLORCLASS_PURPLE         = 'purple';
    const COLORCLASS_MAROON         = 'maroon';


    private $const_target;

    /**
     * ODTreeview constructor.
     * @param $id
     * @throws \Exception
     */
    public function __construct($id)
    {
        parent::__construct($id, "oobjects/odcontained/odtreeview/odtreeview.config.php");

        $properties = $this->getProperties();
        if ($properties['id']) {
            $this->setDisplay();
            $width = $this->getWidthBT();
            if (!is_array($width) || empty($width)) $this->setWidthBT(12);
            $this->enable();
        }

        $this->saveProperties();
        return $this;
    }

    /**
     * @param $ref
     * @param $libel
     * @param null $ord
     * @param string $parent
     * @return $this|bool
     */
    public function addLeaf($ref, $libel, $ord = null, $parent = "0")
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
            if ($parent == '0') {
                if ($ord == 0) { $ord = sizeof($dataTree) + 1; }
                if (!isset($dataTree[$ord])) {
                    $item = [];
                    $item['libel']      = $libel;
                    $item['ord']        = $ord;
                    $item['ref']        = $ref;
                    $item['icon']       = 'none';
                    $item['link']       = 'none';
                    $item['targetL']    = 'none';
                    $item['parent']     = '0';
                    $item['check']      = false;
                    $leaf['selectable'] = true;
                    $item['sortable']	= true;

                    $dataTree[$ord]     = $item;
                    $dataPath[$ref]     = $ord;
                    $validAct           = true;
                    ksort($dataTree);
                }
            } else {
                $leaf   = $this->getLeaf($parent);
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
                    $item['check']      = false;
                    $leaf['selectable'] = true;
                    $item['sortable']	= true;

                    $path               = explode('-', $dataPath[$parent]);
                    if ((int) $path[0] == 0) { unset($path[0]); }

                    $dataTree           = $this->updateTree($dataTree, $path, $item, true);
                    $dataPath[$ref]     = $dataPath[$parent].'-'.$ord;
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

    /**
     * @param $libel
     * @param $path
     * @return $this|bool
     */
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

    /**
     * @param $ref
     * @return bool
     */
    public function getLeaf($ref)
    {
        $properties = $this->getProperties();
        $dataPath   = $properties['dataPath'];

        return $this->getLeafByPath($dataPath[$ref]);
    }

    /**
     * @param null $path
     * @return bool
     */
    public function getLeafByPath($path = null)
    {
        $properties = $this->getProperties();
        $leaf       = $properties['dataTree'];
        $found      = true;

        if ($path != '') {
            $first      = true;
            $refs       = explode('-', $path);
            if ((int) $refs[0] == 0) { unset($refs[0]); }
            foreach ($refs as $ref) {
                if ($first) {
                    $leaf = $leaf[$ref];
                    $first = false;
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

    /**
     * @return $this
     */
    public function enaIcon()
    {
        $properties = $this->getProperties();
        $properties['icon'] = true;
        $this->setProperties($properties);
        return $this;
    }

    /**
     * @return $this
     */
    public function disIcon()
    {
        $properties = $this->getProperties();
        $properties['icon'] = false;
        $this->setProperties($properties);
        return $this;
    }

    /**
     * @param $leafIco
     * @return $this
     */
    public function setLeafIco($leafIco)
    {
        $properties = $this->getProperties();
        $leafIco    = (string) $leafIco;
        $properties['leafIco']  = $leafIco;
        $this->setProperties($properties);
        return $this;
    }

    /**
     * @return bool
     */
    public function getLeafIco()
    {
        $properties = $this->getProperties();
        return array_key_exists('leafIco', $properties) ? $properties['leafIco'] : false;
    }

    /**
     * @param $nodeOpenedIco
     * @return $this
     */
    public function setNodeOpenedIco($nodeOpenedIco)
    {
        $properties     = $this->getProperties();
        $nodeOpenedIco  = (string) $nodeOpenedIco;
        $properties['nodeOpenedIco']  = $nodeOpenedIco;
        $this->setProperties($properties);
        return $this;
    }

    /**
     * @return bool
     */
    public function getNodeOpenedIco()
    {
        $properties = $this->getProperties();
        return array_key_exists('nodeOpenedIco', $properties) ? $properties['nodeOpenedIco'] : false;
    }

    /**
     * @param $nodeClosedIco
     * @return $this
     */
    public function setNodeClosedIco($nodeClosedIco)
    {
        $properties     = $this->getProperties();
        $nodeClosedIco  = (string) $nodeClosedIco;
        $properties['nodeClosedIco']  = $nodeClosedIco;
        $this->setProperties($properties);
        return $this;
    }

    /**
     * @return bool
     */
    public function getNodeClosedIco()
    {
        $properties = $this->getProperties();
        return array_key_exists('nodeClosedIco', $properties) ? $properties['nodeClosedIco'] : false;
    }

    /**
     * @param array $selectedLeaves
     * @return $this
     */
    public function setSelectedLeaves(array $selectedLeaves)
    {
        $properties = $this->getProperties();
        $properties['dataSelected'] = $selectedLeaves;
        $this->setProperties($properties);
        return $this;
    }

    /**
     * @return bool
     */
    public function getSelectedLeaves()
    {
        $properties = $this->getProperties();
        return array_key_exists('dataSelected', $properties) ? $properties['dataSelected'] : false;
    }

    /**
     * @param $class
     * @param $method
     * @param bool $stopEvent
     * @return bool|ODTreeview
     */
    public function evtClick($class, $method, $stopEvent = false)
    {
        if (!empty($class) && !empty($method)) {
            return $this->setEvent('click', $class, $method, $stopEvent);
        }
        return false;
    }

    /**
     * @return bool
     */
    public function getClick()
    {
        return $this->getEvent('click');
    }

    /**
     * @return bool|ODTreeview
     */
    public function disClick()
    {
        return $this->disEvent('click');
    }

    /**
     * @return $this
     */
    public function enaMultiSelect()
    {
        $properties = $this->getProperties();
        $properties['multiSelect'] = true;
        $this->setProperties($properties);
        return $this;
    }

    /**
     * @return $this
     */
    public function disMultiSelect()
    {
        $properties = $this->getProperties();
        $properties['multiSelect'] = false;
        $this->setProperties($properties);
        return $this;
    }

    /**
     * @param $ref
     * @param bool $root
     * @return $this|bool
     */
    public function rmLeafNode($ref, $root = true)
    {
        $leaf       = $this->getLeaf($ref);

        if ($leaf) {
            if (array_key_exists('children', $leaf)) {
                $children = $leaf['children'];
                foreach ($children as $child) {
                    $this->rmLeafNode($child['ref'], false);
                }
            }

            $properties = $this->getProperties();
            $dataPath   = $properties['dataPath'];
            if ($root) {
                $dataTree   = $properties['dataTree'];
                $dataTree   = $this->rmLeafTree($dataTree, $dataPath[$ref]);
            }
            unset($dataPath[$ref]);
            $properties['dataPath'] = $dataPath;

            $this->setProperties($properties);
            return $this;
        }
        return false;
    }

    /**
     * @param string $title
     * @return $this
     */
    public function setTitle($title = "")
    {
        $title = (string) $title;
        $properties = $this->getProperties();
        $properties['title'] = $title;
        $this->setProperties($properties);
        return $this;
    }

    /**
     * @return bool
     */
    public function getTitle()
    {
        $properties             = $this->getProperties();
        return (array_key_exists('title', $properties)) ? $properties['title'] : false ;
    }

    /**
     * @param $ref
     * @param $link
     * @param string $target
     * @return $this|bool
     */
    public function setLeafLink($ref, $link, $target = self::ODTREEVIEWTARGET_SELF)
    {
        $leaf = $this->getLeaf($ref);
        if ($leaf) {
            $properties     = $this->getProperties();
            $dataTree       = $properties['dataTree'];
            $dataPath       = $properties['dataPath'];

            $leaf['link']   = $link;
            $targets        = $this->getTargetConstants();
            if (!in_array($target, $targets)) { $target = self::ODTREEVIEWTARGET_SELF; }

            $dataTree       = $this->updateTree($dataTree, $dataPath[$ref], $leaf);
            $properties['dataTree'] = $dataTree;
            $this->setProperties($properties);
            return $this;
        }
        return false;
    }

    /**
     * @param $ref
     * @return bool|string
     */
    public function getLeafLink($ref)
    {
        $leaf = $this->getLeaf($ref);
        if ($leaf) {
            return $leaf['link'];
        }
        return false;
    }

    /**
     * @return ODTreeview
     */
    public function enaSortable()
    {
        $properties = $this->getProperties();
        $properties['sortable'] = true;
        $this->setProperties($properties);
        return $this;
    }

    /**
     * @return ODTreeview
     */
    public function disSortable()
    {
        $properties = $this->getProperties();
        $properties['sortable'] = false;
        $this->setProperties($properties);
        return $this;
    }

    /**
     * @return ODTreeview
     */
    public function enaSelection()
    {
        $properties = $this->getProperties();
        $properties['selection'] = true;
        $this->setProperties($properties);
        return $this;
    }

    /**
     * @return ODTreeview
     */
    public function disSelection()
    {
        $properties = $this->getProperties();
        $properties['selection'] = false;
        $this->setProperties($properties);
        return $this;
    }

    public function selectNode($ref)
    {
        $leaf   = $this->getLeaf($ref);
        if ($leaf) {
            $properties     = $this->getProperties();
            $dataTree       = $properties['dataTree'];
            $dataPath       = $properties['dataPath'];

            $leaf['check'] = true;

            $dataTree       = $this->updateTree($dataTree, $dataPath[$ref], $leaf);
            $properties['dataTree'] = $dataTree;
            $this->setProperties($properties);
            return $this;
        }
        return false;
    }

    public function unselectNode($ref)
    {
        $leaf   = $this->getLeaf($ref);
        if ($leaf) {
            $properties     = $this->getProperties();
            $dataTree       = $properties['dataTree'];
            $dataPath       = $properties['dataPath'];

            $leaf['check']  = false;

            $dataTree       = $this->updateTree($dataTree, $dataPath[$ref], $leaf);
            $properties['dataTree'] = $dataTree;
            $this->setProperties($properties);
            return $this;
        }
        return false;
    }

    public function enaSelectNode($ref) {
        $leaf   = $this->getLeaf($ref);
        if ($leaf) {
            $properties     = $this->getProperties();
            $dataTree       = $properties['dataTree'];
            $dataPath       = $properties['dataPath'];

            $leaf['selectable']  = true;

            $dataTree       = $this->updateTree($dataTree, $dataPath[$ref], $leaf);
            $properties['dataTree'] = $dataTree;
            $this->setProperties($properties);
            return $this;
        }
        return false;
    }

    public function disSelectNode($ref) {
        $leaf   = $this->getLeaf($ref);
        if ($leaf) {
            $properties     = $this->getProperties();
            $dataTree       = $properties['dataTree'];
            $dataPath       = $properties['dataPath'];

            $leaf['selectable']  = false;

            $dataTree       = $this->updateTree($dataTree, $dataPath[$ref], $leaf);
            $properties['dataTree'] = $dataTree;
            $this->setProperties($properties);
            return $this;
        }
        return false;
    }

	public function enaSortableNode($ref, $anfChildren = false) {
		$leaf	= $this-getLeaf($ref);
		if (!empty($leaf)) {
			$properties				= $this->getProperties();
			$dataTree       		= $properties['dataTree'];
            $dataPath       		= $properties['dataPath'];

			$leaf['sortable']		= true;

			if (isset($leaf['children']) && !empty($leaf['children']) && $andChildren) {
				foreach ($leaf['children'] as $child) {
					if (!$this->enaSortableNode($child['ref'], $andChildren)) {
						return false;
					}
				}
			}

            $dataTree       		= $this->updateTree($dataTree, $dataPath[$ref], $leaf);
            $properties['dataTree'] = $dataTree;
            $this->setProperties($properties);
            return $this;
		}
		return false;
	}

	public function disSortableNode($ref, $anfChildren = false) {
		$leaf	= $this-getLeaf($ref);
		if (!empty($leaf)) {
			$properties				= $this->getProperties();
			$dataTree       		= $properties['dataTree'];
            $dataPath       		= $properties['dataPath'];

			$leaf['sortable']		= false;

			if (isset($leaf['children']) && !empty($leaf['children']) && $andChildren) {
				foreach ($leaf['children'] as $child) {
					if (!$this->enaSortableNode($child['ref'], $andChildren)) {
						return false;
					}
				}
			}

            $dataTree       		= $this->updateTree($dataTree, $dataPath[$ref], $leaf);
            $properties['dataTree'] = $dataTree;
            $this->setProperties($properties);
            return $this;
		}
		return false;
	}
    /** **************************************************************************************************
     * méthodes de gestion de retour de callback                                                         *
     * *************************************************************************************************** */

    /**
     * @param $parentPath
     * @param $ord
     * @return array
     */
    public function returnAddLeaf($parentPath, $ord)
    {
        $parentPath = (string) $parentPath;
        $ord        = (int) $ord;
        $ret        = [];

        if ($parentPath == "0" || empty($parentPath)) {
            $dataLvl    = "0";
            $dataOrd    = "0";
            $parent     = null;
        } else {
            $dataLvl    = $parentPath;
            $parent     = $this->getLeafByPath($parentPath);
            $dataOrd    = $parent['ord'];
        }
        $pathChild  = $dataLvl.'-'.$ord;
        $child      = $this->getLeafByPath($pathChild);

        // traitement ajout de feuille enfant
        $line   = '<li id="'.$this->getId().'Li-'.$dataLvl.'-'.$ord.'" class="leaf">';
        $itemIco = ($child['icon'] == 'none') ? $this->getLeafIco() : $child['icon'];
        $line .= '<i class="'.$itemIco.' icon leaf"></i>';
        $line  .= '<label>';
        $line  .= '<input class="hummingbird-end-node" id="'.$this->getId().'-'.$dataLvl.'-'.$ord.'" data-id="'.$dataLvl.'-'.$ord.'" type="checkbox">';
        $line .= $child['libel'];
        $line .= '</label>';
        $line .= '</li>';

        /** détermination sélecteur sur parent ligne à indérer */
        if (!empty($parent)) { $dataLvl = $parent['parent']; }
        $selector   = '#'.$this->getId().'Li-'.$dataLvl.'-'.$dataOrd.'';

        if ($parentPath != "0" && $parent && sizeof($parent['children']) == 1) {
            $node   = '<li id="'.$this->getId().'Li-'.$dataLvl.'-'.$dataOrd.'" class="node">';
            $node  .= '<i class="'.$this->getNodeOpenedIco().'"></i>';
            $node  .= '<label>';
            $node  .= '<input id="'.$this->getId().'-'.$dataLvl.'-'.$dataOrd.'" data-id="'.$dataLvl.'-'.$dataOrd.'" type="checkbox">';
            $node  .= $parent['libel'];
            $node  .= '</label>';
            $node  .= '<ul class="show">';
            $node  .= $line;
            $node  .= '</ul>';
            $node  .= '</li>';

            $code   = ['html' => $node, 'selector' => $selector];
            $mode   = 'updtTreeLeaf';
            /* mode update supprime - remplace sur sélecteur enfant */
        } else {
            // traitement ajout nouvelle feuille enfant
            // mode append sur sélecteur parent
            $code   = ['html' => $line, 'selector' => $selector.' > ul'];
            $mode       = 'appendTreeNode';
        }
        $ret[] = OObject::formatRetour($this->getId(), $this->getId(), $mode, $code);
        $ret[] = OObject::formatRetour($this->getId(), $this->getId(), 'exec', '$("#'.$this->getId().' .treeview").off().find("*").off();');
        $ret[] = OObject::formatRetour($this->getId(), $this->getId(), 'execID', $this->getId().'Script');
        return $ret ;
    }

    /**
     * @param $leafPath
     * @return array
     */
    public function returnDelLeaf($leafPath)
    {
        $leafPath = (string) $leafPath;
        $leaf     = $this->getLeaf($leafPath);
        $selector = $this->getId().'Li-'.$leaf['parent'].'-'.$leaf['ord'];

        $ret[] = OObject::formatRetour($this->getId(), $selector, 'delete');

        return $ret ;
    }

    /** **************************************************************************************************
     * méthodes privées de la classe                                                                     *
     * *************************************************************************************************** */

    /**
     * @param $tree
     * @param $path
     * @param $item
     * @return mixed
     */
    private function updateTree($tree, $path, $item, $addNode = false)
    {
            if (!is_array($path)) { $path = explode('-', $path); }
            $id = array_shift($path);
            if (empty($path)) {
                if ($addNode) {
                    if (!isset($tree[$id]['children'])) { $tree[$id]['children'] = []; }
                    $tree[$id]['children'][$item['ord']] = $item;
                } else {
                    $tree[$id] = $item;
                }
            } else {
                $leaves = $tree[$id]['children'];
                $tree[$id]['children'] = $this->updateTree($leaves, $path, $item, $addNode);
            }
        ksort($tree);
        return $tree;
    }

    /**
     * @param $ref
     * @return bool
     */
    private function validRefUnique($ref)
    {
        $properties = $this->getProperties();
        $dataPath   = $properties['dataPath'];
        return (!array_key_exists($ref, $dataPath));
    }

    /**
     * @param $dataTree
     * @param $dataPath
     * @return mixed
     */
    private function rmLeafTree($dataTree, $dataPath)
    {
        $refs       = explode('-', $dataPath);
        if ((int) $refs[0] == 0) { unset($refs[0]); }
        if (sizeof($refs) > 1) {
            $localTree = $dataTree['children'][$refs[0]];
            unset($refs[0]);
            $refs = implode('-', $refs);
            $this->rmLeafTree($localTree, $refs);
            $dataTree['children'][$refs[0]] = $localTree;
        } else {
            if (array_key_exists('children', $dataTree)) {
                unset($dataTree['children'][$dataPath]);
            } else {
                unset($dataTree[$dataPath]);
            }
        }
        return $dataTree;
    }

    /**
     * @return array
     * @throws \ReflectionException
     */
    public function getTargetConstants()
    {
        $retour = [];
        if (empty($this->const_target)) {
            $constants = $this->getConstants();
            foreach ($constants as $key => $constant) {
                $pos = strpos($key, 'ODTREEVIEWTARGET_');
                if ($pos !== false) {
                    $retour[$key] = $constant;
                }
            }
            $this->const_target = $retour;
        } else {
            $retour = $this->const_target;
        }

        return $retour;
    }
}
