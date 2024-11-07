<?php

namespace App\Controller;

use App\Config\Database;

class AttributeController
{
    private $connection;

    public function __construct() {
        $database = new Database();
        $this->connection = $database->getConnection();
    }

    public function getAll()
    {
        $attributes = [];
        $queryBuilder = $this->connection->createQueryBuilder();
        $queryBuilder 
            ->select("p.product_id, at.name as attribute_type, a.display_value,a.value")
            ->from("ProductAttribute","p")
            ->innerJoin('p','Attribute','a','p.attribute_id = a.id')
            ->innerJoin('a','AttributeType','at','a.attribute_type_id = at.id');
        foreach($queryBuilder->fetchAllAssociative() as $row){
            if(!isset($attributes[$row['attribute_type']])){
                $attributes[$row['attribute_type']] = [];
                $attributes[$row['attribute_type']][] = $row;
            }else{
                $attributes[$row['attribute_type']][] = $row;
            }
        }

        return $attributes;
    }
}