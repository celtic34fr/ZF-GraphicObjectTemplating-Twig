<?php

namespace GraphicObjectTemplating\OObjects\ODContained;

use function Couchbase\basicEncoderV1;
use GraphicObjectTemplating\OObjects\ODContained;
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
 * stateCol($nCol)          état de visibilité de la colonne $nCol
 * findNolineOnColValue($nCol, $value)
 *                          recherche le numéro de ligne sur une valeur de colonne
 * findNolineOnOrderedColsValue(array $fColsVals)
 *                          recherche le numéro de la ligne sur un ensemble de couples valeurs / colonnes (conditions
 *                          liées entre-elles par 'AND' -> ligne contenant tous les couples valeurs / colonnes)
 * enaPagination()          activation de la pagination
 * disPagination()          dé-activation de la pagination
 * getPagination()          retourne si la pagination est activé ou non
 * setMaxPage(int $maxPage) affecte le nombre maximal de page pour la pagination (navigation)
 * getMaxPage()
 * setNoPage(int $noPage)   affecte le numéro de la page affichée pour la pagination (navigation)
 * getNoPage()
 * setLength(int $length = self::ODTABLELENGHT_10)
 *                          détermine ne nombre de ligne pour le tablea en mode pagination
 * getLength()
 * setStart(int $start = 0) fixe l'index du premier élement de la page par rapport à length et noPage
 * getStart()
 * buildNavbar()
 * showHeader()             affiche les entête de colonnes comme définie avec initColsHead()
 * hideHeader()             supprime l'affichage des entête de colonne (tableau sans titre de colonne)
 * addTableClass($class)
 * getTableClasses()
 * setTableClasses($classes)
 * findCellOnValue($value, $noCol = '', $noLine = '')
 * setLinesStyles(array $styles = null)
 * setColsStyles(array $styles = null)
 * setCellsStyles(array $style = null)
 * clearAllStyles()
 * clearColsStyles()
 * clearLinesStyles()
 * clearCellsStyles()
 * addColClass($nCol, $class)
 * setColClasses($nCol, $classes)
 * getColClasses($nCol)
 * clearColClasses($nCol)
 * addLineClass($nLine, $class)
 * setLineClasses($nLine, $classes)
 * getLineClasses($nLine)
 * clearLineClasses($nLine)
 *
 * méthodes de gestion de retour de callback 
 * -----------------------------------------
 * returnAppendLine($idTable, $noLine)
 * returnUpdateLine($idTable, $noLine)
 * returnUpdateCell($idTable, $noLine, $noCol, $code)
 * returnUpdateCol($noCol)
 * returnRmLine($noLine)
 *
 * méthodes privées de la classe
 * -----------------------------
 * getTitlePosConstants()
 * getLengthConstants()
 * arrayOneDim(array $ar)
 */
class ODTable extends ODContained
{
    const ODTABLETITLEPOS_TOP_LEFT = "top_left";
    const ODTABLETITLEPOS_TOP_CENTER = "top_center";
    const ODTABLETITLEPOS_TOP_RIGHT = "opt_right";
    const ODTABLETITLEPOS_BOTTOM_LEFT = "bottom_left";
    const ODTABLETITLEPOS_BOTTOM_CENTER = "bottom_center";
    const ODTABLETITLEPOS_BOTTOM_RIGHT = "bottom_right";

    const ODTABLELENGTH_10 = 10;
    const ODTABLELENGTH_20 = 20;
    const ODTABLELENGTH_50 = 50;
    const ODTABLELENGTH_100 = 100;

    private $const_titlePos;
    private $const_length;

    /**
     * ODTable constructor.
     * @param $id
     * @throws \ReflectionException
     * @throws \Exception
     */
    public function __construct($id)
    {
        parent::__construct($id, "oobjects/odcontained/odtable/odtable.config.php");
        $this->setDisplay();
        $width = $this->getWidthBT();
        if (!is_array($width) || empty($width)) $this->setWidthBT(12);
        $this->enable();

        return $this;
    }

    /**
     * @param $title            : titre associé au tableau
     * @param string $position  : position du titre opar rapport au tableau
     * @return ODTable
     * @throws \Exception
     */
    public function setTitle($title, $position = self::ODTABLETITLEPOS_BOTTOM_CENTER)
    {
        $title = (string)$title;
        $positions = $this->getTitlePosConstants();
        if (!in_array($position, $positions)) $position = self::ODTABLETITLEPOS_BOTTOM_CENTER;

        $properties = $this->getProperties();
        $properties['title'] = $title;
        $properties['titlePos'] = $position;

        $this->setProperties($properties);
        $this->saveProperties();
        return $this;
    }

    /**
     * @return string|bool  : retourne le contenu de l'attribut title s'il existe, sinon false
     */
    public function getTitle()
    {
        $properties = $this->getProperties();
        return (array_key_exists('title', $properties) ? $properties['title'] : false);
    }

    /**
     * @param string $position  : valeur de la position à affecter au titre
     * @return ODTable
     */
    public function setTitlePosition($position = self::ODTABLETITLEPOS_BOTTOM_CENTER)
    {
        $properties = $this->getProperties();
        $positions = $this->getTitlePosConstants();
        if (!in_array($position, $positions)) $position = self::ODTABLETITLEPOS_BOTTOM_CENTER;

        $properties['titlePos'] = $position;
        $this->setProperties($properties);
        return $this;
    }

    /**
     * @return string|bool      : retourne la valeur de l'attribut titlePos s'il existe, sinon false
     */
    public function getTitlePosition()
    {
        $properties = $this->getProperties();
        return (array_key_exists('titlePos', $properties) ? $properties['titlePos'] : false);
    }

    /**
     * @param $style            : valeuir du style à ajouter au tableau globalement
     * @return ODTable
     */
    public function addTitleStyle($style)
    {
        $style = (string)$style;
        $properties = $this->getProperties();
        $properties['titleStyle'] .= " " . $style;
        $this->setProperties($properties);
        return $this;
    }

    /**
     * @param $style            : valeur de style à affecter au tableau globalement
     * @return ODTable
     */
    public function setTitleStyle($style)
    {
        $style = (string)$style;
        $properties = $this->getProperties();
        $properties['titleStyle'] = $style;
        $this->setProperties($properties);
        return $this;
    }

    /**
     * @return string|bool      : valeur du style appliqué globalement au tableau si existe, sinon false
     */
    public function getTitleStyle()
    {
        $properties = $this->getProperties();
        return (array_key_exists('titleStyle', $properties) ? $properties['titleStyle'] : false);
    }

