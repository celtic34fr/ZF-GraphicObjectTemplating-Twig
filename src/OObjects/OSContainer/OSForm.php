<?php

namespace GraphicObjectTemplating\OObjects\OSContainer;

use GraphicObjectTemplating\OObjects\ODContained;
use GraphicObjectTemplating\OObjects\ODContained\ODButton;
use GraphicObjectTemplating\OObjects\OObject;
use GraphicObjectTemplating\OObjects\OSContainer;

/**
 * Class OSForm
 * @package GraphicObjectTemplating\OObjects\OSContainer
 *
 * addChild(OObject $child, $require = false, $mode = self::MODE_LAST, $params = null)
 *              : méthode visant à ajouter un champs au formulaire en 2 temps
 *              -> ajout de l'objet en tant qu'enfant du formulaire (pareent::addChild)
 *              -> ajout de la référence du champs à la liste des champs du formulaire (attribut fields)
 * (traitement récussif en cas d'ajout d'objet de type OSContainer)
 * addExtField(ODContained $field, $require = false)
 * setExtField(ODContained $field, $require = false)
 * removeExtField(ODContained $field)
 * removeChild(OObject $child)
 *              : méthode de suppression d'un champ au formulaire en 2 temps*
 *              -> suppression de l'objet en tant qu'enfant du formulaire (parent::removeChild)
 *              -> suppression de la référence du cmap à la liste des champs du formulaire (attribut fields)
 * (traitement récussif en cas d'ajout d'objet de type OSContainer)
 * removeChildren()
 *              : méthode de suppression de l'ensemble des champs du formulaire en 2 temps
 *              -> suppression de l'ensemble des enfant du formulaire (parent::removeChildren)
 *              -> initialisation à vide de l'attribut fields;
 * removeField(OObject $field)
 *              : méthode visant à supprimer un champs et l'objet relatif dans le contenant relatif
 * isField(OObject $field)
 *              : valide le fait ou non que l'objet $field est un champ du formulaire
 * isRequire($fieldID)
 *              : permet de savoir si le champ fieldID est obligatoin ou non
 * getFormDatas()
 * setFormDatas(array $datas)
 * addBtn($name, $label, $type, $nature, $ord, $class = null, $method = null, $stopEvent = false)
 * rmBtn($name)
 * rmBtns()
 *
 * mérthodes privées
 * propageFormParams(OObject $child, string $formID, bool $require )
 * removeFormParams(OObject $child)
 * addField($fieldID, $sourceId, $require = false)
 * appendFieldAfter($objID, string $objPrev, OObject $objet)
 * appendFieldBefore($objID, string $objPrev, OObject $objet)
 * delField(OObject $field, OSContainer $source)
 *
 * méthodes de gestion de retour de callback
 * updateFormDatas()
 * razFormDatas()
 * appendField($objID, OObject $objet)
 * isValid(array $formDatas)
 */
class OSForm extends OSDiv
{

    const OSFORMBTN_RESET   = 'reset';
    const OSFORMBTN_SUBMIT  = 'submit';

    protected $const_btn;

    public function __construct($id)
    {
        /** création de l'objet de base OSDiv */
        parent::__construct($id);
        /** ajout des propriétés spécifiques au formulaire */
        $localAttributes = include __DIR__ . '/../../../view/zf3-graphic-object-templating/oobjects/oscontainer/osform/osform.config.php';
        $properties = $this->getProperties();

        $properties['object']    = 'osform';
        $properties['typeObj']   = 'oscontainer';
        $properties['template']  = 'osform.twig';
        $properties['resources'] = $localAttributes['resources'];
        foreach ($localAttributes as $key => $localAttribute) {
            if (!array_key_exists($key, $properties)) {
                $properties[$key] = $localAttribute;
            }
        }
        $templateName = 'zf3-graphic-object-templating/oobjects/' . $properties['typeObj'];
        $templateName .= '/' . $properties['object'] . '/' . $properties['template'];
        $properties['template'] = $templateName;

        $objName = 'GraphicObjectTemplating/OObjects/';
        $objName .= strtoupper(substr($properties['typeObj'], 0, 3));
        $objName .= strtolower(substr($properties['typeObj'], 3)) . '/';
        $objName .= strtoupper(substr($properties['object'], 0, 3));
        $objName .= strtolower(substr($properties['object'], 3));
        $objName = str_replace('/', chr(92), $objName);
        $properties['className'] = $objName;

        $this->setProperties($properties);
        return $this;
    }

