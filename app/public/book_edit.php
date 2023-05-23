<?php

declare(strict_types=1);

include "_includes/global-functions.php";
include "_includes/database-connection.php";

$Title = "Min sida";

// förbered variabler som används i formuläret
$book_id = 0;
$title = "";
$author = "";
$year_published = "";
$review = "";
$created_at = "";
$user_id = 0;

$row = "";

// hantera POST request
if ($_SERVER['REQUEST_METHOD'] === "POST") {

    print_r2("Metoden post används...");

    // global array $_POST innehåller olika fält som finns i formuläret
    print_r2($_POST);

    $title = isset($_POST['title']) ? $_POST['title'] : 1;

    // kontrollera om det finns ett fält med delete som name attribut
    // finns fältet aktivt - dvs ngn klickat på knappen - radera posten
    $action_delete = isset($_POST['delete']) ? true : false;

    if ($action_delete) {

        // sql syntax för att radera en post i en tabell
        $sql = "DELETE FROM book WHERE title=$title";

        // använd databaskopplingen för att radera posten i tabellen
        $result = $pdo->exec($sql);

        // om posten raderas visa åter sidan book.php
        if ($result) {
            header('Location: book.php?action=delete');
            exit;
        }
    }


    // kontrollera att minst 2 tecken finns i fältet för bird_name
    if (strlen($author) >= 2) {

        // spara till databasen
        $sql = "UPDATE `book` SET `book` = '$book_id' WHERE `book`.`title` = $title";

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

// för att redigera en book används en GET request där id framgår, ex id=2
if ($_SERVER['REQUEST_METHOD'] === "GET") {

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

        // / Step 2: Execute a query to fetch data from the 'book' table
        $sql = "SELECT * FROM book";
        $result = $pdo->query($sql);

        // använd databaskopplingen för att hämta data
        $result = $pdo->prepare($sql);
        $result->execute();
        print_r2($result);
        // om det finns ett resultat från databasanropet sparas det i variabeln $row
        print_r2($row);
        // $title = $row['book'];
    
        // $result = $pdo->query("SELECT * FROM book");
        // Step 3: Display the results on your webpage
        // kontrollera att det finns en post som gav resultat
        if ($result->rowCount() > 0) {
            echo "<table>";
            echo "<tr><th>title</th><th>author</th><th>year published</th><th>review</th><th>created_at</th><th>user_id</th></tr>";

            while ($row = $result->fetch()) {
                echo "<tr>";
                echo "<td>" . $row["title"] . "</td>";
                echo "<td>" . $row["author"] . "</td>";
                echo "<td>" . $row["year_published"] . "</td>";
                echo "<td>" . $row["review"] . "</td>";
                echo "<td>" . $row["created_at"] . "</td>";
                echo "<td>" . $row["user_id"] . "</td>";
                echo "</tr>";
            }
            echo "</table>";
        } else {
            echo "No books found in the database.";
        }

        // Assuming $result is the database query result containing multiple rows
    
        foreach ($result as $row) { {
                echo "<tr>";
                echo "<td>" . $row["title"] . "</td>";
                echo "<td>" . $row["author"] . "</td>";
                echo "<td>" . $row["year_published"] . "</td>";
                echo "<td>" . $row["review"] . "</td>";
                echo "<td>" . $row["created_at"] . "</td>";
                echo "<td>" . $row["user_id"] . "</td>";
                echo "</tr>";
            }
            echo "</table>";
        }
}

?>

    <form action="<?= $_SERVER['PHP_SELF'] ?>" method="post">

        <body>
        </body>
        <hr>
        <input type="submit" value="Uppdatera" class="button3">
        <hr>
        <input type="reset" value="Nollställ" class="button3">

        <hr>
        <input type="submit" value="Radera" name="delete" class="button3">

    </form>
    <?php
    include "_includes/footer.php";
    ?>

</body>

</html>