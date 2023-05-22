<?php

namespace App\Repositories;

use App\Database\DbConnection;
use App\Models\User;
use App\Services\EmailService;

class UserRepository
{
    private DbConnection $connection;

    public function __construct()
    {
        $this->connection = new DbConnection();
    }

    public function getUser(string $username, string $password): ?User
    {
        $query = sprintf('SELECT * FROM users WHERE email="%s" AND password="%s"', $username, md5($password));

        return $this->connection->executeQuery($query) !== null
            ? User::getUser($this->connection->executeQuery($query)[0])
            : null;
    }

    private function userForListQuery(string $loggedInUser, string $search = null): string
    {
        if ($search !== null) {
            $query = 'SELECT * FROM users WHERE 
                        email <> ".$loggedInUser." 
                      AND (email like "%'.$search.'%" OR name like "%'.$search.'%" OR surname like "%'.$search.'%")';
        } else {
            $query = 'SELECT * FROM users WHERE email <> "' . $loggedInUser . '"';
        }

        return $query;
    }

    public function getUsersForList(string $loggedInUser, string $search = null, int $limit = 20, int $offset = 0): array
    {
        $query = $this->userForListQuery($loggedInUser, $search);

        $query = $query . ' LIMIT '.$limit.' OFFSET ' . $offset;

        return $this->connection->executeQuery($query);
    }

    public function getUsersForListCount(string $loggedInUser, string $search = null): int
    {
        $query = $this->userForListQuery($loggedInUser, $search);

        return count($this->connection->executeQuery($query));
    }

    public function getUserByUsername(string $username): User
    {
        $query = sprintf('SELECT * FROM users WHERE email="%s"', $username);

        return User::getUser($this->connection->executeQuery($query)[0]);
    }

    public function getUserById(int $userid): User
    {
        $query = sprintf('SELECT * FROM users WHERE id="%s"', $userid);

        return User::getUser($this->connection->executeQuery($query)[0]);
    }

    public function saveUser(array $values): bool
    {
        $query = sprintf('INSERT INTO users (email, name, surname, password) VALUES ("%s", "%s", "%s", "%s")', $values['email'], $values['name'], $values['surname'], md5($values['password']));

        return $this->connection->executeQuery($query);
    }

    public function updateUser(array $values): bool
    {
        $query = sprintf('UPDATE users SET name="%s", surname="%s", password="%s" WHERE email="%s"', $values['name'], $values['surname'], md5($values['password']), $values['email']);

        return $this->connection->executeQuery($query);
    }

    public function pokeUser(int $pokedUser):bool
    {
        $query = sprintf('UPDATE users SET poke=poke + 1 WHERE id=%d', $pokedUser);
        $one = $this->connection->executeQuery($query);

        $query2 = sprintf('INSERT INTO poke_history (from_user, to_user, date) VALUES (%d, %d, "%s")', $_SESSION['user']['id'], $pokedUser, (new \DateTime('now'))->format('Y-m-d H:i:s'));
        $two = $this->connection->executeQuery($query2);

        $recipient = $this->getUserById($pokedUser);

        EmailService::sendEmail($recipient->getEmail());

        return true;
    }

    public function getUserPokes(): array
    {
        $query = sprintf('
            SELECT ph.date, fu.email, fu.name, fu.surname FROM poke_history ph
            JOIN users fu ON fu.id=ph.from_user
            JOIN users tu ON tu.id=ph.to_user
            WHERE tu.id=%d
        ', $_SESSION['user']['id']);

        return $this->connection->executeQuery($query);
    }

    public function getPokedUsers(): array
    {
        $query = sprintf('
            SELECT ph.date, tu.email, tu.name, tu.surname FROM poke_history ph
            JOIN users fu ON fu.id=ph.from_user
            JOIN users tu ON tu.id=ph.to_user
            WHERE fu.id=%d
            LIMIT 10
        ', $_SESSION['user']['id']);

        return $this->connection->executeQuery($query);
    }

    public function importPoke(array $poke): bool
    {
        $fromUser = $this->getUserByUsername($poke['from']);
        $toUser = $this->getUserByUsername($poke['to']);

        $query = sprintf('INSERT INTO poke_history (from_user, to_user, date) VALUES ("%s", "%s", "%s")', $fromUser->getId(), $toUser->getId(), $poke['date']);

        return $this->connection->executeQuery($query);
    }

}
