<?php

namespace App\Models;

class AttributeWithusb3ports extends Attribute
{
    public function __construct(string $displayValue, string $value)
    {
        parent::__construct($displayValue,$value);
    }
    public function getAttributeType(): string
    {
        return "With USB 3 ports";
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