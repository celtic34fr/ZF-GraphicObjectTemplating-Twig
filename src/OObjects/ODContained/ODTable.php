<?php

namespace GraphicObjectTemplating\OObjects\ODContained;

use GraphicObjectTemplating\OObjects\ODContained;
use GraphicObjectTemplating\OObjects\OObject;
use GraphicObjectTemplating\OObjects\OSContainer\OSDiv;
use Zend\Session\Container;

/**
 * Class ODTable
 * @package GraphicObjectTemplating\OObjects\ODContained
 *
 * __construct($id)         constructeur de l'objet, obligation de fournir $id identifiant de l'objet
 * setTitle($title, $position = self::ODTABLETITLEPOS_BOTTOM_CENTER)
 *                          affecte un titre légende au tableau et précise sa position
 * getTitle()
 * setTitlePosition($position = self::ODTABLETITLEPOS_BOTTOM_CENTER)
 *                          permet d'affecter sa possition au titre légende du tableau
 * getTitlePosition()
 * addTitleStyle($style)    ajoute un style CSS au titre légende du tableau
 * setTitleStyle($style)    affecte un style CSS au titre du tableau (replaçant l'existant au passage)
 * getTitleStyle()
 * initColsHead(array $cols = null)
 *                          initialisation des titres des colonnes du tableau
 * getColsHead()
 * addColHead($title, array $cDatas = null, $nCol = 0)
 *                          permet d'ajouter une colonne dans le tableau avec des données au besoin ($cDatas)
 *                          si $nCol == 0 : on ajoute la colonne en dernière position
 *                          sinon, l'ajout se fait avant la colone $nCol
 * removeColHead($nCol)     supprime la colonne $nCol (si elle existe) avec ses valeurs, en réorganisant le tableau
 * setColValues($nCol, array $cDatas)
 *                          affecte à la colonne $nCol (si elle existe) les valeurs du tableau $cDatas si les indices de lignes existent
 * getColValues($nCol)      récupère sous forme de tableau les valeurs contenues dans la colonne $nCol (si elle existe)
 * setColsWidth(array $widths = null)
 *                          affectation des tailles des colonnes avec un tableau (valeur CSS directement)
 * setColWidth($nCol, $width)
 *                          affecte à la colonne $nCol la taille CSS $width
 * getColsWith()            retourne un tableau avec la taille de chaque colonne
 * getColWidth($nCol)       retourne la taille de la colonne $nCol si elle existe
 *
 * méthodes privées
 * getTitlePosConstants()   récupération des constantes 'ODTABLETITLEPOS_*' dans un tableau associatif
 * addLine(array $line = null)
 *                          ajoute une ligne en fin de tableau (le tableau $line doit comprendre autant de valeurs que de colonnes)
 * setLine($nLine, array $line = null)
 *                          permet d'affecter à la ligne $nLine (si elle existe) le contenu du tableau $line (valide en nbre chanmps)
 * setLines(array $lines = null)
 *                          affecte au tableau le contenu du tableau $lines pourvu que chaque occurance aie le nobre de champs valide
 * getLine($nLine)          récupération de la ligne $nLine si elle existe
 * getLines()               récupération de l'ensemble des lignes du tableau
 * removeLine($nLine)       suppression de la ligne $nLine du tableau avec réorganisation de ce dernier
 * removeLines()            suppression de l'ensemble des lignes du tableau (pasd des titres de colonnes)
 * clearTable()             suppression (vidage) complet du tableau => besoin de tout redéfinir après
 *
 * setCell($nCol, $nLine, $val)
 *                          affecte le contenu de la cellule ligne $nLine, colonne $nCol, par $val
 * getCell($nCol, $nLine)   récupère le contenu de la cellule ligne $nLine, colonne $nCol
 * addCellStyle($nCol, $nLine, $style)
 *                          ajoute au style courrant de la cellule en ligne $nLine, colonne $nCol, le style $style
 * setCellStyle($nCol, $nLine, $style)
 *                          affecte à la cellule en ligne $nLine, colonne $nCol le style $style (suppression de l'ancien de fait)
 * getCellStyle($nCol, $nLine)
 *                          restitue le contenu de la définition du style de la cellule en ligne $nLine, colonne $nCol
 * clearCellStyle($nCol, $nLine)
 *                          suppression de tous les styles actuels de la cellule en ligne $nLine, colonne $nCol
 * toggleCellStyle($nCol, $nLine, $style = null)
 *                          permutation du style de la cellule en ligne $nLine, colonne $nCol de l'actuel vers celui sauvegardé en session
 * evtCellClick($nCol, $nLine, $class, $method, $stopEvent = true)
 *                          déclaration d'un évènement onClick sur la cellule en ligne $nLine, colonne $nCol
 * disCellClick($nCol, $nLine)
 *                          suppression de l'évènement onClick sur la cellule en ligne $nLine, colonne $nCol
 * showCol($nCol)           rend visible une colonne ($ncol)
 * hideCol($nCol)           cache une colonne ($nCol) pour l'affichage
 * findNolineOnColValue($nCol, $value)
 *                          recherche le numéro de ligne sur une valeur de colonne
 * enaPagination()          activation de la pagination
 * disPagination()          dé-activation de la pagination
 * setMaxPage(int $maxPage) affecte le nombre maximal de page pour la pagination (navigation)
 * getMaxPage()
 * setNoPage(int $noPage)   affecte le numéro de la page affichée pour la pagination (navigation)
 * getNoPage()
 * setLength(int $length = self::ODTABLELENGHT_10)
 *                          détermine ne nombre de ligne pour le tablea en mode pagination
 * getLength()
 * setStart(int $start = 0) fixe l'index du premier élement de la page par rapport à length et noPage
 * getStart()
 *
 * méthodes privées de la classe
 * -----------------------------
 * getTitlePosConstants()
 * getLengthConstants()
 */
