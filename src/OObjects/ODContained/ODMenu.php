<?php

namespace GraphicObjectTemplating\OObjects\ODContained;

use GraphicObjectTemplating\OObjects\ODContained;
use GraphicObjectTemplating\OObjects\OObject;

/**
 * Class ODMenu
 * @package GraphicObjectTemplating\Objects\ODContained
 *
 * __construct($id)         constructeur de l'objet, obligation de fournir $id identifiant de l'objet
 * addLeaf($id, $label, $link, $float=self::ODMENUPOSITION_LEFT, $parent = NULL, $target = self;;ODMENUTARGET_SELF, $enable = true)
 * deactiveAll()
 * active($id)
 * getActive()
 * function removeLeaf($id)
 * clearTree()
 * function updateLeaf($id, $item, $keepDropdown = true)
 * setMenus(array $menus)
 * getMenu($id)
 * getMenus()
 * getDataPath()
 * getDataTree()
 * setMode($mode = self::ODMENUMODE_CLICK)
 * getMode()
 * setTitle($title)
 * getTitle()
 * getTargetConstants()
 *
 * méthodes privées de la classe
 * -----------------------------
 * insertLeaf($tree, $path, $item, $parent = null)
 * activeTree($tree, $path)
 * deactiveTree($tree, $path)
 * removeSubTree($tree, $tmpPath)
 * updateSubTree($tree, $tmpPath, $item, $keepDropdown)
 * getLeaf($tree, $tmpPath)
 * tree2array($tree, $parent = false)
 * getPositionConstants()
 * getModeConstants()
 */
class ODMenu extends ODContained
{
    const ODMENUPOSITION_LEFT   = "left";
    const ODMENUPOSITION_RIGHT  = "right";

    const ODMENUMODE_CLICK      = 'click';
    const ODMENUMODE_HOVER      = 'hover';

    const ODMENUTARGET_SELF     = '_self';
    const ODMENUTARGET_BLANK    = '_blank';
    const ODMENUTARGET_PARENT   = '_parent';
    const ODMENUTARGET_TOP      = '_Top';

    private $const_position;
    private $const_mode;
    private $const_target;

    public function __construct($id)
    {
        parent::__construct($id, "oobjects/odcontained/odmenu/odmenu.config.phtml");

        $properties = $this->getProperties();
        if ($properties['id'] != 'dummy') {
            if (!$this->getWidthBT() || empty($this->getWidthBT())) {
                $this->setWidthBT(12);
            }
            $this->setDisplay(OObject::DISPLAY_BLOCK);
            $this->enable();
        }
        return $this;
    }

    public function addLeaf($id, $label, $link, $float=self::ODMENUPOSITION_LEFT, $parent = NULL, $target = self::ODMENUTARGET_SELF, $enable = true)
    {
        $floats = $this->getPositionConstants();
        $float  = (string) $float;
        if (!in_array($float, $floats)) { $float = self::ODMENUPOSITION_LEFT; }

        $targets    = $this->getTargetConstants();
        $target     = (string) $target;
        if (!in_array($target, $targets)) { $target = self::ODMENUTARGET_SELF; }

        $properties     = $this->getProperties();
        $id             = (string) $id;
        $label          = (string) $label;
        $link           = (string) $link;

        $dataPath       = $properties['dataPath'];
        $dataTree       = $properties['dataTree'];

        if ($this->validIdUnique($id)) {
            $item           = [];
            $item['id']     = $id;
            $item['label']  = $label;
            $item['link']   = $link;
            $item['float']  = $float;
            $item['target'] = $target;
            $item['enable'] = $enable;
            $item['active'] = false;

            if (!empty($parent)) {
                $dataPath[$id] = $dataPath[$parent] .".". $id;
            } else {
                $dataPath[$id] = $id;
            }
            $dataTree = $this->insertLeaf($dataTree, $dataPath, $item, $parent);

            $properties['dataPath'] = $dataPath;
            $properties['dataTree'] = $dataTree;
            $this->setProperties($properties);
            return $this;
        }
        return false;
    }

    public function deactiveAll()
    {
        $properties                 = $this->getProperties();
        $dataPath                   = $properties['dataPath'];
        $dataTree                   = $properties['dataTree'];
        $idPath                     = $properties['activeMenu'];
        if (!empty($idPath)) {
            $dataTree               = $this->deactiveTree($dataTree, $idPath);
        }

		$properties['dataTree'] = $dataTree;
		$this->setProperties($properties);
		return $this;
    }

    public function active($id)
    {
        $properties                 = $this->getProperties();
        $dataPath                   = $properties['dataPath'];
        $dataTree                   = $properties['dataTree'];
        $idPath                     = $properties['activeMenu'];
        if (!empty($idPath)) {
            $dataTree               = $this->deactiveTree($dataTree, $idPath);
        }
        $idPath                     = $dataPath[$id];
        $properties['activeMenu']   = $idPath;

        $idPath     = explode(".", $idPath);
        $dataTree   = $this->activeTree($dataTree, $idPath);

		$properties['dataTree'] = $dataTree;
		$this->setProperties($properties);
		return $this;
    }