    /**
     * @param array|null $cols  : tableau d'initialisation des entêtes (ou titres) de colonnes
     * @return ODTable|bool     : retourne false, si le tableau $cols est vide
     */
    public function initColsHead(array $cols = null)
    {
        if (empty($cols)) return false;
        $properties = $this->getProperties();
        $colsTab = [];
        foreach ($cols as $col) {
            $item = [];
            $item['libel'] = $col;
            $item['view'] = true;
            $colsTab[sizeof($colsTab) + 1] = $item;
        }
        $properties['cols'] = $colsTab;
        $this->setProperties($properties);
        return $this;
    }

    /**
     * @return string|bool      : retourne les entêtes de colonnes si l'attribut existe, sinon false
     */
    public function getColsHead()
    {
        $properties = $this->getProperties();
        return (!empty($properties['cols']) ? $properties['cols'] : false);
    }

    /**
     * @param $title             : entête ou titre de la colonne à ajouter
     * @param array|null $cDatas : tableau des valeurs de la colonne (suivant les numéro de ligne) à ajouter
     * @param int $nCol          : numéro de la colonne après lequelle on ajoute la nuvelle colonne
     * @return ODTable|bool
     */
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

    /**
     * @param $nCol         : numéro de la colonne à supprimer (entête et valeurs)
     * @return ODTable|bool
     */
    public function removeColHead($nCol)
    {
        $properties = $this->getProperties();
        $nbCols = sizeof($properties['cols']);
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

    /**
     * @param $nCol         : numéro de la colonne sur laquelle appliquer les nouvelles valeurs
     * @param array $cDatas : tableau des nouvelles valeurs de la colonne suivant le numéro de ligne
     * @return ODTable|bool
     */
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

    /**
     * @param $nCol         : numéro de la colonne des valeurs à restituer
     * @return array|bool   : tableau des valeurs de la colonne recherchée, false si le numéro est <1 ou > au nombre max
     */
    public function getColValues($nCol)
    {
        $properties = $this->getProperties();
        $nbCols = sizeof($properties['cols']);
        if ($nCol > $nbCols || $nCol < 1) return false;

        return array_combine(array_keys($properties['datas']), array_column($properties['datas'], $nCol));

//        $datas = $properties['datas'];
//        $cols = [];
//        foreach ($datas as $nLine => $data) {
//            $cols[$nLine] = $data[$nCol];
//        }
//        return $cols;
    }

    /**
     * @param array|null $widths    : tableau des affectioation des nouvelles largeurs de colonne
     *                                  ce tableau doit décrire toutes les colonnes du tableau, si le nombre de colonne
     *                                  décrite est 0 (tableau vide) ou supérieur au nombre max => retourne false
     * @return ODTable|bool
     */
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

    /**
     * @param $nCol         : numéro de la colonne à modifier
     * @param $width        : largeur de colonne à affecter
     * @return ODTable|bool : false si le numéro de colonne < 1 ou > au nombre max
     */
    public function setColWidth($nCol, $width)
    {
        $nCol = (int)$nCol;
        $width = (string)$width;
        $properties = $this->getProperties();
        $nbCols = sizeof($properties['cols']);
        if ($nCol < 1 || $nCol > $nbCols) return false;

        $properties['cols'][$nCol]['width'] = $width;
        $this->setProperties($properties);
        return $this;
    }

    /**
     * @return array    : restitue le tableau des largeurs des colonnes paramétrées, sinon tableau vide
     */
    public function getColsWith()
    {
        $properties = $this->getProperties();
        $cols = $properties['cols'];
        $retColsWd = [];

        foreach ($cols as $nCol => $col) {
            if ($nCol > 0) {
                $retColsWd[$nCol] = $col['width'] ?? 0;
            }
        }
        return $retColsWd;
    }

    /**
     * @param $nCol         : numéro de la colonne à rechercher
     * @return string|bool  : chaîne décrivant la largeur de la colonne (vide = pas de paramétrage)
     *                          false si le numéro est <1 ou > au nombre max
     */
    public function getColWidth($nCol)
    {
        $properties = $this->getProperties();
        $nbCols = sizeof($properties['cols']);
        $nCol = (int)$nCol;
        if ($nCol < 1 || $nbCols < $nCol) { return false; }
        return ($nbCols[$nCol]['width'] ?? false);
    }

    /**
     * @param array|null $line  : tableau contenant la nouvelle ligne à ajouter au tableau
     * @return bool|int         : retourne le numéro de la ligne ajouée, false si la ligne est mal formatée (nombre de
     *                              colonnes ne correspondant pas à celui du tableau)
     */
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

    /**
     * @param $nLine            : numéro de la ligne à mettre à jour
     * @param array|null $line  : tableau des nouvelles valeurs de la ligne
     * @return ODTable|bool     : retourne false si le nombre de colonnes du tableau $line est incorrect
     */
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

    /**
     * @param array|null $lines : tableau des lignes à mettre en remplacements des lignes actuellement dans le tableau
     * @return ODTable|bool     : retourne false si un ligne du tableau $lines n'a pas le bon nombre de colonne
     */
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

    /**
     * @param $nLine        : numéro de la ligne à rechercher
     * @return array|bool   : retourne la ligne (tableau des colonnes) ou false si nLine < 1 ou > au nombre max de ligne
     *                          du tableau
     */
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

    /**
     * @return array|bool   : retitue en tableau de valeurs des lignes du tableau, false si l'attribut dats n'existe pas
     */
    public function getLines()
    {
        $properties = $this->getProperties();
        return (array_key_exists('datas', $properties) ? $properties['datas'] : false);
    }

    /**
     * @param $nLine        : numéro de la ligne à supprimer
     * @return ODTable|bool : retourne false si nLine == 0 ou > au nombre max de lignes du tableau
     */
    public function removeLine($nLine)
    {
        $properties = $this->getProperties();
        $datas = $properties['datas'];
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

    /**
     * méthode de suppression de toutes les lignes du tableau (garde les entêtes de colonne)
     * @return ODTable
     */
    public function removeLines()
    {
        $properties = $this->getProperties();
        $properties['datas'] = [];
        $this->setProperties($properties);
        return $this;
    }

    /**
     * méthode supprimant les lignes et les entêtes de colonnes du tableau
     * @return ODTable
     */
    public function clearTable()
    {
        $properties = $this->getProperties();
        $properties['cols'] = [];
        $properties['datas'] = [];
        $properties['styles'] = [];
        $properties['events'] = [];
        $this->setProperties($properties);
        return $this;
    }

    /**
     * @param $nCol         : numéro de la colonne de la cellule à mettre à jour
     * @param $nLine        : numérto de la ligne de la cellule à mettre à jour
     * @param $val          : valeur de la cellule à mettre à jour
     * @return ODTable|bool : retourne false si nCol et/ou nLine ne sont pas cohérent avec le contenu du tableau
     */
    public function setCell($nCol, $nLine, $val)
    {
        $properties = $this->getProperties();
        $nbCols = sizeof($properties['cols']);
        if ($nCol > $nbCols || $nCol < 1) return false;
        $nbLines = sizeof($properties['datas']);
        if ($nbLines == 0) return false;
        if ($nLine > $nbLines) return false;

        $properties['datas'][$nLine][$nCol] = $val;
        $this->setProperties($properties);
        return $this;
    }

    /**
     * @param $nCol         : numéro de colonne de la cellule à restituer
     * @param $nLine        : numéro de ligne de la cellule à restituer
     * @return string|bool  : retourne false si nCol et/ou nLine ne sont pas cohérent avec le contenu du tableau
     */
    public function getCell($nCol, $nLine)
    {
        $properties = $this->getProperties();
        $nbCols = sizeof($properties['cols']);
        if ($nCol > $nbCols || $nCol < 1) return false;
        $nbLines = sizeof($properties['datas']);
        if ($nbLines == 0) return false;
        if ($nLine > $nbLines) return false;

        return (isset($properties['datas'][$nLine][$nCol])) ? $properties['datas'][$nLine][$nCol] : false;
    }

    /**
     * @param $nCol         : numéro de colonne de la cellule à modifier
     * @param $nLine        : numéro de ligne de la cellule à modifier
     * @param $style        : style à ajouter à ceux de la cellule
     * @return ODTable|bool : retourne false si nCol et/ou nLine ne sont pas cohérent avec le contenu du tableau
     */
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

    /**
     * @param $nCol         : numéro de colonne de la cellule à modifier
     * @param $nLine        : numéro de ligne de la cellule à modifier
     * @param $style        : style à affecter à la cellule
     * @return ODTable|bool : retourne false si nCol et/ou nLine ne sont pas cohérent avec le contenu du tableau
     */
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

    /**
     * @param $nCol         : numéro de colonne de la cellule à rechercher
     * @param $nLine        : numéro de ligne de la cellule à rechercher
     * @return string|bool  : valeur de la cellule ou false si nCol et/ou nLine ne sont pas cohérent avec le contenu du
     *                          tableau
     */
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

    /**
     * @param $nCol         : numéro de colonne de la cellule à modifier (suppression de tout style)
     * @param $nLine        : numéro de ligne de la cellule à modifier (suppression de tout style)
     * @return ODTable|bool : retourne false si nCol et/ou nLine ne sont pas cohérent avec le contenu du tableau
     */
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

    /**
     * @param $nCol         : numéro de colonne de la cellule à modifier
     * @param $nLine        : numéro de ligne de la cellule à modifier
     * @param null $style   : valeur de style de remplacement de l'actuel
     * @return ODTable|bool : retourne false si nCol et/ou nLine ne sont pas cohérent avec le contenu du tableau
     */
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

    /**
     * @param $nCol             : numéro de colonne de la cellule concernée
     * @param $nLine            : numéro de ligne de la cellule concernée
     * @param $class            : classe de l'objet contenant la callback à exécuter
     * @param $method           : nom de la méthode callback )à exécuter
     * @param bool $stopEvent   : top de propagation (true) ou non (false) de l'evènement click
     * @return ODTable|bool     : retourne false si nCol et/ou nLine ne sont pas cohérent avec le contenu du tableau
     *                                           si classes et/ou méthode n'existe pas ou vide
     */
    public function evtCellClick($nCol, $nLine, $class, $method, $stopEvent = true)
    {
        $class = (string)$class;
        $method = (string)$method;
        $properties = $this->getProperties();
        $nbCols = sizeof($properties['cols']);
        if ($nCol > $nbCols || $nCol < 1) return false;
        $nbLines = sizeof($properties['datas']);
        if ($nLine > $nbLines || $nLine < 1) return false;

        $events = $properties['event'];
        if (!array_key_exists('click', $events)) { $events['clieck'] = []; }
        $evtDef = $events['click'];

        if (!empty($class) && !empty($method)) {
            switch (true) {
                case (class_exists($class)) :
                    if ($class != $properties['className']) {
                        $obj = new $class();
                    } else {
                        $obj = $this;
                    }
                    if (method_exists($obj, $method)) {
                        $evtDef['class']        = $class;
                        $evtDef['method']       = $method;
                        $evtDef['stopEvent']    = ($stopEvent) ? 'OUI' : 'NON';
                    }
                    break;
                case ($class == "javascript:") :
                    $evtDef['class']        = $class;
                    $evtDef['method']       = $method;
                    $evtDef['stopEvent']    = ($stopEvent) ? 'OUI' : 'NON';
                    break;
                case ($properties['object'] == 'odbutton' && $properties['type'] == ODButton::BUTTONTYPE_LINK):
                    $params = [];
                    if ($method != 'none') {
                        $method = explode('|', $method);
                        foreach ($method as $item) {
                            $item = explode(':', $item);
                            $params[$item[0]] = $item[1];
                        }
                    }
                    $evtDef['class']        = $class;
                    $evtDef['method']       = $params;
                    $evtDef['stopEvent']    = ($stopEvent) ? 'OUI' : 'NON';
                    break;
            }

            $properties['events'][$nLine][$nCol]                = [];
            $properties['events'][$nLine][$nCol]['class']       = $evtDef['class'];
            $properties['events'][$nLine][$nCol]['method']      = $evtDef['method'];
            $properties['events'][$nLine][$nCol]['stopEvent']   = $evtDef['stopEvent'];

            $this->setProperties($properties);
            return $this;
        }
        return false;
    }

    /**
     * @param $nCol         : numéro de colonne de la cellule concernée par la suppression de l'évènement click
     * @param $nLine        : numéro de ligne de la cellule concernée par la suppression de l'évènement click
     * @return ODTable|bool : retourne false si nCol et/ou nLine ne sont pas cohérent avec le contenu du tableau
     */
    public function disCellClick($nCol, $nLine)
    {
        $properties = $this->getProperties();
        $nbCols = sizeof($properties['cols']);
        if ($nCol > $nbCols || $nCol < 1) return false;
        $nbLines = sizeof($properties['datas']);
        if ($nLine > $nbLines || $nLine < 1) return false;

        if (isset($properties['events'][$nLine][$nCol])) unset($properties['events'][$nLine][$nCol]);
        $this->setProperties($properties);
        return $this;
    }

    /**
     * @param $nCol         : numéro de la colonne à rendre visible
     * @return ODTable|bool : retourne false si nCol n'est pas cohérent avec le contenu du tableau
     */
    public function showCol($nCol)
    {
        $nCol = (int)$nCol;
        $properties = $this->getProperties();
        $nbCols = sizeof($properties['cols']);
        if ($nCol < 1 || $nCol > $nbCols) return false;

        $properties['cols'][$nCol]['view'] = true;
        $this->setProperties($properties);
        return $this;
    }

    /**
     * @param $nCol         : numéro de la colonne à rendre invisible
     * @return ODTable|bool : retourne false si nCol n'est pas cohérent avec le contenu du tableau
     */
    public function hideCol($nCol)
    {
        $nCol = (int)$nCol;
        $properties = $this->getProperties();
        $nbCols = sizeof($properties['cols']);
        if ($nCol < 1 || $nCol > $nbCols) return false;

        $properties['cols'][$nCol]['view'] = false;
        $this->setProperties($properties);
        return $this;
    }

    /**
     * @param int $nCol     : numéro de la colonne on l'on recherche sa visibilité
     * @return string|bool  : retourne false si nCol n'est pas cohérent avec le contenu du tableau
     */
    public function stateCol(int $nCol)
    {
        $properties = $this->getProperties();
        $nbCols = sizeof($properties['cols']);
        if ($nCol < 1 || $nCol > $nbCols) return false;
        return $properties['cols'][$nCol]['view'];
    }

    /**
     * @param $nCol         : numéro de la ciolonne (à partir de 1)
     * @param $value        : valeur recherchée
     * @return array|bool   : tableau des numéros de ligne correspodante à la recherche, false si rien
     */
    public function findNolineOnColValue($nCol, $value)
    {
        $nCol = (int)$nCol;
        $lines = $this->getLines();
        $properties = $this->getProperties();
        $nbCols = sizeof($properties['cols']);
        if ($nCol < 1 || $nCol > $nbCols) return false;

        $rslt = [];
        foreach ($lines as $noLine => $line) {
            if ($line[$nCol] === $value) {
                $rslt[] = $noLine;
            }
        }
        return $rslt;
    }

    /**
     * @param array $fColsVals  : tableau des valeurs à chercher avec comme clé le numérode colonne ou chercher la dite
     *                              valeur
     * @return array|bool       : tableau des numéros de ligne correspodante à la recherche, false si rien
     */
    public function findNolineOnOrderedColsValue(array $fColsVals)
    {
        $rslt       = [];
        $properties = $this->getProperties();
        $nbCols     = sizeof($properties['cols']);
        $lines      = $this->getLines();

        // validation numéros colonnes
        foreach ($fColsVals as $nCol => $fVal) {
            $nCol   = (int) $nCol;
            if ($nCol < 1 || $nCol > $nbCols) return false;
        }

        // recher des lignes par numéro en retour
        foreach ($lines as $noLine => $line) {
            foreach ($fColsVals as $nCol => $fVal) {
                if ($line[(int) $nCol] != $fVal) {
                    continue 2;
                }
            }
            $rslt[] = $noLine;
        }
        return $rslt;
    }

    /**
     * méthode d'activation de la pagination,
     * @return ODTable
     * @throws \ReflectionException
     * @throws \Exception
     */
    public function enaPagination()
    {
        $properties = $this->getProperties();
        $properties['pagination'] = self::BOOLEAN_TRUE;

        $id = $this->getId();
        /** @var ODSelect $objLength */
        $objLength = new ODSelect($id . 'Length');
        $lengths = $this->getLengthConstants();
        foreach ($lengths as $length) {
            $objLength->addOption($length, $length);
        }
        $objLength->setSelectedOption(self::ODTABLELENGTH_10);
        $objLength->setWidthBT('O8:W4');
        $objLength->setLabel('Par ');
        $objLength->setLabelWidthBT(4);
        $objLength->setClasses('bouton navBtn');
        $properties['objLength'] = $objLength->getId();

        $objNavbar = new OSDiv($id . 'Navbar');
        $objNavbar->setWidthBT("O1:W11");

        $btnPage = new ODButton($id . 'BtnPage');
        $btnPage->setLabel('');
        $btnPage->setWidthBT(1);
        $btnPage->setDisplay(self::DISPLAY_NONE);
        $btnPage->setClasses('bouton navBtn');

        $btnFirst = new ODButton($id . 'BtnFirst');
        $btnFirst->setLabel('');
        $btnFirst->setIcon('fa fa-angle-double-left');
        $btnFirst->setWidthBT(1);
        $btnFirst->setDisplay(self::DISPLAY_NONE);
        $btnFirst->setClasses('bouton navBtn');

        $btnPrev = new ODButton($id . 'BtnPrev');
        $btnPrev->setLabel('');
        $btnPrev->setIcon('fa fa-angle-left');
        $btnPrev->setWidthBT(1);
        $btnPrev->setDisplay(self::DISPLAY_NONE);
        $btnPrev->setClasses('bouton navBtn');

        $btnSuiv = new ODButton($id . 'BtnSuiv');
        $btnSuiv->setLabel('');
        $btnSuiv->setIcon('fa fa-angle-right');
        $btnSuiv->setWidthBT(1);
        $btnSuiv->setDisplay(self::DISPLAY_NONE);
        $btnSuiv->setClasses('bouton navBtn');

        $btnLast = new ODButton($id . 'BtnLast');
        $btnLast->setLabel('');
        $btnLast->setIcon('fa fa-angle-double-right');
        $btnLast->setWidthBT(1);
        $btnLast->setDisplay(self::DISPLAY_NONE);
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

    /**
     * méthode désactivation de la pagination,
     * @return ODTable
     * @throws \Exception
     */
    public function disPagination()
    {
        $properties = $this->getProperties();
        $properties['pagination'] = self::BOOLEAN_FALSE;

        self::destroyObject($properties['objLength']);
        self::destroyObject($properties['objNavbar']);

        $properties['objLength'] = "";
        $properties['objNavbar'] = "";

        $this->setProperties($properties);
        return $this;
    }

    /**
     * @return string|bool  : retourne l'état de la pagination (attribut pagination) sinon false si absent
     */
    public function getPagination()
    {
        $properties = $this->getProperties();
        return (array_key_exists('pagination', $properties) ? $properties['pagination'] : false);
    }

    /**
     * @param int $maxPage  : nombre mazximum de page
     * @return ODTable|bool : false si la pagination n'est pas activée et maxPage > 0
     */
    public function setMaxPage(int $maxPage)
    {
        if ($maxPage > 0 && $this->getPagination() == self::BOOLEAN_TRUE) {
            $properties = $this->getProperties();
            $properties['maxPage'] = $maxPage;
            $this->setProperties($properties);
            return $this;
        }
        return false;
    }

    /**
     * @return string|bool  : retourne le nombre maximum de page ou false si la pagination n'est pas activée ou que
     *                          l'attribut maxPage est absent
     */
    public function getMaxPage()
    {
        if ($this->getPagination() == self::BOOLEAN_TRUE) {
            $properties = $this->getProperties();
            return (array_key_exists('maxPage', $properties) ? $properties['maxPage'] : false);
        }
        return false;
    }

    /**
     * @param int $noPage   : numéro de la page à activer ou afficher
     * @return ODTable|bool : false si pas de maxPage, maxPage <1 ou noPage > maxPage
     */
    public function setNoPage(int $noPage)
    {
        if ($noPage > 0 && $this->getPagination() == self::BOOLEAN_TRUE) {
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

    /**
     * @return string|bool  : retourne le numéro de la page active ou affichée, fase si l'attribut noPage est absent ou
     *                          que la pagination n'est pas activée
     */
    public function getNoPage()
    {
        if ($this->getPagination() == self::BOOLEAN_TRUE) {
            $properties = $this->getProperties();
            return (array_key_exists('noPage', $properties) ? $properties['noPage'] : false);
        }
        return false;
    }

    /**
     * @param int $length   : nombre de lignes dans le tableau paginé
     * @return ODTable|bool : false si la pagination n'est pas activée
     */
    public function setLength(int $length = self::ODTABLELENGTH_10)
    {
        if ($this->getPagination() == self::BOOLEAN_TRUE) {
            $lengths = $this->getLengthConstants();
            if (!in_array($length, $lengths)) {
                $length = self::ODTABLELENGTH_10;
            }
            $properties = $this->getProperties();
            $properties['length'] = $length;
            $this->setProperties($properties);
            return $this;
        }
        return false;
    }

    /**
     * restitue le nombre de ligne du tableau paginé
     * @return string|bool  : false si la pagination n'est pas activée ou attribut length absent
     */
    public function getLength()
    {
        if ($this->getPagination() == self::BOOLEAN_TRUE) {
            $properties = $this->getProperties();
            return (array_key_exists('length', $properties) ? $properties['length'] : false);
        }
        return false;
    }

    /**
     * @param int $start    : numéro de la page de départ
     * @return ODTable|bool : false si la pagination n'est pas activée
     */
    public function setStart(int $start = 0)
    {
        if ($this->getPagination() == self::BOOLEAN_TRUE) {
            $properties = $this->getProperties();
            $properties['start'] = $start;
            $this->setProperties($properties);
            return $this;
        }
        return false;
    }

    /**
     * retsitue le numéro de la page de départ
     * @return string|bool  : false si la pagination n'est pas activée ou attribut start absent
     */
    public function getStart()
    {
        if ($this->getPagination() == self::BOOLEAN_TRUE) {
            $properties = $this->getProperties();
            return (array_key_exists('start', $properties) ? $properties['start'] : false);
        }
        return false;
    }

    /**
     * méthode de construction de la barre de navigation d'un tableau paginé
     * @return ODTable|bool : false si la pagination n'est pas activée
     * @throws \ReflectionException
     * @throws \Exception
     */
    public function buildNavbar()
    {
        if ($this->getPagination() == self::BOOLEAN_TRUE) {
            $id = $this->getId();
            $navbarBtns = new OSDiv($id . 'NavbarBtns');
            $maxPage = $this->getMaxPage();
            $noPage = $this->getNoPage();
            $sessionObj = self::validateSession();

            /** @var ODButton $btnFirst */
            /** @var ODButton $btnFirstF */
            $btnFirst = self::buildObject($id . 'BtnFirst', $sessionObj);
            $btnFirstF = self::cloneObject($btnFirst, $sessionObj);
            $btnFirstF->setId($id . 'BtnF');
            $btnFirstF->setValue(1);
            $btnFirstF->setDisplay(self::DISPLAY_BLOCK);
            $btnFirstF->disable();
            if ((int)$noPage > 1) {
                $btnFirstF->enable();
            }
            $navbarBtns->addChild($btnFirstF);

            /** @var ODButton $btnPrev */
            /** @var ODButton $btnPrevP */
            $btnPrev = self::buildObject($id . 'BtnPrev', $sessionObj);
            $btnPrevP = self::cloneObject($btnPrev, $sessionObj);
            $btnPrevP->setId($id . 'BtnP');
            $btnPrevP->setDisplay(self::DISPLAY_BLOCK);
            $btnPrevP->disable();
            if ((int)$noPage > 1) {
                $btnPrevP->setValue((int)$noPage - 1);
                $btnPrevP->enable();
            }
            $navbarBtns->addChild($btnPrevP);

            /** @var ODButton $btnPage */
            /** @var ODButton $btnPageP */
            $btnPage = self::buildObject($id . 'BtnPage', $sessionObj);
            if ((int)$maxPage < 6) {
                // cas 1 : nbPage < 6 :
                //        btnPrev & btnSuiv inactif
                //        dessin d'autant de bouton page que maxPage
                //        mise de la page idPage en actif (fondBleu)
                for ($ind = 1; $ind <= $maxPage; $ind++) {
                    $btnPageP = self::cloneObject($btnPage, $sessionObj);
                    $btnPageP->setId($id . 'btnPage' . $ind);
                    $btnPageP->setLabel($ind);
                    $btnPageP->setValue($ind);
                    $btnPageP->setDisplay(self::DISPLAY_BLOCK);
                    $btnPageP->enable();

                    if ($ind == $noPage) {
                        $btnPageP->disable();
                    }

                    $navbarBtns->addChild($btnPageP);
                }
            } else {
                // cas 2 : maxPage > 5
                if ($noPage < 3) {
                    //cas 2.1 : noPage < 3 :
                    //         dessin des boutons page de 1 à 4
                    //         dessin du bouton page 5 avec '...' inactif, visible
                    //         mise de la page noPage en actif (fondBleu)
                    for ($ind = 1; $ind < 5; $ind++) {
                        $btnPageP = self::cloneObject($btnPage, $sessionObj);
                        $btnPageP->setId($id . 'btnPage' . $ind);
                        $btnPageP->setValue($ind);
                        $btnPageP->setLabel($ind);
                        $btnPageP->setDisplay(self::DISPLAY_BLOCK);
                        $btnPageP->enable();

                        if ($ind == $noPage) {
                            $btnPageP->disable();
                        }

                        $navbarBtns->addChild($btnPageP);
                    }
                    $btnPageP = self::cloneObject($btnPage, $sessionObj);
                    $btnPageP->setId($id . 'btnPage5');
                    $btnPageP->setLabel('...');
                    $btnPageP->setValue('');
                    $btnPageP->setDisplay(self::DISPLAY_BLOCK);
                    $btnPageP->disable();
                    $navbarBtns->addChild($btnPageP);
                } else if ($noPage > ($maxPage - 4)) {
                    //cas 2.2 : noPage > (maxPage - 4)
                    //         dessin du bouton page 1 avec '...' inactif, visible
                    //         dessin des boutons page de 2 à 5 avec valeur & label de maxPage - 3 ' à maxPage
                    //         mise de la page noPage en actif (fondBleu)
                    $btnPageP = self::cloneObject($btnPage, $sessionObj);
                    $btnPageP->setId($id . 'btnPage1');
                    $btnPageP->setLabel('...');
                    $btnPageP->setValue('');
                    $btnPageP->setDisplay(self::DISPLAY_BLOCK);
                    $btnPageP->disable();
                    $navbarBtns->addChild($btnPageP);

                    for ($ind = 1; $ind < 5; $ind++) {
                        $btnPageP = self::cloneObject($btnPage, $sessionObj);
                        $btnPageP->setId($id . 'btnPage' . ($ind + 1));
                        $btnPageP->setValue($maxPage - 4 + $ind);
                        $btnPageP->setLabel($maxPage - 4 + $ind);
                        $btnPageP->setDisplay(self::DISPLAY_BLOCK);
                        $btnPageP->enable();

                        if (($maxPage - 4 + $ind) == $noPage) {
                            $btnPageP->disable();
                        }

                        $navbarBtns->addChild($btnPageP);
                    }
                } else {
                    //cas 2.3 : noPage > 2 && noPage < (maxPage - 3)
                    //          dessin du bouton page 1 avec '...' inactif, visible
                    //          dessin des boutons 2 à 4 avec valeur & label de noPage - 1 à noPage + 1
                    //          dessin du bouton page 5 avec '...' inactif, visible
                    //          mise de la page noPage en actif (fondBleu)
                    $btnPageP = self::cloneObject($btnPage, $sessionObj);
                    $btnPageP->setId($id . 'btnPage1');
                    $btnPageP->setLabel('...');
                    $btnPageP->setValue('');
                    $btnPageP->setDisplay(self::DISPLAY_BLOCK);
                    $btnPageP->disable();
                    $navbarBtns->addChild($btnPageP);

                    for ($ind = 1; $ind < 4; $ind++) {
                        $btnPageP = self::cloneObject($btnPage, $sessionObj);
                        $btnPageP->setId($id . 'btnPage' . ($ind + 1));
                        $btnPageP->setValue($noPage - 2 + $ind);
                        $btnPageP->setLabel($noPage - 2 + $ind);
                        $btnPageP->setDisplay(self::DISPLAY_BLOCK);
                        $btnPageP->enable();

                        if ($ind == 2) {
                            $btnPageP->disable();
                        }

                        $navbarBtns->addChild($btnPageP);
                    }

                    $btnPageP = self::cloneObject($btnPage, $sessionObj);
                    $btnPageP->setId($id . 'btnPage5');
                    $btnPageP->setLabel('...');
                    $btnPageP->setValue('');
                    $btnPageP->setDisplay(self::DISPLAY_BLOCK);
                    $btnPageP->disable();
                    $navbarBtns->addChild($btnPageP);
                }
            }

            /** @var ODButton $btnSuiv */
            /** @var ODButton $btnSuivS */
            $btnSuiv = self::buildObject($id . 'BtnSuiv', $sessionObj);
            $btnSuivS = self::cloneObject($btnSuiv, $sessionObj);
            $btnSuivS->setId($id . 'BtnS');
            $btnSuivS->setDisplay(self::DISPLAY_BLOCK);
            $btnSuivS->disable();
            if ($noPage < $maxPage && $maxPage > 1) {
                $btnSuivS->setValue((int)$noPage + 1);
                $btnSuivS->enable();
            }
            $navbarBtns->addChild($btnSuivS);

            /** @var ODButton $btnLast */
            /** @var ODButton $btnLastL */
            $btnLast = self::buildObject($id . 'BtnLast', $sessionObj);
            $btnLastL = self::cloneObject($btnLast, $sessionObj);
            $btnLastL->setId($id . 'BtnL');
            $btnLastL->setValue($maxPage);
            $btnLastL->setDisplay(self::DISPLAY_BLOCK);
            $btnLastL->disable();
            if ($noPage < $maxPage) {
                $btnLastL->enable();
            }
            $navbarBtns->addChild($btnLastL);

            $properties = $this->getProperties();
            $properties['navbarBtns'] = $navbarBtns->getId();
            $this->setProperties($properties);
            return $this;
        }
        return false;
    }

    /**
     * rend visible des entêtes de colonnes
     * @return ODTable
     */
    public function showHeader()
    {
        $properties = $this->getProperties();
        $properties['header'] = true;
        $this->setProperties($properties);
        return $this;
    }

    /**
     * rend invisible des entêtes de colonnes
     * @return ODTable
     */
    public function hideHeader()
    {
        $properties = $this->getProperties();
        $properties['header'] = false;
        $this->setProperties($properties);
        return $this;
    }

    /**
     * @param null $class   : valeur de classe à ajouter globalmement au tableau
     * @return ODTable|bool : false si class est vide ou déjà présent
     */
    public function addTableClass($class = null)
    {
        if (strlen($class) > 0) {
            $properties = $this->getProperties();
            $tableClasses = $properties['tableClasses'];
            if (!strpos($tableClasses, ' '.$class.' ')) {
                $tableClasses .= ' '.$class.' ';
                $properties['tableClasses'] = $tableClasses;
                $this->setProperties($properties);
                return $this;
            }
        }
        return false;
    }

    /**
     * @return string|bool  : retourne la valeur des classes appliquées globalement au tableau, false si attribut
     *                          tableClasses absent
     */
    public function getTableClasses()
    {
        $properties = $this->getProperties();
        return (array_key_exists('tableClasses', $properties) ? $properties['tableClasses'] : false);
    }

    /**
     * @param $tableClasses : chaîne de caractère des classes à applique globalement au tableau
     * @return ODTable
     */
    public function setTableClasses($tableClasses)
    {
        $tableClasses = (string) $tableClasses;
        $properties = $this->getProperties();
        $properties['tableClasses'] = $tableClasses;
        $this->setProperties($properties);
        return $this;
    }

    /**
     * @param $value
     * @param string $noCol
     * @param string $noLine
     * @return array|bool
     */
    public function findCellOnValue($value, $noCol = '', $noLine = '')
    {
        $crc = false;
        $crl = false;
        $crr = [];
        switch (true) {
            case (!empty($noCol) && !empty($noLine)) :
		        // cas noCol et noLine renseigné
                $line = $this->getLine($noLine);
                $crr[] = ($value == $line[$noCol]) ? [$noCol, $noLine]: false;
                break;
            case (!empty($noCol) && empty($noLine)) :
        		// cas noCol renseigné
                $lines = $this->getLines();
                $crl = false;
                foreach ($lines as $ind => $line) {
                    $crl = ($line[$noCol] == $value) ? $ind : false;
                    if ($crl !== false) {
                        $crr[] = [$noCol, $crl];
                    }
                }
                break;
            case (empty($noCol) && empty($noLine)) :
        		// cas noCol et noLine non renseigné
                $lines = $this->getLines();
                $crl   = false;
                foreach ($lines as $ind => $cols) {
                    $crc = false;
                    foreach ($cols as $jnd => $col) {
                        $crc = ($col == $value) ? $jnd : false;
                        if ($crc !== false) {
                            $crr[] = [$ind, $crl];
                        }
                    }
                }
                break;
            case (empty($noCol) && !empty($noLine)) :
        		// cas noLine renseigné
                $line = $this->getLine($noLine);
                foreach ($line as $ind => $col) {
                    $crc = ($line[$noCol] == $value) ? $ind : false;
                    if ($crc !== false) {
                        $crr[] = [$crc, $noLine];
                    }
                }
                break;
        }
        return (!empty($crr)) ? $crr : false;
    }

    /**
     * @param array|null $styles
     * @return ODTable
     */
    public function setLinesStyles(array $styles = null)
    {
        $isOneDim = $this->arrayOneDim($styles);
        if ($isOneDim) {
            foreach ($styles as $noLine => $style) {
                $this->setLineStyle($noLine, $style);
            }
        }
        return $this;
    }

    /**
     * @param array|null $styles
     * @return ODTable
     */
    public function setColsStyles(array $styles = null)
    {
        $isOneDim = $this->arrayOneDim($styles);
        $properties = $this->getProperties();
        $nbCols = count($properties['cols']);
        if ($isOneDim && count($styles) == $nbCols) {
            foreach ($styles as $noCol => $style) {
                $this->setcolStyle($noCol, $style);
            }
        }
        return $this;
    }

    /**
     * @param array|null $style
     */
    public function setCellsStyles(array $style = null)
    {
        $properties = $this->getProperties();
        $nbCols     = count($properties['cols']);
        $nbLines    = count($properties['datas']);
        $dim        = $this->arrayMaxDim($style);
        if ($dim == [$nbLines,$nbCols]) {
            for ($ind=1; $ind<=$nbLines; $ind++) {
                for ($jnd=1; $jnd<=$nbCols; $jnd++) {
                    $this->setCell($ind, $jnd, $style[$ind][$jnd]);
                }
            }
        }
    }

    /**
     * @return ODTable
     */
    public function clearAllStyles()
    {
        $properties = $this->getProperties();
        $properties['styles'] = [];
        $this->setProperties($properties);
        return $this;
    }

    /**
     * @return ODTable
     */
    public function clearColsStyles()
    {
        $properties = $this->getProperties();
        $nbCols = count($properties['cols']);
        for ($ind=1; $ind<=$nbCols; $ind++) {
            $properties['style'][0][$ind] = '';
        }
        $this->setProperties($properties);
        return $this;
    }

    /**
     * @return ODTable
     */
    public function clearLinesStyles()
    {
        $properties = $this->getProperties();
        $nbLines = count($properties['datas']);
        for ($ind=1; $ind<=$nbLines; $ind++) {
            $properties['style'][$ind][0] = '';
        }
        $this->setProperties($properties);
        return $this;
    }

    /**
     * @return ODTable
     */
    public function clearCellsStyles()
    {
        $properties = $this->getProperties();
        $nbCols = count($properties['cols']);
        $nbLines = count($properties['datas']);
        for ($ind = 1; $ind<=$nbLines; $ind++) {
            for ($jnd = 1; $jnd<=$nbCols; $jnd++) {
                $properties['style'][$ind][$jnd] = '';
            }
        }
        $this->setProperties($properties);
        return $this;
    }

    /**
     * @param $nCol
     * @param $class
     * @return ODTable|bool
     */
    public function addColClass($nCol, $class)
    {
        $class = (string) $class;
        $nCol  = (int) $nCol;
        $properties             = $this->getProperties();
        $nbCols                 = sizeof($properties['cols']);
        if ($nCol > $nbCols || $nCol < 1) return false;
        if (!isset($properties['classesTab'])) { $properties['classesTab'] = []; }
        if (!isset($properties['classesTab']['col'.$nCol])) { $properties['classesTab']['col'.$nCol] = ""; }
        if (!empty($properties['classesTab']['col'.$nCol])) { $properties['classesTab']['col'.$nCol] .= " "; }
        $properties['classesTab']['col'.$nCol] .= $class;
        $this->setProperties($properties);
        return $this;
    }

    /**
     * @param $nCol
     * @param $classes
     * @return ODTable|bool
     */
    public function setColClasses($nCol, $classes)
    {
        if (is_array($classes)) { $classes = implode(" ", $classes); }
        if (!is_string($classes)) { return false; }
        $nCol  = (int) $nCol;
        $properties             = $this->getProperties();
        $nbCols                 = sizeof($properties['cols']);
        if ($nCol > $nbCols || $nCol < 1) return false;
        if (!isset($properties['classesTab'])) { $properties['classesTab'] = []; }
        if (!isset($properties['classesTab']['col'.$nCol])) { $properties['classesTab']['col'.$nCol] = ""; }
        $properties['classesTab']['col'.$nCol] = $classes;
        $this->setProperties($properties);
        return $this;
    }

    /**
     * @param $nCol
     * @return bool|string
     */
    public function getColClasses($nCol)
    {
        $nCol  = (int) $nCol;
        $properties             = $this->getProperties();
        $nbCols                 = sizeof($properties['cols']);
        if ($nCol > $nbCols || $nCol < 1) return false;
        return (isset($properties['classesTab']['col'.$nCol])) ? $properties['classesTab']['col'.$nCol] : false;
    }

    /**
     * @param $nCol
     * @return ODTable|bool
     */
    public function clearColClasses($nCol)
    {
        $nCol  = (int) $nCol;
        $properties             = $this->getProperties();
        $nbCols                 = sizeof($properties['cols']);
        if ($nCol > $nbCols || $nCol < 1) return false;
        if (!isset($properties['classesTab'])) { $properties['classesTab'] = []; }
        if (isset($properties['classesTab']['col'.$nCol])) { unset($properties['classesTab']['col'.$nCol]); }

        $this->setProperties($properties);
        return $this;
    }

    /**
     * @param $nLine
     * @param $class
     * @return ODTable|bool
     */
    public function addLineClass($nLine, $class)
    {
        $class = (string) $class;
        $nLine = (int) $nLine;
        $properties             = $this->getProperties();
        $nbLines = sizeof($properties['datas']);
        if ($nLine > $nbLines|| $nLine< 1) return false;
        if (!isset($properties['classesTab'])) { $properties['classesTab'] = []; }
        if (!isset($properties['classesTab']['line'.$nLine])) { $properties['classesTab']['line'.$nLine] = ""; }
        if (!empty($properties['classesTab']['line'.$nLine])) { $properties['classesTab']['line'.$nLine] .= " "; }
        $properties['classesTab']['line'.$nLine] .= $class;
        $this->setProperties($properties);
        return $this;
    }

    /**
     * @param $nLine
     * @param $classes
     * @return ODTable|bool
     */
    public function setLineClasses($nLine, $classes)
    {
        if (is_array($classes)) { $classes = implode(" ", $classes); }
        if (!is_string($classes)) { return false; }
        $nLine = (int) $nLine;
        $properties             = $this->getProperties();
        $nbLines = sizeof($properties['datas']);
        if ($nLine > $nbLines|| $nLine< 1) return false;
        if (!isset($properties['classesTab'])) { $properties['classesTab'] = []; }
        if (!isset($properties['classesTab']['line'.$nLine])) { $properties['classesTab']['line'.$nLine] = []; }
        $properties['classesTab']['line'.$nLine] = $classes;
        $this->setProperties($properties);
        return $this;
    }

    /**
     * @param $nLine
     * @return bool|string
     */
    public function getLineClasses($nLine)
    {
        $nLine = (int) $nLine;
        $properties             = $this->getProperties();
        $nbLines = sizeof($properties['datas']);
        if ($nLine > $nbLines|| $nLine< 1) return false;
        return (isset($properties['classesTab']['line'.$nLine])) ? $properties['classesTab']['line'.$nLine] : false;
    }

    /**
     * @param $nLine
     * @return ODTable|bool
     */
    public function clearLineClasses($nLine)
    {
        $nLine = (int) $nLine;
        $properties             = $this->getProperties();
        $nbLines = sizeof($properties['datas']);
        if ($nLine > $nbLines|| $nLine< 1) return false;
        if (!isset($properties['classesTab'])) { $properties['classesTab'] = []; }
        if (isset($properties['classesTab']['line'.$nLine])) {
            $classes = $properties['classesTab'];
            unset($classes['line'.$nLine]);
            $properties['classesTab'] = $classes;
        }

        $this->setProperties($properties);
        return $this;
    }

    /** **************************************************************************************************
     * méthodes de gestion de retour de callback                                                         *
     * *************************************************************************************************** */

    /**
     * méthode retournant les valeurs exploitée en retour de callback pour l'ajout d'une ligne en fin de tableau
     * @param $idTable      : identifiant de l'objet ODTable
     * @param $noLine       : numéro de ligne
     * @return array        : valeur de retour de callback
     */
    public function returnAppendLine($idTable, $noLine)
    {
        $line = $this->getLine($noLine);
        $code = '<tr class="line lno' . $noLine . '" data-lno="' . $noLine . '">';
        foreach ($line as $noCol => $valCol) {
            if ($this->stateCol($noCol)) {
                $code .= '<td class="col cno' . $noCol . '" data-cno="' . $noCol . '">';
                $code .= $valCol;
                $code .= '</td>';
            }
        }
        $code .= "</tr>";
        return self::formatRetour($idTable, $idTable . " tbody", 'append', $code);
    }

    /**
     * méthode retournant les valeurs exploitée en retour de callback pour la mise à jour d'une ligne du tableau
     * @param $idTable      : identifiant de l'objet ODTable
     * @param $noLine       : numéro de ligne
     * @return array        : valeur de retour de callback
     */
    public function returnUpdateLine($idTable, $noLine)
    {
        $line = $this->getLine($noLine);
        $code = '';
        $idTarget = $idTable . ' .lno' . $noLine;
        foreach ($line as $noCol => $valCol) {
            if ($this->stateCol($noCol)) {
                $code .= '<td class="col cno' . $noCol . '" data-cno="' . $noCol . '">';
                $code .= $valCol;
                $code .= '</td>';
            }
        }
        return self::formatRetour($idTable, $idTarget, 'innerUpdate', $code);
    }

    /**
     * méthode retournant les valeurs exploitée en retour de callback pour la mise à jour d'une cellule du tableau
     * @param $idTable      : identifiant de l'objet ODTable
     * @param $noLine       : numéro de ligne
     * @param $noCol        : numéro de colonne
     * @param $code         : code de la mise à jour
     * @return array|bool   : valeur de retour de callback, false si la colonne de la cellule n'est pas visible
     */
    public function returnUpdateCell($idTable, $noLine, $noCol, $code)
    {
        $idTarget = $idTable . " .lno" . $noLine . " .cno" . $noCol;
        if ($this->stateCol($noCol)) {
            return self::formatRetour($idTable, $idTarget, 'innerUpdate', $code);
        }
        return false;
    }

    /**
     * méthode retournant les valeurs exploitée en retour de callback pour la mise à jour d'une colonne du tableau
     * @param $noCol        : numéro de colonne
     * @return array|bool   : valeur de retour de callback, false si la colonne de la cellule n'est pas visible
     */
    public function returnUpdateCol($noCol)
    {
        if ($this->stateCol($noCol)) {

            $idTable = $this->getId();
            $cols = $this->getColValues($noCol);
            $params['col'] = $noCol;
            $params['datas'] = $cols;
            return self::formatRetour($idTable, $idTable, 'updateCol', $params);
        }
        return false;
    }

    /**
     * méthode retournant les valeurs exploitée en retour de callback pour la suppression d'une ligne du tableau
     * @param $noLine       : numéro de ligne
     * @return array|bool   :  valeur de retour de callback, false si noLine < 1 ou > maxLine
     */
    public function returnRmLine($noLine)
    {
        if ($noLine < 1 || $noLine <= (sizeof($this->getLines()) + 1)) {
            $idTable = $this->getId();
            $params['noLine'] = $noLine;
            $params['maxLine'] = sizeof($this->getLines()) + 1;
            return self::formatRetour($idTable, $idTable, 'rmLineUpdate', $params);
        }
        return false;
    }

    /** **************************************************************************************************
     * méthodes privées de la classe                                                                     *
     * *************************************************************************************************** */

    /**
     * @return array    : tableau des valeurs de constantes commençant par ODTABLETITLEPOS_
     * @throws \ReflectionException
     */
    private function getTitlePosConstants()
    {
        $retour = [];
        if (empty($this->const_titlePos)) {
            $constants = $this->getConstants();
            foreach ($constants as $key => $constant) {
                $pos = strpos($key, 'ODTABLETITLEPOS_');
                if ($pos !== false) $retour[$key] = $constant;
            }
            $this->const_titlePos = $retour;
        } else {
            $retour = $this->const_titlePos;
        }
        return $retour;
    }

    /**
     * @return array    : tableau des valeurs de constantes commençant par ODTABLELENGTH_
     * @throws \ReflectionException
     */
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

    private function arrayOneDim(array $ar)
    {
        $ret = true;
        foreach ($ar as $item) {
            if (is_array($item)) { $ret = (false or $ret); }
        }
        return $ret;
    }
}
