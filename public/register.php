<?php
session_start();

require_once __DIR__ . '/../vendor/autoload.php';

// Check if the user is already logged in
if (isset($_SESSION['user'])) {
    // Redirect the user to the home page or any other desired location
    header("Location: index.php");
    exit();
}

// Check if the registration form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve the submitted data
    $name = $_POST['name'];
    $surname = $_POST['surname'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $password_r = $_POST['password_r'];

    // Validate the input fields
    $errors = [];

    // Check if name is empty
    if (empty($name)) {
        $errors[] = "Name is required";
    }

    // Check if surname is empty
    if (empty($surname)) {
        $errors[] = "Surname is required";
    }

    // Check if email is empty and valid format
    if (empty($email)) {
        $errors[] = "Email is required";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email format";
    }

    // Check if password is empty and meets requirements
    if (empty($password)) {
        $errors[] = "Password is required";
    } elseif (!preg_match("/^(?=.*\d)(?=.*[A-Z]).{8,}$/", $password)) {
        $errors[] = "Password must contain at least one number and one uppercase letter";
    }

    if ($password !== $password_r) {
        $errors[] = "Passwords did not match";
    }

    // If there are no errors, perform further actions (e.g., save user to database)
    if (empty($errors)) {
        // Perform your registration logic here (e.g., save user to database)

        // Set a success message
        $_SESSION['success'] = "Registration successful!";

        // Redirect the user to the login page or any other desired location
        header("Location: login.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
</head>
<body>
<h2>Register</h2>
<?php if (isset($errors) && !empty($errors)) { ?>
    <ul style="color: red;">
        <?php foreach ($errors as $error) { ?>
            <li><?php echo $error; ?></li>
        <?php } ?>
    </ul>
<?php } ?>
<form method="POST" action="">
    <label for="name">Name:</label>
    <input type="text" name="name" id="name" required><br>

    <label for="surname">Surname:</label>
    <input type="text" name="surname" id="surname" required><br>

    <label for="email">Email:</label>
    <input type="email" name="email" id="email" required><br>

    <label for="password">Password:</label>
    <input type="password" name="password" id="password" required><br>

    <label for="password">Repeat password:</label>
    <input type="password" name="password_r" id="password_r" required><br>

    <button type="submit">Register</button>
</form>
</body>
</html>
