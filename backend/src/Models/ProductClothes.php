<?php

namespace App\Models;

use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use App\Models\Price;
use App\Models\AttributeColor;
use App\Models\AttributeSize;


class ProductClothes extends Product
{
    private const ALLOWED_ATTRIBUTES = [AttributeColor::class, AttributeSize::class];

    public function __construct(string $id, string $name, bool $inStock, string $description, Category $category, Brand $brand, Price $price)
    {
        parent::__construct($id,  $name,  $inStock,  $description, $category,  $brand,  $price);

    }
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