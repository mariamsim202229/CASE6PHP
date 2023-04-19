<?php

// en variabel deklareras med inledande $ 
$name = "Flisa Hedenhös";

echo $name;

// variablers namn skrivs som snake_case i PHP: små bokstäver a-z, understreck mellan orddelar
// snake_case
// kebab-case
// camelCase
// PascalCase

// ett förnamn
$first_name = "Hugge";
$fname = "Knota";

// ett efternamn
$last_name = "Hedenhös";

// kontrollera vilken datatyp som en variabel har
// gettype

echo "<br>";
echo gettype($first_name);
echo "<br>";

// strängar slås ihop med punkt
echo "Variabeln med namnet last_name:  <b>$last_name</b>, har datattypen:" . gettype($last_name);

// en variabel med namnet comment
$comment = "PHP är ju kul";

echo "<br>";
// hur många tecken har variabeln - strlen
$number_of_characters = strlen($comment);

echo "Kommentaren <i>$comment</i> har $number_of_characters tecken";

// uppgift
// för att validera en variabel kan olika strängmetoder användas
// gör ngt vettigt med följande metoder
// ta bort eventuella inledande mellanslag med trim
// räkna ord med str_word_count
// repetera en sträng med str_repeat
// ersätt ett ord i en mening med str_replace
// testa exempelvis olika ordspråk

$proverb = "  Allt är inte guld som glimmar     ";

// antal tecken innan trim
$number_before = strlen($proverb);

// använd funktionen för att ta bort blanksteg
$proverb = trim($proverb);

$number_after = strlen($proverb);

echo "<br>";
echo "Ordspråket $proverb hade innan trim $number_before tecken, och efter trim $number_after tecken.";
echo "<br>";

$number_of_words = str_word_count($proverb);

echo "<br>";
echo "Ordspråket $proverb har $number_of_words ord";
echo "<br>";

$promise = "Jag lovar att lära mig stava till programmering<br>";
$result = str_repeat($promise, 10);

echo "<br>";
echo $result;
echo "<br>";

// fixa stora tecken till små tecken - obs funkar kanske.... inte med svenska tecken som ÅÄÖ
$message = "ALLT ÄR BARA EN STOR KONSPIRATION";

echo "<br>";
echo strtolower($message);
echo "<br>";


?>