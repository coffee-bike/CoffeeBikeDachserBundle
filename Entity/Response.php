<?php


namespace CoffeeBike\DachserBundle\Entity;


class Response
{
    private $messages = array();
    private $objects = array();
    private $newObjectIds = array();

    public function addObject($aData)
    {
        switch ($aData[0]) {
            // FIXME: Add mapping type for delivery response
            case 'DeliveryResponse':
                $object = new DeliveryResponse();
                break;
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

    public function addMessage($message)
    {
        $this->messages[] = $message;
    }

    public function getMessages()
    {
        return $this->messages;
    }

    public function addNewObjectId($newObjectId)
    {
        $this->newObjectIds[] = $newObjectId;
    }

    public function getNewObjectIds()
    {
        return $this->newObjectIds;
    }
}
