<?php

namespace GoTemplating\Objects\ODContained;

use GraphicObjectTemplating\OObjects\ODContained;
use Zend\Session\Container;

/**
 * Class ODBreadcrumbs
 * @package GraphicObjectTemplating\Objects\ODContained
 *
 * setTree      : initialise le fil d'ariane avec le contenu du tableau $tree [['label', 'url'], ...]
 * addItem      : ajoute à la suite un nouvel élément du fil d'ariane
 * removeItem   : supprime le dernier élément du fil d'ariane
 * clearTree    : supprime tout le contenu du fil d'arraine
 */

class ODBreadcrumbs extends ODContained
{
    public function __construct(string $id, array $pathObjArray = []) {
        $session = new Container($id);
        if ($session->offsetExists('properties')) {
            $properties = unserialize($session->offsetGet('properties'), ['allowed_classes' => true]);
            $this->setProperties($properties);
        } else {
            $pathObjArray[] = "oobject/odcontained/odbreadcrumbs/odbreadcrumbs.config.phtml";
		parent::__construct($id, $pathObjArray);
        }
        $this->setDisplay();
    }

    public function setTree(array $tree)
    {
        $properties = $this->getProperties();
        $properties['tree'] = $tree;
        $this->setProperties($properties);
        return $this;
    }

    public function addItem($label, $url)
    {
        $label = (string) $label;
        $url   = (string) $url;

        if (!empty($label) && !empty($url)) {
            $item = [];
            $item['label'] = $label;
            $item['url']   = $url;

            $properties    = $this->getProperties();
            $properties['tree'][] = $item;
            $this->setProperties($properties);
            return $this;
        }
    }

    public function removeItem()
    {
        $properties    = $this->getProperties();
        $tree          = $properties['tree'];
        $delItemId     = sizeof($tree) - 1;
        unset($tree[$delItemId]);

        $properties['tree'] = $tree;
        $this->setProperties($properties);
        return $this;
    }

    public function clearTree()
    {
        $properties    = $this->getProperties();
        $properties['tree'] = [];
        $this->setProperties($properties);
        return $this;
    }
}