    public function getActive()
    {
        $properties                 = $this->getProperties();
        return (isset($properties['activeMenu'])) ? $properties['activeMenu'] : false;
    }

    public function removeLeaf($id)
    {
        $properties                  = $this->getProperties();
        $dataPath                    = $properties['dataPath'];
        $dataTree                    = $properties['dataTree'];

        $tmpPath                     = $dataPath[$id];
        $tmpPath                     = explode(".", $tmpPath);
        $localPath                   = $tmpPath[0];
        unset($tmpPath[0]);
        $dataTree[$localPath] = $this->removeSubTree($dataTree[$localPath], $tmpPath);
    }

    public function clearTree()
    {
		$properties     = $this->getProperties();
		$properties['dataTree'] = [];
		$properties['dataPath'] = [];
		$this->setProperties($properties);
		return $this;
	}

    public function updateLeaf($id, $item, $keepDropdown = true)
    {
        $properties                  = $this->getProperties();
        $dataPath                    = $properties['dataPath'];
        $dataTree                    = $properties['dataTree'];

        $tmpPath                     = $dataPath[$id];
        $tmpPath                     = explode(".", $tmpPath);
        $localPath                   = $tmpPath[0];
        unset($tmpPath[0]);
        $dataTree[$localPath] = $this->updateSubTree($dataTree[$localPath], $tmpPath, $item, $keepDropdown);
    }

    public function setMenus(array $menus)
    {
        /* vidage du contenu courrant de dataTre et dataPath */
        $properties                  = $this->getProperties();
        $properties['dataPath']      = [];
        $properties['dataTree']      = [];
        $this->setProperties($properties);
        $dataPath = $this->getDataPath();

        foreach ($menus as $menu) {
            try {
                $id     = $menu['id'];
                $label  = $menu['label'];
                $link   = (isset($menu['link'])) ? $menu['link'] : "";
                $float  = (isset($menu['float'])) ? $menu['float'] : "left";
                $parent = (isset($menu['parent'])) ? $menu['parent'] : "";
                $enable = (isset($menu['enable'])) ? $menu['enable'] : true;
            } catch(\Exception $e) {
                throw new \Exception("setMenu(), array not correctly form");
            } finally {
                if (array_key_exists($id, $dataPath)) {
                    throw new \Exception("setMenu(), dupplicate key ".$id);
                }
            }
            $this->addLeaf($id, $label, $link, $float, $parent, $enable);
            $dataPath = $this->getDataPath();
        }
        return $this;
    }

    public function getMenu($id)
    {
        $properties     = $this->getProperties();
        $dataPath       = $properties['dataPath'];
        $dataTree       = $properties['dataTree'];

        if (array_key_exists($id, $dataPath)) {
            $tmpPath    = $dataPath[$id];
            $tmpPath    = explode('.', $tmpPath);
            $localPath  = $tmpPath[0];
            $item       = $this->getLeaf($dataTree[$localPath], $tmpPath);
            return $item;
        }
        return false;
    }

    public function getMenus()
    {
        $properties     = $this->getProperties();
        $dataTree       = $properties['dataTree'];

        return $this->tree2array($dataTree);
    }

    public function getDataPath()
    {
        $properties     = $this->getProperties();
        return $properties['dataPath'];
    }

    public function getDataTree()
    {
        $properties     = $this->getProperties();
        return $properties['dataTree'];
    }

    public function setMode($mode = self::ODMENUMODE_CLICK)
    {
        $modes  = $this->getModeConstants();
        $mode   = (string) $mode;
        if (!in_array($mode, $modes)) { $mode = self::ODMENUMODE_CLICK; }
        /* vidage du contenu courrant de dataTre et dataPath */
        $properties                 = $this->getProperties();
        $properties['mode']         = $mode;
        $this->setProperties($properties);
        return $this;
    }

    public function getMode()
    {
        $properties                 = $this->getProperties();
        return (isset($properties['mode'])) ? $properties['mode'] : false;
    }

    public function setTitle($title)
    {
        $title                      = (string) $title;
        $properties                 = $this->getProperties();
        $properties['title']        = $title;
        $this->setProperties($properties);
        return $this;
    }

    public function getTitle()
    {
        $properties                 = $this->getProperties();
        return (isset($properties['title'])) ? $properties['title'] : false;
    }

