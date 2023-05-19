<?php

require_once __DIR__ . '/../vendor/autoload.php';


// Check if the user is already logged in
if (!isset($_SESSION['user'])) {
    // Redirect the user to the home page or any other desired location
    header("Location: /");
    exit();
}

$list = (new \App\Repositories\UserRepository())->getUsersForList($_SESSION['user']['username']);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Pokes</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        function testClick(user) {
            var userId = '<?php echo $_SESSION["user"]['username']; ?>';
            console.log(userId);
            console.log('test' + user);
        }
    </script>
</head>
<body>
<h2>Poke</h2>
<?php if (isset($error)) { ?>
    <p style="color: red;"><?php echo $error; ?></p>
<?php } ?>

<a href="register.php?edit=true">Redaguoti</a>

<table width="100%" border="1">
    <tr>
        <th>Name</th>
        <th>Surname</th>
        <th>Email</th>
        <th>Pokes</th>
        <th></th>
    </tr>
    <?php
    foreach ($list as $item) {
    ?>
    <tr>
        <td><?=$item['name'];?></td>
        <td><?=$item['surname'];?></td>
        <td><?=$item['email'];?></td>
        <td><?=$item['poke'];?></td>
        <td><button onclick="testClick(<?=$item['id'];?>)" >Poke</button> </td>
    </tr>
    <?php }?>
</table>

</body>
</html>

