<?php

namespace GraphicObjectTemplating\OObjects\ODContained;

use Zend\ServiceManager\ServiceManager;
use GraphicObjectTemplating\OObjects\ODContained;
use GraphicObjectTemplating\OObjects\OObject;
use GraphicObjectTemplating\Service\ZF3GotServices;

/**
 * Class ODCheckbox
 * @package GraphicObjectTemplating\OObjects\ODContained
 *
 * setLabel($label)
 * getLabel()
 * setLabelWidthBT($labelWidthBT)
 * getLabelWidthBT()
 * getCheckboxWidthBT()
 * enaDispBySide()          disposition label à coté de la case à cocher
 * enaDispUnder()           disposition label, et dessous de la case à cocher
 *                  ATTENTION : un setLabelWidthBT après ces 2 dernières commandes annule l'effet attendu pour exécuter
 *                  la commande demandée (setLabelWidthBT)
 * addOption($value, $libel, $type = self::CHECKTYPE_DEFAULT, $state = self::STATE_ENABLE)
 * rmOption($value)
 * setOption($value, $libel, $type = self::CHECKTYPE_DEFAULT, $state = self::STATE_ENABLE)
 * getOption($value)
 * setOptions(array $options = null)
 * getOptions()
 * checkOption($value)
 * uncheckOption($value)
 * checkAllOptions()
 * uncheckAllOptions()
 * enaOption($value)
 * disOption($value)
 * getStateOption($value)
 * enaAllOptions()
 * disAllOptions()
 * getStateOptions()
 * setForme($forme = self::CHECKFORME_HORIZONTAL)
 * getForme()
 * setHMargin($hMargin = '0')
 * getHMargin()
 * setVMargin($vMargin = '0')
 * getVMargin()
 * setPlacement($placement = self::CHECKPLACEMENT_LEFT)
 * getPlacement()
 * evtChange($value, $class, $method, $stopEvent = false)
 * getChange($value)
 * disChange($value)
 * getChanges()
 * disChanges()
 *
 * méthodes de gestion de retour de callback
 * ------------------------------------------
 * dispatchEvents(ServiceManager $sm, $params)
 *
 * méthodes privées de la classe
 * -----------------------------
 * getFormeConstants()
 * getPlacementConstants()
 * getTypeConstants()
 * getCheckboxConstants()
 */
class ODCheckbox extends ODContained
{
    const CHECKFORME_HORIZONTAL = 'horizontal';
    const CHECKFORME_VERTICAL = 'vertical';

    const CHECKPLACEMENT_LEFT  = "left";
    const CHECKPLACEMENT_RIGHT = "right";

    const CHECKTYPE_DEFAULT = "checkbox";
    const CHECKTYPE_PRIMARY = "checkbox checkbox-primary";
    const CHECKTYPE_SUCCESS = "checkbox checkbox-success";
    const CHECKTYPE_INFO    = "checkbox checkbox-info";
    const CHECKTYPE_WARNING = "checkbox checkbox-warning";
    const CHECKTYPE_DANGER  = "checkbox checkbox-danger";

    const CHECKBOX_CHECK   = "check";
    const CHECKBOX_UNCHECK = "uncheck";

    private $const_forme;
    private $const_placement;
    private $const_type;
    private $const_checkbox;

    public function __construct(string $id, array $pathObjArray = []) {
        $pathObjArray[] = "oobjects/odcontained/odcheckbox/odcheckbox";
		parent::__construct($id, $pathObjArray);
        $this->setDisplay();
        $width = $this->getWidthBT();
        if (!is_array($width) || empty($width)) $this->setWidthBT(12);
        $this->enable();

        $this->saveProperties();
        return $this;
    }

    public function setLabel($label)
    {
        $label = (string) $label;
        $properties = $this->getProperties();
        $properties['label'] = $label;
        $this->setProperties($properties);
        return $this;
    }

    public function getLabel()
    {
        $properties = $this->getProperties();
        return array_key_exists('label', $properties) ? $properties['label'] : false;
    }