class ODTable extends ODContained
{
    const ODTABLETITLEPOS_TOP_LEFT      = "top_left";
    const ODTABLETITLEPOS_TOP_CENTER    = "top_center";
    const ODTABLETITLEPOS_TOP_RIGHT     = "opt_right";
    const ODTABLETITLEPOS_BOTTOM_LEFT   = "bottom_left";
    const ODTABLETITLEPOS_BOTTOM_CENTER = "bottom_center";
    const ODTABLETITLEPOS_BOTTOM_RIGHT  = "bottom_right";

    const ODTABLELENGTH_10              = 10;
    const ODTABLELENGTH_20              = 20;
    const ODTABLELENGTH_50              = 50;
    const ODTABLELENGTH_100             = 100;

    private $const_titlePos;
    private $const_length;

    public function __construct($id) {
        parent::__construct($id, "oobjects/odcontained/odtable/odtable.config.php");
        $this->setDisplay();
        $width = $this->getWidthBT();
        if (!is_array($width) || empty($width)) $this->setWidthBT(12);
        $this->enable();

        $properties = $this->getProperties();

        $objLength  = new ODSelect($id.'Length');
        $lengths    = $this->getLengthConstants();
        foreach ($lengths as $length) {
            $objLength->addOption($length, $length);
        }
        $objLength->selectOption(self::ODTABLELENGTH_10);
        $objLength->setWidthBT('O8:W4');
        $objLength->setLabel('Par ');
        $objLength->setLabelWidthBT(4);
        $objLength->setClasses('bouton navBtn');
        $properties['objLength'] = $objLength->getId();

        $objNavbar  = new OSDiv($id.'Navbar');
        $objNavbar->setWidthBT("O1:W11");

        $btnPage    = new ODButton($id.'BtnPage');
        $btnPage->setLabel('');
        $btnPage->setWidthBT(1);
        $btnPage->setDisplay(OObject::DISPLAY_NONE);
        $btnPage->setClasses('bouton navBtn');

        $btnFirst   = new ODButton($id.'BtnFirst');
        $btnFirst->setLabel('');
        $btnFirst->setIcon('fa fa-angle-double-left');
        $btnFirst->setWidthBT(1);
        $btnFirst->setDisplay(OObject::DISPLAY_NONE);
        $btnFirst->setClasses('bouton navBtn');

        $btnPrev    = new ODButton($id.'BtnPrev');
        $btnPrev->setLabel('');
        $btnPrev->setIcon('fa fa-angle-left');
        $btnPrev->setWidthBT(1);
        $btnPrev->setDisplay(OObject::DISPLAY_NONE);
        $btnPrev->setClasses('bouton navBtn');

        $btnSuiv    = new ODButton($id.'BtnSuiv');
        $btnSuiv->setLabel('');
        $btnSuiv->setIcon('fa fa-angle-right');
        $btnSuiv->setWidthBT(1);
        $btnSuiv->setDisplay(OObject::DISPLAY_NONE);
        $btnSuiv->setClasses('bouton navBtn');

        $btnLast    = new ODButton($id.'BtnLast');
        $btnLast->setLabel('');
        $btnLast->setIcon('fa fa-angle-double-right');
        $btnLast->setWidthBT(1);
        $btnLast->setDisplay(OObject::DISPLAY_NONE);
        $btnLast->setClasses('bouton navBtn');

        $objNavbar->addChild($btnFirst);
        $objNavbar->addChild($btnPrev);
        $objNavbar->addChild($btnPage);
        $objNavbar->addChild($btnSuiv);
        $objNavbar->addChild($btnLast);

        $properties['objNavbar'] = $objNavbar->getId();

        $this->setProperties($properties);

        return $this;
    }

    public function setTitle($title, $position = self::ODTABLETITLEPOS_BOTTOM_CENTER)
    {
        $title = (string)$title;
        $positions  = $this->getTitlePosConstants();
        if (!in_array($position, $positions)) $position = self::ODTABLETITLEPOS_BOTTOM_CENTER;

        $properties = $this->getProperties();
        $properties['title'] = $title;
        $properties['titlePos'] = $position;
        $this->setProperties($properties);
        return $this;
    }

    public function getTitle()
    {
        $properties = $this->getProperties();
        return (array_key_exists('title', $properties) ? $properties['title'] : false);
    }

