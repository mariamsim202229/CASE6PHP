<?php
declare(strict_types=1);

session_start();

include "_includes/database-connection.php";
include "_includes/global-functions.php";

// Variables in php start with dollar sign
$title = "BOOK REVIEW";

// preparing variables that will be used in the form

$book_id = "";
$book_title = "";
$author = "";
$year_published = "";
$review = "";
$created_at = "";
// $user_id= "" ;

// make a POST request
if ($_SERVER['REQUEST_METHOD'] === "POST") {

    print_r2("Metoden post används...");

    // global array $_POST innehåller olika fält som finns i formuläret
    print_r2($_POST);

    // $book_id = trim($_POST['BookReview1']); 

    $book_id = $_POST['book_id'];
    $book_title = $_POST['book_title'];
    $author = $_POST['author'];
    $year_published = $_POST['year_published'];
    $review = $_POST['review'];
    $created_at = $_POST['created_at'];
    // $user_id = $_POST ['user_id'];

    // if (isset($book_id,$book_title, $author, $year_published, $review, $created_at, $user_id)) {
//     $trimmed_id = trim($book_id) trim($book_title);

    // ,$author,$year_published,$review,$created_at,$user_id);
    // Rest of your code here
// } else {
    // Handle the case when $bookTitle is null or not set
// }

    // kontrollera att minst 2 tecken finns i fältet för book_name
    if (strlen($book_id) >= 2) {

        // spara till databasen
        $sql = "INSERT INTO BookReview1 (book_id, book_title, author, year_published, review, created_at) VALUES ('$book_id', '$book_title', '$author', '$year_published', '$review', '$created_at')";
        print_r2($sql);

        // använd databaskopplingen för att spara till tabellen i databasen
        $pdo->exec($sql);
    }
}

setup_book($pdo);
// setup_user($pdo);

// visa eventuella fåglar som finns i tabellen
$sql = "SELECT * FROM BookReview1";

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
        <?php echo $title; ?>
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
        <?= $title ?>
    </h1>


    <form action="<?= $_SERVER['PHP_SELF'] ?>" method="post">

        <p>
            <label for="book_id">Book id</label>
            <input type="text" name="book_id" id="book_id">
        </p>

        <hr>
        <p>
            <label for="book_title">Book title</label>
            <input type="text" name="book_title" id="book_title" required minlength="2" maxlength="25">
        </p>
<hr>
        <p>
            <label for="author">Author</label>
            <input type="text" name="author" id="author">
        </p>
<hr>

        <p>
            <label for="year_published"> Year published</label>
            <input type="date" name="year_published" id="year_published">
        </p>

        <hr>
        <p>
            <label for="review">Review</label>
            <input type="text" name="review" id="review">
        </p>
<hr>
        <p>
            <label for="created_at">created at</label>
            <input type="datetime-local" name="created_at" id="created_at">
        </p>
<hr>
        <p>
            <label for="user_id">user id</label>

        </p>
        <hr>
        <p>
            <input type="submit" value="Spara">
            <input type="reset" value="Nollställ">
        </p>

    </form>

    <section>
        <?php

        foreach ($rows as $row) {
            $book_id = $row['book_id'];
            $book_title = $row['book_title'];
            $author = $row['author'];
            $year_published = $row['year_published'];
            $review = $row['review'];
            $created_at = $row['created_at'];
        }


        // Assuming $result is the database query result containing multiple rows
        
        foreach ($result as $row) {
            $bookId = $row['book_id'];
            $bookTitle = $row['book_title'];
            $author = $row['author'];

            echo '<a href="book_edit.php?id=' . $bookId . '">';
            echo $bookTitle;
            echo '</a>';
            echo $author;
            echo '<br>'; // Add line break for better readability
        }
        ?>


        <?php
        //     echo "<div>";
//     echo '<a href="book_edit.php?id='. $row['book_id'] .'">';
//     echo $row['book_title'];
//     echo $row ['author'];
//     echo "</a>";
//     echo "</div>";
// }
        
        ?>

    </section>

    <?php
    include "_includes/footer.php";
    ?>

</body>

</html>