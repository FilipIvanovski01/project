<?php

namespace App\Models;

use App\Models\Category;
use App\Models\Brand;
use App\Models\Price;
use App\exceptions\NotInstanceOfPhotoException;
use App\exceptions\InvalidAttributeException;

abstract class Product
{
    protected string $id;
    protected string $name;
    protected bool $inStock;
    protected string $description;
    protected array $photos = [];
    protected array $attributes = [];
    protected Category $category;
    protected Brand $brand;   
    protected Price $price;

    public function __construct(string $id, string $name, bool $inStock, string $description,
    Category $category, Brand $brand, Price $price)
    {
        $this->setId($id);
        $this->setName($name);
        $this->setInStock($inStock);
        $this->setDescription($description);
        $this->setCategory($category);
        $this->setBrand($brand);
        $this->setPrice($price);
    }
    /**
     * Return the value of CONST ALLOWED_ATTRIBUTE
     */
    abstract public function getAllowedAttributes(): array;
    abstract public function getName(): string;
    abstract public function getInStock(): bool;
    abstract public function getDescription(): string;
    abstract public function getPhotos(): array;
    abstract public function getAttributes(): array;
    abstract public function getCategory(): Category;
    abstract public function getBrand(): Brand;
    abstract public function getPrice(): Price;

    /**
     * Set attributes.
     *
     * @param Attribute|array $attributes
     * @throws InvalidAttributeException
     * @return self
     */
    public function setAttributes(Attribute|array $attributes): self
    {
        foreach ($attributes as $attributeType => $a) {
            foreach($a as $attribute){
                $isAllowed = false;
                foreach ($this->getAllowedAttributes() as $allowedAttribute) {
                    if ($attribute instanceof $allowedAttribute) {
                        $isAllowed = true;
                        break;
                    }
                }
                if ($isAllowed) {
                    $this->attributes[$attributeType][] = $attribute;
                }
        }
    }
        return $this;
    }

    /**
     * Set the value of id
     *
     * @return  self
     */ 
    public function setId(string $id): self
    {
        $this->id = $id;
        return $this;
    }

    /**
     * Get the value of id
     */ 
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * Set the value of name
     *
     * @return  self
     */ 
    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    /**
     * Set the value of inStock
     * 
     * @return  self
     */ 
    public function setInStock(bool $inStock): self
    {
        $this->inStock = $inStock;
        return $this;
    }

    /**
     * Set the value of description
     *
     * @return  self
     */ 
    public function setDescription(string $description): self
    {
        $this->description = $description;
        return $this;
    }

    /**
     * Set the value of category
     *
     * @return  self
     */ 
    public function setCategory(Category $category): self
    {
        $this->category = $category;
        return $this;
    }

    /**
     * Set the value of brand
     *
     * @return  self
     */ 
    public function setBrand(Brand $brand): self
    {
        $this->brand = $brand;
        return $this;
    }

    /**
     * Set the value of price
     *
     * @return  self
     */ 
    public function setPrice(Price $price): self
    {
        $this->price = $price;
        return $this;
    }

    /**
     * Set a photos
     *
     * @param Photo|array $photos
     * @throws NotInstanceOfPhotoException
     */
    public function setPhotos(Photo|array $photos): void
    {
        $photos = is_array($photos) ? $photos : [$photos];
        foreach($photos as $photo) { 
            if ($photo instanceof Photo) {
                $this->photos[] = $photo;
            } else {
                throw new NotInstanceOfPhotoException();
            }
        }
    }
}
