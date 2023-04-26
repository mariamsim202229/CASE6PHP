<?php
// strict_types i php kan användas för att skapa bättre kodkvalité validering av datatyper
declare(strict_types=1);

$title = "Funktioner";

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

    <ul>
        <li>Använd beskrivande funktionsnamn</li>
        <li>Följ kodstandard för språket</li>
        <li>Validera ev parametrar|argument som finns i funktionen</li>
        <li>Använd flera funktioner - dela upp logik</li>
        <li>Dokumentera funktionen - vilka parametrar ...</li>
    </ul>

    <?php

    // en funktion för att beräkna en kostnad



    /**
     * calculate_total
     *
     * @param  mixed $price
     * @param  mixed $amount
     * @return int
     */
    function calculate_total(int $price, int $amount): int
    {
        return $price * $amount;
    }

    // använd funktionen, spara värdet i en ny variabel
    $total = calculate_total(7, 4);

    // presentera resultat i ett html block element
    echo "<div>Kostnaden är $total</div>";

    $total = calculate_total(8, 6);

    echo "<div>Kostnaden är $total</div>";

    // skapa en funktion med namnet render_total
    // funktionen ska använda calculate_total och därefter
    // presentera resultatet - ex med echo


    /**
     * render_total
     *
     * @param  int $price
     * @param  int $amount
     * @param  int $in_stock
     * @param  string $element
     * @return void
     */
    function render_total(int $price, int $amount, int $in_stock, string $element)
    {

        // validera inkommande argument
        // ex är det ok med nagtiva tal?
        // vilka html element ska kunna anges?
        if ($price < 0 || $amount < 0) {
            return;
        }

        // ny kontroll av $amount - värde inom ett intervall_ is_orderable()
        // med ett inledande ! så är logiken omvänd
        if (!is_orderable($amount, $in_stock)) {
            return;
        }

        // se till att endast följande html element är giltiga
        // en array med giltiga element
        $elements = ["p", "div", "h4"];
        if (!in_array($element, $elements)) {
            $element = "h1";
        }

        $total = calculate_total($price, $amount);
        echo "<$element>Kostnad: $total</$element>";
    }

    // skapa en funtktion som kontrollerar att ett värde finns mellan min och max

    /**
     * is_orderable
     *
     * @param  int $x
     * @param  int $max default 100, används om parametern ej anges
     * @return void
     */
    function is_orderable(int $x, int $max = 100)
    {
        // if ($x > 0 && $x < $max) {
        //     return true;
        // } else {
        //     return false;
        // }

        // som enrads alternativ return
        return ($x > 0 && $x < $max);
    }

    // anropa funktionen med de argument som ska gälla
    render_total(3, 11, 25, "h21");


    // uppgift
    // skapa en funktion som presenterar en persons hela namn och ålder
    // ex
    // Flisa Hedenhös, 5 år
    // funktionen ska ta 3 parametrar, förnamn, efternamn och ålder
    // funktionen ska rendera resultatet som html

    // ...
    // använd ett fjärde argument för vilken html element
    // html elementet ska vara ngt av följande: p, div, span
    // används funktionen med ett element som inte finns i listan ska ett förvalt finnas

    // ...
    // gör en kontroll om personen har nått en viss ålder, alternativt inte nått...
    // rendera ett välkomnande ord som du tycker passar med åldern 


    // associativ array

    // ett exempel på hur man backend kan hantera olika språk för ex formulärfält
    // skapa en array med standardspråk
    $english = [
        "welcome" => "Hello, welcome to this application",
        "name" => "Please enter name",
        "reset" => "Reset",
        "save" => "Save"
    ];

    $swedish = [
        "welcome" => "Hejsan, pigg på att testa en applikation....muhahaha",
        "name" => "Ditt namn",
        "reset" => "Börja om",
        "save" => "Spara om du törs..."
    ];


    $norwegian = [
        "welcome" => "Hei, skriv navnet ditt",
        "name" => "Ditt navn",
        "reset" => "Nullstille",
        "save" => "Spar hvis du tør"
    ];


    // skapa en array med giltiga språk
    $languages = [
        "en" => $english,
        "sv" => $swedish,
        "no" => $norwegian
    ];


    // en variabel för aktuellt språk
    // skulle kunna sparas i en session, eller om man i applikationen först fått möjligheten att välja... 
    // ...men nu bestämt så här...
    $language = "no";


    ?>

    <form action="#" method="post">
        <p>
            Välkommen till applikationen!
        </p>
        <input type="text" name="first_name" placeholder="Ange förnamn">
        <input type="reset" value="Nollställ">
        <button>Spara</button>
    </form>

    <hr>

    <form action="#" method="post">
        <p>
            <?=  $languages[$language]['welcome'] ?>
        </p>
        <input type="text" name="first_name" placeholder="<?= $languages[$language]['name'] ?>">
        <input type="reset" value="<?= $languages[$language]['reset'] ?>">
        <button><?= $languages[$language]['save'] ?></button>
    </form>



    <?php

    include "_includes/footer.php";

    ?>

</body>

</html>