    public function getTargetConstants()
    {
        $retour = [];
        if (empty($this->const_target)) {
            $constants = $this->getConstants();
            foreach ($constants as $key => $constant) {
                $pos = strpos($key, 'ODMENUTARGET_');
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

    /** **************************************************************************************************
     * méthodes privées de la classe                                                                     *
     * *************************************************************************************************** */

    private function insertLeaf($tree, $path, $item, $parent = null)
    {
        switch (true) {
            case ($parent == null) :
                $tree[$item['id']] = $item;
                break;
            case ($parent != null) :
                $tmpPath = $path[$parent];
                $tmpPath = explode(".", $tmpPath);
                $nParent = sizeOf($tmpPath);
                if (!isset($tree[$parent]['dropdown'])) $tree[$parent]['dropdown'] = [];
                $localPath = ($nParent > 1) ? $tmpPath[$nParent - 2] : null;
                $tree[$parent]['dropdown'] = $this->insertLeaf($tree[$parent]['dropdown'], $path, $item, $localPath);
                break;
        }
        return $tree;
    }

    private function activeTree($tree, $path)
    {
        if (!empty($path)) {
            $localPath = $path[0];
            unset($path[0]);

            $tree[$localPath]['active'] = true;
            if (isset($tree[$localPath]['dropdown']))
                $tree[$localPath]['dropdown'] = $this->activeTree($tree[$localPath]['dropdown'], $path);
        }
        return $tree;
    }

    private function deactiveTree($tree, $path)
    {
        if (!empty($path) && !is_array($path)) {
            $tree[$path]['active'] = false;
        } elseif (!empty($path)) {
            $localPath = $path[0];
            unset($path[0]);

            $tree[$localPath]['active'] = false;
            $tree[$localPath]['dropdown'] = $this->deactiveTree($tree[$localPath]['dropdown'], $path);
        }
        return $tree;
    }

    private function removeSubTree($tree, $tmpPath)
    {
        if (!empty($tmpPath)) {
            $localPath                   = $tmpPath[0];
            unset($tmpPath[0]);
            if (!empty($tmpPath)) {
                $tree[$localPath] = $this->removeSubTree($tree[$localPath], $tmpPath);
            } else {
                if (isset($tree[$localPath]['dropdown'])) unset($tree[$localPath]['dropdown']);
            }
        }
        return $tree;
    }

    private function updateSubTree($tree, $tmpPath, $item, $keepDropdown)
    {
        if (!empty($tmpPath)) {
            $localPath                   = $tmpPath[0];
            unset($tmpPath[0]);
            if (!empty($tmpPath)) {
                $tree[$localPath] = $this->removeSubTree($tree[$localPath], $tmpPath);
            } else {
                if (isset($tree[$localPath]['dropdown']) && $keepDropdown) {
                    $item['dropdown'] = $tree[$localPath]['dropdown'];
                } elseif (isset($tree[$localPath]['dropdown'])) {
                    unset($tree[$localPath]['dropdown']);
                }
                $tree[$localPath] = $item;
            }
        }
        return $tree;
    }

    private function getLeaf($tree, $tmpPath)
    {
        if (!empty($tmpPath)) {
            $localPath                   = $tmpPath[0];
            unset($tmpPath[0]);
            if (!empty($tmpPath)) {
                $tree[$localPath] = $this->getLeaf($tree[$localPath], $tmpPath);
            }
        }
        return $tree;
    }

    private function tree2array($tree, $parent = false)
    {
        $treeArray = [];
        foreach ($tree as $id => $leaf) {
            $item = [];
            $item['id']         = $leaf['id'];
            $item['label']      = $leaf['label'];
            $item['link']       = $leaf['link'];
            $item['float']      = $leaf['float'];
            $item['enable']     = $leaf['enable'];
            $item['parent']     = $parent;
            $treeArray[]        = $item;

            if (isset($tree['dropdown']) && !empty($tree['dropdown'])) {
                $treeArray = array_merge($this->tree2array($tree['dropdown'], $id), $treeArray);
            }
        }

        return $treeArray;
    }

    private function getPositionConstants()
    {
        $retour = [];
        if (empty($this->const_position)) {
            $constants = $this->getConstants();
            foreach ($constants as $key => $constant) {
                $pos = strpos($key, 'ODMENUPOSITION_');
                if ($pos !== false) {
                    $retour[$key] = $constant;
                }
            }
            $this->const_position = $retour;
        } else {
            $retour = $this->const_position;
        }
        return $retour;
    }

    private function getModeConstants()
    {
        $retour = [];
        if (empty($this->const_mode)) {
            $constants = $this->getConstants();
            foreach ($constants as $key => $constant) {
                $pos = strpos($key, 'ODMENUMODE_');
                if ($pos !== false) {
                    $retour[$key] = $constant;
                }
            }
            $this->const_mode = $retour;
        } else {
            $retour = $this->const_mode;
        }
        return $retour;
    }

    private function validIdUnique($id)
    {
        $properties = $this->getProperties();
        $dataPath   = $properties['dataPath'];
        return (!array_key_exists($id, $dataPath));
    }
}
