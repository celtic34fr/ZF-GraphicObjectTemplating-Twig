<?php

namespace GraphicObjectTemplating\OObjects\ODContained;


use GraphicObjectTemplating\OObjects\ODContained;

class ODTreeview extends ODContained
{

    const ODTREEVIEWTARGET_SELF     = '_self';
    const ODTREEVIEWTARGET_BLANK    = '_blank';
    const ODTREEVIEWTARGET_PARENT   = '_parent';
    const ODTREEVIEWTARGET_TOP      = '_Top';

    private $const_target;

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

    public function addLeaf($id, $label, $link, $target = self::ODTREEVIEWTARGET_SELF, $icon = '',$parent = NULL, $open = true, $disable = false, $select = false)
    {
        $targets            = $this->getTargetConstants();
        $target             = (string) $target;
        if (!in_array($target, $targets)) { $target = self::ODTREEVIEWTARGET_SELF; }

        $properties         = $this->getProperties();
        $id                 = (string) $id;
        $label              = (string) $label;
        $link               = (string) $link;
        $icon               = (string) $icon;

        $dataPath           = $properties['dataPath'];
        $dataTree           = $properties['dataTree'];

        $item               = [];
        $item['id']         = $id;
        $item['label']      = $label;
        $item['link']       = $link;
        $item['target']     = $target;
        $item['icon']       = $icon;
        $item['open']       = $open;
        $item['disable']    = $disable;
        $item['select']     = $select;

        if (!array_key_exists($id, $dataPath)) {
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

    /** **************************************************************************************************
     * méthodes privées de la classe                                                                     *
     * *************************************************************************************************** */

    private function getTargetConstants()
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
}