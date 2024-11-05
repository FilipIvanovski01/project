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
        $queryBuilder = $this->connection->createQueryBuilder();
        $queryBuilder 
            ->select("*")
            ->from("Attribute");
        return $queryBuilder->fetchAllAssociative();
    }
}