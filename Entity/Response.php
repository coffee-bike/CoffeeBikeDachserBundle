<?php

namespace CoffeeBike\DachserBundle\Entity;

class Response
{
    private $objects = array();
    private $type = "";

    public function addObject($type, $aData)
    {
        /*
         * Bewegung Wareneingang"BEWEI"
         * Bewegung Warenausgang "BEWAU"
         * Bestände "BESTA"
         * Statusänderungen "STATI"
         * Auftragsrückmeldung "RUCKP"
         * Kontierungsdaten "RECHN"
         * Borderos "ABORD"
         * Entladeberichte "AENTL"
         * Statusinformationen "ASTAT"
         */
        switch ($type->type) {
            // FIXME: Add mapping type for delivery response
            case 'BEWAU':
                $object = new DeliveryResponse();
                break;

            case 'BEWEI':
            case 'BESTA':
            case 'STATI':
            case 'RUCKP':
            case 'RECHN':
            case 'ABORD':
            case 'AENTL':
            case 'ASTAT':
            default:
                die('Entity not mapped in DachserBundle!');
        }

        if (isset($object)) {
            $object->setData($aData);
            $this->objects[] = $object;
        }
    }

    public function getObjects()
    {
        return $this->objects;
    }
}
