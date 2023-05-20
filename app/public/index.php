<?php

// en variabel i php inleds med dollartecken
$title = "Case-6-PHP";

?>

<!DOCTYPE html>
<html lang="sv">

<head>
    <link rel="stylesheet" type="css" href="style.css">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?php echo $title; ?>
    </title>
</head>

<body>

    <style>
        <?php include 'styles/style.css'; ?>
    </style>
    <h1>
        <?php echo "CASE 6"; ?>
    </h1>

    <a href="book.php">Book Review</a>
    <a href="book_edit.php">Book edit</a>


</body>

</html>