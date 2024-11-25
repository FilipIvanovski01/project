<?php

namespace App\Models;;

use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use App\Models\Price;
use App\Models\AttributeCapacity;
use App\Models\AttributeColor;
use App\Models\AttributeThouchIdInKeyboard;
use App\Models\AttributeUsb3Port;
use App\Exceptions\InvalidAttributeException;

class ProductTech extends Product
{
    /**
     * Allowed attributes for Tech Products
     */
    private const ALLOWED_ATTRIBUTES = [AttributeCapacity::class, AttributeColor::class, AttributeThoucidinkeyboard::class, AttributeUsb3Port::class];

    public function __construct(string $id, string $name, bool $inStock, string $description, Category $category, Brand $brand, Price $price)
    {
        parent::__construct($id,  $name,  $inStock,  $description,  $category,  $brand,  $price);
    }
    /**
     * Get the value of ALLOWED_ATTRIBUTE
     */
    public function getAllowedAttributes(): array
    {
        return self::ALLOWED_ATTRIBUTES;
    }
    /**
     * Get the value of name
     */ 
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Get the value of inStock
     */ 
    public function getInStock(): bool
    {
        return $this->inStock;
    }

    /**
     * Get the value of description
     */ 
    public function getDescription():string
    {
        return $this->description;
    }

    /**
     * Get the value of photo
     */ 
    public function getPhotos(): array
    {
        return $this->photos;
    }



    /**
     * Get the value of category
     */ 
    public function getCategory(): Category
    {
        return $this->category;
    }

    /**
     * Get the value of brand
     */ 
    public function getBrand(): Brand
    {
        return $this->brand;
    }

    /**
     * Get the value of price
     */ 
    public function getPrice(): Price
    {
        return $this->price;
    }

    /**
    * Get the value of attribute
    */ 
    public function getAttributes(): array
    {
        return $this->attributes;
    }

          
}