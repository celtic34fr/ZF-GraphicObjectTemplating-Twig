<?php

namespace GraphicObjectTemplating\OObjects\OSContainer;

use GraphicObjectTemplating\OObjects\ODContained\ODContent;
use GraphicObjectTemplating\OObjects\ODContained\ODSpan;
use GraphicObjectTemplating\OObjects\OObject;
use GraphicObjectTemplating\OObjects\OSContainer;

/**
 * Class OSDialog
 * @package GraphicObjectTemplating\Objects\OSContainer
 *
 * showBtnClose             : paramètre l'affichage de la croix de fermeture
 * hideBtnClose             : paramètre de ne pas afficher la croix de fermeture
 * setTitle($title)         : affecte un titre à la fenêtre modale
 * getTitle()               : restitue le titre de la fenêtre modale
 * setWidthDialog($width)   : largeur du dialogue en unité compatible internet
 * getWidthDialog()         : restitue la largeur du dialogue en unité compatible internet
 * setMinHeight($minHeight) : hauteur minimale du dialogue en unité compatible internet
 * getMinHeight()           : restitue la hauteur minimale du dialogue en unité compatible internet
 * setBgColor($bgColor)     : permet de fixer la couleur de fond du dialogue
 * getBgColor()             : restitue la couleur de fond du dialogue
 * setFgColor($fgColor)     : permet de fixer la couleur d'écriture dans le dialogue
 * getFgColor()             : restitue la couleur d'écriture dans le dialogue
 * setContent($content)     : affecte le contenu de $content en enfant du dialogue (directe si OObject,
 *                                  sinon via ODContent)
 * getContent()             : restitue le contnu du dialogue au travers de l'objet enfant (ODContent ou autre)
 * enaCloseBtnOnly()        : n'autorise la fermeture du dialogue par le bouton close ou un bouton d'annulation
 * disCloseBtnOnly()
 * setSize($size = null)    : fixe la taille (largeur ) du dialogue modal
 * getSize()                : récupère la taille (largeur) du dialogue modal
 * enaAnimation()           : active l'animation de visualisation du dialogue modal
 * disAnimation()           : supprime l'animation de visualisation du dialogue modal
 */
class OSDialog extends OSContainer
{
    const COLOR_BLACK         = 'black';
    const COLOR_WHITE         = 'white';
    const COLOR_LIME          = 'lime';
    const COLOR_GREEN         = 'green';
    const COLOR_EMERALD       = 'emerald';
    const COLOR_TEAL          = 'teal';
    const COLOR_BLUE          = 'blue';
    const COLOR_CYAN          = 'cyan';
    const COLOR_COBALT        = 'cobalt';
    const COLOR_INDIGO        = 'indigo';
    const COLOR_VIOLET        = 'violet';
    const COLOR_PINK          = 'pink';
    const COLOR_MAGENTA       = 'magenta';
    const COLOR_CRIMSON       = 'crimson';
    const COLOR_RED           = 'red';
    const COLOR_ORANGE        = 'orange';
    const COLOR_AMBER         = 'amber';
    const COLOR_YELLOW        = 'yellow';
    const COLOR_BROWN         = 'brown';
    const COLOR_OLIVE         = 'olive';
    const COLOR_STEEL         = 'steel';
    const COLOR_MAUVE         = 'mauve';
    const COLOR_TAUPE         = 'taupe';
    const COLOR_GRAY          = 'gray';
    const COLOR_DARK          = 'dark';
    const COLOR_DARKER        = 'darker';
    const COLOR_DARKBROWN     = 'darkBrown';
    const COLOR_DARKCRIMSON   = 'darkCrimson';
    const COLOR_DARKMAGENTA   = 'darkMagenta';
    const COLOR_DARKINDIGO    = 'darkIndigo';
    const COLOR_DARKCYAN      = 'darkCyan';
    const COLOR_DARKCOBALT    = 'darkCobalt';
    const COLOR_DARKTEAL      = 'darkTeal';
    const COLOR_DARKEMERALD   = 'darkEmerald';
    const COLOR_DARKGREEN     = 'darkGreen';
    const COLOR_DARKORANGE    = 'darkOrange';
    const COLOR_DARKRED       = 'darkRed';
    const COLOR_DARKPINK      = 'darkPink';
    const COLOR_DARKVIOLET    = 'darkViolet';
    const COLOR_DARKBLUE      = 'darkBlue';
    const COLOR_LIGHTBLUE     = 'lightBlue';
    const COLOR_LIGHTRED      = 'lightRed';
    const COLOR_LIGHTGREEN    = 'lightGreen';
    const COLOR_LIGHTERBLUE   = 'lighterBlue';
    const COLOR_LIGHTTEAL     = 'lightTeal';
    const COLOR_LIGHTOLIVE    = 'lightOlive';
    const COLOR_LIGHTORANGE   = 'lightOrange';
    const COLOR_LIGHTPINK     = 'lightPink';
    const COLOR_GRAYDARK      = 'grayDark';
    const COLOR_GRAYDARKER    = 'grayDarker';
    const COLOR_GRAYLIGHT     = 'grayLight';
    const COLOR_GRAYLIGHTER   = 'grayLighter';

