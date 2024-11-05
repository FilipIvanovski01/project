<?php

namespace App\Controller;

use App\Config\Database;
use App\Models\Category;
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
        $queryBuilder = $this->connection->createQueryBuilder();
        $queryBuilder 
            ->select("*, cc.id as cat_id, cc.name as cat_name")
            ->from("Products",'p')
            ->innerJoin("p","ProductPrice","pp","pp.product_id = p.id")
            ->innerJoin("p", "Categories", "cc", "cc.id = p.category_id");
        foreach($queryBuilder->fetchAllAssociative() as $row)
        {
            $category =  new Category($row['cat_id'], $row['cat_name']);

        };
    }
}