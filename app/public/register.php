<?php
// Session används på sidan
session_start();

require_once "_includes/database-connection.php";

setup_user($pdo);
?>

<?php


if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // hämta användardata från form , använd trim för att ta bort mellanslag
    $form_username = trim($_POST['username']);
    $form_hashed_password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // skicka till databasen
    $sql = "INSERT INTO `user` (`username`, `password`) VALUES (:username, :password)";

    // Validera registreringsinput med bindValue för att skydda mot SQL injektion
    try {
        $result = $pdo->prepare($sql);
        $result->bindValue(':username', $form_username, PDO::PARAM_STR);
        $result->bindValue(':password', $form_hashed_password, PDO::PARAM_STR);
        $result->execute();
        if ($result->rowCount() == 1) {

            // om OK omdirigera till inloggningssidan
            header("location: NewLogin.php?register=success");
        }
    } catch (PDOException $err) {
        echo "There was a problem: " . $err->getMessage();
    }

}

?>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
</head>

<body>


    <?php

    include "_includes/header.php";
    ?>
    <h1>Register</h1>

    <style>
        <?php include 'styles/style.css'; ?>
    </style>

    <hr>

    <!-- skapa formulär för registrering -->
    <form action="" method="post" class="form1">
        <hr>
        <label for="username">Username: </label>
        <input type="text" name="username" id="username">
        <hr>
        <label for="password">Password: </label>
        <input type="password" name="password" id="password">
        <hr>

        <button type="submit" class="button">Register</button>
    </form>