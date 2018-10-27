<?php

namespace GraphicObjectTemplating\OObjects\ODContained;

use GraphicObjectTemplating\OObjects\ODContained;

/**
 * Class ODBadge
 * @package GraphicObjectTemplating\Objects\ODContained
 *
 * setWidthBT  : surcharge de méthode pour la rendre inactive
 * getWidthBT  : surcharge de méthode pour la rendre inactive
 * setColor    : permet d'affecter une couleur de fond au badge
 * getColor    : récupère la couleur actuellement affecté au badge
 * evtClick    : affecte et active l'évèvement Click sur le badge
 * disClick    : déactive l'évènement click sur le badge
 * setPosition : permet, via l'affectation d'une classe, de positionner le badge à droite ou à gauche
 * getPosition : récupère la position actuelle du basge
 */
class ODBadge extends ODContained
{
    const BADGE_DEFAULT    = "badge";
    const BADGE_BLUE       = "badge bg-color-blue";
    const BADGE_BLUEDARK   = "badge bg-color-blueLight";
    const BADGE_GREEN      = "badge bg-color-green";
    const BADGE_GREENLIGHT = "badge bg-color-greenLight";
    const BADGE_GREENDARK  = "badge bg-color-greenDark";
    const BADGE_RED        = "badge bg-color-red";
    const BADGE_YELLOW     = "badge bg-color-yellow";
    const BADGE_ORANGE     = "badge bg-color-orange";
    const BADGE_ORANGEDARK = "badge bg-color-orangeDark";
    const BADGE_PINK       = "badge bg-color-pink";
    const BADGE_PINKDARK   = "badge bg-color-pinkDark";
    const BADGE_PURPLE     = "badge bg-color-purple";
    const BADGE_DARKEN     = "badge bg-color-darken";
    const BADGE_LIGHTEN    = "badge bg-color-lighten";
    const BADGE_WHITE      = "badge bg-color-white";
    const BADGE_GRAYDARK   = "badge bg-color-grayDark";
    const BADGE_MAGENTA    = "badge bg-color-magenta";
    const BADGE_TEAL       = "badge bg-color-teal";
    const BADGE_REDLIGHT   = "badge bg-color-redLight";

    const BADGE_COLOR_DEFAULT = "badge bg-color-white";
    const BADGE_COLOR_DANGER  = "badge bg-color-red";
    const BADGE_COLOR_WARNING = "badge bg-color-orange";
    const BADGE_COLOR_INFO    = "badge bg-color-blue";
    const BADGE_COLOR_PRIMARY = "badge bg-color-blueMedium";
    const BADGE_COLOR_SUCCES  = "badge bg-color-greenMedium";

    const BADGEPOS_LEFT   = "pull-left";
    const BADGEPOS_CENTER = "pull-center";
    const BADGEPOS_RIGHT  = "pull-right";

    protected $const_badgeColors;
    protected $const_badgePos;

    public function __construct($id) {
        parent::__construct($id, "oobjects/odcontained/odbadge/odbadge.config.php");

        $properties = $this->getProperties();
        if ($properties['id'] != 'dummy') {
            if (!$this->getWidthBT() || empty($this->getWidthBT())) {
                $this->setWidthBT(12);
            }
            $this->setDisplay(self::DISPLAY_BLOCK);
            $this->enable();
        }

        $this->saveProperties();
        return $this;
    }

    public function setWidthBT($widthBT)
    {
        // surcharge de méthode pour qu'elle ne fasse rien
        return $this;
    }

    public function getWidthBT()
    {
        // surcharge de méthode pour qu'elle ne fasse rien
        return $this;
    }

    public function setColor($color = null)
    {
        if (!empty($color)) {
            $colors = $this->getBadgeColorConst();
            $color  = (string) $color;
            if (!in_array($color, $colors)) $color = self::BADGE_DEFAULT;

            $properties = $this->getProperties();
            $properties['badgeColor'] = $color;
            $this->setProperties($properties);
            return $this;
        }
        return false;
    }

    public function getColor()
    {
        $properties          = $this->getProperties();
        return ((!empty($properties['badgeColor'])) ? $properties['badgeColor'] : false) ;
    }

    public function evtClick($class, $method, $stopEvent = true)
    {
        $properties = $this->getProperties();
        if(!isset($properties['event'])) $properties['event'] = [];
        $properties['event']['click'] = [];
        $properties['event']['click']['class'] = $class;
        $properties['event']['click']['method'] = $method;
        $properties['event']['click']['stopEvent'] = ($stopEvent) ? 'OUI' : 'NON';
        $this->setProperties($properties);
        return $this;
    }

    public function disClick()
    {
        $properties             = $this->getProperties();
        if (isset($properties['event']['click'])) unset($properties['event']['click']);
        $this->setProperties($properties);
        return $this;
    }

    public function setPosition($position = self::BADGEPOS_RIGHT)
    {
        $position = (string) $position;
        $positions = $this->getBadgePosConst();
        if (!in_array($position, $positions)) $position = self::BADGEPOS_RIGHT;

        $properties = $this->getProperties();
        $properties['position'] = $position;
        $this->setProperties($properties);
        return $this;
    }

    public function getPosition()
    {
        $properties          = $this->getProperties();
        return ((!empty($properties['position'])) ? $properties['position'] : false) ;
    }

    public function setContent($content = "&nbsp")
    {
        $content = (string) $content;
        $properties = $this->getProperties();
        $properties['content'] = $content;
        $this->setProperties($properties);
        return $this;
    }

    public function getContent()
    {
        $properties          = $this->getProperties();
        return ((!empty($properties['content'])) ? $properties['content'] : false) ;
    }


    private function getBadgeColorConst()
    {
        $retour = [];
        if (empty($this->const_badgeColors)) {
            $constants = $this->getConstants();
            foreach ($constants as $key => $constant) {
                $pos = strpos($key, 'BADGE_');
                if ($pos !== false) $retour[$key] = $constant;
            }
            $this->const_badgeColors = $retour;
        } else {
            $retour = $this->const_badgeColors;
        }
        return $retour;
    }

    private function getBadgePosConst()
    {
        $retour = [];
        if (empty($this->const_badgePos)) {
            $constants = $this->getConstants();
            foreach ($constants as $key => $constant) {
                $pos = strpos($key, 'BADGEPOS');
                if ($pos !== false) $retour[$key] = $constant;
            }
            $this->const_badgePos = $retour;
        } else {
            $retour = $this->const_badgePos;
        }
        return $retour;
    }


}