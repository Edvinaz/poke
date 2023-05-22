<?php

namespace App\Repositories;

use App\Database\DbConnection;
use App\Models\User;

class UserRepository
{
    private DbConnection $connection;
    public function __construct()
    {
        $this->connection = new DbConnection();
    }

    public function getUser(string $username, string $password)
    {
        $query = sprintf('SELECT * FROM users WHERE email="%s" AND password="%s"', $username, md5($password));

        return $this->connection->executeQuery($query) !== null ? User::getUser($this->connection->executeQuery($query)[0]) : null;
    }

    public function getUsersForList(string $loggedInUser, int $limit, int $offset)
    {
        $query = sprintf('SELECT * FROM users WHERE email <> "%s" LIMIT %d OFFSET %d', $loggedInUser, $limit, $offset);

        return $this->connection->executeQuery($query);
    }

    public function getUserByUsername(string $username)
    {
        $query = sprintf('SELECT * FROM users WHERE email="%s"', $username);

        return User::getUser($this->connection->executeQuery($query)[0]);
    }

    public function saveUser(array $values)
    {
        $query = sprintf('INSERT INTO users (email, name, surname, password) VALUES ("%s", "%s", "%s", "%s")', $values['email'], $values['name'], $values['surname'], md5($values['password']));

        return $this->connection->executeQuery($query);
    }

    public function updateUser(array $values)
    {
        $query = sprintf('UPDATE users SET name="%s", surname="%s", password="%s" WHERE email="%s"', $values['name'], $values['surname'], md5($values['password']), $values['email']);

        return $this->connection->executeQuery($query);
    }

    public function pokeUser(int $pokedUSer)
    {
        $query = sprintf('UPDATE users SET poke=poke + 1 WHERE id=%d', $pokedUSer);
        $one = $this->connection->executeQuery($query);

        $query2 = sprintf('INSERT INTO poke_history (from_user, to_user, date) VALUES (%d, %d, "%s")', $_SESSION['user']['id'], $pokedUSer, (new \DateTime('now'))->format('Y-m-d H:i:s'));
        $two = $this->connection->executeQuery($query2);

        return true;
    }

    public function getUserPokes()
    {
        $query = sprintf('
            SELECT ph.date, fu.email, fu.name, fu.surname FROM poke_history ph
            JOIN users fu ON fu.id=ph.from_user
            JOIN users tu ON tu.id=ph.to_user
            WHERE tu.id=%d
        ', $_SESSION['user']['id']);

        return $this->connection->executeQuery($query);
    }

}