    public function setTitlePosition($position = self::ODTABLETITLEPOS_BOTTOM_CENTER)
    {
        $properties = $this->getProperties();
        $positions  = $this->getTitlePosConstants();
        if (!in_array($position, $positions)) $position = self::ODTABLETITLEPOS_BOTTOM_CENTER;

        $properties['titlePos'] = $position;
        $this->setProperties($properties);
        return $this;
    }

    public function getTitlePosition()
    {
        $properties = $this->getProperties();
        return (array_key_exists('titlePos', $properties) ? $properties['title'] : false);
    }

    public function addTitleStyle($style)
    {
        $style = (string) $style;
        $properties = $this->getProperties();
        $properties['titleStyle'] .= " " .$style;
        $this->setProperties($properties);
        return $this;
    }

    public function setTitleStyle($style)
    {
        $style = (string) $style;
        $properties = $this->getProperties();
        $properties['titleStyle'] = $style;
        $this->setProperties($properties);
        return $this;
    }

    public function getTitleStyle()
    {
        $properties = $this->getProperties();
        return (array_key_exists('titleStyle', $properties) ? $properties['title'] : false);
    }

    public function initColsHead(array $cols = null)
    {
        if (empty($cols)) return false;
        $properties = $this->getProperties();
        $colsTab = [];
        foreach ($cols as $col) {
            $item = [];
            $item['libel'] = $col;
            $item['view']  = true;
            $colsTab[sizeof($colsTab) + 1] = $item;
        }
        $properties['cols'] = $colsTab;
        $this->setProperties($properties);
        return $this;
    }

    public function getColsHead()
    {
        $properties = $this->getProperties();
        return (!empty($properties['cols']) ? $properties['cols'] : false);
    }

    public function addColHead($title, array $cDatas = null, $nCol = 0)
    {
        /* attention les indice de $cDatas doivent commencer à 1 pour le plus petit */
        /* ils sont obligatoirement numérique */
        $title = (string)$title;
        $properties = $this->getProperties();
        $nbCols = sizeof($properties['cols']);
        $datas = $properties['datas'];
        if ($nCol > $nbCols || $nCol < 0) return false;

        if ($nCol < 1) { // nCol == 0 : insertion en fin de ligne de la colonne
            $properties['cols'][sizeof($properties['cols']) + 1] = $title;
            foreach ($datas as $key => $data) {
                $data[] = (isset($cDatas[$key])) ? $cDatas[$key] : "";
                $datas[$key] = $data;
            }
        } else {
            $cols = $properties['cols'];
            for ($i = $nbCols; $i > $nCol; $i--) {
                $cols[$i + 1] = $cols[$i];
            }
            $cols[$nCol] = $title;
            $properties['cols'] = $cols;

            foreach ($datas as $key => $data) {
                for ($i = $nbCols; $i > $nCol; $i--) {
                    $data[$i + 1] = $data[$i];
                }
                $data[$nCol] = (isset($cDatas[$key])) ? $cDatas[$key] : "";
                $datas[$key] = $data;
            }
        }
        $properties['datas'] = $datas;
        $this->setProperties($properties);
        return $this;
    }

    public function removeColHead($nCol)
    {
        $properties = $this->getProperties();
        $nbCols     = sizeof($properties['cols']);
        if ($nCol > $nbCols || $nCol < 1) return false;

        /* suppression de l'entête */
        $cols = $properties['cols'];
        for ($i = $nCol; $i < $nbCols; $i++) {
            $cols[$i] = $cols[$i + 1];
        }
        unset($cols[$nbCols]);
        $properties['cols'] = $cols;

        /* suppression des données de la colonne */
        $datas = $properties['datas'];
        foreach ($datas as $key => $data) {
            for ($i = $nCol; $i < $nbCols; $i++) {
                $data[$i] = $data[$i + 1];
            }
            unset($data[$nbCols]);
            $datas[$key] = $data;
        }
        $properties['datas'] = $datas;
        $this->setProperties($properties);
        return $this;
    }

    public function setColValues($nCol, array $cDatas)
    {
        /* attention les indice de $cDatas doivent commencer à 1 pour le plus petit */
        /* ils sont obligatoirement numérique */
        $properties = $this->getProperties();
        $nbCols = sizeof($properties['cols']);
        if ($nCol > $nbCols || $nCol < 1) return false;

        $datas = $properties['datas'];
        foreach ($datas as $key => $data) {
            $data[$nCol] = (isset($cDatas[$key])) ? $cDatas[$key] : "";
            $datas[$key] = $data;
        }
        $properties['datas'] = $datas;
        $this->setProperties($properties);
        return $this;
    }

    public function getColValues($nCol)
    {
        $properties = $this->getProperties();
        $nbCols     = sizeof($properties['cols']);
        if ($nCol > $nbCols || $nCol < 1) return false;

        $datas = $properties['datas'];
        $cols  = [];
        foreach ($datas as $nLine => $data) {
            $cols[$nLine] = $data[$nCol];
        }
        return $cols;
    }

