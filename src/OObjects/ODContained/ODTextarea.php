<?php

namespace GraphicObjectTemplating\OObjects\ODContained;

use GraphicObjectTemplating\OObjects\ODContained;

/**
 * Class ODTextarea
 * @package ZF3_GOT\OObjects\ODContained
 *
 * getCols()
 * setCols($cols)
 * getRows()
 * setRows($rows)
 * getMaxLength()
 * setMaxLength($maxLength)
 * setPlaceholder   : affecte le texte à montrer quand la zone de saisie est vide (l'invite de saisie)
 * getPlaceholder   : restitue le texte affiché quand la zone de saisie est vide
 * setText($text)
 * getText()
 * evtChange        : évènement changement de valeur, paramètre callback
 *      callback : "nomModule/nomObjet/nomMéthode"
 *          si nomObjet contient 'Controller' -> "nomModule/Controller/nomObjet/nomMéthode"
 *          si nomModule == 'Object' :
 *              si nomObjet commence par 'OD' -> "GraphicObjectTemplating/Objects/ODContained/nomObjet/nomMéthode"
 *              si nomObjet commence par 'OS' -> "GraphicObjectTemplating/Objects/ODContainer/nomObjet/nomMéthode"
 * disChange        : désactivation de l'évènement changement de valeur
 * evtKeyup         : évènement touche frappée (à chaque saisie de caractère), paramètre callback
 *      callback : "nomModule/nomObjet/nomMéthode"
 *          si nomObjet contient 'Controller' -> "nomModule/Controller/nomObjet/nomMéthode"
 *          si nomModule == 'Object' :
 *              si nomObjet commence par 'OD' -> "GraphicObjectTemplating/Objects/ODContained/nomObjet/nomMéthode"
 *              si nomObjet commence par 'OS' -> "GraphicObjectTemplating/Objects/ODContainer/nomObjet/nomMéthode"
 * disKeyup         : désactivation de l'évènement touche frappée
 * setLabel         : attribut un label, une étiquette à la zone de saisie
 * getLabel         : restitue le label, l'étiquette affectée à la zone de saisie
 * setLabelWidthBT  : attribut une largeur (Bootstrap Twitter) au label (tableau de valeur en rapport des 4 médias gérés)
 * getLabelWidthBT  : restitue la largeur (Bootstrap Twitter) du label (tableau de valeur en rapport des 4 médias gérés)
 * enaDispBySide()  : disposition label à coté zone de saisie Textarea
 * enaDispUnder()   : disposition label, et dessous zone de saisie Textarea
 *                  ATTENTION : un setLabelWidthBT après ces 2 dernières commandes annule l'effet attendu pour exécuter
 *                  la commande demandée (setLabelWidthBT)
 * enaResize()      : autorise à redimensionner le textarea en X et Y
 * disResize()      : interdit à redimensionner le textarea en X et Y
 * enaVertiResize   : autorise à redimensionner le textarea en Y
 * enaHorizResize   : autorise à redimensionner le textarea en X
 */
class ODTextarea extends ODContained
{
    const TEXTAREA_RESIZEBOTH   = 'both';
    const TEXTAREA_RESIZEHORIZ  = 'horizontal';
    const TEXTAREA_RESIZEVERTI  = 'vertical';
    const TEXTAREA_RESIZENONE   = 'none';

    private $const_resize;

    /**
     * ODTextarea constructor.
     * @param $id
     * @throws \ReflectionException
     */
    public function __construct(string $id, array $pathObjArray = []) {
        $pathObjArray[] = "oobjects/odcontained/odtextarea/odtextarea";
		parent::__construct($id, $pathObjArray);
        $this->setDisplay();
        $width = $this->getWidthBT();
        if (!is_array($width) || empty($width)) $this->setWidthBT(12);
        $this->enable();

        $this->saveProperties();
        return $this;
    }

    /**
     * @return bool
     */
    public function getCols()
    {
        $properties = $this->getProperties();
        return (array_key_exists('cols', $properties) ? $properties['cols'] : false);
    }

    /**
     * @param $cols
     * @return $this
     */
    public function setCols($cols)
    {
        $cols = (int) $cols;
        $properties = $this->getProperties();

        if ($cols > 0) { $properties['cols'] = $cols; }
        else { $properties['cols'] = ""; }

        $this->setProperties($properties);
        return $this;
    }

    /**
     * @return bool
     */
    public function getRows()
    {
        $properties = $this->getProperties();
        return (array_key_exists('rows', $properties) ? $properties['rows'] : false);
    }

    /**
     * @param $rows
     * @return $this
     */
    public function setRows($rows)
    {
        $rows = (int) $rows;
        $properties = $this->getProperties();

        if ($rows > 0) { $properties['rows'] = $rows; }
        else { $properties['rows'] = ""; }

        $this->setProperties($properties);
        return $this;
    }

    /**
     * @return bool
     */
    public function getMaxLength()
    {
        $properties = $this->getProperties();
        return (array_key_exists('maxLength', $properties) ? $properties['maxLength'] : false);
    }

    /**
     * @param $maxLength
     * @return $this
     */
    public function setMaxLength($maxLength)
    {
        $maxLength = (int) $maxLength;
        $properties = $this->getProperties();

        if ($maxLength > 0) { $properties['maxLength'] = $maxLength; }
        else { $properties['maxLength'] = ""; }

        $this->setProperties($properties);
        return $this;
    }

    /**
     * @param $placeholder
     * @return $this
     */
    public function setPlaceholder($placeholder)
    {
        $placeholder = (string) $placeholder;
        $properties                = $this->getProperties();
        $properties['placeholder'] = $placeholder;
        $this->setProperties($properties);
        return $this;
    }

