<?php

declare(strict_types=1);
session_start();

include "_includes/header.php";

// Kontrollera om användaren är inloggad
if (!isset($_SESSION['username'])) {
    // Användaren är inte inloggad, omdirigera till inloggningssidan eller visa ett felmeddelande
    header("Location: NewLogin.php");
    exit;
    // Se till att avsluta efter omdirigeringen av rubriken
}

include "_includes/global-functions.php";
include "_includes/database-connection.php";

$Title = "Redigera bokrecensioner";

// förbered variabler som används i formuläret
$title = "";
$author = "";
$year_published = "";
$review = "";
$created_at = date('Y-m-d H:i:s');
$user_id = $_SESSION['user_id'];

$row = null;

// hantera POST request
if ($_SERVER['REQUEST_METHOD'] === "POST" && isset($_POST['update'])) {

    // Kontrollera vilken knapp som användaren tryckte på
    // Användaren tryckte på "UPDATE" - uppdatera bokinformationen
    // Hämta användarinput
    $book_id = isset($_POST['book_id']) ? $_POST['book_id'] : 0;
    $title = trim($_POST['title']);
    $author = trim($_POST['author']);
    $year_published = trim($_POST['year_published']);
    $review = trim($_POST['review']);
    // $created_at = date('Y-m-d H:i:s');
    $user_id = $_SESSION['user_id'];

    // Uppdatera bokinformationen i databasen
    $sql = "UPDATE `book` SET `title` = '$title', `author` = '$author', year_published = $year_published, `review` = '$review', `created_at` = '$created_at' WHERE book_id = $book_id";
    $result = $pdo->prepare($sql);
    $result->execute();

    // Kontrollera om uppdateringen lyckades
    if ($result) {
        header('Location: book_edit.php?action=update');
        exit;
    }
}

if ($_SERVER['REQUEST_METHOD'] === "POST" && isset($_POST['delete'])) {

    // Användaren tryckte på "Radera" - radera boken från databasen
    $book_id = $_POST['book_id'];
    // Radera boken från databasen
    $sql = "DELETE FROM `book` WHERE book_id = $book_id ";

    // använd databaskopplingen för att radera posten i tabellen
    $result = $pdo->exec($sql);

    // Kontrollera om raderingen lyckades
    if ($result) {
        // Omdirigera till en framgångssida eller visa ett framgångsmeddelande
        header('Location: book_edit.php?action=delete');
        exit;
    }
}

// för att redigera en bookrecension används en GET request där id framgår, ex id=2
if ($_SERVER['REQUEST_METHOD'] === "GET") {
    $book_id = isset($_GET['book_id']) ? $_GET['book_id'] : 0;
    $title = isset($_GET['title']) ? $_GET['title'] : '';
    $author = isset($_GET['author']) ? $_GET['author'] : '';
    $year_published = isset($_GET['year_published']) ? $_GET['year_published'] : '';
    $review = isset($_GET['review']) ? $_GET['review'] : '';

    //     // / Steg 2: Kör en fråga för att hämta data från "book"-tabellen
    $sql = "SELECT * FROM `book` WHERE user_id = '{$_SESSION['user_id']}'";

    // använd databaskopplingen för att hämta data
    $result = $pdo->prepare($sql);
    $result->bindParam(':book_id', $book_id, PDO::PARAM_INT);
    $result->execute();

    if ($result) {
        $rows = $result->fetchAll();
        // Hämta alla rader från resultatuppsättningen

        if (!empty($rows)) {
            // Kontrollera om arrayen inte är tom
            echo '<table>';
            echo '<tr><th>title</th><th>author</th><th>year published</th><th>review</th><th>created_at</th></tr>';

            foreach ($rows as $row) {
                echo '<tr>';
                echo '<td><a href="book_edit.php?book_id=' . $row['book_id'] . '">' . $row['title'] . '</a></td>';
                echo '<td>' . $row['author'] . '</td>';
                echo '<td>' . $row['year_published'] . '</td>';
                echo '<td>' . $row['review'] . '</td>';
                echo '<td>' . $row['created_at'] . '</td>';
                echo '</tr>';
            }
            echo '</table>';
        } else {

            echo 'No books found.';
        }
    } else {
        echo 'No books found';
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
        <?= $Title ?>
    </title>
</head>

<body>

    <style>
        <?php include 'styles/style.css'; ?>
    </style>

    <h1>
        <?= $Title ?>
    </h1>

    <?php
    if ($row && isset($_GET['book_id'])) {


        ?>

        <form action="<?= $_SERVER['PHP_SELF'] ?>" method="post">
            <p>
                <hr>
                <label for="title">title</label>
                <hr>
                <input type="text" name="title" id="title" value="<?= isset($title) ? $title : '' ?>" required minlength="2"
                    maxlength="25">
                <hr>
                <label for="author">Author</label>
                <hr>
                <input type="text" name="author" id="author" value="<?= isset($author) ? $author : '' ?>" required
                    minlength="2" maxlength="25">
                <hr>
                <label for="year_published">Year</label>
                <hr>
                <input type="string" name="year_published" id="year_published"
                    value="<?= isset($year_published) ? $year_published : '' ?>" required minlength="2" maxlength="25">
                <hr>
                <label for="review">Review</label>
                <hr>

                <textarea name="review" id="review" required minlength="2" maxlength="25" cols="20"
                    rows="5"><?= isset($review) ? $review : '' ?></textarea>
                <!-- Include the book_id and user_id as hidden input fields -->
                <input type="text" name="book_id" value="<?= $_GET['book_id'] ?>">
                <input type="hidden" name="user_id" value="<?= $_SESSION['user_id'] ?>">
            </p>
            <p>
                <hr>
                <input type="submit" value="Uppdatera" name="update" class="button">
            </p>

        </form>

        <!-- Delete knappen utanför formuläret-->
        <form action="<?= $_SERVER['PHP_SELF'] ?>" method="post">
            <input type="hidden" name="book_id" value="<?= $_GET['book_id'] ?>">
            <input type="submit" value="Ta bort" name="delete" class="button1">
        </form>

        <?php

    }
    ?>

    <?php
    include "_includes/footer.php";
    ?>

</body>

</html>