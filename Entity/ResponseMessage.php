<?php


namespace CoffeeBike\DachserBundle\Entity;


class ResponseMessage
{
    private $typeIdentifier;
    private $status;
    private $code;
    private $text;
    private $line;


    /**
     * @return mixed
     */
    public function getTypeIdentifier()
    {
        return $this->typeIdentifier;
    }

    /**
     * @param mixed $typeIdentifier
     */
    public function setTypeIdentifier($typeIdentifier)
    {
        $this->typeIdentifier = $typeIdentifier;
    }

    /**
     * @return mixed
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param mixed $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }

    /**
     * @return mixed
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * @param mixed $code
     */
    public function setCode($code)
    {
        $this->code = $code;
    }

    /**
     * @return mixed
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * @param mixed $text
     */
    public function setText($text)
    {
        $this->text = $text;
    }

    /**
     * @return mixed
     */
    public function getLine()
    {
        return $this->line;
    }

    /**
     * @param mixed $line
     */
    public function setLine($line)
    {
        $this->line = $line;
    }
}
