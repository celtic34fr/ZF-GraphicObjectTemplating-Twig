<?php

namespace GraphicObjectTemplating\OObjects\ODContained;

use Exception;
use GraphicObjectTemplating\OObjects\ODContained;

/**
 * Class ODMenu
 * @package GraphicObjectTemplating\OObjects\ODContained
 * objet visant à mettre en place et assurer la gestion d'un menu dans une page HTML
 *
 * __construct($id) : constructeur de l'objet
 * addOption(string $ref, array $item, int $ord = 0, string $parent = null)
 * addOptionByPath(string $ref, array $item, int $ord, string $pathParent = null)
 * setOption(string $ref, array $item, int $ord, string $parent = null)
 * setOptionByPath(string $ref, array $item, int $ord, string $pathParent)
 * getOption(string $ref)
 * getOptionByPath(string $pathOption)
 * rmOption($ref)
 * rmOptionByPath(string $pathOption)
 * getRef(string $pathOption)
 * getPath(string $ref)
 * clearOptions()
 * getOptions()
 * setOptions(array $options)
 * setTitle(string $title)
 * getTitle()
 *
 * méthodes privées de la classe
 * -----------------------------
 * getPositionConstants()
 * getTargetConstants()
 * insertOption(array $tree, int $ord, array $item, array $parentPath = null)
 * removeOption(array $pathOption, array $optionsPath, array $tree)
 * removePathChildren(array $optionsPath, array $option)
 * findOption(array $pathOption, array $tree)
 * validateOptionsArray(array $options)
 * buildOptionsArray($node, $nodesArray)
 */
class ODMenu extends ODContained
{
    const ODMENU_POSITION_LEFT = "left";
    const ODMENU_POSITION_RIGHT = "right";

    const ODMENU_TARGET_SELF = '_self';
    const ODMENU_TARGET_BLANK = '_blank';
    const ODMENU_TARGET_PARENT = '_parent';
    const ODMENU_TARGET_TOP = '_top';

    private $const_position;
    private $const_target;