    public function setColsWidth(array $widths = null)
    {
        $properties = $this->getProperties();
        $nbCols = sizeof($properties['cols']);
        if (sizeof($widths) == 0 || sizeof($widths) != $nbCols) return false;

        foreach ($widths as $key => $width) {
            $properties['cols'][$key]['width'] = $width;
        }
        $this->setProperties($properties);
        return $this;
    }

    public function setColWidth($nCol, $width)
    {
        $nCol = (int) $nCol;
        $width = (string) $width;
        $properties = $this->getProperties();
        $nbCols = sizeof($properties['cols']);
        if ($nCol < 1 || $nCol > $nbCols) return false;

        $properties['cols'][$nCol]['width'] = $width;
        $this->setProperties($properties);
        return $this;
    }

    public function getColsWith()
    {
        $properties = $this->getProperties();
        $cols       = $properties['cols'];
        $retColsWd  = [];

        foreach ($cols as $nCol => $col) {
            if ($nCol > 0) {
                $retColsWd[$nCol] = $col['width'] ?? 0;
            }
        }
        return $retColsWd;
    }

    public function getColWidth($nCol)
    {
        $nCol = (int) $nCol;
        if ($nCol > 0) {
            $properties = $this->getProperties();
            $nbCols = sizeof($properties['cols']);
            if (sizeof($nbCols) < $nCol) return false;
            return ($nbCols[$nCol]['width'] ?? false);
        }
        return false;
    }

    public function addLine(array $line = null)
    {
        if (empty($line)) return false;
        $properties = $this->getProperties();
        $nbCols = sizeof($properties['cols']);
        $caCols = sizeof($line) + (int)$properties['isIdRow'];
        if ($nbCols != $caCols) { return false; }

        /* remise en séquence des champs de la ligne */
        $tmp = [];
        foreach ($line as $col) { $tmp[sizeof($tmp) + (int)$properties['isIdRow'] + 1] = $col; }
        $tmp['view'] = true;
        $properties['datas'][sizeof($properties['datas']) + 1] = $tmp;
        $this->setProperties($properties);
        return (sizeof($properties['datas']));
    }

    public function setLine($nLine, array $line = null)
    {
        $properties = $this->getProperties();
        $nbCols = sizeof($properties['cols']);
        $nbLines = sizeof($properties['datas']);
        if ($nbLines == 0) return false;
        if ($nLine > $nbLines) return false;
        if (array_key_exists('view', $line)) {
            if ($nbCols != sizeof($line) - 1) return false;
        } else {
            if ($nbCols != sizeof($line)) return false;
        }

        $tmp = [];
        /* remise en séquence des champs de la ligne */
        foreach ($line as $key => $col) {
            if ($key != 'view') {
                $tmp[sizeof($tmp) + 1] = $col;
            } else {
                $tmp['view'] = $col;
            }
        }
        if (!array_key_exists('view', $tmp)) {
            $tmp['view'] = true;
        }
        $properties['datas'][$nLine] = $tmp;
        $this->setProperties($properties);
        return $this;
    }

    public function setLines(array $lines = null)
    {
        if (empty($lines)) return false;
        $properties = $this->getProperties();
        $nbCols = sizeof($properties['cols']);
        // vérification des lignes de lines qui doivent avoir le bon nombre de colonnes
        foreach ($lines as $line) {
            if ($nbCols != (sizeof($line) - 1)) return false;
        }

        $properties['datas'] = [];
        foreach ($lines as $line) {
            $tmp = [];
            /* remise en séquence des champs de la ligne */
            foreach ($line as $col) {
                $tmp[sizeof($tmp) + 1] = $col;
            }
            $tmp['view'] = true;
            $properties['datas'][sizeof($properties['datas']) + 1] = $tmp;
        }
        $this->setProperties($properties);
        return $this;
    }

    public function getLine($nLine)
    {
        $properties = $this->getProperties();
        $nbLines = sizeof($properties['datas']);
        if ($nbLines == 0) return false;
        if ($nLine == 0 || $nLine > $nbLines) return false;
        $line = $properties['datas'][$nLine];
        unset($line['view']);

        return $line;
    }

    public function getLines()
    {
        $properties = $this->getProperties();
        return (array_key_exists('datas', $properties) ? $properties['datas'] : false);
    }

    public function removeLine($nLine)
    {
        $properties = $this->getProperties();
        $datas      = $properties['datas'];
        $nbLines = sizeof($datas);
        if ($nbLines == 0) return false;
        if ($nLine == 0 || $nLine > $nbLines) return false;

        /* remise en séquence des lignes restantes */
        for ($i = $nLine; $i < $nbLines; $i++) {
            $datas[$i] = $datas[$i + 1];
        }
        unset($datas[$nbLines]);
        $properties['datas'] = $datas;
        $this->setProperties($properties);
        return $this;
    }

    public function removeLines()
    {
        $properties = $this->getProperties();
        $properties['datas'] = [];
        $this->setProperties($properties);
        return $this;
    }

    public function clearTable()
    {
        $properties = $this->getProperties();
        $properties['cols']   = [];
        $properties['datas']  = [];
        $properties['styles'] = [];
        $properties['events']  = [];
        $this->setProperties($properties);
        return $this;
    }