    /**
     * @return bool
     */
    public function getPlaceholder()
    {
        $properties                = $this->getProperties();
        return ((!empty($properties['placeholder'])) ? $properties['placeholder'] : false) ;
    }

    /**
     * @param $text
     * @return $this
     */
    public function setText($text)
    {
        $text = (string) $text;
        $properties         = $this->getProperties();
        $properties['text'] = $text;
        $this->setProperties($properties);
        return $this;
    }

    /**
     * @return bool
     */
    public function getText()
    {
        $properties                = $this->getProperties();
        return ((!empty($properties['text'])) ? $properties['text'] : false) ;
    }

    /**
     * @param $class
     * @param $method
     * @param bool $stopEvent
     * @return $this
     */
    public function evtChange($class, $method, $stopEvent = true)
    {
        $properties = $this->getProperties();
        if(!isset($properties['event'])) $properties['event']= [];
        $properties['event']['change'] = [];
        $properties['event']['change']['class'] = $class;
        $properties['event']['change']['method'] = $method;
        $properties['event']['change']['stopEvent'] = ($stopEvent) ? 'OUI' : 'NON';
        $this->setProperties($properties);
        return $this;
    }

    /**
     * @return $this
     */
    public function disChange()
    {
        $properties             = $this->getProperties();
        if (isset($properties['event']['change'])) unset($properties['event']['change']);
        $this->setProperties($properties);
        return $this;
    }

    /**
     * @param $class
     * @param $method
     * @param bool $stopEvent
     * @return $this
     */
    public function evtKeyup($class, $method, $stopEvent = true)
    {
        $properties = $this->getProperties();
        if(!isset($properties['event'])) $properties['event']= [];
        $properties['event']['keyup'] = [];
        $properties['event']['keyup']['class'] = $class;
        $properties['event']['keyup']['method'] = $method;
        $properties['event']['keyup']['stopEvent'] = ($stopEvent) ? 'OUI' : 'NON';
        $this->setProperties($properties);
        return $this;
    }

    /**
     * @return $this
     */
    public function disKeyup()
    {
        $properties             = $this->getProperties();
        if (isset($properties['event']["keyup"])) unset($properties['event']["keyup"]);
        $this->setProperties($properties);
        return $this;
    }

    /**
     * @param $label
     * @return $this
     */
    public function setLabel($label)
    {
        $label = (string) $label;
        $properties          = $this->getProperties();
        $properties['label'] = $label;
        $this->setProperties($properties);
        return $this;
    }

    /**
     * @return bool
     */
    public function getLabel()
    {
        $properties            = $this->getProperties();
        return ((array_key_exists('label', $properties)) ? $properties['label'] : false);
    }

    /**
     * @param $widthBT
     * @return $this|bool
     */
    public function setLabelWidthBT($widthBT)
    {
        if (!empty($labelWidthBT)) {
            $widthLabTxtBT = self::formatLabelBT($labelWidthBT);

            $properties = $this->getProperties();
            $properties['labelWidthBT']     = $widthLabTxtBT['labelWidthBT'];
            $properties['textareaWidthBT']  = $widthLabTxtBT['textareaWidthBT'];
            $this->setProperties($properties);
            return $this;
        }
        return false;
    }

    /**
     * @return bool
     */
    public function getLabelWidthBT()
    {
        $properties                = $this->getProperties();
        return ((!empty($properties['labelWidthBT'])) ? $properties['labelWidthBT'] : false) ;
    }

    /**
     * @return $this
     */
    public function enaDispBySide()
    {
        $properties = $this->getProperties();
        $properties['labelWidthBT'] = '';
        $properties['textareaWidthBT'] = '';

        $this->setProperties($properties);
        return $this;
    }

    /**
     * @return $this
     */
    public function enaDispUnder()
    {
        $properties = $this->getProperties();
        $widthLabChkBT  = self::formatLabelBT(12);
        $properties['labelWidthBT'] = $widthLabChkBT['labelWidthBT'];
        $properties['textareaWidthBT'] = $widthLabChkBT['labelWidthBT'];

        $this->setProperties($properties);
        return $this;
    }

    /**
     * @return $this
     */
    public function enaResize()
    {
        $properties = $this->getProperties();
        $properties['resize'] = self::TEXTAREA_RESIZEBOTH;

        $this->setProperties($properties);
        return $this;
    }

    /**
     * @return $this
     */
    public function disResize()
    {
        $properties = $this->getProperties();
        $properties['resize'] = self::TEXTAREA_RESIZENONE;

        $this->setProperties($properties);
        return $this;
    }

    /**
     * @return $this
     */
    public function enaVertiResize()
    {
        $properties = $this->getProperties();
        $properties['resize'] = self::TEXTAREA_RESIZEVERTI;

        $this->setProperties($properties);
        return $this;
    }

    /**
     * @return $this
     */
    public function enaHorizResize()
    {
        $properties = $this->getProperties();
        $properties['resize'] = self::TEXTAREA_RESIZEHORIZ;

        $this->setProperties($properties);
        return $this;
    }

    /** **************************************************************************************************
     * méthodes privées de la classe                                                                     *
     * *************************************************************************************************** */

    /**
     * @return array
     * @throws \ReflectionException
     */
    private function getResizeConstants()
    {
        $retour = [];
        if (empty($this->const_resize)) {
            $constants = $this->getConstants();
            foreach ($constants as $key => $constant) {
                $pos = strpos($key, 'TEXTAREA_RESIZE');
                if ($pos !== false) {
                    $retour[$key] = $constant;
                }
            }
            $this->const_resize = $retour;
        } else {
            $retour = $this->const_resize;
        }
        return $retour;
    }
}