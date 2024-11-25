<?php

namespace App\Models;
use App\Models\Attribute;
class Order 
{
    private string $productId;
    private int $quantity;
    private array $choosenAttributes;


    public function __construct(string $productId, int $quantity)
    {
        $this->setProductId($productId);
        $this->setQuantity($quantity);
        $this->choosenAttributes = [];
    }

    /**
     * Get the value of quantity
     */ 
    public function getQuantity():int
    {
        return $this->quantity;
    }

    /**
     * Set the value of quantity
     *
     * @return  self
     */ 
    public function setQuantity(int $quantity):self
    {
        $this->quantity = $quantity;

        return $this;
    }

    /**
     * Get the value of productId
     */ 
    public function getProductId():string
    {
        return $this->productId;
    }

    /**
     * Set the value of productId
     *
     * @return  self
     */ 
    public function setProductId(string $productId):self
    {
        $this->productId = $productId;

        return $this;
    }
    
    /**
     * Add choosen attribute
     * 
     * @return self
     */
    public function addChoosenAttributes(array|Attribute $attribute):self
    {
        
        $this->choosenAttributes[] = $attribute;
        
        return $this;
    }
    public function getChoosenAttributes(): array
    {
        return $this->choosenAttributes;
    }
}