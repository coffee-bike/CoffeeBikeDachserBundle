<?php

namespace CoffeeBike\DachserBundle\Entity;


class DachserMappingObject extends DachserObject
{
    protected $mapping = [];

    /**
     * Formally validates the type data in $data attribute.
     *
     * @return bool Validation success
     */
    public function __construct()
    {
        $this->initiateKeys();
    }

    protected function validate()
    {
        // TODO: Implement validate() method.
    }

    public function setData($aTemplate)
    {
        foreach ($aTemplate as $key => $value) {
            $this->setField(key, $value);
        }

        return $this;
    }

    public function initiateKeys()
    {
        foreach ($this->mapping as $key => $values) {
            $this->setField($key, null);
        }
        $this->setField($this->type_key, $this->type_identifier);
    }

    public function getData()
    {
        $data = [];

        foreach ($this->mapping as $key => $values) {
            $data[$key] = $this->getField($key);
        }

        return $data;
    }

    public function getField($key)
    {
        $this->checkKey($key);

        return $this->$key;
    }

    public function setField($key, $value)
    {
        $this
            ->checkKey($key)
            ->checkLength($key, $value)
        ;

        $this->$key = $value;

        return $this;
    }

    public function isKeySet($key)
    {
        if (!isset($this->mapping[$key])) {
            return false;
        }

        return true;
    }

    public function hasValue($key)
    {
        if (empty($this->$key)) {
            return false;
        }

        return true;
    }

    public function getShort($key)
    {
        $this->checkKey($key);

        return $this->mapping[$key]['short'];
    }

    public function getDescription($key)
    {
        $this->checkKey($key);

        return $this->mapping[$key]['description'];
    }

    public function getLength($key)
    {
        $this->checkKey($key);

        return $this->mapping[$key]['length'];
    }

    public function getRequired($key)
    {
        $this->checkKey($key);

        return (bool)$this->mapping[$key]['required'];
    }

    public function isRequiredValue($key)
    {
        $this->checkKey($key);

        return $this->getRequired($key);
    }

    public function checkKey($key)
    {
        if (!$this->isKeySet($key)) {
            throw new \Exception("Key '{$key}' not exists");
        }

        return $this;
    }

    public function checkLength($key, $value)
    {
        if (strlen($value) > $this->mapping[$key]['length']) {
            throw new \Exception("Key '{$key}' with value '{$value}' to long (max {$this->mapping[$key]['length']} chars)");
        }

        return $this;
    }

    public function checkAllRequiredValues()
    {
        foreach ($this->mapping as $key => $values) {
            if (
                $this->isRequiredValue($key)
                and !$this->hasValue($key)
            ) {
                throw new \Exception("Key '{$key}' is required but has no value");
            }
        }

        return $this;
    }
}