    public function setLabelWidthBT($labelWidthBT)
    {
        if (!empty($labelWidthBT)) {
            $widthLabChkBT = self::formatLabelBT($labelWidthBT);

            $properties     = $this->getProperties();
            $properties['labelWidthBT'] = $widthLabChkBT['labelWidthBT'];
            $properties['inputWidthBT'] = $widthLabChkBT['inputWidthBT'];
            $this->setProperties($properties);
            return $this;
        }
        return false;
    }

    public function getLabelWidthBT()
    {
        $properties = $this->getProperties();
        return array_key_exists('labelWidthBT', $properties) ? $properties['labelWidthBT'] : false;
    }

    public function getCheckboxWidthBT()
    {
        $properties = $this->getProperties();
        return array_key_exists('inputWidthBT', $properties) ? $properties['inputWidthBT'] : false;
    }

    public function enaDispBySide()
    {
        $properties = $this->getProperties();
        $properties['labelWidthBT'] = '';
        $properties['inputWidthBT'] = '';

        $this->setProperties($properties);
        return $this;
    }

    public function enaDispUnder()
    {
        $properties = $this->getProperties();
        $widthLabChkBT  = self::formatLabelBT(12);
        $properties['labelWidthBT'] = $widthLabChkBT['labelWidthBT'];
        $properties['inputWidthBT'] = $widthLabChkBT['labelWidthBT'];

        $this->setProperties($properties);
        return $this;
    }

    public function enaCheckBySide()
    {
        $properties = $this->getProperties();
        $properties['checkLabelWidthBT'] = '';
        $properties['checkInputWidthBT'] = '';

        $this->setProperties($properties);
        return $this;
    }

    public function enaCheckUnder()
    {
        $properties = $this->getProperties();
        $widthLabChkBT  = self::formatLabelBT(12);
        $properties['checkLabelWidthBT'] = $widthLabChkBT['labelWidthBT'];
        $properties['checkInputWidthBT'] = $widthLabChkBT['labelWidthBT'];

        $this->setProperties($properties);
        return $this;
    }

    public function addOption($value, $libel, $type = self::CHECKTYPE_DEFAULT, $state = self::STATE_ENABLE)
    {
        $value = (string) $value;
        if (!empty($value)) {
            $libel      = (string) $libel;
            $properties = $this->getProperties();

            $types      = $this->getTypeConstants();
            if (!in_array($type, $types)) { $type = self::CHECKTYPE_DEFAULT; }

            $states     = $this->getStateConstants();
            if (!in_array($state, $states)) { $stat = self::STATE_ENABLE; }
            if (!array_key_exists('options', $properties)) { $properties['options'] = []; }

            $options    = $properties['options'];
            $item       = [];
            if (!array_key_exists($value, $options)) {
                $item['libel']      = $libel;
                $item['check']      = self::CHECKBOX_UNCHECK;
                $item['type']       = $type;
                $item['state']      = $state;
                $item['value']      = $value;
                $options[$value]    = $item;
                $properties['options'] = $options;
                $this->setProperties($properties);
            }
            return $this;
        }
        return false;
    }

    public function rmOption($value)
    {
        $value = (string) $value;
        if (!empty($value)) {
            $properties = $this->getProperties();
            $options = $properties['options'];
            if (array_key_exists($value, $options)) {
                unset($options[$value]);
                $properties['options'] = $options;
                $this->setProperties($properties);
                return $this;
            }
        }
        return false;
    }

    public function setOption($value, $libel, $type = self::CHECKTYPE_DEFAULT, $state = self::STATE_ENABLE)
    {
        $value = (string) $value;
        if (!empty($value)) {
            $libel = (string) $libel;
            $properties = $this->getProperties();
            $types = $this->getTypeConstants();
            if (!in_array($type, $types)) { $type = self::CHECKTYPE_DEFAULT; }
            $states = $this->getStateConstants();
            if (!in_array($state, $states)) { $stat = self::STATE_ENABLE; }
            if (!array_key_exists('options', $properties)) { $properties['options'] = []; }
            $label = $properties['label'];
            $options = $properties['options'];
            if (empty($label) && empty($options)) {
                $label = $libel;
                $properties['label'] = $libel;
            } else {
                if (array_key_exists($value, $options)) {
                    $item = [];
                    $item['libel']  = $libel;
                    $item['check']  = self::CHECKBOX_UNCHECK;
                    $item['type']   = $type;
                    $item['state']  = $state;
                    $item['value']  = $value;
                    $options[$value]    = $item;
                    $properties['options']  = $options;
                    $this->setProperties($properties);
                    return $this;
                }
            }
        }
        return false;
    }

