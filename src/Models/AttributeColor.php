<?php

namespace App\Models;

class AttributeColor extends Attribute
{
    public function __construct(string $displayValue, string $value)
    {
        parent::__construct($displayValue,$value);
    }
    
    public function getAttributeType(): string
    {
        return "color";
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

    /**
     * Set the value of value
     *
     * @return  self
     */ 
 
}