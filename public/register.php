<?php

use App\Repositories\Repository;

session_start();

require_once __DIR__ . '/../vendor/autoload.php';

$disabled = false;
$name_edit = '';
$surname_edit = '';
$email_edit = '';

if (isset($_SESSION['user']) && !isset($_GET['edit'])) {
    header("Location: index.php");
    exit();
} elseif(isset($_SESSION['user']) && isset($_GET['edit'])) {
    $disabled = true;
    $user = (new Repository())->getUserByUsername($_SESSION['user']['username']);

    $name_edit = $user->getName();
    $surname_edit = $user->getSurname();
    $email_edit = $user->getEmail();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve the submitted data
    $name = $_POST['name'];
    $surname = $_POST['surname'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $password_r = $_POST['password_r'];

    $errors = [];

    if (empty($name)) {
        $errors[] = "Name is required";
    }

    if (empty($surname)) {
        $errors[] = "Surname is required";
    }

    if (empty($email) && !$disabled) {
        $errors[] = "Email is required";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL) && !$disabled) {
        $errors[] = "Invalid email format";
    }

    if (empty($password)) {
        $errors[] = "Password is required";
    } elseif (!preg_match("/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/", $password)) {
        $errors[] = "Password must contain at least one number and one uppercase letter";
    }

    if ($password !== $password_r) {
        $errors[] = "Passwords did not match";
    }

    if (empty($errors) && !$disabled) {
        (new Repository())->saveUser([
            'email' => $email,
            'name' => $name,
            'surname' => $surname,
            'password' => $password,
        ]);
        $_SESSION['success'] = "Registration successful!";

        header("Location: /");
        exit();
    } else {
        (new Repository())->updateUser([
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
