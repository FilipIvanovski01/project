<?php

namespace App\Models;

class AttributeCapacity extends Attribute
{
    public function __construct(string $displayValue, string $value)
    {
        parent::__construct($displayValue,$value);
    }

    public function getAttributeType(): string
    {
        return "Capacity";
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