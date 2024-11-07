<?php

namespace App\Controller;

use App\Config\Database;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Photo;
use App\Models\Price;
use App\Models\ProductClothe;
use App\Models\ProductTech;

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
        ->select("p.id, p.name as product_name, in_stock, description, cc.name as category_name, b.name as brand_name, pr.amount, cr.currency_label, cr.currency_symbol")
        ->from("Products", 'p')
        ->innerJoin("p", "Categories", "cc", "p.category_id = cc.id")
        ->innerJoin("p", "Brands", "b", "p.brand_id = b.id")
        ->innerJoin("p", "ProductPrice", "pr", "p.id = pr.product_id")
        ->innerJoin("pr", "Currency", "cr", "pr.currency_id = cr.id");
    

    $products = [];
    foreach ($queryBuilder->fetchAllAssociative() as $row) {
        $productType = "App\\Models\\Product" . strtoupper($row['category_name'][0]) . strtolower(substr($row['category_name'],1));
        $productPhotos = [];
        $productAttributes = [];

        foreach($attributes as $attributeType => $array){
            $attributeType = "App\\Models\\Attribute" . strtoupper($attributeType[0]) . strtolower(substr($attributeType,1));
            foreach($array as $attribute){
                if($row['id'] === $attribute['product_id']){
                    $productAttributes[$attributeType][] = new $attributeType($attribute['display_value'], $attribute['value']);
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

}