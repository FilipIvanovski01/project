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
            ->select("p.product_id, at.name as attribute_type, a.display_value, a.value")
            ->from("ProductAttribute", "p")
            ->innerJoin('p', 'Attribute', 'a', 'p.attribute_id = a.id')
            ->innerJoin('a', 'AttributeType', 'at', 'a.attribute_type = at.id');
        
        $rows = $queryBuilder->fetchAllAssociative();
        foreach ($rows as $row) {
            $attributes[$row['attribute_type']][] = $row;
        }

        return $attributes;
    }

    public function getAttributeId($attributeType, $value, $displayValue)
    {
        $queryBuilder = $this->connection->createQueryBuilder();
        $queryBuilder 
            ->select("id")
            ->from("Attribute")
            ->where('attribute_type = :attribute_type')
            ->andWhere('value = :value')
            ->andWhere('display_value = :display_value')
            ->setParameters([
                'attribute_type' => $attributeType,
                'value' => $value,
                'display_value' => $displayValue
            ]);
        $result = $queryBuilder->fetchAssociative();
        if ($result) {
            return $result['id'];
        }
        return null;

    }
}
