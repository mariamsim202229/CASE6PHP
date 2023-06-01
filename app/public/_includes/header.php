<header>
    <h2> CASE 6 PHP BOOKREVIEW </h2>

    <div class="usernamedisplay">
        <?= isset($_SESSION['username']) ? $_SESSION['username'] : ""; ?>

    </div>
    <nav>
        <div>
            <a href="index.php"> <b>Startsida</b></a>
            | <a href="register.php">Registera</a>
            | <a href="book.php"> <b>Bokrecension</b> </a>
        </div>

        <hr>
        <hr>
        <div class="menu2">
            | <a href="book_edit.php"> <b>Min sida</b> </a>
            | <a href="NewLogin.php">Logga in</a>
            | <a href="logout.php"> <b>Logga ut</b></a>
        </div>
    </nav>
</header>