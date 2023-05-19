<?php

use App\Database\DbConnection;

session_start();

require_once __DIR__ . '/../vendor/autoload.php';

$disabled = false;
$name_edit = '';
$surname_edit = '';
$email_edit = '';

// Check if the user is already logged in
if (isset($_SESSION['user']) && !isset($_GET['edit'])) {
    // Redirect the user to the home page or any other desired location
    header("Location: index.php");
    exit();
} elseif(isset($_SESSION['user']) && isset($_GET['edit'])) {
    $disabled = true;
    $user = (new \App\Repositories\UserRepository())->getUserByUsername($_SESSION['user']['username']);

    $name_edit = $user->getName();
    $surname_edit = $user->getSurname();
    $email_edit = $user->getEmail();
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
    if (empty($email) && !$disabled) {
        $errors[] = "Email is required";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL) && !$disabled) {
        $errors[] = "Invalid email format";
    }

    // Check if password is empty and meets requirements
    if (empty($password)) {
        $errors[] = "Password is required";
    } elseif (!preg_match("/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/", $password)) {
        $errors[] = "Password must contain at least one number and one uppercase letter";
    }

    if ($password !== $password_r) {
        $errors[] = "Passwords did not match";
    }

    // If there are no errors, perform further actions (e.g., save user to database) sSs8sS
    if (empty($errors) && !$disabled) {
        // Perform your registration logic here (e.g., save user to database)
        (new \App\Repositories\UserRepository())->saveUser([
            'email' => $email,
            'name' => $name,
            'surname' => $surname,
            'password' => $password,
        ]);
        // Set a success message
        $_SESSION['success'] = "Registration successful!";

        // Redirect the user to the login page or any other desired location
        header("Location: /");
        exit();
    } else {
        (new \App\Repositories\UserRepository())->updateUser([
            'email' => $email,
            'name' => $name,
            'surname' => $surname,
            'password' => $password,
        ]);
        // Set a success message
        $_SESSION['success'] = "Registration successful!";

        header("Location: poke.php");
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
    <input type="text" name="name" id="name" required value="<?=$name_edit;?>"><br>

    <label for="surname">Surname:</label>
    <input type="text" name="surname" id="surname" required value="<?=$surname_edit;?>"><br>

    <label for="email">Email:</label>
    <input type="email" name="email" id="email" required value="<?=$email_edit;?>"><br>

    <label for="password">Password:</label>
    <input type="password" name="password" id="password" required><br>

    <label for="password">Repeat password:</label>
    <input type="password" name="password_r" id="password_r" required><br>

    <button type="submit">Register</button>
</form>
</body>
</html>