    public function addChild(OObject $child, $require = false, $mode = self::MODE_LAST, $params = null)
    {
        $properties = $this->getProperties();
        $children   = $properties['children'];
        if (!array_key_exists($child->getId(), $children)) {
            parent::addChild($child, $mode, $params);
            $this->propageFormParams($child, $this->getId(), $this->getId(), $require);
            return $this;
        }
        return false;
    }

    public function addExtField(ODContained $field, $require = false)
    {
        $properties = $this->getProperties();
        $properties['fields'][$field->getId()] = $require;
        $field->setForm(trim($field->getForm().' '.$this->getId()));
        $field->saveProperties();
        $this->setProperties($properties);
        return $this;
    }

    public function setExtField(ODContained $field, $require = false)
    {
        $properties = $this->getProperties();
        if (array_key_exists($field->getId(), $properties['fields'])) {
            $properties['fields'][$field->getId()] = $require;
            $this->setProperties($properties);
            return $this;
        }
        return false;
    }

    public function removeExtField(ODContained $field)
    {
        $properties = $this->getProperties();
        if (array_key_exists($field->getId(), $properties['fields'])
        && !array_key_exists($field->getId(), $properties['children'])) {
            unset($properties['fields'][$field->getId()]);
            $this->setProperties($properties);
            return $this;
        }
        return false;
    }

    public function removeChild(OObject $child)
    {
        $topExec = parent::removeChild($child);
        if ($topExec) {
            $this->removeFormParams($child);
            return $this;
        }
        return false;
    }

    public function removeChildren()
    {
        $topExec = parent::removeChildren();
        if ($topExec) {
            $properties = $this->getProperties();
            $properties['fields'] = [];
            $this->setProperties($properties);
            return $this;
        }
        return false;
    }

    public function removeField(OObject $field)
    {
        $properties = $this->getProperties();
        $fields     = $properties['fields'];
        if (array_key_exists($field->getId(), $fields)) {
            if ($this->isChild($field->getId())) {
                $this->removeChild($field);
            } else {
                $origine    = $properties['origine'];
                /** @var OSContainer $objSource */
                $objSource  = OObject::buildObject($origine[$field->getId()]);
                $this->delField($field, $objSource);
                return $this;
            }
        }
        return false;
    }

    public function isField($fieldID)
    {
        $properties = $this->getProperties();
        $fields     = $properties['fields'];
        return (array_key_exists($fieldID, $fields));
    }

    public function isRequire($fieldID)
    {
        $properties = $this->getProperties();
        $fields     = $properties['fields'];
        return (array_key_exists($fieldID, $fields) && $fields[$fieldID]);
    }

    public function getFormDatas()
    {
        $properties = $this->getProperties();
        $fields     = $properties['fields'];
        $datas      = [];
        if (!empty($fields)) {
            $sessionObj = OObject::validateSession();
            $objects    = $sessionObj->objetcs;
            foreach ($fields as $field => $require) {
                $properties     = unserialize($objects[$field]);
                switch ($properties['object']) {
                    case 'odcheckbox':
                        $options    = $properties['options'];
                        $checked    = [];
                        foreach ($options as $value => $option) {
                            if ($option['check']) {
                                $checked[] = $value;
                            }
                        }
                        $datas[$field] = $checked;
                        break;
                    default:
                        $datas[$field] = $properties['value'];
                        break;
                }
            }
        }
        return $datas;
    }

    public function setFormDatas(array $datas)
    {
        /** validation du contenu (clés) du tableau en entrée sont dans le formulaire */
        $properties = $this->getProperties();
        $fields     = $properties['fields'];
        $topOk  = true;
        foreach ($datas as $cle => $data) {
            if (!array_key_exists($cle, $fields)) {
                $topOk = false;
                break;
            }
        }

        if ($topOk) { // données valides -> mise à jour des champs objets
            $sessionObj = OObject::validateSession();
            $objects    = $sessionObj->objects;
            foreach ($datas as $cle => $data) {
                $properties = unserialize($objects[$cle]);
                switch ($properties['object']) {
                    case 'odcheckbox':
                        $options    = $properties['options'];
                        foreach ($data as $value => $check) {
                            if (array_key_exists($value, $options)) {
                                $options[$value]['check'] = $check;
                            }
                        }
                    default:
                        $properties['value'] = $data;
                        break;
                }
                $objects[$cle] = serialize($properties);
            }
            $sessionObj->objets = $objects;
        }
    }

