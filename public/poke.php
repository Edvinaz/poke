<?php
session_start();
if (!isset($_SESSION['user'])) {
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

<div>
    <p>Gauti poke</p>
    <table id="pokeList">
        <tbody></tbody>
    </table>
</div>

<div>
    <p>Išsiųsti poke</p>
    <table id="pokedList" border="1">
        <tbody></tbody>
    </table>
</div>
<div>
    <p>USER LIST</p>
    <form id="searchForm">
        <label for="search">Paieska</label><input id="search" />
        <button type="submit">ieškoti</button>
    </form>

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
    <div id="userPages"></div>
</div>

</body>
</html>

