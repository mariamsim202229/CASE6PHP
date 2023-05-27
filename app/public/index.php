<?php

// en variabel i php inleds med dollartecken
$Title = "Case-6-PHP";

?>

<!DOCTYPE html>
<html lang="sv">

<head>
    <link rel="stylesheet" type="css" href="style.css">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?php echo $Title; ?>
    </title>
</head>

<body class="indexbody">

    <style>
        <?php include 'styles/style.css'; ?>
    </style>
    <h1>
        <?php echo "CASE 6"; ?>

    </h1>
<h2>Välkommen till en bokrecension applikation</h2>

    <header>
        <nav>

            <menu class="indexmenu">
                <a href="register.php">Registera</a>
                <hr>
                <a href="book.php">Bokrecension</a>
                <hr>
                <a href="book_edit.php">Min sida</a>
                <hr>
                <a href="NewLogin.php">Logga in</a>

            </menu>

        </nav>
    </header>

    <?php
    include "_includes/footer.php";
    ?>

</body>

</html>