<?php

require_once __DIR__ . '/../vendor/autoload.php';

session_start();

unset($_SESSION['user']);
if (isset($_SESSION['user'])) {
    echo 'user logged in';
} else {
    require __DIR__ . '/../src/templates/login.php';
}
//$controller = new \App\Controllers\HomeController();
//
//$controller->index();
