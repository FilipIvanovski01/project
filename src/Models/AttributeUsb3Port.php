<?php

namespace App\Models;

class AttributeUsb3Port extends Attribute
{
    public function __construct(string $displayValue, string $value)
    {
        parent::__construct($displayValue,$value);
    }
    /**
     * Get the value of displayValue
     */ 
    public function getDisplayValue():string
    {
        return $this->displayValue;
    }

    /**
     * Get the value of value
     */ 
    public function getValue():string
    {
        return $this->value;
    }
}