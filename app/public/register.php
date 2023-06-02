<?php
// Session används på sidan
session_start();

require_once "_includes/database-connection.php";

setup_user($pdo);
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

    <?php


    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        // hämta användardata från form
        $form_username = $_POST['username'];
        $form_hashed_password = password_hash($_POST['password'], PASSWORD_DEFAULT);

        // skicka till databasen
        $sql_statement = "INSERT INTO `user` (`username`, `password`) VALUES ('$form_username', '$form_hashed_password')";

        try {
            $result = $pdo->query($sql_statement);
            if ($result->rowCount() == 1) {

                // om OK omdirigera till inloggningssidan
                header("location: NewLogin.php");
            }
        } catch (PDOException $err) {
            echo "There was a problem: " . $err->getMessage();
        }

    }

    ?>