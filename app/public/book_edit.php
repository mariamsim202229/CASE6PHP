<?php

declare(strict_types=1);

session_start();

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
$book_id = "";
$title = "";
$author = "";
$year_published = "";
$review = "";
$created_at = date('Y-m-d H:i:s');
$user_id = "";

$row = null;

// hantera POST request
if ($_SERVER['REQUEST_METHOD'] === "POST") {

    print_r2("Metoden post används...");

    // global array $_POST innehåller olika fält som finns i formuläret
    print_r2($_POST);

    // $title = trim($_POST['title']);
    $book_id = isset($_POST['book_id']) ? $_POST['book_id'] : 0;
    $user_id = $_SESSION['user_id'];

    // kontrollera om det finns ett fält med delete som name attribut
    // finns fältet aktivt - dvs ngn klickat på knappen - radera posten
    $action_delete = isset($_POST['delete']) ? true : false;

    if ($action_delete) {

        // sql syntax för att radera en post i en tabell
        $sql = "DELETE FROM book WHERE book_id=$book_id";

        // använd databaskopplingen för att radera posten i tabellen
        $result = $pdo->exec($sql);

        // om posten raderas visa åter sidan book.php
        if ($result) {
            header('Location: book_edit.php?action=delete');
            exit;
        }
    }

    // kontrollera att minst 2 tecken finns i fältet för bird_name
    if (strlen($author) >= 2) {

        // spara till databasen
        $sql = "UPDATE `book` SET `title` = '$title', `author` = '$author', `year_published` = '$year_published', `review` = '$review', `created_at` = '$created_at', user_id = $user_id WHERE book_id = $book_id";



        print_r2($sql);

        // använd databaskopplingen för att spara till tabellen i databasen
        $result = $pdo->exec($sql);

        // om posten uppdaterats visa sidan bird.php
        if ($result) {
            header('Location: book_edit.php?action=update');
            exit;
        }
    }
}


// för att redigera en bookrecension används en GET request där id framgår, ex id=2
if ($_SERVER['REQUEST_METHOD'] === "GET") {

    $book_id = isset($_GET['book_id']) ? $_GET['book_id'] : 0;


    // / Steg 2: Kör en fråga för att hämta data från "bok"-tabellen
    $sql = "SELECT * FROM book";
    //  WHERE book_id=$book_id";
    $result = $pdo->query($sql);

    // använd databaskopplingen för att hämta data
    $result = $pdo->prepare($sql);
    $result->execute();

    $row = $result->fetch();

    // print_r2($result);
    // om det finns ett resultat från databasanropet sparas det i variabeln $row


    // Steg 3: Visa resultaten på din webbsida
// kontrollera att det finns en post som gav resultat
    if ($row) { {
            print_r2($row);
            $book_id = $row['book_id'];
            $title = $row['title'];
            $author = $row['author'];
            $year_published = $row['year_published'];
            $created_at = $row['created_at'];
            $user_id = $row['user_id'];
        }
        echo "<table>";
        echo "<tr><th>book_id</th><th>title</th><th>author</th><th>year published</th><th>review</th><th>created_at</th><th>user_id</th></tr>";

        while ($row = $result->fetch()) {
            echo "<tr>";
            echo "<td>" . $row["book_id"] . "</td>";
            echo "<td>" . $row["title"] . "</td>";
            echo "<td>" . $row["author"] . "</td>";
            echo "<td>" . $row["year_published"] . "</td>";
            echo "<td>" . $row["review"] . "</td>";
            echo "<td>" . $row["created_at"] . "</td>";
            echo "<td>" . $row["user_id"] . "</td>";
            echo "</tr>";
        }
    }
    echo "</table>";
} else {
    echo "No books found in the database.";
}



// Förutsatt att $result är databasfrågeresultatet som innehåller flera rader
// $result är databasfrågans resultat med flera rader

foreach ($result as $row) {
    $book_id = $row['book_id'];
    $title = $row['title'];
    $author = $row['author'];
    $year_published = $row['year_published'];
    $review = $row['review'];
    $created_at = $row['created_at'];
    $user_id = $row['user_id'];

    // echo "<tr>";
    // echo "<td>" . $row["title"] . "</td>";
    // echo "<td>" . $row["author"] . "</td>";
    // echo "<td>" . $row["year_published"] . "</td>";
    // echo "<td>" . $row["review"] . "</td>";
    // echo "<td>" . $row["created_at"] . "</td>";
    // echo "<td>" . $row["user_id"] . "</td>";
    // echo "</tr>";
}
echo "</table>";


echo '<a href="book_edit.php?book_id=' . $book_id . '">';
echo $title;
echo '</a>';
echo $author;
echo '<br>';
echo $year_published;
echo '</a>';
echo $review;
echo '</a>';
echo $created_at;
echo '</a>';
echo $user_id;
echo '</a>';

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
        <?= $Title ?>
    </h1>



    <!-- visa formulär om det finns ett fågelnamn som ska redigeras -->

    <?php
    if ($row) {
        ?>
        <form action="<?= $_SERVER['PHP_SELF'] ?>" method="post">


            <label for="title">title</label>
            <input type="text" name="title" id="title" value="<?= $title ?>" required minlength="2" maxlength="25">
            <hr>
            <label for="author">Author</label>
            <input type="text" name="author" id="author" value="<?= $author ?>" required minlength="2" maxlength="25">
            <hr>
            <label for="year_published">Year</label>
            <input type="string" name="year_published" id="year_published" value="<?= $year_published ?>" required
                minlength="2" maxlength="25">
            <hr>
            <label for="review">Review</label>
            <input type="text" name="review" id="review" value="<?= $review ?>" required minlength="2" maxlength="25">
            <hr>
            <label for="created_at">Created at</label>

            <hr>

            <!-- skicka med book_id och user_id som finns sparad i databasen - använd ett dolt input fält -->
            <input type="hidden" name="book_id" value="<?= $row['book_id'] ?>">
            <input type="hidden" name="user_id" value="<?= $_SESSION['user_id'] ?>">

            <hr>
            <input type="submit" value="Uppdatera" name="update">
            <hr>
            <input type="reset" value="Nollställ">

            <hr>
            <input type="submit" value="Radera" name="delete">

        </form>

    </body>
    <?php
    }
    ?>

<?php
include "_includes/footer.php";
?>

</body>

</html>