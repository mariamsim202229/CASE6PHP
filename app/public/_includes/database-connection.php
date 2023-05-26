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


    // setup_book($pdo);
    // setup_user($pdo);


    echo "Connected successfully";
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}


// funktion för att skapa tabellen bookReview
function setup_book($pdo)
{

    $sql = "CREATE TABLE IF NOT EXISTS `book` (
        `book_id` int(11) NOT NULL AUTO_INCREMENT,
        `title` varchar(255) NOT NULL,
        `author` varchar(255) NOT NULL,
        `year_published` year(4) NOT NULL,
        `review` text NOT NULL,
        `created_at` datetime NOT NULL DEFAULT current_timestamp(),
        `user_id` int(11) NOT NULL DEFAULT uuid(),
        PRIMARY KEY (`book_id`)
       ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci";

    $pdo->exec($sql);
}


// funktion för att skapa tabellen user

function setup_user($pdo)
{

    $sql = "CREATE TABLE IF NOT EXISTS `user` (
        `user_id` int(11) NOT NULL AUTO_INCREMENT,
        `username` varchar(255) NOT NULL,
        `password` varchar(255) NOT NULL,
        PRIMARY KEY (`user_id`)
       ) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci";

    $pdo->exec($sql);
}



?>