    public function setCell($nCol, $nLine, $val)
    {
        $properties = $this->getProperties();
        $nbCols     = sizeof($properties['cols']);
        if ($nCol > $nbCols || $nCol < 1) return false;
        $nbLines = sizeof($properties['datas']);
        if ($nbLines == 0) return false;
        if ($nLine > $nbLines) return false;

        $properties['datas'][$nLine][$nCol] = $val;
        $this->setProperties($properties);
        return $this;
    }

    public function getCell($nCol, $nLine)
    {
        $properties = $this->getProperties();
        $nbCols     = sizeof($properties['cols']);
        if ($nCol > $nbCols || $nCol < 1) return false;
        $nbLines = sizeof($properties['datas']);
        if ($nbLines == 0) return false;
        if ($nLine > $nbLines) return false;

        return (isset($properties['datas'][$nLine][$nCol])) ? $properties['datas'][$nLine][$nCol] : false;
    }

    public function addCellStyle($nCol, $nLine, $style)
    {
        $nCol = (int)$nCol;
        $nLine = (int)$nLine;
        $style = (string)$style;
        $properties = $this->getProperties();
        $nbCols = sizeof($properties['cols']);
        $nbLines = sizeof($properties['datas']);
        if ($nCol == 0 || $nbCols < $nCol) return false;
        if ($nLine == 0 || $nbLines < $nLine) return false;

        if (!isset($properties['styles'])) $properties['styles'] = [];
        if (!isset($properties['styles'][$nLine])) $properties['styles'][$nLine] = [];
        if (!isset($properties['styles'][$nLine][$nCol])) $properties['styles'][$nLine][$nCol] = "";
        $properties['styles'][$nLine][$nCol] .= " " . $style;
        $this->setProperties($properties);
        return $this;
    }

    public function setCellStyle($nCol, $nLine, $style)
    {
        $nCol = (int)$nCol;
        $nLine = (int)$nLine;
        $style = (string)$style;
        $properties = $this->getProperties();
        $nbCols = sizeof($properties['cols']);
        $nbLines = sizeof($properties['datas']);
        if ($nCol == 0 || $nbCols < $nCol) return false;
        if ($nLine == 0 || $nbLines < $nLine) return false;

        if (!isset($properties['styles'])) $properties['styles'] = [];
        if (!isset($properties['styles'][$nLine])) $properties['styles'][$nLine] = [];
        $properties['styles'][$nLine][$nCol] = $style;
        $this->setProperties($properties);
        return $this;
    }

    public function getCellStyle($nCol, $nLine)
    {
        $nCol = (int)$nCol;
        $nLine = (int)$nLine;
        $properties = $this->getProperties();
        $nbCols = sizeof($properties['cols']);
        $nbLines = sizeof($properties['datas']);
        if ($nCol == 0 || $nbCols < $nCol) return false;
        if ($nLine == 0 || $nbLines < $nLine) return false;

        return ((isset($properties['styles'][$nLine][$nCol])) ? $properties['styles'][$nLine][$nCol] : false);
    }

    public function clearCellStyle($nCol, $nLine)
    {
        $nCol = (int)$nCol;
        $nLine = (int)$nLine;
        $properties = $this->getProperties();
        $nbCols = sizeof($properties['cols']);
        $nbLines = sizeof($properties['datas']);
        if ($nCol == 0 || $nbCols < $nCol) return false;
        if ($nLine == 0 || $nbLines < $nLine) return false;

        if (isset($properties['styles'][$nLine][$nCol])) $properties['styles'][$nLine][$nCol] = "";
        $this->setProperties($properties);
        return $this;
    }

    public function toggleCellStyle($nCol, $nLine, $style = null)
    {
        $nCol = (int)$nCol;
        $nLine = (int)$nLine;
        $properties = $this->getProperties();
        $nbCols = sizeof($properties['cols']);
        $nbLines = sizeof($properties['datas']);
        if ($nCol == 0 || $nbCols < $nCol) return false;
        if ($nLine == 0 || $nbLines < $nLine) return false;
        if (!isset($properties['style'][$nLine][$nCol])) return false;

        $id = $properties['id'];
        $cStyle = $properties['style'][$nLine][$nCol];
        $oStyle = "";
        $session = new Container("styleTable_" . $id);
        if ($session->offsetExists('styleC' . $nCol . 'L' . $nLine)) $oStyle = $session->offsetGet('styleC' . $nCol . 'L' . $nLine);
        $session->offsetSet('styleC' . $nCol . 'L' . $nLine, $cStyle);
        $properties['style'][$nLine][$nCol] = (!empty($style)) ? $style : $oStyle;
        $this->setProperties($properties);
        return $this;
    }

