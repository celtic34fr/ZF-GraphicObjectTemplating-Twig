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
 * showBtnClose         : paramètre l'affichage de la croix de fermeture
 * hideBtnClose         : paramètre de ne pas afficher la croix de fermeture
 * setTitle($title)     : affecte un titre à la fenêtre modale
 * getTitle()           : restitue le titre de la fenêtre modale
 * setWidthDialog($width)   : largeur du dialogue en unité compatible internet
 * getWidthDialog()         : restitue la largeur du dialogue en unité compatible internet
 * setMinHeight($minHeight) : hauteur minimale du dialogue en unité compatible internet
 * getMinHeight()           : restitue la hauteur minimale du dialogue en unité compatible internet
 * setBgColor($bgColor)     : permet de fixer la couleur de fond du dialogue
 * getBgColor()             : restitue la couleur de fond du dialogue
 * setFgColor($fgColor)     : permet de fixer la couleur d'écriture dans le dialogue
 * getFgColor()             : restitue la couleur d'écriture dans le dialogue
 * setContent($content)     : affecte le contenu de $content en enfant du dialogue (directe si OObject, sinon via ODContent)
 * getContent()             : restitue le contnu du dialogue au travers de l'objet enfant (ODContent ou autre)
 *
 * enaCloseBtnOnly()        : n'autorise la fermeture du dialogue par le bouton close ou un bouton d'annulation
 * disCloseBtnOnly()
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

    protected $const_color;

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

    public function showBtnClose()
    {
        $properties = $this->getProperties();
        $properties['btnClose'] = true;
        $this->setProperties($properties);
        return $this;
    }

    public function hideBtnClose()
    {
        $properties = $this->getProperties();
        $properties['btnClose'] = false;
        $this->setProperties($properties);
        return $this;
    }

    public function setTitle($title)
    {
        $title = (string) $title;
        $properties = $this->getProperties();
        $properties['title'] = $title;
        $this->setProperties($properties);
        return $this;
    }

    public function getTitle()
    {
        $properties          = $this->getProperties();
        return ((!empty($properties['title'])) ? $properties['title'] : false) ;
    }

    public function setWidthDialog($widthDialog)
    {
        $widthDialog = (string) $widthDialog;
        $properties = $this->getProperties();
        $properties['widthDialog'] = $widthDialog;
        $this->setProperties($properties);
        return $this;
    }

    public function getWidthDialog()
    {
        $properties          = $this->getProperties();
        return ((!empty($properties['widthDialog'])) ? $properties['widthDialog'] : false) ;
    }

    public function setMinHeight($minHeight)
    {
        $minHeight = (string) $minHeight;
        $properties = $this->getProperties();
        $properties['minHeight'] = $minHeight;
        $this->setProperties($properties);
        return $this;
    }

    public function getMinHeight()
    {
        $properties          = $this->getProperties();
        return ((!empty($properties['minHeight'])) ? $properties['minHeight'] : false) ;
    }

    public function setBgColor($bgColor)
    {
        $bgColor  = (string) $bgColor;
        $colors = $this->getColorConst();
        if (!in_array($bgColor, $colors, true)) { $bgColor = self::COLOR_GRAYLIGHTER; }
        $properties = $this->getProperties();
        $properties['bgColor'] = 'bg-'.$bgColor;
        $this->setProperties($properties);
        return $this;
    }

    public function getBgColor()
    {
        $properties = $this->getProperties();
        return ((!empty($properties['bgColor'])) ? $properties['bgColor'] : false);
    }

    public function setFgColor($fgColor)
    {
        $fgColor  = (string) $fgColor;
        $colors = $this->getColorConst();
        if (!in_array($fgColor, $colors, true)) { $fgColor = self::COLOR_GRAYLIGHTER; }
        $properties = $this->getProperties();
        $properties['fgColor'] = 'fg-'.$fgColor;
        $this->setProperties($properties);
        return $this;
    }

    public function getFgColor()
    {
        $properties = $this->getProperties();
        return ((!empty($properties['fgColor'])) ? $properties['fgColor'] : false);
    }

    public function evtClose($class, $method, $stopEvent = true)
    {
        $class = (string)$class;
        $method = (string)$method;
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

    public function getClose()
    {
        $properties = $this->getProperties();
        if (array_key_exists('event', $properties)) {
            $event = $properties['event'];
            if (array_key_exists('click', $event)) { return $event['click']; }
        }
        return false;
    }

    public function disClose()
    {
        $properties = $this->getProperties();
        if (isset($properties['event']['click'])) {
            unset($properties['event']['click']);
        }
        $this->setProperties($properties);
        return $this;
    }


    public function setContent($content)
    {
        $properties = $this->getProperties();
        if (!($content instanceof OObject)) {
            $contenu = new ODSpan($properties['id']."Content");
            $contenu->setContent($content);
            $this->addChild($contenu);
        } else {
            $this->addChild($content);
        }
        return $this;
    }

    public function getContent()
    {
        if ($this->$this->hasChildren()) return $this->getChildren();
        return false;
    }

    public function CmdOpenDialog()
    {
        $item = [];
        $item['idSource']   = $this->getId();
        $item['idCible']   = $this->getId();
        $item['mode'] = "exec";
        $item['code'] = '$("#'.$this->getId().'").modal("show");';
        return $item;
    }

    public function CmdCloseDialog()
    {
        $item = [];
        $item['idSource']   = $this->getId();
        $item['idCible']   = $this->getId()."Command";
        $item['mode'] = "exec";
        $item['code'] = '$("#'.$this->getId().'").modal("hide");';
        return $item;
    }

    public function CmdToggleDialog()
    {
        $item = [];

        $item['idSource']   = $this->getId();
        $item['idCible']   = $this->getId()."Command";
        $item['mode'] = "exec";
        $item['code'] = '$("#'.$this->getId().'").modal("toggle");';

        return $item;
    }

    public function enaCloseBtnOnly()
    {
        $properties = $this->getProperties();
        $properties['closeBtnOnly'] = true;
        $this->setProperties($properties);
        return $this;
    }

    public function disCloseBtnOnly()
    {
        $properties = $this->getProperties();
        $properties['closeBtnOnly'] = true;
        $this->setProperties($properties);
        return $this;
    }


    /** méthode(s) privée(s) */

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
}