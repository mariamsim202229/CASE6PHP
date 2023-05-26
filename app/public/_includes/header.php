<header>
   <h2> CASE 6 PHP BOOKREVIEW </h2>
    <?= isset($_SESSION['username']) ? $_SESSION['username'] : ""; ?>


    <nav>
        <a href="index.php"> <b>Startsida</b></a>
        | <a href="register.php">Registera</a>
        | <a href="book.php"> <b>Bokrecension</b> </a>
        <hr>
        | <a href="NewLogin.php">Logga in</a>
        | <a href="book_edit.php"> <b>Min sida</b> </a>
        | <a href="logout.php"> <b>Logga ut</b></a>
 
    </nav>
</header>