<?php

use App\Repositories\UserRepository;

session_start();

require_once __DIR__ . '/../vendor/autoload.php';

$data = $_GET['data'];

if (isset($data) && $data === 'list') {
    $data = (new UserRepository())->getUsersForList($_SESSION['user']['username']);
    $response = array(
        'status' => 'success',
        'message' => 'Data retrieved successfully.',
        'data' => json_encode($data)
    );

    echo json_encode($response);

    exit();
}

if (isset($data) && $data === 'poke_user') {
    $data = (new UserRepository())->pokeUser($_GET['poked_user']);

    $response = array(
        'status' => 'success',
        'message' => 'Data retrieved successfully.',
        'data' => json_encode([])
    );

    echo json_encode($response);

    exit();
}

if (isset($data) && $data === 'pokes') {
    $data = (new UserRepository())->getUserPokes();

    $response = array(
        'status' => 'success',
        'message' => 'Data retrieved successfully.',
        'data' => json_encode($data)
    );

    echo json_encode($response);

    exit();
}