    public function evtCellClick($nCol, $nLine, $class, $method, $stopEvent = true)
    {
        $class                  = (string)$class;
        $method                 = (string)$method;
        $properties             = $this->getProperties();
        $nbCols                 = sizeof($properties['cols']);
        if ($nCol > $nbCols || $nCol < 1) return false;
        $nbLines                = sizeof($properties['datas']);
        if ($nLine > $nbLines || $nLine < 1) return false;

        if(!isset($properties['events'])) $properties['events'] = [];
        if(!is_array($properties['events'])) $properties['events'] = [];
        if (!isset($properties['events'][$nLine])) $properties['events'][$nLine] = [];

        $properties['events'][$nLine][$nCol] = [];
        $properties['events'][$nLine][$nCol]['class'] = $class;
        $properties['events'][$nLine][$nCol]['method'] = $method;
        $properties['events'][$nLine][$nCol]['stopEvent'] = ($stopEvent) ? 'OUI' : 'NON';

        $this->setProperties($properties);
        return $this;
    }

    public function disCellClick($nCol, $nLine)
    {
        $properties             = $this->getProperties();
        $nbCols                 = sizeof($properties['cols']);
        if ($nCol > $nbCols || $nCol < 1) return false;
        $nbLines                = sizeof($properties['datas']);
        if ($nLine > $nbLines || $nLine < 1) return false;

        if (isset($properties['events'][$nLine][$nCol])) unset($properties['events'][$nLine][$nCol]);
        $this->setProperties($properties);
        return $this;
    }

    public function showCol($nCol)
    {
        $nCol = (int) $nCol;
        $properties = $this->getProperties();
        $nbCols = sizeof($properties['cols']);
        if ($nCol < 1 || $nCol > $nbCols) return false;

        $properties['cols'][$nCol]['view'] = true;
        $this->setProperties($properties);
        return $this;
    }

    public function hideCol($nCol)
    {
        $nCol = (int) $nCol;
        $properties = $this->getProperties();
        $nbCols = sizeof($properties['cols']);
        if ($nCol < 1 || $nCol > $nbCols) return false;

        $properties['cols'][$nCol]['view'] = false;
        $this->setProperties($properties);
        return $this;
    }

    public function findNolineOnColValue($nCol, $value)
    {
        $nCol   = (int) $nCol;
        $lines  = $this->getLines();
        $properties = $this->getProperties();
        $nbCols = sizeof($properties['cols']);
        if ($nCol < 1 || $nCol > $nbCols) return false;

        $rslt   = [];
        foreach ($lines as $noLine => $line) {
            if ($line[$nCol] == $value) { $rslt[] = $noLine; }
        }
        return $rslt;
    }

    public function enaPagination()
    {
        $properties = $this->getProperties();
        $properties['pagination'] = true;
        $this->setProperties($properties);
        return $this;
    }

    public function disPagination()
    {
        $properties = $this->getProperties();
        $properties['pagination'] = false;
        $this->setProperties($properties);
        return $this;
    }

    public function setMaxPage(int $maxPage)
    {
        if ($maxPage > 0) {
            $properties = $this->getProperties();
            $properties['maxPage'] = $maxPage;
            $this->setProperties($properties);
            return $this;
        }
        return false;
    }

    public function getMaxPage()
    {
        $properties = $this->getProperties();
        return (array_key_exists('maxPage', $properties) ? $properties['maxPage'] : false);
    }

    public function setNoPage(int $noPage)
    {
        if ($noPage > 0) {
            $maxPage = $this->getMaxPage();
            if (!empty($maxPage) && $maxPage > 0 && $noPage <= $maxPage) {
                $properties = $this->getProperties();
                $properties['noPage'] = $noPage;
                $this->setProperties($properties);
                return $this;
            }
        }
        return false;
    }

    public function getNoPage()
    {
        $properties = $this->getProperties();
        return (array_key_exists('noPage', $properties) ? $properties['noPage'] : false);
    }

    public function setLength(int $length = self::ODTABLELENGTH_10)
    {
        $lengths = $this->getLengthConstants();
        if (!in_array($length, $lengths)) { $length = self::ODTABLELENGTH_10; }
        $properties = $this->getProperties();
        $properties['length'] = $length;
        $this->setProperties($properties);
        return $this;
    }

    public function getLength()
    {
        $properties = $this->getProperties();
        return (array_key_exists('length', $properties) ? $properties['length'] : false);
    }

    public function setStart(int $start = 0)
    {
        $properties = $this->getProperties();
        $properties['start'] = $start;
        $this->setProperties($properties);
        return $this;
    }

    public function getStart()
    {
        $properties = $this->getProperties();
        return (array_key_exists('start', $properties) ? $properties['start'] : false);
    }

