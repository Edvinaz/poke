<?php

require_once __DIR__ . '/../vendor/autoload.php';

// Check if the user is already logged in
if (!isset($_SESSION['user'])) {
    // Redirect the user to the home page or any other desired location
    header("Location: /");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Pokes</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="/js/scripts.js"></script>
</head>
<body>
<h2>Poke</h2>
<?php if (isset($error)) { ?>
    <p style="color: red;"><?php echo $error; ?></p>
<?php } ?>

<a href="register.php?edit=true">Redaguoti</a>
<a href="logout.php">Atsijungti</a>

<table id="pokeList">
    <tbody></tbody>
</table>

<table id="userList" width="100%" border="1">
    <thead>
    <tr>
        <th>Name</th>
        <th>Surname</th>
        <th>Email</th>
        <th>Pokes</th>
        <th></th>
    </tr>
    </thead>
    <tbody></tbody>
</table>

</body>
</html>

