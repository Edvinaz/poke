<?php

use App\Database\DbConnection;

require_once __DIR__ . '/../../vendor/autoload.php';

$db = new DbConnection();

$query = "
            CREATE TABLE IF NOT EXISTS users (
                id INT(11) AUTO_INCREMENT PRIMARY KEY,
                email VARCHAR(255) NOT NULL,
                name VARCHAR(255) NOT NULL,
                surname VARCHAR(255) NOT NULL,
                password VARCHAR(255) NOT NULL,
                poke INT(11),
                UNIQUE INDEX unique_email (email)
            )
            ENGINE=InnoDB DEFAULT CHARSET=utf8;
        ";

$db->executeQuery($query);

$query = "
            CREATE TABLE IF NOT EXISTS poke_history (
                id INT(11) AUTO_INCREMENT PRIMARY KEY,
                from_user INT(11) NOT NULL,
                to_user INT(11) NOT NULL,
                date DATETIME NOT NULL,
                FOREIGN KEY (from_user) REFERENCES users(id),
                FOREIGN KEY (to_user) REFERENCES users(id)
            )
            ENGINE=InnoDB DEFAULT CHARSET=utf8;
        ";

$db->executeQuery($query);
