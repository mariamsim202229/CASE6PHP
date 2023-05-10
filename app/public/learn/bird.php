<?php

declare(strict_types=1);

include "_includes/global-functions.php";
include "_includes/database-connection.php";

$title = "Fågelskådning";

// förbered variabler som används i formuläret
$bird_name = "";

// hantera POST request
if ($_SERVER['REQUEST_METHOD'] === "POST") {

    print_r2("Metoden post används...");

    // global array $_POST innehåller olika fält som finns i formuläret
    print_r2($_POST);

    $bird_name = trim($_POST['bird_name']);

    // kontrollera att minst 2 tecken finns i fältet för bird_name
    if (strlen($bird_name) >= 2) {

        // spara till databasen
        $sql = "INSERT INTO bird (bird_name) VALUES ('$bird_name')";

        print_r2($sql);

        // använd databaskopplingen för att spara till tabellen i databasen
        $result = $pdo->exec($sql);
    }
}

// visa eventuella fåglar som finns i tabellen
$sql = "SELECT * FROM bird";

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
    <title><?= $title ?></title>
</head>

<body>

    <?php

    include "_includes/header.php";

    ?>

    <h1><?= $title ?></h1>

    <form action="<?= $_SERVER['PHP_SELF'] ?>" method="post">

        <p>
            <label for="bird_name">Fågel:</label>
            <input type="text" name="bird_name" id="bird_name" required minlength="2" maxlength="25">
        </p>

        <p>
            <input type="submit" value="Spara">
            <input type="reset" value="Nollställ">
        </p>

    </form>


    <section>

        <?php

        foreach ($rows as $row) {
            $id = $row['id'];
            echo "<div>";
            // echo "<a href=\"bird_edit.php?id=$id\">";
            echo '<a href="bird_edit.php?id='. $row['id'] .'">';
            echo $row['bird_name'];
            echo "</a>";
            echo "</div>";
        }

        ?>

    </section>


    <?php

    include "_includes/footer.php";

    ?>

</body>

</html>