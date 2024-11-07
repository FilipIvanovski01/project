<?php

namespace App\Controller;

use App\Config\Database;

class PhotoController
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
            ->from("ProductGallery");
        return $queryBuilder->fetchAllAssociative();
    }
}