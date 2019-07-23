<?php

namespace GraphicObjectTemplating\OObjects\ODContained;

use Exception;
use GraphicObjectTemplating\OObjects\ODContained;
use ReflectionException;
use Zend\ServiceManager\ServiceManager;

/**
 * Class ODTreeview
 * @package GraphicObjectTemplating\OObjects\ODContained
 *
 * __construct($id)         constructeur de l'objet, obligation de fournir $id identifiant de l'objet
 * addLeaf(string $ref, string $libel, int $ord = null, string $parent = "0")
 * setLeaf(string $libel, string $path)
 * getLeaf(string $ref)
 * getLeafByPath(string $path = null)
 * isLeafNode(string $ref)
 * enaIcon()
 * disIcon()
 * setLeafIco(string $leafIco)
 * getLeafIco()
 * setNodeOpenedIco(string $nodeOpenedIco)
 * getNodeOpenedIco()
 * setNodeClosedIco(string $nodeClosedIco)
 * getNodeClosedIco()
 * setSelectedLeaves(array $selectedLeaves)
 * getSelectedLeaves()
 * #evtClick($class, $method, $stopEvent = false)
 * #getClick()
 * #disClick()
 * enaMultiSelect
 * disMultiSelect
 * rmLeafNode(string $ref, bool $root = true)
 * setTitle($title)
 * getTitle()
 * enaSortable()
 * disSortable()
 * enaSelection()
 * disSelection()
 * selectNode(string $ref)
 * unselectNode(string $ref)
 * enaSelectNode(string $ref)
 * disSelectNode(string $ref)
 * enaSortableNode(string $ref, bool $andChildren = false)
 * disSortableNode($ref, $andChildren = false)
 * evtClickNode(string $class, string $method, bool $stopEvent = false)
 * getClickNode()
 * disClickNode()
 * getParent($ref)
 * getChildLeaves(string $ref, int $level = 0)
 * getRef(string $path)
 * getPath(string $ref)
 * addBtnAction(string $idBtn, array $optionsBtn)
 * setBtnAction(string $idBtn, array $optionsBtn)
 * getBtnAction(string $idBtn)
 * isBtnAction(string $btnId)
 * addBtnsNode(string $refNode, array $btnActions)
 * setBtnsNode(string $refNode, array $btnActions)
 * getBtnsNode(string $refNode)
 * cloneNode(string $refNode, string $newRef)
 *
 * méthodes de gestion de retour de callback
 * -----------------------------------------
 * dispatchEvents(ServiceManager $sm, array $params)
 * returnAddLeaf(string $parentPath, int $ord)
 *
 * méthodes privées de la classe
 * -----------------------------
 * updateTree(array $tree, $path, array $item, bool $addNode = false)
 * validRefUnique(string $ref)
 * rmLeafTree(array $dataTree, array $refs)
 * validArrayOptionsBtn(array $optionsBtn)
 * addCloneNodeChild(string $refNode, string $newRef, array $dataPath)
 */
class ODTreeview extends ODContained
{

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

    const ARRAY_OPTIONS             = [
        'label'     => 'mixte',
        'icon'      => 'mixte',
        'pathFile'  => 'mixte',
        'nature'    => 'noRequire',
        'class'     => 'require',
        'method'    => 'require',
        'stopEvent' => 'noRequire',
        'position'  => 'require',
        'ord'       => 'noRequire'
    ];

    private $const_target;


