<?php

if (isset($_SESSION['user'])) {
    header("Location: poke.php");
    exit();
} else {
    header("Location: login.php");
    exit();
}
