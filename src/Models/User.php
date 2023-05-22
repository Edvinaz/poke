<?php

namespace App\Models;

class User
{
    private int $id;
    private string $email;
    private string $name;
    private string $surname;
    private string $password;

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getSurname(): string
    {
        return $this->surname;
    }

    public function setSurname(string $surname): void
    {
        $this->surname = $surname;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public static function getUser(?array $values)
    {
        if ($values === null) {
            return null;
        }
        $user = new self();
        $user->setId($values['id']);
        $user->setName($values['name']);
        $user->setSurname($values['surname']);
        $user->setEmail($values['email']);

        return $user;
    }
}
