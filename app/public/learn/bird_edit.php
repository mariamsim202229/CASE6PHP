<?php

declare(strict_types=1);

include "_includes/global-functions.php";
include "_includes/database-connection.php";

$title = "Fågelskådning - redigera namn";

// förbered variabler som används i formuläret
$bird_name = "";

$row = null;

// hantera POST request
if ($_SERVER['REQUEST_METHOD'] === "POST") {

    print_r2("Metoden post används...");

    // global array $_POST innehåller olika fält som finns i formuläret
    print_r2($_POST);

    $bird_name = trim($_POST['bird_name']);
    $id = isset($_POST['id']) ? $_POST['id'] : 0;

    // kontrollera om det finns ett fält med delete som name attribut
    // finns fältet aktivt - dvs ngn klickat på knappen - radera posten
    $action_delete = isset($_POST['delete']) ? true : false;

    if ($action_delete) {

        // sql syntax för att radera en post i en tabell
        $sql = "DELETE FROM bird WHERE id=$id";

        // använd databaskopplingen för att radera posten i tabellen
        $result = $pdo->exec($sql);

        // om posten raderas visa åter sidan bird.php
        if ($result) {
            header('Location: bird.php?action=delete');
            exit;
        }
    }


    // kontrollera att minst 2 tecken finns i fältet för bird_name
    if (strlen($bird_name) >= 2) {

        // spara till databasen
        $sql = "UPDATE `bird` SET `bird_name` = '$bird_name' WHERE `bird`.`id` = $id";

        print_r2($sql);

        // använd databaskopplingen för att spara till tabellen i databasen
        $result = $pdo->exec($sql);

        // om posten uppdaterats visa sidan bird.php
        if ($result) {
            header('Location: bird.php?action=update');
            exit;
        }
    }
}



// för att redigera en fågel används en GET request där id framgår, ex id=2
if ($_SERVER['REQUEST_METHOD'] === "GET") {

    $id = isset($_GET['id']) ? $_GET['id'] : 0;

    // visa eventuella fåglar som finns i tabellen
    $sql = "SELECT * FROM bird WHERE id=$id";

    // använd databaskopplingen för att hämta data
    $result = $pdo->prepare($sql);
    $result->execute();

    // om det finns ett resultat från databasanropet sparas det i variabeln $row
    $row = $result->fetch();

    // kontrollera att det finns en post som gav resultat
    if ($row) {
        print_r2($row);
        $bird_name = $row['bird_name'];
    }
}



?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?></title>
</head>

<body>

    <?php

    include "_includes/header.php";

    ?>

    <h1><?= $title ?></h1>

    <!-- visa formulär om det finns ett fågelnamn som ska redigeras -->

    <?php
    if ($row) {
    ?>

        <form action="<?= $_SERVER['PHP_SELF'] ?>" method="post">

            <p>
                <label for="bird_name">Fågel:</label>
                <input type="text" name="bird_name" id="bird_name" value="<?= $bird_name ?>" required minlength="2" maxlength="25">
                <!-- skicka med fågelns id som finns sparad i databasen - använd ett dolt input fält -->
                <input type="hidden" name="id" value="<?= $row['id'] ?>">
            </p>

            <p>
                <input type="submit" value="Uppdatera">
                <input type="reset" value="Nollställ">
                <input type="submit" value="Radera" name="delete">
            </p>

        </form>

    <?php
    }
    ?>

    <?php

    include "_includes/footer.php";

    ?>

</body>

</html>