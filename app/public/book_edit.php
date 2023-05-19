<?php

declare(strict_types=1);

include "_includes/global-functions.php";
include "_includes/database-connection.php";

$title = "Min sida";

// förbered variabler som används i formuläret
$book_id= "";
$book_title= "";
$author="";
$year_published="";
$review="";
$created_at="";
// $user_id?"" ;

$row = "";

// hantera POST request
if ($_SERVER['REQUEST_METHOD'] === "POST") {

    print_r2("Metoden post används...");

    // global array $_POST innehåller olika fält som finns i formuläret
    print_r2($_POST);

    $book_id = trim($_POST['BookReview1']);
    $book_title = isset($_POST['book_title']) ? $_POST['book_title'] : 0;

    // kontrollera om det finns ett fält med delete som name attribut
    // finns fältet aktivt - dvs ngn klickat på knappen - radera posten
    $action_delete = isset($_POST['delete']) ? true : false;

    if ($action_delete) {

        // sql syntax för att radera en post i en tabell
        $sql = "DELETE FROM BookReview1 WHERE book_id=$book_id";

        // använd databaskopplingen för att radera posten i tabellen
        $result = $pdo->exec($sql);

        // om posten raderas visa åter sidan bird.php
        if ($result) {
            header('Location: book.php?action=delete');
            exit;
        }
    }


    // kontrollera att minst 2 tecken finns i fältet för bird_name
    if (strlen($book_id) >= 2) {

        // spara till databasen
        $sql = "UPDATE `BookReview1` SET `BookReview1` = '$book_id' WHERE `BookReview1`.`id` = $book_id";

        print_r2($sql);

        // använd databaskopplingen för att spara till tabellen i databasen
        $result = $pdo->exec($sql);

        // om posten uppdaterats visa sidan bird.php
        if ($result) {
            header('Location: book.php?action=update');
            exit;
        }
    }
}

// för att redigera en fågel används en GET request där id framgår, ex id=2
if ($_SERVER['REQUEST_METHOD'] === "GET") {

    $book_id = isset($_GET['book_id']) ? $_GET['book_id'] : 0;

    // visa eventuella fåglar som finns i tabellen
    $sql = "SELECT * FROM BookReview1 WHERE book_id=$book_id";

    // använd databaskopplingen för att hämta data
    $result = $pdo->prepare($sql);
    $result->execute();

    // om det finns ett resultat från databasanropet sparas det i variabeln $row
    $row = $result->fetch();

    // kontrollera att det finns en post som gav resultat
    if ($row) {
        print_r2($row);
        $book_id = $row['BookReview1'];
    }
}



?>
<!DOCTYPE html>
<html lang="en">

<head>
   
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?= $title ?>
    </title>
</head>

<body>

    <?php

    include "_includes/header.php";

    ?>

<style>
<?php include 'styles/style.css'; ?>
</style>

    <h1>
        <?= $title ?>
    </h1>

    <!-- visa formulär om det finns ett fågelnamn som ska redigeras -->

    <?php
    if ($row) {
        ?>

        <form action="<?= $_SERVER['PHP_SELF'] ?>" method="post">

            <p>
                <label for="book_id">Book id</label>
                <input type="text" name="book_id" id="book_id" value="<?= $book_id ?>" required minlength="2" maxlength="25">
                <!-- skicka med fågelns id som finns sparad i databasen - använd ett dolt input fält -->
                <input type="hidden" name="id" value="<?= $row['id'] ?>">
            </p>

            <p>
            <label for="book_title">Book title</label>
            <input type="text" name="book_title" id="book_title" required minlength="2" maxlength="25">
        </p>

        <p>
            <label for="author">Author</label>
            <input type="text" name="author" id="author">
        </p>


        <p>
            <label for="year_published"> Year published</label>
            <input type="date" name="year_published" id="year_published">
        </p>

        <p>
            <label for="review">Review</label>
            <input type="text" name="review" id="review">
        </p>

        <p>
            <label for="created_at">created at</label>
            <input type="datetime-local" name="created_at" id="created_at">
        </p>

        <p>
            <label for="user_id">user id</label>

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