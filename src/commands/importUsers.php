<?php

use App\Helpers\PasswordGenerator;
use App\Repositories\Repository;

require_once __DIR__ . '/../../vendor/autoload.php';

$repository = new Repository();

$fileName = 'users.csv';

$file = fopen($fileName, 'r');

if ($file) {
    while (($data = fgetcsv($file)) !== false) {
        if (is_array($data)) {
            $user = [
                'email' => $data[3],
                'name' => $data[1],
                'surname' => $data[2],
                'password' => PasswordGenerator::generatePassword(8),
            ];
            $repository->saveUser($user);

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