    public function buildNavbar()
    {
        $id         = $this->getId();
        $navbarBtns = new OSDiv($id.'NavbarBtns');
        $maxPage    = $this->getMaxPage();
        $noPage     = $this->getNoPage();
        $sessionObj = self::validateSession();

        /** @var ODButton $btnFirst */
        /** @var ODButton $btnFirstF */
        $btnFirst = OObject::buildObject($id.'BtnFirst', $sessionObj);
        $btnFirstF = OObject::cloneObject($btnFirst, $sessionObj);
        $btnFirstF->setId($id.'BtnF');
        $btnFirstF->setValue(1);
        $btnFirstF->setDisplay(OObject::DISPLAY_BLOCK);
        $btnFirstF->disable();
        if ((int) $noPage > 1) { $btnFirstF->enable(); }
        $navbarBtns->addChild($btnFirstF);

        /** @var ODButton $btnPrev */
        /** @var ODButton $btnPrevP */
        $btnPrev    = OObject::buildObject($id.'BtnPrev', $sessionObj);
        $btnPrevP   = OObject::cloneObject($btnPrev, $sessionObj);
        $btnPrevP->setId($id.'BtnP');
        $btnPrevP->setDisplay(OObject::DISPLAY_BLOCK);
        $btnPrevP->disable();
        if ((int) $noPage > 1) {
            $btnPrevP->setValue((int) $noPage - 1);
            $btnPrevP->enable();
        }
        $navbarBtns->addChild($btnPrevP);

        /** @var ODButton $btnPage */
        /** @var ODButton $btnPageP */
        $btnPage = OObject::buildObject($id.'BtnPage', $sessionObj);
        if ((int) $maxPage < 6) {
            // cas 1 : nbPage < 6 :
            //        btnPrev & btnSuiv inactif
            //        dessin d'autant de bouton page que maxPage
            //        mise de la page idPage en actif (fondBleu)
            for ($ind =1; $ind <= $maxPage ; $ind++) {
                $btnPageP = OObject::cloneObject($btnPage, $sessionObj);
                $btnPageP->setId($id.'btnPage'.$ind);
                $btnPageP->setLabel($ind);
                $btnPageP->setValue($ind);
                $btnPageP->setDisplay(OObject::DISPLAY_BLOCK);
                $btnPageP->enable();

                if ($ind == $noPage) { $btnPageP->disable(); }

                $navbarBtns->addChild($btnPageP);
            }
        } else {
            // cas 2 : maxPage > 5
            if ($noPage < 3) {
                //cas 2.1 : noPage < 3 :
                //         dessin des boutons page de 1 à 4
                //         dessin du bouton page 5 avec '...' inactif, visible
                //         mise de la page noPage en actif (fondBleu)
                for ($ind = 1; $ind < 5; $ind++ ) {
                    $btnPageP = OObject::cloneObject($btnPage, $sessionObj);
                    $btnPageP->setId($id.'btnPage'.$ind);
                    $btnPageP->setValue($ind);
                    $btnPageP->setLabel($ind);
                    $btnPageP->setDisplay(OObject::DISPLAY_BLOCK);
                    $btnPageP->enable();

                    if ($ind == $noPage) { $btnPageP->disable(); }

                    $navbarBtns->addChild($btnPageP);
                }
                $btnPageP = OObject::cloneObject($btnPage, $sessionObj);
                $btnPageP->setId($id.'btnPage5');
                $btnPageP->setLabel('...');
                $btnPageP->setValue('');
                $btnPageP->setDisplay(OObject::DISPLAY_BLOCK);
                $btnPageP->disable();
                $navbarBtns->addChild($btnPageP);
            } else if ($noPage > ($maxPage - 4)) {
                //cas 2.2 : noPage > (maxPage - 4)
                //         dessin du bouton page 1 avec '...' inactif, visible
                //         dessin des boutons page de 2 à 5 avec valeur & label de maxPage - 3 ' à maxPage
                //         mise de la page noPage en actif (fondBleu)
                $btnPageP = OObject::cloneObject($btnPage, $sessionObj);
                $btnPageP->setId($id.'btnPage1');
                $btnPageP->setLabel('...');
                $btnPageP->setValue('');
                $btnPageP->setDisplay(OObject::DISPLAY_BLOCK);
                $btnPageP->disable();
                $navbarBtns->addChild($btnPageP);

                for ($ind = 1; $ind < 5; $ind++ ) {
                    $btnPageP = OObject::cloneObject($btnPage, $sessionObj);
                    $btnPageP->setId($id.'btnPage'.($ind + 1));
                    $btnPageP->setValue($maxPage - 4 + $ind);
                    $btnPageP->setLabel($maxPage - 4 + $ind);
                    $btnPageP->setDisplay(OObject::DISPLAY_BLOCK);
                    $btnPageP->enable();

                    if (($maxPage - 4 + $ind) == $noPage) { $btnPageP->disable(); }

                    $navbarBtns->addChild($btnPageP);
                }
            } else {
                //cas 2.3 : noPage > 2 && noPage < (maxPage - 3)
                //          dessin du bouton page 1 avec '...' inactif, visible
                //          dessin des boutons 2 à 4 avec valeur & label de noPage - 1 à noPage + 1
                //          dessin du bouton page 5 avec '...' inactif, visible
                //          mise de la page noPage en actif (fondBleu)
                $btnPageP = OObject::cloneObject($btnPage, $sessionObj);
                $btnPageP->setId($id.'btnPage1');
                $btnPageP->setLabel('...');
                $btnPageP->setValue('');
                $btnPageP->setDisplay(OObject::DISPLAY_BLOCK);
                $btnPageP->disable();
                $navbarBtns->addChild($btnPageP);

                for ($ind = 1; $ind < 4; $ind++ ) {
                    $btnPageP = OObject::cloneObject($btnPage, $sessionObj);
                    $btnPageP->setId($id.'btnPage'.($ind + 1));
                    $btnPageP->setValue($noPage - 2 + $ind);
                    $btnPageP->setLabel($noPage - 2 + $ind);
                    $btnPageP->setDisplay(OObject::DISPLAY_BLOCK);
                    $btnPageP->enable();

                    if ($ind == 2) { $btnPageP->disable(); }

                    $navbarBtns->addChild($btnPageP);
                }

                $btnPageP = OObject::cloneObject($btnPage, $sessionObj);
                $btnPageP->setId($id.'btnPage5');
                $btnPageP->setLabel('...');
                $btnPageP->setValue('');
                $btnPageP->setDisplay(OObject::DISPLAY_BLOCK);
                $btnPageP->disable();
                $navbarBtns->addChild($btnPageP);
            }
        }

        /** @var ODButton $btnSuiv */
        /** @var ODButton $btnSuivS */
        $btnSuiv    = OObject::buildObject($id.'BtnSuiv', $sessionObj);
        $btnSuivS   = OObject::cloneObject($btnSuiv, $sessionObj);
        $btnSuivS->setId($id.'BtnS');
        $btnSuivS->setDisplay(OObject::DISPLAY_BLOCK);
        $btnSuivS->disable();
        if ($noPage < $maxPage && $maxPage > 1) {
            $btnSuivS->setValue((int) $noPage + 1);
            $btnSuivS->enable();
        }
        $navbarBtns->addChild($btnSuivS);

        /** @var ODButton $btnLast */
        /** @var ODButton $btnLastL */
        $btnLast    = OObject::buildObject($id.'BtnLast', $sessionObj);
        $btnLastL   = OObject::cloneObject($btnLast, $sessionObj);
        $btnLastL->setId($id.'BtnL');
        $btnLastL->setValue($maxPage);
        $btnLastL->setDisplay(OObject::DISPLAY_BLOCK);
        $btnLastL->disable();
        if ($noPage < $maxPage) { $btnLastL->enable(); }
        $navbarBtns->addChild($btnLastL);

        $properties = $this->getProperties();
        $properties['navbarBtns'] = $navbarBtns->getId();
        $this->setProperties($properties);
        return $this;
    }

