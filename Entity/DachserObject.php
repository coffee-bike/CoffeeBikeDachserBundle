<?php

namespace CoffeeBike\DachserBundle\Entity;

/**
 * @author Andreas Penner <andreas.penner@coffee-bike.com>
 */
class DachserObject
{
    /**
     * Formally validates the type data in $data attribute.
     *
     * @return bool Validation success
     */
    protected function validate()
    {
        // TODO: Implement validate() method.
    }

    public function setData($aTemplate)
    {
        $i = 0;
        foreach ($this as $key => $value) {
            $this->$key = $aTemplate[$i];
            $i++;
        }
    }

    public function getData()
    {
        $data = array();

        foreach ($this as $key => $value) {
            $data[$key] = $value;
        }

        return $data;
    }

    public function setField($key, $value)
    {
        $this->$key = $value;
    }

    public function getField($key)
    {
        return $this->$key;
    }
}