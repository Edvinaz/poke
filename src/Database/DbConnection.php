<?php

namespace App\Database;

use PDO;
use PDOException;

class DbConnection
{
    private $host;
    private $dbname;
    private $username;
    private $password;
    private $pdo;

    public function __construct()
    {
        $this->host = 'mysql';
        $this->dbname = 'poke3000';
        $this->username = 'poke';
        $this->password = 'poke3000';
        $this->connect();
    }

    private function connect()
    {
        try {
            $dsn = "mysql:host=$this->host;dbname=$this->dbname";
            $this->pdo = new PDO($dsn, $this->username, $this->password);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Connection failed: " . $e->getMessage());
        }
    }

    public function executeQuery($query, $params = [])
    {
        try {
            $statement = $this->pdo->prepare($query);
            $statement->execute($params);
            return $statement->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            die("Query execution failed: " . $e->getMessage());
        }
    }
}