    /** **************************************************************************************************
     * méthodes de gestion de retour de callback                                                         *
     * *************************************************************************************************** */

    public function returnAppendLine($idTable, $noLine)
    {
        $line   = $this->getLine($noLine);
        $code   = '<tr class="line lno'.$noLine.'" data-lno="'.$noLine.'">';
        foreach ($line as $noCol => $valCol) {
            $code .= '<td class="col cno'.$noCol.'" data-cno="'.$noCol.'">';
            $code .= $valCol;
            $code .= '</td>';
        }
        $code  .= "</tr>";
        return [OObject::formatRetour($idTable, $idTable." tbody", 'append', $code)];
    }

    public function returnUpdateLine($idTable, $noLine)
    {
        $line   = $this->getLine($noLine);
        $code   = '';
        $idTarget   = $idTable.' .lno'.$noLine;
        foreach ($line as $noCol => $valCol) {
            $code .= '<td class="col cno'.$noCol.'" data-cno="'.$noCol.'">';
            $code .= $valCol;
            $code .= '</td>';
        }
        return [OObject::formatRetour($idTable, $idTarget, 'innerUpdate', $code)];
    }

    public function returnUpdateCell($idTable, $noLine, $noCol, $code)
    {
        $idTarget   = $idTable." .lno".$noLine." .cno".$noCol;
        return [OObject::formatRetour($idTable, $idTarget, 'innerUpdate', $code)];
    }

    public function returnUpdateCol($noCol)
    {
        $idTable            = $this->getId();
        $cols               = $this->getColValues($noCol);
        $params['col']      = $noCol;
        $params['datas']    = $cols;
        return [OObject::formatRetour($idTable, $idTable, 'updCols'), $params];
    }

    /** **************************************************************************************************
     * méthodes privées de la classe                                                                     *
     * *************************************************************************************************** */

    private function getTitlePosConstants()
    {
        $retour = [];
        if (empty($this->const_titlePos)) {
            $constants = $this->getConstants();
            foreach ($constants as $key => $constant) {
                $pos = strpos($key, 'ODTABLETITLEPOS_');
                if ($pos !== false) $retour[$key] = $constant;
            }
            $this->const_titlePos= $retour;
        } else {
            $retour = $this->const_titlePos;
        }
        return $retour;
    }

    private function getLengthConstants()
    {
        $retour = [];
        if (empty($this->const_length)) {
            $constants = $this->getConstants();
            foreach ($constants as $key => $constant) {
                $pos = strpos($key, 'ODTABLELENGTH_');
                if ($pos !== false) $retour[$key] = $constant;
            }
            $this->const_length = $retour;
        } else {
            $retour = $this->const_length;
        }
        return $retour;
    }
}
