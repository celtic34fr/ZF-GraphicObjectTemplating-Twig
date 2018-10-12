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
    }

    /** **************************************************************************************************
     * méthodes de gestion de retour de callback                                                         *
     * *************************************************************************************************** */

    public function appendField(OObject $object)
    {
        if ($object instanceof OObject) { $object = $object->getId(); }
        $ret    = [];
        $ret[]  = OObject::formatRetour($object, $this->getId(), 'append');
        $ret[]  = OObject::formatRetour($this->getId(), $this->getId(), 'exec', 'updatePage()');
        $ret[]  = OObject::formatRetour($this->getId(), $this->getId(), 'exec', 'updateForm()');

        return $ret;
    }

    public function deleteField(OObject $object)
    {
        return OObject::formatRetour($object->getId(), $object->getId(), 'delete');
    }

    public function appendFieldAfter($objID, string $objPrev)
    {
        $ret    = [];
        $form   = $this->getId();
        $ret[]  = OObject::formatRetour($objID, $form."  #".$objPrev, 'appendAfter');
        $ret[]  = OObject::formatRetour($form, $form, 'exec', 'updatePage()');
        $ret[]  = OObject::formatRetour($form, $form, 'exec', 'updateForm("'.$this->getId().'"")');

        return $ret;
    }

    public function appendFieldBefore($objID, string $objPrev)
    {
        $ret    = [];
        $form   = $this->getId();
        $ret[]  = OObject::formatRetour($objID, $form." #".$objPrev, 'appendBefore');
        $ret[]  = OObject::formatRetour($form, $form, 'exec', 'updatePage()');
        $ret[]  = OObject::formatRetour($form, $form, 'exec', 'updateForm()');

        return $ret;
    }

}