    /**
     * ODMenu constructor.
     * @param $id
     * @throws \ReflectionException
     * @throws \Exception
     */
    public function __construct($id)
    {
        parent::__construct($id, "oobjects/odcontained/odmenu/odmenu.config.php");

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
    
    private function validateItem(array &$item) {
        if (!array_key_exists('label', $item) or !array_key_exists('link', $item)) return false;
    
        $targets    = $this->getTargetConstants();
        $posis      = $this->getPositionConstants();
        if (!array_key_exists('target', $item) || !in_array($item['target'], $targets)) {
            $item['target'] = self::ODMENU_TARGET_SELF;
        }
        if (!array_key_exists('pos', $item) || !in_array($item['pos'], $posis)) {
            $item['pos']    = self::ODMENU_POSITION_LEFT;
        }
        if (!array_key_exists('activ', $item)) { $item['activ'] = false; }
        $item['activ']      = (bool) $item['activ'];
        
        return true;
    }

    /**
     * méthode addOption visant à insérer une option de menu dans l'abre menu
     *
     * @param $ref : référence d'accès à l'option à insérer
     * @param array $item : tableau des données de l'option de menu
     *      label (obligatoire) : texte affiché à l'écran
     *      link (obligatoire) : URL vers laquelle pointe l'option de menu ('#' si rien à faire)
     *      target : mode d'ouverture du lien link
     *      pos : position de l'option de menu (left : cadrée à gauche, right : cadrée à droite)
     *      activ : booléen indiquant si l'option de menu est sélectionné (true) ou non (false)
     * @param int $ord : numéro d'ordre de l'option de menu (ne doit pas exister pour création sinon 'new Exception())
     * @param string|null $parent : chemin d'accès dans l'arbre du parent de l'option à insérer
     * @return boolean|ODMenu : retourne l'objet lui-même afin, de pouvoir chaîner les appels de méthodes
     * retourne false : option de menu ($item) n'est pas cohérente ou référence $parent n'existe pas dans optionsPath
     * @throws Exception
     */
    public function addOption(string $ref, array $item, int $ord = 0, string $parent = null)
    {
        $properties         = $this->getProperties();
        $optionsPath        = &$properties['optionsPath'];
        $optionsTree        = &$properties['optionsTree'];

        if (!$this->validateItem($item)) return false;
        
        $item["ref"] = $ref;
        if (!empty($parent)) {
            $parent = $optionsPath[$parent];
            $prefix = substr($parent, 0, 1);
            $parent = explode('-', substr($parent, 1));
            $idTree = ($prefix == 'L') ? self::ODMENU_POSITION_LEFT : self::ODMENU_POSITION_RIGHT;
        } else {
            $prefix = ($item['pos'] == self::ODMENU_POSITION_LEFT) ? 'L' : 'R';
            $idTree = $item['pos'];
        }
        $optionsPath[$ref] = $this->insertOption($optionsTree[$idTree], $ord, $item, $parent);
        
        $this->setProperties($properties);

        return $this;
    }

    /**
     * méthode addOption visant à insérer une option de menu dans l'abre menu avec le chemin d'accès au parent
     *
     * @param $ref : référence d'accès à l'option à insérer
     * @param array $item : tableau des données de l'option de menu
     *      label (obligatoire) : texte affiché à l'écran
     *      link (obligatoire) : URL vers laquelle pointe l'option de menu ('#' si rien à faire)
     *      target : mode d'ouverture du lien link
     *      pos : position de l'option de menu (left : cadrée à gauche, right : cadrée à droite)
     *      activ : booléen indiquant si l'option de menu est sélectionné (true) ou non (false)
     * @param int $ord : numéro d'ordre de l'option de menu (ne doit pas exister pour création sinon 'new Exception())
     * @param string $pathParent : chemine d'accès à l'option parente
     * @return boolean|ODMenu : retourne l'objet lui-même afin, de pouvoir chaîner les appels de méthodes
     * retourne false : option de menu ($item) n'est pas cohérente ou chemin $pathParent n'existe pas dans optionsPath
     * @throws \ReflectionException
     * @throws Exception
     */
    public function addOptionByPath(string $ref, array $item, int $ord, string $pathParent = null)
    {
        $properties         = $this->getProperties();
        $optionsPath        = $properties['optionsPath'];
        $optionsTree        = $properties['optionsTree'];

        if (!array_key_exists('label', $item) or !array_key_exists('link', $item)) { return false; }
        if (!empty($pathParent) && !in_array($pathParent, $optionsPath)) { return false; }

        $targets    = $this->getTargetConstants();
        $posis      = $this->getPositionConstants();
        if (!array_key_exists('target', $item) || !in_array($item['target'], $targets)) {
            $item['target'] = self::ODMENU_TARGET_SELF;
        }
        if (!array_key_exists('pos', $item) || !in_array($item['pos'], $posis)) {
            $item['pos']    = self::ODMENU_POSITION_LEFT;
        }
        $item['ref']        = $ref;
        if (!array_key_exists('activ', $item)) { $item['activ'] = false; }
        $item['activ']      = $item['activ'] && true;

        if (!empty($pathParent)) {
            $parent = explode('-', substr($pathParent, 1));
        }
        $prefix = ($item['pos'] == self::ODMENU_POSITION_LEFT) ? 'L' : 'R';
        $pathOption = $this->insertOption($optionsTree[$item['pos']], $ord, $item, $parent);
        $optionsPath[$ref] = $prefix.$pathOption;

        $properties['optionsPath']  = $optionsPath;
        $properties['optionsTree']  = $optionsTree;
        $this->setProperties($properties);

        return $this;
    }

    /**
     * méthode de mise à jour d'une option existante par référence parent
     *
     * @param $ref : référence d'accès à l'option à modifier
     * @param array $item : tableau des données de l'option de menu
     *      label (obligatoire) : texte affiché à l'écran
     *      link (obligatoire) : URL vers laquelle pointe l'option de menu ('#' si rien à faire)
     *      target : mode d'ouverture du lien link
     *      pos : position de l'option de menu (left : cadrée à gauche, right : cadrée à droite)
     * @param int $ord : numéro d'ordre de l'option de menu (doit exister pour modification sinon 'new Exception())
     * @param string|null $parent : chemin d'accès dans l'arbre du parent de l'option à modifier
     * @return ODMenu|bool : retourne l'objet lui-même afin, de pouvoir chaîner les appels de méthodes
     * retourne false : option de menu ($item) n'est pas cohérente ou référence $parent n'existe pas dans optionsPath
     * ou la référence $ref n'existe pas dans optionsPath
     * @throws \ReflectionException
     * @throws Exception
     */
    public function setOption(string $ref, array $item, int $ord, string $parent = null)
    {
        $properties     = $this->getProperties();
        $optionsPath    = $properties['optionsPath'];

        if (!array_key_exists('label', $item) or !array_key_exists('link', $item)) { return false; }
        if (!empty($parent) && !array_key_exists($parent, $optionsPath)) { return false; }
        if (!array_key_exists($ref, $optionsPath)) { return false; }

        $optionsTree    = $properties['optionsTree'];
        $targets        = $this->getTargetConstants();
        $posis          = $this->getPositionConstants();
        if (!array_key_exists('target', $item) || !in_array($item['target'], $targets)) {
            $item['target'] = self::ODMENU_TARGET_SELF;
        }
        if (!array_key_exists('pos', $item) || !in_array($item['pos'], $posis)) {
            $item['pos']    = self::ODMENU_POSITION_LEFT;
        }
        $item['ref']        = $ref;

        if (!empty($parent)) {
            $parent = $optionsPath[$parent];
            $parent = explode('-', $parent);
        }
        $this->insertOption($optionsTree, $ord, $item, $parent, false);

        $properties['optionsTree']  = $optionsTree;
        $this->setProperties($properties);

        return $this;
    }

    /**
     * méthode de mise à jour d'une option existante par référence parent
     *
     * @param $ref : référence d'accès à l'option à modifier
     * @param array $item : tableau des données de l'option de menu
     *      label (obligatoire) : texte affiché à l'écran
     *      link (obligatoire) : URL vers laquelle pointe l'option de menu ('#' si rien à faire)
     *      target : mode d'ouverture du lien link
     *      pos : position de l'option de menu (left : cadrée à gauche, right : cadrée à droite)
     * @param int $ord : numéro d'ordre de l'option de menu (doit exister pour modification sinon 'new Exception())
     * @param string $pathParent : chemin d'accès au parent de l'option à modifier
     * @return ODMenu|bool : retourne l'objet lui-même afin, de pouvoir chaîner les appels de méthodes
     * retourne false : option de menu ($item) n'est pas cohérente ou chemin $pathParent n'existe pas dans optionsPath
     * ou la référence $ref n'existe pas dans optionsPath
     * @throws \ReflectionException
     * @throws Exception
     */
    public function setOptionByPath(string $ref, array $item, int $ord, string $pathParent)
    {
        $properties     = $this->getProperties();
        $optionsPath    = $properties['optionsPath'];

        if (!array_key_exists('label', $item) or !array_key_exists('link', $item)) { return false; }
        if (!array_key_exists($ref, $optionsPath)) { return false; }
        if (!in_array($pathParent, $optionsPath)) { return false; }

        $optionsTree    = &$properties['optionsTree'];
        $targets        = $this->getTargetConstants();
        $posis          = $this->getPositionConstants();
        if (!array_key_exists('target', $item) || !in_array($item['target'], $targets)) {
            $item['target'] = self::ODMENU_TARGET_SELF;
        }
        if (!array_key_exists('pos', $item) || !in_array($item['pos'], $posis)) {
            $item['pos']    = self::ODMENU_POSITION_LEFT;
        }
        $item['ref']        = $ref;

        if (!empty($pathParent)) {
            $pathParent = explode('-', $pathParent);
        }
        $this->insertOption($optionsTree, $ord, $item, $pathParent, false);

        $this->setProperties($properties);

        return $this;
    }

    /**
     * méthode de récupération du tableau de description de l'option par référence
     *
     * @param $ref : référence de l'option de menu à récupérer
     * @return array : tableau de description de l'option recherchée
     * @throws Exception
     */
    public function getOption(string $ref)
    {
        $properties     = $this->getProperties();
        $optionsPath    = $properties['optionsPath'];

        if (!array_key_exists($ref, $optionsPath)) { throw new Exception("Référence d'option $ref inconnue"); }

        $pathOption     = $optionsPath[$ref];
        $pathOption     = explode('-', $pathOption);
        $optionsTree    = $properties['optionsTree'];

        return $this->findOption($pathOption, $optionsTree);
    }

    /**
     * méthode de récupération du tableau de description de l'option par chemin d'accès
     *
     * @param $pathOption : chemin d'accès à l'option à récupérer
     * @return array : tableau de description de l'option recherchée
     * @throws Exception
     */
    public function getOptionByPath(string $pathOption)
    {
        $properties     = $this->getProperties();
        $optionsPath    = $properties['optionsPath'];

        if (!in_array($pathOption, $optionsPath)) {
            throw new Exception("Chemin d'accès $pathOption à l'option inconnu"); }
        $pathOption     = explode('-', $pathOption);
        $optionsTree    = $properties['optionsTree'];

        return $this->findOption($pathOption, $optionsTree);
    }

    /**
     * méthode de suppression d'une option (feuille d'arbre ou noeud)
     *
     * @param $ref : référence de l'option de menu à supprimer
     * @return ODMenu : retourne l'objet lui-même afin, de pouvoir chaîner les appels de méthodes
     * @throws Exception : si la référence de l'option est inconnue du système
     */
    public function rmOption($ref)
    {
        $properties     = $this->getProperties();
        $optionsPath    = $properties['optionsPath'];

        if (!array_key_exists($ref, $optionsPath)) { throw new Exception("Référence d'option $ref inconnue"); }

        $optionsTree    = $properties['optionsTree'];
        $pathOption     = $optionsPath[$ref];
        $pathOption     = explode('-', $pathOption);

        list($optionsTree, $optionsPath)    = $this->removeOption($pathOption, $optionsPath, $optionsTree);
        $properties['optionsTree']          = $optionsTree;
        $properties['optionsPath']          = $optionsPath;
        $this->setProperties($properties);
        return $this;
    }

    /**
     * méthode de suppression d'une option (feuille d'arbre ou noeud)
     *
     * @param string $pathOption : chemin d'accès à l'option à supprimer
     * @return ODMenu : retourne l'objet lui-même afin, de pouvoir chaîner les appels de méthodes
     * @throws Exception : si le chemin d'accès à l'option est inconnue du système
     */
    public function rmOptionByPath(string $pathOption)
    {
        $properties     = $this->getProperties();
        $optionsPath    = $properties['optionsPath'];

        if (!in_array($pathOption, $optionsPath)) {
            throw new Exception("Chemin d'accès $pathOption à l'option inconnu"); }

        $optionsTree    = $properties['optionsTree'];
        $pathOption     = explode('-', $pathOption);

        list($optionsTree, $optionsPath)    = $this->removeOption($pathOption, $optionsPath, $optionsTree);
        $properties['optionsTree']          = $optionsTree;
        $properties['optionsPath']          = $optionsPath;
        $this->setProperties($properties);
        return $this;
    }

    /**
     * méthode de recherche d'une référence d'option par son chemin d'accès $pathOption
     *
     * @param string $pathOption : chemin d'accès à l'option
     * @return false|string : retourne la référence clé d'accès dans le tableau optionsPath
     * false si aucun chemin de correspond
     */
    public function getRef(string $pathOption)
    {
        $properties     = $this->getProperties();
        $optionsPath    = $properties['optionsPath'];

        return array_search($pathOption, $optionsPath);
    }

    /**
     * méthode de recherche d'un chemin d'accès à une option par sa référence $ref
     *
     * @param string $ref : référence de l'option
     * @return false|string : retourne le chemin d'accès à l'option
     * false si la référence n'existe pas en clé dans le tableau optionsPath
     */
    public function getPath(string $ref)
    {
        $properties     = $this->getProperties();
        $optionsPath    = $properties['optionsPath'];

        return array_key_exists($ref, $optionsPath) ? $optionsPath[$ref] : false;
    }

    /**
     * méthode de suppression du menu mémorisé
     *
     * @return ODMenu : retourne l'objet lui-même afin, de pouvoir chaîner les appels de méthodes
     */
    public function clearOptions()
    {
        $properties     = $this->getProperties();
        $properties['optionsPath']  = [];
        $properties['optionsTree']['left']  = [];
        $properties['optionsTree']['right']  = [];
        $this->setProperties($properties);
        return $this;
    }

    /**
     * méthode de récupération de l'ensemble des noeuds et feuilles de l'arbre des options de mnu
     *
     * @return array : tableau des options de menu ayant pour occurence l'item :
     * 'ref'    -> référence de l'option
     * 'label'  -> texte affiché de l'option
     * 'link'   -> lien, URL à accéder sur clic de l'option ('#' si rien à faire)
     * 'target' -> mode d'ouverture de lien link
     * 'pos'    -> position de l'option de menu cadrée à gauche ou à droite
     * 'parent' -> référence de l'option parent (null si option du niveau racine du menu)
     */
    public function getOptions()
    {
        $properties     = $this->getProperties();
        $optionsTree    = $properties['optionsTree'];
        $optionsArray   = [];

        foreach ($optionsTree as $optionNode) {
            $optionsArray = $this->buildOptionsArray($optionNode, $optionsArray);
        }
        return $optionsArray;
    }

    /**
     * @param array $options : tableau des options de menu à insérer au format d'occurance
     * 'ref'    -> référence de l'option (obligatoire)
     * 'label'  -> texte affiché de l'option (obligatoire)
     * 'link'   -> lien, URL à accéder sur clic de l'option ('#' si rien à faire) (obligatoire)
     * 'target' -> mode d'ouverture de lien link
     * 'pos'    -> position de l'option de menu cadrée à gauche ou à droite
     * 'parent' -> référence de l'option parent (null si option du niveau racine du menu) (obligatoire)
     * @return bool|ODMenu : retourne l'objet lui-même afin, de pouvoir chaîner les appels de méthodes
     * false si le tableau options est incohérent avec les besoins
     * @throws Exception
     */
    public function setOptions(array $options)
    {
        if ($this->validateOptionsArray($options)) {
            $this->clearOptions();

            /** tri en fonction de la colonne 'parent' e chaque occurence du tableau des options de menu */
            $column = 'parent';
            usort($options, function($a, $b) use ($column) {
                return strnatcmp($a[$column], $b[$column]);
            });
            foreach ($options as $option) {
                $ref    = $option['ref'];
                $parent = $option['parent'];
                $ord    = $option['ord'] ?? 0;
                $this->addOption($ref, $option, $ord, $parent);
            }
            return $this;
        }
        return false;
    }

    /**
     * méthode visant à donner un titre et terme présenté à gauche du menu
     *
     * @param string $title : titre, terme associé au menu
     * @return ODMenu : retourne l'objet lui-même afin, de pouvoir chaîner les appels de méthodes
     */
    public function setTitle(string $title)
    {
        $properties             = $this->getProperties();
        $properties['title']    = $title;
        $this->setProperties($properties);
        return $this;
    }

    /**
     * méthode de restitution du titre ou terme associé au menu
     *
     * @return bool|string : terme associé au menu (même si vide)
     * false si la clé 'title n'existe pas dans le tableau $properties
     */
    public function getTitle()
    {
        $properties = $this->getProperties();
        return array_key_exists('title', $properties) ? $properties['title'] : false;
    }

    /** **************************************************************************************************
     * méthodes privées de la classe                                                                     *
     * *************************************************************************************************** */

    /**
     * méthode d'extraction et restitution des constantes de position d'option de menu
     *
     * @return array : tableau des valeurs autorisées de position d'option de menu
     * @throws \ReflectionException
     */
    private function getPositionConstants()
    {
        $retour = [];
        if (empty($this->const_position)) {
            $constants = $this->getConstants();
            foreach ($constants as $key => $constant) {
                $pos = strpos($key, 'ODMENU_POSITION_');
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

    /**
     * méthode d'extraction et restitution des constantes de type d'ouverture de lien d'option de menu
     *
     * @return array : tableau des valeurs autorisées de type d'ouverturede lien d'option de menu
     * @throws \ReflectionException
     */
    public function getTargetConstants()
    {
        $retour = [];
        if (empty($this->const_target)) {
            $constants = $this->getConstants();
            foreach ($constants as $key => $constant) {
                $pos = strpos($key, 'ODMENU_TARGET_');
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

    /**
     * méthode récursive d'ajout d'option de menu
     *
     * @param array $tree : arbre partiel pour arriver à l'option parente
     * @param int $ord : numéro d'ordre pour indice d'insertion de l'option (si 0 : à la suite des existantes)
     * @param array $item : tableau des valeurs de l'option à insérer
     * @param array|null $parentPath : total des indices de lecture de l'arbre pour arriver à l'option parente
     * @param bool $insert : booléen indiquant si l'on doit insérer (true) ou modifier (false) une option
     * @return string : chemin partiel d'accès à l'option (1er appel : total), arbre local de l'option (1er appel: total)
     * @throws Exception : si le numéro d'ordre $ord est déjà attributé
     */
    private function insertOption(array &$tree, int $ord, array $item, array $parentPath = null, bool $insert = true) : string
    {
        $idOption = array_shift($parentPath);
        if (!empty($parentPath)) {
            $localTree  = &$tree[$idOption]['children'];
            $pathOption = $this->insertOption($localTree, $ord, $item, $parentPath);
            $pathOption = $idOption . '-' .$pathOption;
        } else {
            if (strlen($idOption) < 1) {
                if ($ord == 0) { $ord = sizeof($tree) + 1; }
                $ord = (string) $ord;
                $tree[$ord] = $item;
                $pathOption = $ord;
            } else {
                if (!isset($tree[$idOption]['children'])) { $tree[$idOption]['children'] = []; }
                if ($ord == 0) { $ord = sizeof($tree[$idOption]['children']) + 1; }
                else {
                    if ($insert && isset($tree[$idOption]['children'][$ord])) {
                        throw new Exception("Numéro d'ordre $ord d'option dèjà attribué ");
                    }
                }
                $ord = (string) $ord;
                $tree[$idOption]['children'][$ord] = $item;
                $pathOption = $idOption.'-'.$ord;
            }
        }
        return $pathOption;
    }

    /**
     * méthode de suppression d'une option de menu
     *
     * @param array $pathOption : tableau des indices d'accès à l'option de menu à supprimer
     * @param array $optionsPath : tableau global des chemin d'accès aux options de menu
     * @param array $tree : arbre partiel pour accèder à l'option de menu à supprimer
     */
    private function removeOption(array $pathOption, array &$optionsPath, array &$tree)
    {
        $idOption = array_shift($pathOption);
        if (sizeof($pathOption) > 0) {
            $localTree  = &$tree[$idOption]['children'];
            $this->removeOption($pathOption, $optionsPath, $localTree);
            $tree[$idOption]['children'] = $localTree;
        } else {
            if (array_key_exists('children', $tree[$idOption])) {
                /** suppression de l'ensemble des enfants de l'option de menu quelqu'en soit le niveau de parenté */
                foreach ($tree[$idOption]['children'] as $child) {
                    $this->removePathChildren($optionsPath, $child);
                }
            }
            unset($tree[$idOption]);
        }
    }

    /**
     * méthode de suppression des chemins d'accès des options de menu enfants d'une option de menu à supprimer
     *
     * @param array &$optionsPath : Reference du tableau global des chemin d'accès aux options de menu
     * @param array $option : arbre partiel pour accèder aux enfants de l'option de menu traité
     */
    private function removePathChildren(array &$optionsPath, array $option)
    {
        if (array_key_exists('children', $option)) {
            foreach ($option['children'] as $child) {
                $this->removePathChildren($optionsPath, $child);
            }
        } else {
            unset($optionsPath[$option['ref']]);
        }
    }

    /**
     * méthode de recherche et restitution d'une option par son chemin d'accès
     *
     * @param array $pathOption : tableau des indices du chemin d'accès à l'option
     * @param array $tree : arbre local d'accès à l'option
     * @return array : tableau de description de l'option
     */
    private function findOption(array $pathOption, array $tree)
    {
        $idOption = array_shift($pathOption);
        if (sizeof($pathOption) > 0) {
            $localTree  = $tree[$idOption]['children'];
            $option     = $this->findOption($pathOption, $localTree);
        } else {
            $option     = $tree[$idOption];
        }
        return $option;
    }

    /**
     * méthode de validation du contenu minimal à avoir afin de pouvoir créer un menu
     *
     * @param array $options : tableau des options à insérer dans le menu
     * @return bool: true -> le contenu est bon, false -> il manque des données dans une ligne
     */
    private function validateOptionsArray(array $options)
    {
        $refs   = [];
        /** contrôle du contenu de chaque ligne de définition d'options */
        foreach ($options as $option) {
            if (!array_key_exists('ref', $option) || empty($option['ref'])) { return false; }
            if (!array_key_exists('label', $option) || empty($option['label'])) { return false; }
            if (!array_key_exists('link', $option) || empty($option['link'])) { return false; }
            if (!array_key_exists('parent', $option)) { return false; }
            $refs = $option['ref'];
        }

        /** controle de l'existance des parents pour chaque options si non null */
        foreach ($options as $option) {
            $parent     = $option['parent'];
            if (!empty($parent) && !in_array($parent, $refs))  { return false; }
        }

        return true;
    }

    /**
     * méthode récussive de construction du tableau des options de l'arbre menu
     *
     * @param $node : noeud local traité
     * @param $nodesArray : tableau des noeuds - feuilles de l'arbre menu
     * @return array : tableau des noeuds - feuilles de l'arbre menu après traitement
     */
    public function buildOptionsArray($node, $nodesArray)
    {
        $item           = [];
        $item['ref']    = $node['ref'];
        $item['label']  = $node['label'];
        $item['link']   = $node['link'];
        $item['target'] = $node['target'];
        $item['pos']    = $node['pos'];
        $item['parent'] = $node['parent'];

        $nodesArray[]   = $item;
        if (array_key_exists('children', $node)) {
            foreach ($node['children'] as $child) {
                $nodesArray = $this->buildOptionsArray($child, $nodesArray);
            }
        }
        return $nodesArray;
    }
}