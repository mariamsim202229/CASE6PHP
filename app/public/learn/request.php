<?php
declare(strict_types=1);

include "_includes/global-functions.php";

$title = "GET och POST Request";

// kontrollera post request
print_r2($_POST);

// print_r2($_SERVER['REQUEST_METHOD']);


// deklarera variabler som kan visa ett värde i olika formulärfält
$first_name = "";
$country = "";
$message = "";
$email = "";
$condition = "";
$date = "";

// om en post request har gjorts ändra variablers värden
if ($_SERVER['REQUEST_METHOD'] === "POST") {
    
    // kolla first_name
    $first_name = isset($_POST['first_name']) ? $_POST['first_name'] : "";

    // se till att inga blanksteg finns i strängen
    $first_name = trim($first_name);

    // kolla country
    $country = isset($_POST['country']) ? $_POST['country'] : "";

    // kolla message
    $message = isset($_POST['message']) ? $_POST['message'] : "";

    print_r2("Textarea innan htmlspecialchars... ");
    print_r2($message);

    // eventuella html element kan förhindras med den inbyggda php funktionen htmlspecialchars
    // funktionen ser till att följande tecken kodas om som html entity: &"'<>
    // https://www.php.net/manual/en/function.htmlspecialchars.php
    $message = htmlspecialchars($message);

    print_r2("Textarea efter htmlspecialchars... ");
    print_r2($message);

    // kolla email
    $email = isset($_POST['email']) ? $_POST['email'] : "";

    // kolla condition
    $condition = isset($_POST['condition']) ? $_POST['condition'] : "";

    // kolla date
    $date = isset($_POST['date']) ? $_POST['date'] : "";

}

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

    <!-- inludera sidhuvud -->
    <?php
    include "_includes/header.php";
    ?>

    <!-- visa title i ett h1 element -->
    <h1><?= $title ?></h1>

    <a href="<?= $_SERVER['PHP_SELF'] ?>">Läs in sidan igen</a>

    <!-- ett formulär med olika fält -->
    <form action="<?= $_SERVER['PHP_SELF'] ?>" method="post">

        <p>
          Förnamn:<br>
          <input type="text" name="first_name" id="" value="<?= $first_name ?>">  
        </p>

        <p>
            Land:<br>
            <select name="country" id="">
                <option value="sweden" <?= $country === "sweden" ? "selected" : "" ?>>Sverige</option>
                <option value="norway" <?= $country === "norway" ? "selected" : "" ?>>Norge</option>
                <option value="denmark" <?= $country === "denmark" ? "selected" : "" ?>>Danmark</option>
            </select>
        </p>

        <p>
            Dina tankar om programmering:<br>
            <textarea name="message" id="" cols="30" rows="10"><?= $message ?></textarea>
        </p>

        <p>
            E-post:<br>
            <input type="email" name="email" id="" value="<?= $email ?>">
        </p>
    
        <p>
            <input type="checkbox" name="condition" id="" value="1" <?= $condition === "1" ? "checked" : "" ?>> Jag vill inte bli kontaktad igen... 
        </p>

        <p>
            Ditt datum:
            <input type="date" name="date" id="" value="<?= $date ?>">
        </p>

        <p>
            <input type="submit" value="Skicka">
        </p>

    </form>


    <?php 

    // phpinfo();
    // print_r($_SERVER);

    ?>


    <!-- inludera sidfot -->
    <?php
    include "_includes/footer.php";
    ?>

</body>
</html>