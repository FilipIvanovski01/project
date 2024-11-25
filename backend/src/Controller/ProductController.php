<?php

namespace App\Controller;

use App\Config\Database;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Photo;
use App\Models\Price;
use App\Controller\PhotoController;
use App\Controller\AttributeController;

class ProductController
{
    private $connection;

    public function __construct() {
        $database = new Database();
        $this->connection = $database->getConnection();
    }

    public function getAll()
    {
        $photos = (new PhotoController())->getAll();
        $attributes = (new AttributeController())->getAll();

        $queryBuilder = $this->connection->createQueryBuilder();
        $queryBuilder 
            ->select("p.id, p.product_name, in_stock, description, cc.category as category_name, b.brand as brand_name, pr.amount, cr.currency_label, cr.currency_symbol")
            ->from("Products", 'p')
            ->innerJoin("p", "Categories", "cc", "p.category_id = cc.id")
            ->innerJoin("p", "Brands", "b", "p.brand_id = b.id")
            ->innerJoin("p", "ProductPrice", "pr", "p.id = pr.product_id")
            ->innerJoin("pr", "Currency", "cr", "pr.currency_id = cr.id");
        
        $products = [];

        foreach ($queryBuilder->fetchAllAssociative() as $row) {
            $productType = "App\\Models\\Product" . ucfirst(strtolower($row['category_name']));
            $productPhotos = [];
            $productAttributes = [];

            foreach ($attributes as $attributeType => $array) {
                $attributeTypeClass = "App\\Models\\Attribute" . str_replace(" ","",ucfirst(strtolower($attributeType)));
                foreach ($array as $attribute) {
                    if ($row['id'] === $attribute['product_id']) {
                        $productAttributes[$attributeTypeClass][] = new $attributeTypeClass($attribute['display_value'], $attribute['value']);
                    }
                }
            }

            foreach ($photos as $photo) {
                if ($photo['product_id'] === $row['id']) {
                    $productPhotos[] = new Photo($photo['image_url']);
                }
            }

            $product = new $productType(
                id: $row['id'],
                name: $row['product_name'],
                inStock: $row["in_stock"],
                description: $row['description'],
                category: new Category($row['category_name']),
                brand: new Brand($row['brand_name']),
                price: new Price($row['amount'], $row['currency_label'], $row['currency_symbol'])
            );

            $product->setPhotos($productPhotos);
            $product->setAttributes($productAttributes);

            $products[] = $product;
        }

        return $products;
    }
    public function getById($id){
        $photos = (new PhotoController())->getAll();
        $attributes = (new AttributeController())->getAll();

        $queryBuilder = $this->connection->createQueryBuilder();
        $queryBuilder
            ->select("p.id, p.product_name, in_stock, description, cc.category as category_name, b.brand as brand_name, pr.amount, cr.currency_label, cr.currency_symbol")
            ->from("Products", 'p')
            ->innerJoin("p", "Categories", "cc", "p.category_id = cc.id")
            ->innerJoin("p", "Brands", "b", "p.brand_id = b.id")
            ->innerJoin("p", "ProductPrice", "pr", "p.id = pr.product_id")
            ->innerJoin("pr", "Currency", "cr", "pr.currency_id = cr.id")
            ->where("p.id = :id")
            ->setParameter('id', $id);

        $row = $queryBuilder->fetchAssociative();

        if (!$row) {
            return null; 
        }

        $productType = "App\\Models\\Product" . ucfirst(strtolower($row['category_name']));
        $productPhotos = [];
        $productAttributes = [];

        foreach ($attributes as $attributeType => $array) {
            $attributeTypeClass = "App\\Models\\Attribute" . str_replace(" ","",ucfirst(strtolower($attributeType)));
            foreach ($array as $attribute) {
                if ($row['id'] === $attribute['product_id']) {
                    $productAttributes[$attributeTypeClass][] = new $attributeTypeClass($attribute['display_value'], $attribute['value']);
                }
            }
        }

        foreach ($photos as $photo) {
            if ($photo['product_id'] === $row['id']) {
                $productPhotos[] = new Photo($photo['image_url']);
            }
        }

        $product = new $productType(
            id: $row['id'],
            name: $row['product_name'],
            inStock: $row["in_stock"],
            description: $row['description'],
            category: new Category($row['category_name']),
            brand: new Brand($row['brand_name']),
            price: new Price($row['amount'], $row['currency_label'], $row['currency_symbol'])
        );

        $product->setPhotos($productPhotos);
        $product->setAttributes($productAttributes);

        return $product;
        }

    
}
