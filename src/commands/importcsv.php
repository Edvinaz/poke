<?php

use App\Helpers\PasswordGenerator;
use App\Repositories\UserRepository;

require_once __DIR__ . '/../../vendor/autoload.php';

$repository = new UserRepository();

$fileName = 'users.csv';

$file = fopen($fileName, 'r');
$list = [];

if ($file) {
    while (($data = fgetcsv($file)) !== false) {
        if (is_array($data)) {
            $user = [
                'email' => $data[0],
                'name' => $data[1],
                'surname' => $data[2],
                'password' => PasswordGenerator::generatePassword(6),
            ];
            $repository->saveUser($user);
$list[] = $user;
            echo sprintf('Inserted user name: %s, surname: %s, email: %s, password: %s '.PHP_EOL,
                $user['name'],
                $user['surname'],
                $user['email'],
                $user['password'],
            );
        } else {
            echo 'Wrong data provided'.PHP_EOL;
        }
    }
    fclose($file);
} else {
    echo 'not found';
}

var_dump(json_encode($list));
