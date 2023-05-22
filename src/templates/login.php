<?php

use App\Repositories\UserRepository;

require_once __DIR__ . '/../../vendor/autoload.php';

// Check if the user is already logged in
if (isset($_SESSION['user'])) {
    // Redirect the user to the home page or any other desired location
    header("Location: poke.php");
    exit();
}

// Check if the login form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve the submitted credentials
    $username = $_POST['username'];
    $password = $_POST['password'];

    $result = (new UserRepository())->getUser($username, $password);

    // Validate the credentials (replace with your own validation logic)
    if ($result) {
        // Valid credentials, set the user in the session
        $_SESSION['user'] = [
            'username' => $username,
            'id' => $result->getId(),
        ];

        // Redirect the user to the home page or any other desired location
        header("Location: poke.php");
        exit();
    } else {
        // Invalid credentials
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
