<?php
declare(strict_types=1);

// Starta en session för att lagra användarinformation
session_start();

include "_includes/database-connection.php";
include "_includes/global-functions.php";

// Variables in php start with dollar sign
$Title = "MINSIDA";

// Preparing variables that will be used in the form

$user_id = "";
$username = "";
$password = "";


// Funktion för att autentisera användare
function login($username, $password)
{


    if ($username === 'mariam' && $password === 'casephp') {

        // Autentiseringen lyckades
        // Lagra användarinformation i sessionen
        $_SESSION['username'] = $username;

        // Redirect to a logged-in page 
        header('Location: book_edit.php');
        exit();
    } else {
        // Authentication failed
        return 'Invalid username or password';
    }
}

// Check if the login form has been submitted
if (isset($_POST['submit'])) {
    // Get the submitted username and password
    // $user_id = $_POST['user_id'];
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Call the login function
    $loginResult = login($username, $password);

    // If login failed, display an error message
    if ($loginResult) {
        echo $loginResult;
    }
}

$password = 'casephp'; //Hash the password
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

// Output the hashed password
// echo $hashedPassword;


// make a POST request
if ($_SERVER['REQUEST_METHOD'] === "POST") {

    print_r2("Metoden post används...");

    // global array $_POST innehåller olika fält som finns i formuläret
    print_r2($_POST);

    $username = trim($_POST['username']);

    // kontrollera att minst 2 tecken finns i fältet för book_id
    if (strlen($username) >= 2) {

        // spara till databasen
        $sql = "INSERT INTO user ( username, password) VALUES ('$username', '$password')";
        print_r2($sql);

        // använd databaskopplingen för att spara till tabellen i databasen
        $pdo->exec($sql);
    }
}


// visa eventuella bocker som finns i tabellen
$sql = "SELECT * FROM user";

// använd databaskopplingen för att hämta data
$result = $pdo->prepare($sql);
$result->execute();
$rows = $result->fetchAll();

?>

<section>
    <?php

    foreach ($rows as $row) {
        $user_id = $row['user_id'];
        $username = $row['username'];
        $password = $row['password'];
    }

    // Assuming $result is the database query result containing multiple rows
    
    // foreach ($result as $row) {
    //     $user_id = $row['user_id'];
    //     $username = $row['username'];
    //     $password = $row['password'];
    //     echo '<a href="book_edit.php?id=' . $user_id . '">';
    //     echo $username;
    //     echo '</a>';
    //     echo $password;
    //     echo '<br>'; // Add line break for better readability
    // }
    // // ?>

</section>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MINSIDA</title>
</head>

<body>
    <?php
    include "_includes/header.php";
    ?>
    <style>
        <?php include 'styles/style.css'; ?>
    </style>

    <h1>
        <?= $Title ?>
    </h1>

    <form action="<?= $_SERVER['PHP_SELF'] ?>" method="post">
        <label for="user_id">User id</label>
        <hr>
        <label for="username">Username</label>
        <br>
        <input type="text" name="username" id="username" required minlength="2" maxlength="25">
        <hr>
        <label for="password">Password</label>
        <br>
        <input type="text" name="password" id="password">

        <div>
            <input type="submit" value="Login" class="button">
        </div>
    </form>


    <?php
    include "_includes/footer.php";
    ?>
</body>

</html>