<?php

session_start();

// logga ut användare genom att använda session destroy
session_destroy();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logga ut</title>
</head>
<body>

<?php
    include "_includes/header.php";
    ?>
    <style>
        <?php include 'styles/style.css'; ?>
    </style>

    <p class="logout">
    Du är nu utloggad - tillbaka till
<br>
    <a href="NewLogin.php">Login page</a>;
    </p>
</body>
</html>