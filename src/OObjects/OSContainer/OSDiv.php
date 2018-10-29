<?php

namespace GraphicObjectTemplating\OObjects\OSContainer;

use GraphicObjectTemplating\OObjects\OObject;
use GraphicObjectTemplating\OObjects\OSContainer;

class OSDiv extends OSContainer
{
    public function __construct($id)
    {
        parent::__construct($id, "oobjects/oscontainer/osdiv/osdiv.config.php");
        if (!$this->getWidthBT() || empty($this->getWidthBT())) {
            $this->setWidthBT(12); // largeur Bootstrap Twitter à 12 par défaut
        }
        $this->saveProperties();
        return $this;
    }

    /** **************************************************************************************************
     * méthodes de gestion de retour de callback                                                         *
     * *************************************************************************************************** */

    public function appendField($objID, $type = 'append', $objParm = null)
    {
        $objID  = (string) $objID;
        $ret    = [];
        switch ($type) {
            case 'append':
                $ret[]  = OObject::formatRetour($objID, $this->getId(), 'append');
                $ret[]  = OObject::formatRetour($this->getId(), $this->getId(), 'exec', 'updatePage()');
                $ret[]  = OObject::formatRetour($this->getId(), $this->getId(), 'exec', 'updateForm()');
                break;
            case 'after':
                $form   = $this->getId();
                $ret[]  = OObject::formatRetour($objID, $form."  #".$objParm, 'appendAfter');
                $ret[]  = OObject::formatRetour($form, $form, 'exec', 'updatePage()');
                $ret[]  = OObject::formatRetour($form, $form, 'exec', 'updateForm("'.$this->getId().'"")');
                break;
            case 'before':
                $form   = $this->getId();
                $ret[]  = OObject::formatRetour($objID, $form." #".$objParm, 'appendBefore');
                $ret[]  = OObject::formatRetour($form, $form, 'exec', 'updatePage()');
                $ret[]  = OObject::formatRetour($form, $form, 'exec', 'updateForm()');
                break;
            default:
                throw new \Exception('type insertion inconnue '.$type);
        }

        return $ret;
    }

    public function deleteField(OObject $object)
    {
        return OObject::formatRetour($object->getId(), $object->getId(), 'delete');
    }

    public function appendFieldAfter($objID, $objPrev)
    {
        return $this->appendField($objID, 'after', $objPrev);
    }

    public function appendFieldBefore($objID, $objPrev)
    {
        return $this->appendField($objID, 'before', $objPrev);
    }

}