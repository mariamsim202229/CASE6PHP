<?php
declare(strict_types=1);

session_start();

// Kontrollera om användaren är inloggad
if (!isset($_SESSION['username'])) {

    // Användaren är inte inloggad, omdirigera till inloggningssidan eller visa ett felmeddelande
    header("Location: NewLogin.php");
    exit; // Se till att avsluta efter omdirigeringen av rubriken
}

include "_includes/database-connection.php";
include "_includes/global-functions.php";

setup_book($pdo);

// Variabler i php börjar med dollartecken
$Title = "BOOK REVIEW";

// Förbereder variabler som kommer att användas i formuläret
// $book_id = 0;
$title = "";
$author = "";
$year_published = "";
$review = "";
$created_at = date('Y-m-d H:i:s');
$user_id = $_SESSION['user_id'];

// gör en POST-förfrågan
if ($_SERVER['REQUEST_METHOD'] === "POST") {

    // print_r2("Metoden post används...");

    // global array $_POST innehåller olika fält som finns i formuläret
    // print_r2($_POST);

    // $title = trim($_POST['title']);

    $title = $_POST['title'];
    $author = $_POST['author'];
    $year_published = $_POST['year_published'];
    $review = $_POST['review'];
    $created_at = date('Y-m-d H:i:s'); //  Use the current datetime
    $user_id = $_SESSION['user_id'];

    // kontrollera att minst 2 tecken finns i fältet för book_id
    if (isset($_SESSION['username'])) {

        // spara till databasen
        $sql = "INSERT INTO book (title, author, year_published, review, created_at, user_id) VALUES ('$title', '$author', '$year_published', '$review', '$created_at', $user_id)";
        print_r2($sql);

        // använd databaskopplingen för att spara till tabellen i databasen
        $result = $pdo->exec($sql);
    }
}
// visa eventuella böcker som finns i tabellen
$sql = "SELECT book.book_id, book.title, book.author, book.year_published, book.review, book.created_at, user.username FROM book JOIN user ON book.user_id = user.user_id";

// använd databaskopplingen för att hämta data
$result = $pdo->prepare($sql);
$result->execute();
$rows = $result->fetchAll();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?php echo $Title; ?>
    </title>
    <link rel="stylesheet" href="styles/style.css">
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

    <?php

    // Skapa en tabell för att visa/redigera resultatet
    
    if (isset($_SESSION['user_id'])) {
        ?>
        <form action="<?= $_SERVER['PHP_SELF'] ?>" method="post">

            <p>
                <hr>
                <label for="title">Book title</label>
                <hr>
                <input type="text" name="title" id="title" required minlength="2" maxlength="25">

                <hr>
                <label for="author">Author</label>
                <hr>
                <input type="text" name="author" id="author">
                <hr>
                <label for="year_published"> Year published</label>
                <hr>
                <input type="string" name="year_published" id="year_published">
                <hr>
                <label for="review">Review</label>
                <hr>
                <textarea name="review" id="review" cols="30" rows="10"></textarea>
                <hr>
                <!-- för att koppla en användare till tabellen används ett dolt fält med användarens id -->
                <input type="hidden" name="user_id" value="<?= $_SESSION['user_id'] ?>">
            </p>

            <p>
                <input type="submit" value="Spara" class="button">
                <br>
                <input type="reset" value="Nollställ" class="button1">
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