    public function addBtn($name, $label, $icon,  $value, $type, $nature, $ord, $class = null, $method = null, $stopEvent = false)
    {
        $name           = (string) $name;
        $type           = (string) $type;
        $types          = $this->getBtnConstants();
        if (!in_array($type, $types)) { $type = self::OSFORMBTN_SUBMIT; }
        $properties     = $this->getProperties();
        $btnControls    = $properties['btnControls'] ?? [];
        if ($type == ODButton::BUTTONTYPE_RESET){ $ord = 4; }

        if (sizeof($btnControls) < 4 && (!array_key_exists('ord', $btnControls) || !array_key_exists($ord, $btnControls['ord']))) {
            if ($type == ODButton::BUTTONTYPE_SUBMIT && (empty($class) || empty($method))) {
                return false;
            }
            $bouton = new ODButton($name.$this->getId());
            $bouton->setLabel($label);
            $bouton->setIcon($icon);
            $bouton->setType($type);
            $bouton->setNature($nature);
            $bouton->setValue($value);
            $bouton->setForm($this->getId());
            if (empty($label) && !empty($icon)) { $bouton->addClass('btnIco'); }
            if ($type == ODButton::BUTTONTYPE_RESET && (empty($class) || empty($method))){
                $bouton->evtClick('javascript:', 'resetFormDatas('.$this->getId().')', true);
            } else {
                $bouton->evtClick($class, $method, $stopEvent);
            }
            $bouton->saveProperties();
            if (!array_key_exists('ord', $btnControls)) { $btnControls['ord'] = []; }
            $btnControls['ord'][$ord]       = $bouton->getId();
            $btnControls[$name] = [];
            $btnControls[$name]['object']   = $bouton->getId();
            $btnControls[$name]['ord']      = $ord;

            switch (sizeof($btnControls['ord'])) {
                case 1:
                    $widthBT[1] = "O1:W10";
                    $widthBT[2] = '';
                    break;
                case 2:
                    $widthBT[1] = "O1:W4";
                    $widthBT[2] = 'O2:W4';
                    break;
                case 3:
                    $widthBT[1] = "O1:W3";
                    $widthBT[2] = 'O1:W3';
                    break;
                case 4:
                    $widthBT[1] = "O1:W2";
                    $widthBT[2] = 'O1:W2';
                    break;
            }
            $sessionObj = OObject::validateSession();
            $objects    = $sessionObj->objects;
            foreach ($btnControls['ord'] as $ord => $btnID) {
                $btnProperties = unserialize($objects[$btnID]);
                $btnProperties['widthBT'] = OObject::formatBootstrap($widthBT[1 + ($ord > 1)]);
                $objects[$btnID]    = serialize($btnProperties);
            }
            $sessionObj->objects    = $objects;
            $properties['btnControls'] = $btnControls;
            $this->setProperties($properties);
            return $this;
        }
        return false;
    }

    public function rmBtn($name)
    {
        $name           = (string) $name;
        $properties     = $this->getProperties();
        $btnControls    = $properties['btnControls'];
        if (array_key_exists($name, $btnControls)) {
            $ord = $btnControls[$name]['ord'];
            unset($btnControls[$name]);
            unset($btnControls['ord'][$ord]);
            OObject::destroyObject($name);
            $properties['btnControls'] = $btnControls;
            $this->setProperties($properties);
            return $this;
        }
        return false;
    }

    public function rmBtns()
    {
        $properties                 = $this->getProperties();
        $btnControls                = $properties['btnControls'];
        $properties['btnControls']  = [];

        /** suppression en session des objets boutons du formulaire */
        $sessionObj                 = OObject::validateSession();
        $objects                    = $sessionObj->objetcs;
        foreach ($btnControls['ord'] as $ord => $btnID) {
            unset($objects[$btnID]);
        }
        $sessionObj->objects        = $objects;

        $this->setProperties($properties);
        return $this;
    }

    /** **************************************************************************************************
     * méthodes privées de la classe                                                                     *
     * *************************************************************************************************** */

