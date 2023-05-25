<?php
declare(strict_types=1);

session_start();

include "_includes/database-connection.php";
include "_includes/global-functions.php";

setup_book($pdo);

// Variables in php start with dollar sign
$Title = "BOOK REVIEW";

// Preparing variables that will be used in the form

$book_id = 0;
$title = "";
$author = "";
$year_published = "";
$review = "";
$created_at = date('Y-m-d H:i:s');
$user_id = 0;



// make a POST request
if ($_SERVER['REQUEST_METHOD'] === "POST") {

    print_r2("Metoden post används...");

    // global array $_POST innehåller olika fält som finns i formuläret
    print_r2($_POST);

    // $title = trim($_POST['title']);

    // $book_id = $_POST['book_id'];
    // $title = $_POST['title'];
    // $author = $_POST['author'];
    // $year_published = $_POST['year_published'];
    // $review = $_POST['review'];
    // $created_at = date('Y-m-d H:i:s'); // Use the current datetime
    // $user_id = 7;

    // kontrollera att minst 2 tecken finns i fältet för book_id
    if (strlen($title) >= 2) {

        // spara till databasen
        $sql = "INSERT INTO book (title, author, year_published, review, created_at, user_id) VALUES ('$title', '$author', '$year_published', '$review', '$created_at', '$user_id')";
        print_r2($sql);

        // använd databaskopplingen för att spara till tabellen i databasen
        $pdo->exec($sql);
    }
}


// visa eventuella böcker som finns i tabellen
// $sql = "SELECT * FROM book";
$sql = "SELECT book.book_id, book.title, book.author, book.year_published, book.review, book.created_at, user.username FROM book JOIN user ON book.user_id = user.user_id";

// använd databaskopplingen för att hämta data
$result = $pdo->prepare($sql);
$result->execute();
$rows = $result->fetchAll();

?>

<section>

        <?php
        foreach ($rows as $row) {
            $book_id = $row['book_id'];
            $title = $row['title'];
            $author = $row['author'];
            $year_published = $row['year_published'];
            $review = $row['review'];
            $created_at = $row['created_at'];
            // $user_id = $row['user_id'];
            echo "<div>";
            // echo "<a href=\"bird_edit.php?id=$id\">";
            if (isset($_SESSION['user_id'])) {
                echo '<a href="book_edit.php?id=' . $row['title'] . '">';
            }
            // echo $row['title'] . ", " . $row['username'];
        
            if (isset($_SESSION['user_id'])) {
                echo "</a>";
            }
            echo "</div>";
        }

        ?>

    </section>


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

    echo "hey"
    ?>

    <?php

    if (isset($_SESSION['user_id'])) {
        ?>
        <form action="<?= $_SERVER['PHP_SELF'] ?>" method="post">

            <hr>
            <label for="title">Book title</label>
            <input type="text" name="title" id="title" required minlength="2" maxlength="25">

            <hr>

            <label for="author">Author</label>
            <br>
            <input type="text" name="author" id="author">

            <hr>
            <label for="year_published"> Year published</label>
            <input type="string" name="year_published" id="year_published">

            <hr>
            <label for="review">Review</label>
            <hr>
            <textarea name="review" id="review" cols="30" rows="10"></textarea>
        
            <hr>

            <input type="number" name="book_id" value="<?= $row['book_id'] ?>">
                <input type="number" name="user_id" value="<?= $_SESSION['user_id'] ?>">

            <div>
                <input type="submit" value="Spara" class="button">
                <br>
                <input type="reset" value="Nollställ" class="button1">

            </div>
        </form>
        <?php

    }
    ?>


    <?php
    include "_includes/footer.php";
    ?>

</body>

</html>