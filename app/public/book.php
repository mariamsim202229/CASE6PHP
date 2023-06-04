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
// $Title = "BOOK REVIEW";

// Förbereder variabler som kommer att användas i formuläret
$title = "";
$author = "";
$year_published = "";
$review = "";
$created_at = date('Y-m-d H:i:s');
$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 0;

// gör en POST-förfrågan
if ($_SERVER['REQUEST_METHOD'] === "POST") {
    $book_id = isset($_POST['book_id']) ? $_POST['book_id'] : '';
    $title = isset($_POST['title']) ? trim($_POST['title']) : '';
    $author = isset($_POST['author']) ? trim($_POST['author']) : '';
    $year_published = isset($_POST['year_published']) ? trim($_POST['year_published']) : '';
    $review = isset($_POST['review']) ? trim($_POST['review']) : '';
    $created_at = date('Y-m-d H:i:s'); // Använd aktuell datumtid
    $user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 0;



    // kontrollera att minst 2 tecken finns i fältet för "title" och "author"

    if (strlen($title) < 2 || strlen($author) < 2) {
        // Visa ett felmeddelande eller vidta lämpliga åtgärder
        echo
            "Titel och författare måste ha en minsta längd på 2 tecken.";

        // Du kanske vill omdirigera användaren tillbaka till formuläret eller visa ett felmeddelande
        exit;
    }

    if (isset($_SESSION['username'])) {

        // spara till databasen
        $sql = "INSERT INTO book (title, author, year_published, review, created_at, user_id) VALUES (?, ?, ?, ?, ?, ?)";
        // print_r2($sql);
        // använd databaskopplingen för att spara till tabellen i databasen
        $result = $pdo->prepare($sql);
        $result->execute([$title, $author, $year_published, $review, $created_at, $user_id]);


        // Omdirigera till en MIN SIDA eller visa framgångsmeddelande
        header("Location: book_edit.php");
        exit;
        // echo "Bookreview posted successfully";
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
        Skapa en bokrecension
    </h1>

    <?php

    // Skapa en tabell för att visa/redigera resultatet
    
    if (isset($_SESSION['user_id'])) {
        ?>
        <form action="<?= $_SERVER['PHP_SELF'] ?>" method="post" class="form1">

            <p>
                <hr>
                <label for="title"> <b> BOOK TITLE </b></label>
                <hr>
                <input type="text" name="title" id="title" required minlength="2" maxlength="25">

                <hr>
                <label for="author"> <b> AUTHOR </b></label>
                <hr>
                <input type="text" name="author" id="author" required minlength="2" maxlength="25">
                <hr>
                <label for="year_published"><b> YEAR PUBLISHED </b> </label>
                <hr>
                <input type="string" name="year_published" id="year_published" required minlength="4" maxlength="4">
                <hr>
                <label for="review"><b> REVIEW </b></label>
                <hr>
                <textarea name="review" id="review" cols="30" rows="10" required minlength="2" maxlength="50"></textarea>
                <hr>
                <!-- för att koppla en användare till tabellen används ett dolt fält med användarens id -->
                <input type="hidden" name="book_id" id="book_id">
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