    const SIZE_SMALL          = 'small';
    const SIZE_NORMAL         = 'normal';
    const SIZE_LARGE          = 'large';

    protected $const_color;
    protected $const_size;

    /**
     * OSDialog constructor.
     * @param $id
     * @throws \ReflectionException
     * @throws \Exception
     * @return OSDialog
     */
    public function __construct($id) {
        parent::__construct($id, "oobjects/oscontainer/osdialog/osdialog.config.php");

        $properties = $this->getProperties();
        if ($properties['id'] != 'dummy') {
            $this->setDisplay();
            $width = $this->getWidthBT();
            if (!is_array($width) || empty($width)) $this->setWidthBT(12);
            $this->enable();
        }

        $this->saveProperties();
        return $this;
    }

    /**
     * @return OSDialog
     */
    public function showBtnClose()
    {
        $properties = $this->getProperties();
        $properties['btnClose'] = true;
        $this->setProperties($properties);
        return $this;
    }

    /**
     * @return OSDialog
     */
    public function hideBtnClose()
    {
        $properties = $this->getProperties();
        $properties['btnClose'] = false;
        $this->setProperties($properties);
        return $this;
    }

    /**
     * @param $title
     * @return OSDialog
     */
    public function setTitle(string $title)
    {
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
        $properties          = $this->getProperties();
        return (!empty($properties['title'])) ? $properties['title'] : false ;
    }

    /**
     * @param $widthDialog
     * @return OSDialog
     */
    public function setWidthDialog(string $widthDialog)
    {
        $properties = $this->getProperties();
        $properties['widthDialog'] = $widthDialog;
        $this->setProperties($properties);
        return $this;
    }

    /**
     * @return bool
     */
    public function getWidthDialog()
    {
        $properties          = $this->getProperties();
        return ((!empty($properties['widthDialog'])) ? $properties['widthDialog'] : false) ;
    }

    /**
     * @param $minHeight
     * @return OSDialog
     */
    public function setMinHeight(string $minHeight)
    {
        $properties = $this->getProperties();
        $properties['minHeight'] = $minHeight;
        $this->setProperties($properties);
        return $this;
    }

    /**
     * @return bool|string
     */
    public function getMinHeight()
    {
        $properties          = $this->getProperties();
        return ((!empty($properties['minHeight'])) ? $properties['minHeight'] : false) ;
    }

    /**
     * @param $bgColor
     * @return OSDialog
     * @throws \ReflectionException
     */
    public function setBgColor(string $bgColor)
    {
        $colors = $this->getColorConst();
        if (!in_array($bgColor, $colors, true)) { $bgColor = self::COLOR_GRAYLIGHTER; }
        $properties = $this->getProperties();
        $properties['bgColor'] = 'bg-'.$bgColor;
        $this->setProperties($properties);
        return $this;
    }