    public function getOption($value)
    {
        $value = (string) $value;
        if (!empty($value)) {
            $properties = $this->getProperties();
            $options = $properties['options'];
            if (array_key_exists($value, $options)) {
                return $options[$value];
            }
        }
        return false;
    }

    public function setOptions(array $options = null)
    {
        if (!empty($options)) {
            $properties = $this->getProperties();
            $properties['options'] = $options;
            $this->setProperties($properties);
            return $this;
        }
        return false;
    }

    public function getOptions()
    {
        $properties = $this->getProperties();
        return array_key_exists('options', $properties) ? $properties['options'] : false;
    }

    public function checkOption($value)
    {
        $value = (string) $value;
        if (!empty($value)) {
            $properties = $this->getProperties();
            $options = $properties['options'];
            if (array_key_exists($value, $options)) {
                $options[$value]['check'] = self::CHECKBOX_CHECK;
                $properties['options'] = $options;
                $this->setProperties($properties);
                return $this;
            }
        }
        return false;
    }

    public function uncheckOption($value)
    {
        $value = (string) $value;
        if (!empty($value)) {
            $properties = $this->getProperties();
            $options = $properties['options'];
            if (array_key_exists($value, $options)) {
                $options[$value]['check'] = self::CHECKBOX_UNCHECK;
                $properties['options'] = $options;
                $this->setProperties($properties);
                return $this;
            }
        }
        return false;
    }

    public function checkAllOptions()
    {
        $properties = $this->getProperties();
        $options = $properties['options'];
        foreach ($options as $value => $item) {
            $item['check'] = self::CHECKBOX_CHECK;
            $options[$value] = $item;
        }
        $properties['options'] = $options;
        $this->setProperties($properties);
        return $this;
    }

    public function uncheckAllOptions()
    {
        $properties = $this->getProperties();
        $options = $properties['options'];
        foreach ($options as $value => $item) {
            $item['check'] = self::CHECKBOX_UNCHECK;
            $options[$value] = $item;
        }
        $properties['options'] = $options;
        $this->setProperties($properties);
        return $this;
    }

    public function getCheckedOptions()
    {
        $properties = $this->getProperties();
        $options    = $properties['options'];
        $checked    = [];
        foreach ($options as $value => $option) {
            if ($option['check']) {
                $checked[] = $value;
            }
        }
        return $checked;
    }

    public function enaOption($value)
    {
        $value = (string) $value;
        if (!empty($value)) {
            $properties = $this->getProperties();
            $options = $properties['options'];
            if (array_key_exists($value, $options)) {
                $options[$value]['state'] = self::STATE_ENABLE;
                $properties['options'] = $options;
                $this->setProperties($properties);
                return $this;
            }
        }
        return false;
    }

    public function disOption($value)
    {
        $value = (string) $value;
        if (!empty($value)) {
            $properties = $this->getProperties();
            $options = $properties['options'];
            if (array_key_exists($value, $options)) {
                $options[$value]['state'] = self::STATE_DISABLE;
                $properties['options'] = $options;
                $this->setProperties($properties);
                return $this;
            }
        }
        return false;
    }

    public function getStateOption($value)
    {
        $value = (string) $value;
        if (!empty($value)) {
            $properties = $this->getProperties();
            $options = $properties['options'];
            if (array_key_exists($value, $options)) {
                return $options[$value]['state'] ? 'enable' : 'disable';
            }
        }
        return false;
    }

    public function enaAllOptions()
    {
        $properties = $this->getProperties();
        $options = $properties['options'];
        foreach ($options as $value => $item) {
            $item['state'] = self::STATE_ENABLE;
            $options[$value] = $item;
        }
        $properties['options'] = $options;
        $this->setProperties($properties);
        return $this;
    }

