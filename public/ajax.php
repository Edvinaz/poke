<?php

use App\Repositories\Repository;

session_start();

require_once __DIR__ . '/../vendor/autoload.php';

$repository = new Repository();

$data = $_GET['data'];
$limit = $_GET['limit'] ?? 20;
$offset = $_GET['offset'] ?? 0;
$search = isset($_GET['search']) ? $_GET['search'] : null;

if (isset($data) && $data === 'list') {

    $data = $repository->getUsersForList($_SESSION['user']['username'], $search, $limit, $offset);
    $meta = $repository->getUsersForListCount($_SESSION['user']['username'], $search);

    $response = array(
        'status' => 'success',
        'message' => 'Data retrieved successfully.',
        'data' => json_encode($data),
        'meta' => $meta,
    );

    echo json_encode($response);

    exit();
}

if (isset($data) && $data === 'poke_user') {
    $data = $repository->pokeUser($_GET['poked_user']);

    $response = array(
        'status' => 'success',
        'message' => 'Data retrieved successfully.',
        'data' => json_encode([])
    );

    echo json_encode($response);

    exit();
}

if (isset($data) && $data === 'pokes') {
    $data = $repository->getUserPokes();

    $response = array(
        'status' => 'success',
        'message' => 'Data retrieved successfully.',
        'data' => json_encode($data)
    );

    echo json_encode($response);

    exit();
}

if (isset($data) && $data === 'poked') {
    $data = $repository->getPokedUsers();

    $response = array(
        'status' => 'success',
        'message' => 'Data retrieved successfully.',
        'data' => json_encode($data)
    );

    echo json_encode($response);

    exit();
}
