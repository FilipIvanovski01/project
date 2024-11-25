<?php

namespace App\Models;



abstract class Attribute
{
    protected string $displayValue;
    protected string $value;

    public function __construct(string $displayValue, string $value)
    {
        $this->setDisplayValue($displayValue);
        $this->setValue($value);
    }
    abstract public function getAttributeType(): string;
    abstract public function getDisplayValue():string;
    /**
     * return value
     */
    abstract public function getValue():string;
    /**
     * Set the value of displayValue
     *
     * @return  self
     */ 
    public function setDisplayValue(string $displayValue):self
    {
        $this->displayValue = $displayValue;

        return $this;
    }

    /**
     * Set the value of value
     *
     * @return  self
     */ 
    public function setValue(string $value):self
    {
        $this->value = $value;

        return $this;
    }


   
}