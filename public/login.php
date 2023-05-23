<?php

use App\Repositories\Repository;

require_once __DIR__ . '/../vendor/autoload.php';

session_start();

if (isset($_SESSION['user'])) {
    header("Location: poke.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $result = (new Repository())->getUser($username, $password);
//    var_dump($_SESSION['user']);

    if ($result) {
        $_SESSION['user'] = [
            'username' => $username,
            'id' => $result->getId(),
        ];

        header("Location: poke.php");
        exit();
    } else {
        $error = "Invalid username or password";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
</head>
<body>
<h2>Login</h2>
<?php if (isset($error)) { ?>
    <p style="color: red;"><?php echo $error; ?></p>
<?php } ?>
<form method="POST" action="">
    <label for="username">Username:</label>
    <input type="text" name="username" id="username" required><br>

    <label for="password">Password:</label>
    <input type="password" name="password" id="password" required><br>

    <button type="submit">Login</button>
</form>
<p><a href="register.php">Register</a> </p>
</body>
</html>
