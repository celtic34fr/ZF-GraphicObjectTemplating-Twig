<?php

namespace GraphicObjectTemplating\GotObjects;

use GraphicObjectTemplating\OObjects\ODContained\ODSpan;
use GraphicObjectTemplating\OObjects\OObject;
use GraphicObjectTemplating\OObjects\OSContainer\OSDiv;
use Zend\ServiceManager\ServiceManager;

class ObjectGotModel extends OSDiv
{
    /** example of field déclaration */
    /** @var ODSpan $field */
    protected $field;

    /** base for the object constructor */
    public function __construct($first = false)
    {
        if ($first) {
            /** destroy all objects in session */
            OObject::destroyObject('', true);
        }
        parent::__construct('G7U_Dashboard');
    }

    /** method use to initialize all children fields */
    public function init()
    {
        /** by convention, the name of the field is its ID  */
        $this->field    = new ODSpan('field');
    }

    /** declaration of a callback method */
    /**
     * @param ServiceManager $sm    : Zend Framework ServiceManager
     * @param array $params         : call parameters of the method
     *      id      : identifier of the object on which the event was triggered
     *      value   : value associated with the object
     *      form    : array of (ID, value) of the fields of the form to which the object belongs
     */
    public function callback(ServiceManager $sm, array $params)
    {
        /** @var array $ret     : array of all values / actions to be returned to the client */
        $ret    = [];

        /**
         * formatting a values / action instance
         *
         * $idObjOrigin : identifier of the call object
         * $idObjTarget : identifier of the target object to modify
         * $mode        : type of action to execute
         * $code        : HTML, JavaScript or other source code to send
         */
        $ret[]  =  OObject::formatRetour($idObjOrigin, $idObjTarget, $mode, $code);

        /** to send back all action to do ... */
        return $ret;
    }
}