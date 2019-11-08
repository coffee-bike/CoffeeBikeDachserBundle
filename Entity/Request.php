<?php


namespace CoffeeBike\DachserBundle\Entity;


class Request
{
    private $data = array();

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function setData($data)
    {
        $this->data = $data;
    }

    public function getData()
    {
        return $this->data;
    }

}
