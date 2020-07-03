<?php

namespace CoffeeBike\DachserBundle\Entity;


class DachserMappingObject extends DachserObject
{
    protected $mapping = [];

    /**
     * DachserMappingObject constructor.
     */
    public function __construct()
    {
        $this->initiateKeys();

        if (
            !empty($this->type_key)
            and !empty($this->type_identifier)
        ) {
            $this->setField($this->type_key, $this->type_identifier);
        }
    }

    protected function validate()
    {
        // TODO: Implement validate() method.
    }

    /**
     * Set data for object from key->value array
     *
     * @param $aTemplate
     * @return $this|void
     * @throws \Exception if property not exists
     */
    public function setData($aTemplate)
    {
        foreach ($aTemplate as $key => $value) {
            $this->setField($key, $value);
        }

        return $this;
    }

    /**
     * Set data for object from numeric key->value pairs by sequenced mapping of object
     *
     * @param $aTemplate
     * @return $this
     * @throws \Exception if property or length is not valid
     */
    public function setDataWithoutKey($aTemplate)
    {
        $i = 0;
        foreach ($this->mapping as $key => $value) {
            $this->setField($key, $aTemplate[$i]);
            $i++;
        }

        return $this;
    }


    /**
     * Initate properties for object by mapping
     *
     * @throws \Exception if
     */
    public function initiateKeys()
    {
        foreach ($this->mapping as $key => $values) {
            $this->setField($key, null);
        }
    }

    /**
     * Get object data
     *
     * @return array
     * @throws \Exception if property not exists
     */
    public function getData()
    {
        $data = [];

        foreach ($this->mapping as $key => $values) {
            $data[$key] = $this->getField($key);
        }

        return $data;
    }

    /**
     * Check if property in object exists and then returns value
     *
     * @param $key
     * @return mixed
     * @throws \Exception if property not exists
     */
    public function getField($key)
    {
        $this->checkKey($key);

        return $this->$key;
    }

    /**
     * Set value for property of object if property exists and length is correct
     *
     * @param $key
     * @param $value
     * @return $this|void
     * @throws \Exception if property not exists or length not valid
     */
    public function setField($key, $value)
    {
        $this
            ->checkKey($key)
            ->checkLength($key, $value)
        ;

        $this->$key = $value;

        return $this;
    }

    /**
     * Check if key is set in property
     *
     * @param $key
     * @return bool
     */
    public function isKeySet($key)
    {
        if (!isset($this->mapping[$key])) {
            return false;
        }

        return true;
    }

    /**
     * Check if property has an valid value
     *
     * @param $key
     * @return bool
     */
    public function hasValue($key)
    {
        if (empty($this->$key)) {
            return false;
        }

        return true;
    }

    /**
     * Get short value from mapping
     *
     * @param $key
     * @return mixed
     * @throws \Exception if property not exists
     */
    public function getShort($key)
    {
        $this->checkKey($key);

        return $this->mapping[$key]['short'];
    }

    /**
     * Get description value from mapping
     *
     * @param $key
     * @return mixed
     * @throws \Exception if property not exists
     */
    public function getDescription($key)
    {
        $this->checkKey($key);

        return $this->mapping[$key]['description'];
    }

    /**
     * Get length value from mapping
     *
     * @param $key
     * @return mixed
     * @throws \Exception if property not exists
     */
    public function getLength($key)
    {
        $this->checkKey($key);

        return $this->mapping[$key]['length'];
    }

    /**
     * Get required value from mapping
     *
     * @param $key
     * @return bool
     * @throws \Exception if property not exists
     */
    public function getRequired($key)
    {
        $this->checkKey($key);

        return (bool)$this->mapping[$key]['required'];
    }

    /**
     * Check if property is required
     *
     * @param $key
     * @return bool
     * @throws \Exception if property not exists
     */
    public function isRequiredValue($key)
    {
        $this->checkKey($key);

        return $this->getRequired($key);
    }

    /**
     * Check if property exists
     *
     * @param $key
     * @return $this
     * @throws \Exception if property not exists
     */
    public function checkKey($key)
    {
        if (!$this->isKeySet($key)) {
            throw new \Exception("Key '{$key}' not exists");
        }

        return $this;
    }

    /**
     * Check length of property
     *
     * @param $key
     * @param $value
     * @return $this
     * @throws \Exception if value of property is to long
     */
    public function checkLength($key, $value)
    {
        if (mb_strlen($value) > $this->mapping[$key]['length']) {
            throw new \Exception(sprintf("Key '%s' with value '%s' (%s chars) to long (max %s chars)", $key, $value, mb_strlen($value), $this->mapping[$key]['length']));
        }

        return $this;
    }

    /**
     * Check if setted properties are valid and correct filled
     *
     * @return $this
     * @throws \Exception if key is required but has no value
     */
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

    /**
     * Return type_identifier property value
     *
     * @return string
     */
    public function getTypeIdentifier(): string
    {
        return $this->type_identifier;
    }
}
