<header>
    CASE 6 PHP BOOKREVIEW
    <hr>
    <?= isset($_SESSION['username']) ? $_SESSION['username'] : ""; ?>


    <nav>
        <a href="index.php"> <b>Start</b></a> | <a href="logout.php">
            <b>Loggout</b></a> | <a href="book.php"> <b>Review</b> </a>
        <hr>
        | <a href="book_edit.php"> <b>My page</b> </a>
        | <a href="NewLogin.php">New Login</a> | <a href="register.php">Register</a>
    </nav>
</header>