    /**
     * @return bool|string
     */
    public function getBgColor()
    {
        $properties = $this->getProperties();
        return ((!empty($properties['bgColor'])) ? $properties['bgColor'] : false);
    }

    /**
     * @param $fgColor
     * @return OSDialog
     * @throws \ReflectionException
     */
    public function setFgColor(string $fgColor)
    {
        $colors = $this->getColorConst();
        if (!in_array($fgColor, $colors, true)) { $fgColor = self::COLOR_GRAYLIGHTER; }
        $properties = $this->getProperties();
        $properties['fgColor'] = 'fg-'.$fgColor;
        $this->setProperties($properties);
        return $this;
    }

    /**
     * @return bool|string
     */
    public function getFgColor()
    {
        $properties = $this->getProperties();
        return ((!empty($properties['fgColor'])) ? $properties['fgColor'] : false);
    }

    /**
     * @param $class
     * @param $method
     * @param bool $stopEvent
     * @return OSDialog
     */
    public function evtClose(string $class, string $method, bool $stopEvent = true)
    {
        $properties = $this->getProperties();
        if (!isset($properties['event'])) {
            $properties['event'] = [];
        }
        if (!is_array($properties['event'])) {
            $properties['event'] = [];
        }

        $properties['event']['click'] = [];
        $properties['event']['click']['class'] = $class;
        $properties['event']['click']['method'] = $method;
        $properties['event']['click']['stopEvent'] = ($stopEvent) ? 'OUI' : 'NON';

        $this->setProperties($properties);
        return $this;
    }

    /**
     * @return bool|array
     */
    public function getClose()
    {
        $properties = $this->getProperties();
        if (array_key_exists('event', $properties)) {
            $event = $properties['event'];
            if (array_key_exists('click', $event)) { return $event['click']; }
        }
        return false;
    }

    /**
     * @return OSDialog
     */
    public function disClose()
    {
        $properties = $this->getProperties();
        if (isset($properties['event']['click'])) {
            unset($properties['event']['click']);
        }
        $this->setProperties($properties);
        return $this;
    }

    /**
     * @param $content : contenu proprement dit à ajouter
     * @return string : nom attribué au contenu (ID)
     * @throws \Exception
     */
    public function addContent($content, $mode =self::MODE_LAST, $params=null)
    {
        $sessionObjects = self::validateSession();
        $properties     = $this->getProperties();
        if (!($content instanceof OObject)) {
            $name   = $properties['id'].'Content'.(sizeof($properties['contents']) + 1);
            if (self::existObject($name, $sessionObjects)) { throw new \Exception("objet $name already exist"); }
            $contenu = new ODSpan($name);
            $contenu->setContent($content);
            $contenu->saveProperties();
        } else {
            $name   = $content->getId();
        }

        $properties['contents'][$name] = $name;
        $this->setProperties($properties);
        $this->addChild($contenu, $mode, $params);

        return $name;
    }

    /**
     * @param string $name
     * @return OSDialog|bool
     * @throws \Exception
     */
    public function removeContent(string $name)
    {
        $properties = $this->getProperties();
        $contents   = $properties['contents'];
        if (array_key_exists($name, $contents)) {
            $sessionObjects = self::validateSession();
            $content        = self::buildObject($name, $sessionObjects);
            unset($contents[$name]);
            $properties['contents'] = $contents;
            $this->setProperties($properties);
            $this->removeChild($content);
            return $this;
        }
        return false;
    }

    /**
     * @return OSDialog
     * @throws \Exception
     */
    public function clearContents()
    {
        $sessionObjects = self::validateSession();
        $properties     = $this->getProperties();
        $contents       = $properties['contents'];
        foreach ($contents as $name) {
            $content        = self::buildObject($name, $sessionObjects);
            $this->removeChild($content);
        }
        $properties['contents'] = [];
        $this->setProperties($properties);
        return $this;
    }

