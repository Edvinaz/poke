<?php

require_once __DIR__ . '/../vendor/autoload.php';

session_start();

if (isset($_SESSION['user'])) {
    require __DIR__ . '/poke.php';
} else {
    require __DIR__ . '/../src/templates/login.php';
}