    public function disAllOptions()
    {
        $properties = $this->getProperties();
        $options = $properties['options'];
        foreach ($options as $value => $item) {
            $item['state'] = self::STATE_DISABLE;
            $options[$value] = $item;
        }
        $properties['options'] = $options;
        $this->setProperties($properties);
        return $this;
    }

    public function getStateOptions()
    {
        $states     = [];
        $properties = $this->getProperties();
        $options = $properties['options'];
        foreach ($options as $value => $item) {
            $states[$value] = $options[$value]['state'] ? 'enable' : 'disable';
        }
        return $states;
    }

    public function setForme($forme = self::CHECKFORME_HORIZONTAL)
    {
        $formes = $this->getFormeConstants();
        if (!in_array($forme, $formes)) { $form = self::CHECKFORME_HORIZONTAL; }
        $properties = $this->getProperties();
        $properties['forme'] = $forme;
        $this->setProperties($properties);
        return $this;
    }

    public function getForme()
    {
        $properties = $this->getProperties();
        return array_key_exists('forme', $properties) ? $properties['forme'] : false;
    }

    public function setHMargin($hMargin = '0')
    {
        $hMargin = (string) $hMargin;
        $properties = $this->getProperties();
        $properties['hMargin'] = $hMargin;
        $this->setProperties($properties);
        return $this;
    }

    public function getHMargin()
    {
        $properties = $this->getProperties();
        return array_key_exists('hMargin', $properties) ? $properties['hMargin'] : false;
    }

    public function setVMargin($vMargin = '0')
    {
        $vMargin = (string) $vMargin;
        $properties = $this->getProperties();
        $properties['vMargin'] = $vMargin;
        $this->setProperties($properties);
        return $this;
    }

    public function getVMargin()
    {
        $properties = $this->getProperties();
        return array_key_exists('vMargin', $properties) ? $properties['vMargin'] : false;
    }

    public function setPlacement($placement = self::CHECKPLACEMENT_LEFT)
    {
        $placements = $this->getPlacementConstants();
        if (!in_array($placement, $placements)) { $placement = self::CHECKPLACEMENT_LEFT; }
        $properties = $this->getProperties();
        $properties['placement'] = $placement;
        $this->setProperties($properties);
        return $this;
    }

    public function getPlacement()
    {
        $properties = $this->getProperties();
        return array_key_exists('placement', $properties) ? $properties['placement'] : false;
    }

    public function evtChange($value, $class, $method, $stopEvent = false)
    {
        $value = (string) $value;
        if (!empty($value)) {
            $properties = $this->getProperties();
            $options    = $properties['options'];
            if (array_key_exists($value, $options)) {
                if (!empty($class) && !empty($method)) {
                    if (!array_key_exists('event', $properties)) { $properties['event'] = []; }
                    if (class_exists($class)) {
                        $obj = new $class();
                        if (method_exists($obj, $method)) {
                            $properties['event']['change'][$value] = [];
                            $properties['event']['change'][$value]['class'] = $class;
                            $properties['event']['change'][$value]['method'] = $method;
                            $properties['event']['change'][$value]['stopEvent'] = ($stopEvent) ? 'OUI' : 'NON';

                            $this->setProperties($properties);
                            return $this;
                        }
                    }
                }
            }
        }
        return false;
    }

    public function getChange($value)
    {
        $value = (string) $value;
        if (!empty($value)) {
            $properties = $this->getProperties();
            if (array_key_exists('event', $properties)) {
                $event = $properties['event'];
                if (array_key_exists('change', $event)) {
                    $changes =  $event['change'];
                    if (array_key_exists($value, $changes)) {
                        return $changes[$value];
                    }
                }
            }
        }
        return false;

    }

    public function disChange($value)
    {
        $value = (string) $value;
        if (!empty($value)) {
            $properties = $this->getProperties();
            if (array_key_exists('event', $properties)) {
                $event = $properties['event'];
                if (array_key_exists('change', $event)) {
                    $changes =  $event['change'];
                    if (array_key_exists($value, $changes)) {
                        unset($changes[$value]);
                        $event['change'] = $changes;
                        $properties['event'] = $event;
                        $this->setProperties($properties);
                        return $this;
                    }
                }
            }
        }
        return false;
    }

