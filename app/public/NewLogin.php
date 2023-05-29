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
    <title>Login</title>
</head>

<body>

    <?php
    include "_includes/header.php";
    ?>

    <!-- koppla till css -->
    <style>
        <?php include 'styles/style.css'; ?>
    </style>

    <h1>Login</h1>

    <!-- Skapa formulär för att logga in -->
    <form action="" method="post">
        <label for="username">Username: </label>
        <br>
        <input type="text" name="username" id="username">
        <hr>
        <label for="password">Password: </label>
        <br>
        <input type="password" name="password" id="password">
        <button type="submit">Login</button>
    </form>
</body>

</html>

<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Få användardata från form
    $form_username = $_POST['username'];
    $form_hashed_password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // Skicka fråga till databasen
    $sql_statement = "SELECT * FROM `user` WHERE `username` = '$form_username'";

    try {
        $result = $pdo->query($sql_statement);

        $user = $result->fetch();
        var_dump($user);

        echo "user: " . $user['username'] . " should log in ";

        if ($user) {

            // Användare hittades, verifiera lösenordet
            if (password_verify($_POST['password'], $user['password'])) {
                // Lösenordet är korrekt, ställ in sessionsvariabler
                $_SESSION['username'] = $user['username'];
                $_SESSION['user_id'] = $user['user_id'];

                // Omdirigera till en skyddad sida eller visa framgångsmeddelande
                header("Location: book_edit.php");
                exit;
                // echo "login successful";
            } else {
                // Felaktigt lösenord
                echo "Invalid password";
            }
        } else {

            // Ingen användare hittades med det angivna användarnamnet
            echo "User not found";
        }
    } catch (PDOException $err) {
        echo "There was a problem: " . $err->getMessage();
    }
}
?>