    private function propageFormParams(OObject $child, $sourceID, string $formID, bool $require )
    {
        if ($child instanceof OSContainer) {
            $localChildren = $child->getChildren();
            /** @var OObject $localChild */
            foreach ($localChildren as $localChild) {
                $this->propageFormParams($localChild, $child->getId(), $formID, $require);
                $localChild->saveProperties();
            }
        } else { // if ($child instanceof ODContained)
            /** @var ODContained $child */
            $child->setForm($formID);
            $this->addField($child->getId(), $sourceID,  $require);
            $child->saveProperties();
        }
        return $this;
    }

    private function removeFormParams(OObject $child)
    {
        if ($child instanceof OSContainer) {
            $localChildren = $child->getChildren();
            foreach ($localChildren as $localChild) {
                $this->removeFormParams($localChild);
            }
        } else if ($child instanceof ODContained) {
            $properties = $this->getProperties();
            unset($properties['fields'][$child->getId()]);
            $this->setProperties($properties);
        }
        return $this;
    }

    private function addField($fieldID, $sourceId, $require = false)
    {
        $properties = $this->getProperties();
        $properties['fields'][$fieldID] = $require;
        $properties['origine'][$fieldID] = $sourceId;
        $this->setProperties($properties);
        return $this;
    }

    private function delField(OObject $field, OSContainer $source)
    {
        if ($field instanceof ODContained) {
            $source->removeChild($field);
            $properties = $this->getProperties();
            $fields     = $properties['fields'];
            $origine    = $properties['origine'];
            unset($origine[$field->getId()]);
            unset($fields[$field->getId()]);
            $properties['fields'] = $fields;
            $properties['origine'] = $origine;
            $this->setProperties($properties);
        } else if ($field instanceof OSContainer) {
            $localChildren = $field->getChildren();
            foreach ($localChildren as $localChild) {
                $this->delField($localChild, $field);
            }
        }
    }

    private function getBtnConstants()
    {
        $retour = [];
        if (empty($this->const_btn)) {
            $constants = $this->getConstants();
            foreach ($constants as $key => $constant) {
                $pos = strpos($key, 'OSFORMBTN_');
                if ($pos !== false) {
                    $retour[$key] = $constant;
                }
            }
            $this->const_btn = $retour;
        } else {
            $retour = $this->const_btn;
        }
        return $retour;
    }

    /** **************************************************************************************************
     * méthodes de gestion de retour de callback                                                         *
     * *************************************************************************************************** */

    public function updateFormDatas()
    {
        $idSource   = $this->getId();
        $idCible    = $this->getId();
        $mode       = 'setFormDatas';
        $html       = json_encode($this->getFormDatas());
        return OObject::formatRetour($idSource, $idCible, $mode, $html);
    }

    public function razFormDatas()
    {
        $idSource   = $this->getId();
        $idCible    = $this->getId();
        $mode       = 'razFormDatas';
        $html       = null;
        return OObject::formatRetour($idSource, $idCible, $mode, $html);
    }

    public function appendField($objID, OObject $objet)
    {
        $ret = parent::appendField($objet);
        if ($this->isRequire($objID)) { $objet->addClass('require'); }
        $ret[0] = OObject::formatRetour($objID, $this->getId()." .formBody", 'append');

        return $ret;
    }

    public function appendFieldAfter($objID, string $objPrev, OObject $objet)
    {
        if ($this->isRequire($objID)) {
            $objet->addClass('require');
        }
        $ret = parent::appendFieldAfter($objet, $objPrev);
        $ret[0] = OObject::formatRetour($objID, $this->getId()." .formBody #".$objPrev, 'appendAfter');

        return $ret;
    }

    public function appendFieldBefore($objID, string $objPrev, OObject $objet)
    {
        if ($this->isRequire($objID)) {
            $objet->addClass('require');
        }
        $ret = parent::appendFieldBefore($objet, $objPrev);
        $ret[0] = OObject::formatRetour($objID, $this->getId()." .formBody #".$objPrev, 'appendBefore');

        return $ret;
    }

    public function isValid(array $formDatas)
    {
        $properties = $this->getProperties();
        $fields     = $properties['fields'];
        $valid      = true;

        foreach ($formDatas as $key => $formData) {
            if ($fields[$key]) {
                $valid = $valid && (!empty($formData));
                if (!$valid) { break; }
            }
        }

        return $valid;
    }
}