    public function getChanges()
    {
        $properties = $this->getProperties();
        return array_key_exists('change', $properties['event']) ? $properties['event']['change'] : false;

    }

    public function disChanges()
    {
        $properties = $this->getProperties();
        if (array_key_exists('event', $properties)) {
            $event = $properties['event'];
            if (array_key_exists('change', $event)) {
                unset($event['change']);
                $properties['event'] = $event;
                $this->setProperties($properties);
                return $this;
            }
        }
        return false;
    }

    /** **************************************************************************************************
     * méthodes de gestion de retour de callback                                                         *
     * *************************************************************************************************** */

    public function dispatchEvents(ServiceManager $sm, $params)
    {
        /** @var ZF3GotServices $gs */
        $gs = $sm->get('graphic.object.templating.services');
        $ret    = [];
        /** @var ODCheckbox $objet */
        $sessionObj = OObject::validateSession();
        $objet  = OObject::buildObject($params['id'], $sessionObj);
        $values = $params['value'];
        $values = explode('$', $values);
        // sauvegarde de l'état des cases à cocher
        if (!is_array($values)) { $values = [$values]; }
        $objet->uncheckAllOptions();
        foreach ($values as $value) {
            $objet->checkOption($value);
        }
        $item           = [];
        $item['id']     = $objet->getId();
        $item['mode']   = 'update';
        $item['html']   = $gs->render($objet);
        $ret[]          = $item;

        // validation et appel de la callback si existe
        foreach ($values as $value) {
            $event      = $objet->getChange($value);
            if ($event !== false) {
                $class      = (array_key_exists('class', $event)) ? $event['class'] : "";
                $method     = (array_key_exists('method', $event)) ? $event['method'] : "";
                $stopEvt    = (array_key_exists('stopEvent', $event)) ? $event['stopEvent'] : "NON";
                if (!empty($class) && !empty($method)) {
                    $callObj = new $class();
                    $retCallObj = call_user_func_array([$callObj, $method], [$sm, $params]);
                    foreach ($retCallObj as $item) {
                        array_push($ret, $item);
                    }
                }
            }
        }
        return [$ret];
    }

    /** **************************************************************************************************
     * méthodes privées de la classe                                                                     *
     * *************************************************************************************************** */

    private function getFormeConstants()
    {
        $retour = [];
        if (empty($this->const_forme)) {
            $constants = $this->getConstants();
            foreach ($constants as $key => $constant) {
                $pos = strpos($key, 'CHECKFORME');
                if ($pos !== false) {
                    $retour[$key] = $constant;
                }
            }
            $this->const_forme = $retour;
        } else {
            $retour = $this->const_forme;
        }
        return $retour;
    }

    private function getPlacementConstants()
    {
        $retour = [];
        if (empty($this->const_placement)) {
            $constants = $this->getConstants();
            foreach ($constants as $key => $constant) {
                $pos = strpos($key, 'CHECKPLACEMENT');
                if ($pos !== false) {
                    $retour[$key] = $constant;
                }
            }
            $this->const_placement = $retour;
        } else {
            $retour = $this->const_placement;
        }
        return $retour;
    }

    private function getTypeConstants()
    {
        $retour = [];
        if (empty($this->const_type)) {
            $constants = $this->getConstants();
            foreach ($constants as $key => $constant) {
                $pos = strpos($key, 'CHECKTYPE');
                if ($pos !== false) {
                    $retour[$key] = $constant;
                }
            }
            $this->const_type = $retour;
        } else {
            $retour = $this->const_type;
        }
        return $retour;
    }

    private function getCheckboxConstants()
    {
        $retour = [];
        if (empty($this->const_checkbox)) {
            $constants = $this->getConstants();
            foreach ($constants as $key => $constant) {
                $pos = strpos($key, 'CHECKBOX');
                if ($pos !== false) {
                    $retour[$key] = $constant;
                }
            }
            $this->const_checkbox = $retour;
        } else {
            $retour = $this->const_checkbox;
        }
        return $retour;
    }
}