    /**
     * @param $content
     * @return OSDialog
     * @throws \Exception
     */
    public function setContent($content)
    {
        /** suppression detous les contenus présents */
        $this->clearContents();

        $properties = $this->getProperties();
        if (!($content instanceof OObject)) {
            $contenu = new ODSpan($properties['id']."Content");
            $contenu->setContent($content);
            $contenu->saveProperties();
            $this->addChild($contenu);
        } else {
            $this->addChild($content);
        }
        return $this;
    }

    /**
     * @return array|bool
     * @throws \Exception
     */
    public function getContent()
    {
        if ($this->hasChild()) return $this->getChildren();
        return false;
    }

    /**
     * @param string|null $size
     * @return OSDialog
     * @throws \ReflectionException
     */
    public function setSize(string $size = null)
    {
        $sizes  = $this->getSizeConst();
        if (!in_array($size, $sizes)) { $size = self::SIZE_NORMAL; }
        $properties = $this->getProperties();
        $properties['size'] = $size;
        $this->setProperties($properties);
        return $this;
    }

    /**
     * @return bool|string
     */
    public function getSize()
    {
        $properties = $this->getProperties();
        return ((!empty($properties['size'])) ? $properties['size'] : false);
    }

    /**
     * @return OSDialog
     */
    public function enaCloseBtnOnly()
    {
        $properties = $this->getProperties();
        $properties['closeBtnOnly'] = true;
        $this->setProperties($properties);
        return $this;
    }

    /**
     * @return OSDialog
     */
    public function disCloseBtnOnly()
    {
        $properties = $this->getProperties();
        $properties['closeBtnOnly'] = true;
        $this->setProperties($properties);
        return $this;
    }

    /**
     * @return OSDialog
     */
    public function enaAnimation()
    {
        $properties = $this->getProperties();
        $properties['animate'] = true;
        $this->setProperties($properties);
        return $this;
    }

    /**
     * @return OSDialog
     */
    public function disAnimation()
    {
        $properties = $this->getProperties();
        $properties['animate'] = true;
        $this->setProperties($properties);
        return $this;
    }


    /** ------------------------- *
     * méthode(s) retour callback *
     * -------------------------- */

    /**
     * @return array
     */
    public function CmdOpenDialog()
    {
        $item = [];
        $item['idSource']   = $this->getId();
        $item['idCible']   = $this->getId();
        $item['mode'] = "exec";
        $item['code'] = '$("#'.$this->getId().'").modal("show");';
        return $item;
    }

    /**
     * @return array
     */
    public function CmdCloseDialog()
    {
        $item = [];
        $item['idSource']   = $this->getId();
        $item['idCible']   = $this->getId()."Command";
        $item['mode'] = "exec";
        $item['code'] = '$("#'.$this->getId().'").modal("hide");';
        return $item;
    }

    /**
     * @return array
     */
    public function CmdToggleDialog()
    {
        $item = [];

        $item['idSource']   = $this->getId();
        $item['idCible']   = $this->getId()."Command";
        $item['mode'] = "exec";
        $item['code'] = '$("#'.$this->getId().'").modal("toggle");';

        return $item;
    }


    /** ------------------- *
     * méthode(s) privée(s) *
     * ---------------------*/

    /**
     * @return array
     * @throws \ReflectionException
     */
    private function getColorConst()
    {
        $retour = [];
        if (empty($this->const_color)) {
            $constants = $this->getConstants();
            foreach ($constants as $key => $constant) {
                $pos = strpos($key, 'COLOR');
                if ($pos !== false) {
                    $retour[$key] = $constant;
                }
            }
            $this->const_color = $retour;
        } else {
            $retour = $this->const_color;
        }
        return $retour;
    }

    /**
     * @return array
     * @throws \ReflectionException
     */
    private function getSizeConst()
    {
        $retour = [];
        if (empty($this->const_size)) {
            $constants = $this->getConstants();
            foreach ($constants as $key => $constant) {
                $pos = strpos($key, 'SIZE');
                if ($pos !== false) {
                    $retour[$key] = $constant;
                }
            }
            $this->const_size = $retour;
        } else {
            $retour = $this->const_size;
        }
        return $retour;
    }
}