    /**
     * ODTreeview constructor.
     * @param string $id
     * @throws ReflectionException
     * @throws Exception
     */
    public function __construct(string $id)
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
     * @param string $ref
     * @param string $libel
     * @param int $ord
     * @param string $parent
     * @return ODTreeview|bool
     */
    public function addLeaf(string $ref, string $libel, int $ord = null, string $parent = "0")
    {
        $properties = $this->getProperties();
        if (empty($parent)) { $parent = '0'; }

        $dataTree   = $properties['dataTree'];
        $dataPath   = $properties['dataPath'];
        $validAct   = false;

        if ($this->validRefUnique($ref)) {
            if ($parent == '0') {
                if ($ord == 0) { $ord = max(array_keys($dataTree)) + 1; }
                if (!isset($dataTree[$ord])) {
                    $item = [
                        'libel'     => $libel,
                        'ord'       => $ord,
                        'ref'       => $ref,
                        'icon'      => 'none',
                        'parent'    => '0',
                        'check'     => false,
                        'selectable'=> true,
                        'sortable'  => true,
                        'children'  => [],
                    ];

                    $dataTree[(string) $ord]    = $item;
                    $dataPath[$ref]             = (string) $ord;
                    $validAct                   = true;
                    ksort($dataTree);
                }
            } else {
                $leaf   = $this->getLeaf($parent);
                if ($ord == 0 || !isset($leaf['children'][$ord])) {
                    if ($ord == 0) {
                        $keys = array_keys($leaf['children']);
                        $ord  = empty($keys)? 1: (max($keys) + 1);
                    }
                    $item = [
                        'libel'     => $libel,
                        'ord'       => $ord,
                        'ref'       => $ref,
                        'icon'      => 'none',
                        'parent'    => $parent,
                        'check'     => false,
                        'selectable'=> true,
                        'sortable'  => true,
                        'children'  => [],
                    ];

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
     * @param string $libel
     * @param string $path
     * @return ODTreeview|bool
     */
    public function setLeaf(string $libel, string $path)
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
     * @param string $ref
     * @return array|bool
     */
    public function getLeaf(string $ref)
    {
        $properties = $this->getProperties();
        $dataPath   = $properties['dataPath'];

        if (empty($ref) || !array_key_exists($ref, $dataPath)) { $ref = "0"; }
        $refPath    = ($ref != "0") ? $dataPath[$ref] : null;
        return $this->getLeafByPath($refPath);
    }

    /**
     * @param string $path
     * @return bool|array
     */
    public function getLeafByPath(string $path = null)
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
     * @param string $ref
     * @return bool
     */
    public function isLeafNode(string $ref)
    {
        $properties = $this->getProperties();
        return array_key_exists($ref, $properties['dataPath']);
    }

    /**
     * @return ODTreeview
     */
    public function enaIcon()
    {
        $properties = $this->getProperties();
        $properties['icon'] = true;
        $this->setProperties($properties);
        return $this;
    }

    /**
     * @return ODTreeview
     */
    public function disIcon()
    {
        $properties = $this->getProperties();
        $properties['icon'] = false;
        $this->setProperties($properties);
        return $this;
    }

    /**
     * @param string $leafIco
     * @return ODTreeview
     */
    public function setLeafIco(string $leafIco)
    {
        $properties = $this->getProperties();
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
     * @param string $nodeOpenedIco
     * @return ODTreeview
     */
    public function setNodeOpenedIco(string $nodeOpenedIco)
    {
        $properties     = $this->getProperties();
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
     * @param string $nodeClosedIco
     * @return ODTreeview
     */
    public function setNodeClosedIco(string $nodeClosedIco)
    {
        $properties     = $this->getProperties();
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
     * @return ODTreeview
     */
    public function setSelectedLeaves(array $selectedLeaves)
    {
        $properties = $this->getProperties();
        $properties['dataSelected'] = $selectedLeaves;
        $this->setProperties($properties);
        return $this;
    }

    /**
     * @return bool|array
     */
    public function getSelectedLeaves()
    {
        $properties = $this->getProperties();
        return array_key_exists('dataSelected', $properties) ? $properties['dataSelected'] : false;
    }

    /**
     * @param string $class
     * @param string $method
     * @param bool $stopEvent
     * @return bool|ODTreeview
     */
    public function evtClick(string $class, string $method, bool $stopEvent = false)
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
     * @return ODTreeview
     */
    public function enaMultiSelect()
    {
        $properties = $this->getProperties();
        $properties['multiSelect'] = true;
        $this->setProperties($properties);
        return $this;
    }

    /**
     * @return ODTreeview
     */
    public function disMultiSelect()
    {
        $properties = $this->getProperties();
        $properties['multiSelect'] = false;
        $this->setProperties($properties);
        return $this;
    }

    /**
     * @param string $ref
     * @param bool $root
     * @return ODTreeview|bool
     */
    public function rmLeafNode(string $ref, bool $root = true)
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
                $dataPathL  = explode('-', $dataPath[$ref]);
                $dataTree   = $this->rmLeafTree($dataTree, $dataPathL);
            }
            unset($dataPath[$ref]);
            $properties['dataPath'] = $dataPath;
            $properties['dataTree'] = $dataTree;

            $this->setProperties($properties);
            return $this;
        }
        return false;
    }

    /**
     * @param string $title
     * @return ODTreeview
     */
    public function setTitle(string $title = "")
    {
        $title = (string) $title;
        $properties = $this->getProperties();
        $properties['title'] = $title;
        $this->setProperties($properties);
        return $this;
    }

    /**
     * @return bool|string
     */
    public function getTitle()
    {
        $properties             = $this->getProperties();
        return (array_key_exists('title', $properties)) ? $properties['title'] : false ;
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

    /**
     * @param string $ref
     * @return ODTreeview|bool
     */
    public function selectNode(string $ref)
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

    /**
     * @param string $ref
     * @return ODTreeview|bool
     */
    public function unselectNode(string $ref)
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

    /**
     * @param string $ref
     * @return ODTreeview|bool
     */
    public function enaSelectNode(string $ref) {
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

    /**
     * @param string $ref
     * @return ODTreeview|bool
     */
    public function disSelectNode(string $ref) {
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

    /**
     * @param string $ref
     * @param bool $andChildren
     * @return ODTreeview|bool
     */
    public function enaSortableNode(string $ref, bool $andChildren = false) {
		$leaf	= $this->getLeaf($ref);
		if (!empty($leaf)) {
			$properties				= $this->getProperties();
			$dataTree       		= &$properties['dataTree'];
            $dataPath       		= &$properties['dataPath'];

			$leaf['sortable']		= true;

			if (isset($leaf['children']) && !empty($leaf['children']) && $andChildren) {
				foreach ($leaf['children'] as $child) {
					if (!$this->enaSortableNode($child['ref'], $andChildren)) {
						return false;
					}
				}
			}

            $properties['dataTree'] = $this->updateTree($dataTree, $dataPath[$ref], $leaf);
            $this->setProperties($properties);
            return $this;
		}
		return false;
	}

    /**
     * @param string $ref
     * @param bool $andChildren
     * @return ODTreeview|bool
     */
    public function disSortableNode(string $ref, bool $andChildren = false) {
		$leaf	= $this->getLeaf($ref);
		if (!empty($leaf)) {
			$properties				= $this->getProperties();
			$dataTree       		= $properties['dataTree'];
            $dataPath       		= $properties['dataPath'];

			$leaf['sortable']		= false;

			if (isset($leaf['children']) && !empty($leaf['children']) && $andChildren) {
				foreach ($leaf['children'] as $child) {
					if (!$this->disSortableNode($child['ref'], $andChildren)) {
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

    /**
     * @param string $class
     * @param string $method
     * @param bool $stopEvent
     * @return bool|ODTreeview
     */
    public function evtClickNode(string $class, string $method, bool $stopEvent = false)
    {
        if (!empty($class) && !empty($method)) {
            return $this->setEvent('clickNode', $class, $method, $stopEvent);
        }
        return false;
	}

    /**
     * @return bool
     */
    public function getClickNode()
    {
        return $this->getEvent('clickNode');
    }

    /**
     * @return bool|ODTreeview
     */
    public function disClickNode()
    {
        return $this->disEvent('clickNode');
    }

    /**
     * @param $ref
     * @return bool|array
     */
    public function getParent($ref)
    {
        $leaf   = $this->getLeaf($ref);
        if ($leaf) { return $leaf['parent']; }
        return false;
    }

    /**
     * @param string $ref
     * @param int $level
     * @return array
     */
    public function getChildLeaves(string $ref, int $level = -1)
    {
        $children                       = [];
        if ($ref !== "0") {
            $leaf                       = $this->getLeaf($ref);
        } else {
            $leaf                       = [];
            $leaf['children']           = [];
            $properties = $this->getProperties();
            foreach ($properties['dataTree'] as $dataLeaf) {
                $item                   = [];
                $item['ref']            = $dataLeaf['ref'];
                $leaf['children'][]     = $item;
            }
        }

        if (array_key_exists('children', $leaf)) {
            foreach ($leaf['children'] as $child) {
                if ($level > 0 || $level = -1) {
                    if ($level > 0) { $level--; }
                    $children[] = $child['ref'];
                    $children = array_merge($children, $this->getChildLeaves($child['ref'], $level));
                }
            }
        }
        return $children;
    }

    /**
     * @param string $path
     * @return bool|false|int|string
     */
    public function getRef(string $path)
    {
        $properties = $this->getProperties();
        $dataPath   = $properties['dataPath'];
        return array_search($path, $dataPath) ?? false;
    }

    /**
     * @param string $ref
     * @return bool
     */
    public function getPath(string $ref)
    {
        $properties     = $this->getProperties();
        $optionsPath    = $properties['dataPath'];

        return array_key_exists($ref, $optionsPath) ? $optionsPath[$ref] : false;
    }

    /**
     * @param string $idBtn
     * @param array $optionsBtn
     * @return ODTreeview|bool
     * @throws ReflectionException
     */
    public function addBtnAction(string $idBtn, array $optionsBtn)
    {
        $validBtns  = $this->validArrayOptionsBtn($optionsBtn);
        if ($validBtns && !empty($idBtn)) {
            $item                       = [];
            $sessionObjects = self::validateSession();
            $objects        = $sessionObjects->objects;
            if (array_key_exists($idBtn, $objects)) { return false; }
            $properties     = $this->getProperties();
            $btnActions     = $properties['btnActions'];
            if (array_key_exists($idBtn, $btnActions)) { return false; }

            /** @var ODButton $btnAction */
            $btnAction = new ODButton($idBtn);
            if (isset($optionsBtn['label']) && !empty($optionsBtn['label']))
                                                                    { $btnAction->setLabel($optionsBtn['label']);}
            if (isset($optionsBtn['icon']) && !empty($optionsBtn['icon']))
                                                                    { $btnAction->setIcon($optionsBtn['icon']);}
            if (isset($optionsBtn['pathFile']) && !empty($optionsBtn['pathFile']))
                                                                    { $btnAction->setImage($optionsBtn['pathFile']);}
            if (!isset($optionsBtn['nature']) || empty($optionsBtn['nature'])) {
                $optionsBtn['nature'] = ODButton::BUTTONNATURE_INFO;
            }
            $btnAction->setNature($optionsBtn['nature']);
            if (!isset($optionsBtn['stopEvent']) || empty($optionsBtn['stopEvent'])) {
                $optionsBtn['stopEvent'] = false;
            }
            if (!$btnAction->evtClick($optionsBtn['class'], $optionsBtn['method'], $optionsBtn['stopEvent'])) {
                return false;
            }
            $btnAction->setWidth('2.5em');
            $item['position']           = $optionsBtn['position'] ?? 'right';
            $btnAction->addClass('BA'.$item['position']);
            $btnAction->setValue('odtreeview');
            $btnAction->saveProperties();
 
            $item['id']                 = $idBtn;
            if (isset($optionsBtn['ord']) && !empty($optionsBtn['ord'])) { return false; }
            $item['ord']                = sizeof($btnActions) + 1;
            $btnActions[$idBtn]         = $item;
            $properties['btnActions']   = $btnActions;
            $this->setProperties($properties);
            return $this;
        }
        return false;
    }

    /**
     * @param string $idBtn
     * @param array $optionsBtn
     * @return ODTreeview|bool
     * @throws ReflectionException
     */
    public function setBtnAction(string $idBtn, array $optionsBtn)
    {
        if ($this->validArrayOptionsBtn($optionsBtn) && !empty($idBtn)) {
            $properties     = $this->getProperties();
            $btnActions     = $properties['btnActions'];
            if (!array_key_exists($idBtn, $btnActions)) { return false; }

            $sessionObjects = self::validateSession();
            /** @var ODButton $btnAction */
            $btnAction      = self::buildObject($idBtn, $sessionObjects);
            $btnItem        = $btnActions[$idBtn];


            if (isset($optionsBtn['label']) && !empty($optionsBtn['label']))
            { $btnAction->setLabel($optionsBtn['label']);}
            if (isset($optionsBtn['icon']) && !empty($optionsBtn['icon']))
            { $btnAction->setIcon($optionsBtn['label']);}
            if (!isset($optionsBtn['nature']) || empty($optionsBtn['nature'])) {
                $optionsBtn['nature'] = ODButton::BUTTONNATURE_INFO;
            }
            $btnAction->setNature($optionsBtn['nature']);
            if (!isset($optionsBtn['stopEvent']) || empty($optionsBtn['stopEvent'])) {
                $optionsBtn['stopEvent'] = false;
            }
            if (!$btnAction->evtClick($optionsBtn['class'], $optionsBtn['method'], $optionsBtn['stopEvent'])) {
                return false;
            }
            $btnAction->setWidth('2.5em');
            $item['position']           = $optionsBtn['position'] ?? 'right';
            $btnAction->addClass('BA'.$item['position']);
            $btnAction->setValue('odtreeview');
            $btnAction->saveProperties();

            $btnItem['id']              = $idBtn;
            $btnItem['position']        = $optionsBtn['position'] ?? 'right';
            $btnActions[$idBtn]         = $btnItem;
            $properties['btnActions']   = $btnActions;
            $this->setProperties($properties);
            return $this;
        }
        return false;
    }

    /**
     * @param string $idBtn
     * @return bool|array
     */
    public function getBtnAction(string $idBtn)
    {
        $properties     = $this->getProperties();
        $btnActions     = $properties['btnActions'];
        if (!array_key_exists($idBtn, $btnActions)) { return false; }
        else                                        { return $btnActions[$idBtn]; }
    }

    /**
     * @param string $btnId
     * @return bool
     */
    public function isBtnAction(string $btnId)
    {
        $properties = $this->getProperties();
        return array_key_exists($btnId, $properties['btnActions']);
    }

    /**
     * @param string $refNode
     * @param array $btnActions
     * @return $this|bool
     */
    public function addBtnsNode(string $refNode, array $btnActions)
    {
        foreach ($btnActions as $btnAction) {
            if (!$this->isBtnAction($btnAction)) { return false; }
        }
        $leaf = $this->getLeaf($refNode);
        if ($leaf) {
            $properties             = $this->getProperties();
            $dataTree               = $properties['dataTree'];
            $dataPath               = $properties['dataPath'];

            if (!array_key_exists('btnActions', $leaf) || $leaf['btnActions'] == null) { $leaf['btnActions'] = []; }
            $leaf['btnActions']     = array_merge($leaf['btnActions'], $btnActions);

            $dataTree               = $this->updateTree($dataTree, $dataPath[$refNode], $leaf);
            $properties['dataTree'] = $dataTree;
            $this->setProperties($properties);
            return $this;
        }
        return false;
    }

    /**
     * @param string $refNode
     * @param array $btnActions
     * @return $this|bool
     */
    public function setBtnsNode(string $refNode, array $btnActions)
    {
        foreach ($btnActions as $btnAction) {
            if (!$this->isBtnAction($btnAction)) { return false; }
        }
        $leaf = $this->getLeaf($refNode);
        if ($leaf) {
            $properties             = $this->getProperties();
            $dataTree               = $properties['dataTree'];
            $dataPath               = $properties['dataPath'];

            $leaf['btnActions']     = $btnActions;

            $dataTree               = $this->updateTree($dataTree, $dataPath[$refNode], $leaf);
            $properties['dataTree'] = $dataTree;
            $this->setProperties($properties);
            return $this;
        }
        return false;
    }

    /**
     * @param string $refNode
     * @return bool|array
     */
    public function getBtnsNode(string $refNode)
    {
        $leaf = $this->getLeaf($refNode);
        if ($leaf) { return $leaf['btnActions']; }
        return false;
    }

    /**
     * @param string $refNode
     * @param string $newRef
     * @param null $ord
     * @return bool|ODTreeview
     */
    public function addCloneNode(string $refNode, string $newRef, $ord = null)
    {
        $properties = $this->getProperties();
        $dataPath   = $properties['dataPath'];
        $result     = false;

        /** $newRef ne doit pas éxister déjà, et $refNode doit exister */
        if (!array_key_exists($newRef, $dataPath) && array_key_exists($refNode, $dataPath)) {
            $result = $this->addCloneNodeChild($refNode, $newRef, $dataPath, $ord);
        }
        return $result;
    }

    /** **************************************************************************************************
     * méthodes de gestion de retour de callback                                                         *
     * *************************************************************************************************** */

    /**
     * @param ServiceManager $sm
     * @param array $params
     * @return array
     * @throws Exception
     */
    public function dispatchEvents(ServiceManager $sm, array $params)
    {
        $sessionObjects     = self::validateSession();
        $ret                = [];
        /** @var ODTreeview $object */
        $object             = self::buildObject($params['id'], $sessionObjects);
		switch ($params['event']) {
			case 'click':
			    $value      = $params['value'];
			    if (!array_key_exists('selected', $value)) { $value['selected'] = []; }
			    $leaves     = $object->getSelectedLeaves();
                foreach ($leaves as $leaf) {
                    $object->unselectNode($leaf);
			    }
			    $object->setSelectedLeaves($value["selected"]);
                foreach ($value["selected"] as $select) {
                    $object->selectNode($select);
			    }
                $object->saveProperties();

                $callback = $this->getClickNode();
                if (!empty($callback['class']) && !empty($callback['method'])) {
                    $results = call_user_func_array([$callback['class'], $callback['method']], [$sm, $params]);
                    $ret     = array_merge($ret, $results);
                }
				break;
			case 'sortupdate':
				break;
		}
		$object->saveProperties();
		return $ret;
	}

    /**
     * @param $parentPath
     * @param $ord
     * @return array
     */
    public function returnAddLeaf(string $parentPath, int $ord)
    {
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
        $ret[] = self::formatRetour($this->getId(), $this->getId(), $mode, $code);
        $ret[] = self::formatRetour($this->getId(), $this->getId(), 'exec', '$("#'.$this->getId().' .treeview").off().find("*").off();');
        $ret[] = self::formatRetour($this->getId(), $this->getId(), 'execID', $this->getId().'Script');
        return $ret ;
    }

    /**
     * @param string $leafPath
     * @return array
     */
    public function returnDelLeaf(string $leafPath)
    {
        $leafPath = (string) $leafPath;
        $leaf     = $this->getLeaf($leafPath);
        $selector = $this->getId().'Li-'.$leaf['parent'].'-'.$leaf['ord'];

        $ret[] = self::formatRetour($this->getId(), $selector, 'delete');

        return $ret ;
    }

    /** **************************************************************************************************
     * méthodes privées de la classe                                                                     *
     * *************************************************************************************************** */

    /**
     * @param array $tree
     * @param string $path
     * @param array $item
     * @param bool $addNode
     * @return mixed
     */
    private function updateTree(array $tree, string $path, array $item, bool $addNode = false)
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
     * @param string $ref
     * @return bool
     */
    private function validRefUnique(string $ref)
    {
        $properties = $this->getProperties();
        $dataPath   = $properties['dataPath'];
        return (!array_key_exists($ref, $dataPath));
    }

    /**
     * @param array $dataTree
     * @param array $refs
     * @return mixed
     */
    private function rmLeafTree(array $dataTree, array $refs)
    {
        if ((int) $refs[0] == 0) { unset($refs[0]); }

        if (sizeof($refs) > 1) {
            $ref        = array_shift($refs);
            $localTree  = $this->rmLeafTree($dataTree[$ref]['children'], $refs);
            $dataTree[$ref]['children'] = $localTree;
        } else {
            unset($dataTree[$refs[0]]);
        }

        return $dataTree;
    }

    /**
     * @param array $optionsBtn
     * @return bool
     */
    private function validArrayOptionsBtn(array $optionsBtn)
    {
        $valid = true;
        foreach (self::ARRAY_OPTIONS as $cle => $isRequire) {
            switch ($isRequire) {
                case 'require' :
                    $valid = $valid && array_key_exists($cle, $optionsBtn);
                    break;
                case 'noRequire':
                    break;
                case 'mixte':
                    $valid = $valid &&
                        (array_key_exists('label', $optionsBtn) || array_key_exists('icon', $optionsBtn));
                    break;
                default:
                    $valid = false;
            }
            if (!$valid) { break; }
        }
        return $valid;
    }

    /**
     * @param string $refNode
     * @param string $newRef
     * @param array $dataPath
     * @param null $ord
     * @return ODTreeview|bool
     */
    private function addCloneNodeChild(string $refNode, string $newRef, array $dataPath, $ord = null)
    {
        $node   = $this->getLeaf($refNode);
        if ($node['parent'] == "0") {
            $parent = [];
            $parent['children'] = $this->getLeaf($node["parent"]);
        }
        else { $parent = $this->getLeaf($node['parent']); }

        if (empty($ord) ||
            (array_key_exists('children', $parent) && !array_key_exists($ord, $parent['children']))) {

            $this->addLeaf($newRef, $node['libel'], $ord, $node['parent']);

            if (array_key_exists('children', $node) && !empty($node['children'])) {
                foreach ($node['children'] as $child) {
                    $newChildRef    = $newRef.'-'.$child['ord'];
                    if (array_key_exists($newChildRef, $dataPath)) { return false; }
                    $this->addCloneNodeChild($child['ref'], $newChildRef, $dataPath);
                }
            }
            return $this;
        }
        return false;
    }
}
