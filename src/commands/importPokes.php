<?php

use App\Repositories\UserRepository;

require_once __DIR__ . '/../../vendor/autoload.php';

$repository = new UserRepository();
$fileName = 'pokes.json';

$jsonData = file_get_contents($fileName);

if ($jsonData !== false) {
    $data = json_decode($jsonData, true);

    if ($data !== null) {
        foreach ($data as $item) {
            $repository->importPoke($item);
        }
    } else {
        echo 'Failed to decode JSON.';
    }
} else {
    echo 'Failed to read the JSON file.';
}