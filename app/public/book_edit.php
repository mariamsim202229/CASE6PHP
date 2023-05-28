<?php

declare(strict_types=1);
session_start();

include "_includes/header.php";

// Kontrollera om användaren är inloggad
if (!isset($_SESSION['username'])) {
    // Användaren är inte inloggad, omdirigera till inloggningssidan eller visa ett felmeddelande
    header("Location: NewLogin.php");
    exit; // Make sure to exit after the header redirect
}

include "_includes/global-functions.php";
include "_includes/database-connection.php";

$Title = "Min sida-redigera bokrecensioner";

// förbered variabler som används i formuläret
$title = "";
$author = "";
$year_published = "";
$review = "";
$created_at = date('Y-m-d H:i:s');
$user_id = $_SESSION['user_id'];

$row = null;

// visa eventuella böcker som finns i tabellen
$sql = "SELECT book.book_id, book.title, book.author, book.year_published, book.review, book.created_at, user.username FROM book JOIN user ON book.user_id = user.user_id";

// använd databaskopplingen för att hämta data
$result = $pdo->prepare($sql);
$result->execute();
$rows = $result->fetchAll();

foreach ($rows as $row) {
    echo '<table>';
    echo '<tr><th>book_id</th><th>title</th><th>author</th><th>year published</th><th>review</th><th>created_at</th></tr>';
    echo '<tr>';
    echo '<td><a href="book_edit.php?user_id=' . $_SESSION['user_id'] . '">' . $row['book_id'] . '</a></td>';
    echo '<td>' . $row['title'] . '</td>';
    echo '<td>' . $row['author'] . '</td>';
    echo '<td>' . $row['year_published'] . '</td>';
    echo '<td>' . $row['review'] . '</td>';
    echo '<td>' . $row['created_at'] . '</td>';
    echo '<td>' . $_SESSION['user_id'] . '</td>';
    echo '</tr>';
    echo '</table>';
}

// hantera POST request
if ($_SERVER['REQUEST_METHOD'] === "POST") {

    // Kontrollera vilken knapp som användaren tryckte på
    if (isset($_POST['update'])) {
        // Användaren tryckte på "UPDATE" - uppdatera bokinformationen

        // Hämta användarinput
        $title = ($_POST['title']);
        $author = ($_POST['author']);
        $year_published = ($_POST['year_published']);
        $review = ($_POST['review']);

        // Uppdatera bokinformationen i databasen
        $sql = "UPDATE `book` SET `title` = '$title', `author` = '$author', year_published = $year_published, `review` = '$review', `created_at` = '$created_at' WHERE user_id = $_SESSION[user_id]";


        $result = $pdo->prepare($sql);
        $result->execute();

        // Kontrollera om uppdateringen lyckades
        if ($result) {
            header('Location: book_edit.php?action=update');
            exit;
        }
    }
}

if ($_SERVER['REQUEST_METHOD'] === "POST" && isset($_POST['delete'])) {
    // Användaren tryckte på "Radera" - radera boken från databasen

    $book_id = $_POST['book_id'];

    $user_id = $_SESSION['user_id'];

    // Radera boken från databasen
    $sql = "DELETE FROM `book` WHERE user_id = $_SESSION[user_id]";

    // Prepare the SQL statement
    $result = $pdo->prepare($sql);

    // Execute the delete statement
    $result->execute();

    // Check if the deletion was successful
    if ($result) {
        // Redirect to a success page or display a success message
        header('Location: book_edit.php?action=delete');
        exit;
    } else {
        // Display an error message or handle the error appropriately
        echo "Failed to delete the book.";
    }
}


// för att redigera en bookrecension används en GET request där id framgår, ex id=2
if ($_SERVER['REQUEST_METHOD'] === "GET") {


    // / Steg 2: Kör en fråga för att hämta data från "book"-tabellen
    $sql = "SELECT * FROM `book` WHERE user_id = $_SESSION[user_id]";
    // $book_id =  $row['book_id'];

    // använd databaskopplingen för att hämta data
    $result = $pdo->prepare($sql);
    $result->execute();

    $row = $result->fetch();

}

?>

<?php
if ($row) {
    ?>

    <form action="<?= $_SERVER['PHP_SELF'] ?>" method="post">
    <hr>
        <label for="title">title</label>
        <hr>
        <input type="text" name="title" id="title" value="<?= $row['title'] ?>" required minlength="2" maxlength="25">
        <hr>
        <label for="author">Author</label>
        <hr>
        <input type="text" name="author" id="author" value="<?= $row['author'] ?>" required minlength="2" maxlength="25">
        <hr>
        <label for="year_published">Year</label>
        <hr>
        <input type="string" name="year_published" id="year_published" value="<?= $row['year_published'] ?>" required
            minlength="2" maxlength="25">
        <hr>
        <label for="review">Review</label>
        <hr>
        <input type="text" name="review" id="review" value="<?= $row['review'] ?>" required minlength="2" maxlength="25">
        <hr>
        <label for="created_at">Created at</label>
        <hr>
        <!-- Include the book_id and user_id as hidden input fields -->
        <input type="text" name="book_id" value="<?= $row['book_id'] ?>">
        <input type="hidden" name="user_id" value="<?= $_SESSION['user_id'] ?>">
        <hr>
        <input type="submit" value="update" name="update">
        <hr>
        <input type="submit" value="Radera" name="delete">
    </form>

    <?php
}

?>

<?php

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

    <!-- <h1>
        <?= $Title ?>
    </h1> -->


    <?php
    include "_includes/footer.php";
    ?>

</body>

</html>