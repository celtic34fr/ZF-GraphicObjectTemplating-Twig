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

    public function appendField(OObject $object, $type = 'append', $objParm = null)
    {
        if ($object instanceof OObject) { $object = $object->getId(); }
        $ret    = [];
        switch ($type) {
            case 'append':
                $ret[]  = OObject::formatRetour($object, $this->getId(), 'append');
                $ret[]  = OObject::formatRetour($this->getId(), $this->getId(), 'exec', 'updatePage()');
                $ret[]  = OObject::formatRetour($this->getId(), $this->getId(), 'exec', 'updateForm()');
                break;
            case 'after':
                $form   = $this->getId();
                $ret[]  = OObject::formatRetour($object->getId(), $form."  #".$objParm, 'appendAfter');
                $ret[]  = OObject::formatRetour($form, $form, 'exec', 'updatePage()');
                $ret[]  = OObject::formatRetour($form, $form, 'exec', 'updateForm("'.$this->getId().'"")');
                break;
            case 'before':
                $form   = $this->getId();
                $ret[]  = OObject::formatRetour($object->getId(), $form." #".$objParm, 'appendBefore');
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

    public function appendFieldAfter($objID, string $objPrev)
    {
        $sessionObjects = OObject::validateSession();
        $object         = OObject::buildObject($objID, $sessionObjects);

        return $this->appendField($object, 'after', $objPrev);
    }

    public function appendFieldBefore($objID, string $objPrev)
    {
        $sessionObjects = OObject::validateSession();
        $object         = OObject::buildObject($objID, $sessionObjects);

        return $this->appendField($object, 'before', $objPrev);
    }

}