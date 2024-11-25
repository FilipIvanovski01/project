<?php

namespace App\Config;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\DriverManager;
use Doctrine\DBAL\Exception;
use Dotenv\Dotenv;

class Database {
    
    private ?Connection $connect = null; 
    private array $connectionParams; 
    public function __construct()
    {
        $dotenv = Dotenv::createImmutable(__DIR__ . '/..');
        $dotenv->load();
        $this->connectionParams = [
            'dbname' => $_ENV['DB_NAME'],
            'user' => $_ENV['DB_USER'],
            'password' => $_ENV['DB_PASSWORD'],
            'host' => $_ENV['DB_HOST'],
            'driver' => $_ENV['DB_DRIVER'],
        ];
    }

    /**
     * Get connection
     *
     * @return Connection
     */
    public function getConnection(): Connection
    {
        if ($this->connect === null) { 
            try {
                $this->connect = DriverManager::getConnection($this->connectionParams);
            } catch (Exception $e) {
                error_log("Database connection error: " . $e->getMessage());
                die();
            }
        }
        return $this->connect;
    }
}
