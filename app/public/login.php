 <?php
// Starta en session för att lagra användarinformation
    session_start();

include "_includes/database-connection.php";
include "_includes/global-functions.php";

// Variables in php start with dollar sign
$title = "MINSIDA";

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
    //         // Authentication failed
            return 'Invalid username or password';
        }
    }

    // Check if the login form has been submitted
    if (isset($_POST['submit'])) {
        // Get the submitted username and password
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
    ?>




<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>

<body>
    <style>
        <?php include 'styles/style.css'; ?>
    </style>

    <head>
        <title>Login</title>
    </head>

    <body>
        <h1>Login</h1>

        <form method="post" action="">

            <p>
                <label for="user_id">Användar-id</label>
                <input type="text" name="user_id" id="user_id">
            </p>
            <hr>
            <p>

                <label for="username">Username:</label>
                <input type="text" name="username" id="username" required><br><br>
            </p>
            <hr>

            <label for="password">Password:</label>
            <input type="password" name="password" id="password" required><br><br>

            <input type="submit" name="submit" value="Login">
        </form>
    </body>

    </html>

</body>

</html>