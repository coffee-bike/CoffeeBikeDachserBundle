<?php

namespace CoffeeBike\DachserBundle\Entity;

class Response
{
    private $objects = array();
    private $type_key = "";

    public function addObject($type, $aData)
    {
        $this->type_key = $type;
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
        switch ($this->type_key) {
            // FIXME: Add mapping type for delivery response
            case 'RUCKP':
                $object = new DeliveryResponse();
                break;
            case 'BEWAU':
            case 'BEWEI':
            case 'BESTA':
            case 'STATI':
            case 'RECHN':
            case 'ABORD':
            case 'AENTL':
            case 'ASTAT':
            default:
                throw new \Exception('Entity not mapped in DachserBundle!');
        }

        if (isset($object)) {
            $object->setDataWithoutKey($aData);
            $this->objects[] = $object;
        }
    }

    public function getObjects()
    {
        return $this->objects;
    }
}
