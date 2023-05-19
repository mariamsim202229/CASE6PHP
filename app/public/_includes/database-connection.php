<?php

$servername = "mysql";
$database = "db_learn";
$username = "db_user";
$password = "db_password";

$dsn = "mysql:host=$servername;dbname=$database";


try {
    $pdo = new PDO($dsn, $username, $password);
    // set the PDO error mode to exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);


    setup_book($pdo);
    setup_user($pdo);

    // echo "Connected successfully";
} catch (PDOException $e) {
    // echo "Connection failed: " . $e->getMessage();
}


// funktion för att skapa tabellen bookReview
function setup_book($pdo)
{

    $sql = "CREATE TABLE IF NOT EXISTS `BookReview1` (
`book_id` int(11) NOT NULL,
 `book_title` text NOT NULL,
 `author` text NOT NULL,
 `year_published` date NOT NULL,
 `review` text NOT NULL,
 `created_at` date NOT NULL,
 UNIQUE KEY `id_book` (`book_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci";

    $pdo->exec($sql);

}


// funktion för att skapa tabellen user

function setup_user($pdo)
{

    $sql = "CREATE TABLE `User` (
        `Id` int(11) NOT NULL,
        `username` text NOT NULL,
        `password` text NOT NULL,
        UNIQUE KEY `Id` (`Id`),
        UNIQUE KEY `username` (`username`) USING HASH
       ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci";

    $pdo->exec($sql);
}



?>