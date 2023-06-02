<header>
    <nav>
        <hr>
            <a href="index.php"> <b>Startsida</b></a>
            | <a href="register.php"><b>Registrera </b> </a>
            | <a href="book.php"> <b>Bokrecension</b> </a> 
            <hr>
            <br>
            | <a href="book_edit.php"> <b>Min sida</b> </a>
            | <a href="NewLogin.php"> <b> Logga in </b> </a>
            | <a href="logout.php"> <b>Logga ut</b></a>
            <hr>
   
    </nav>
<div class="usernamedisplay">
    Inloggad användare:
    <?= isset($_SESSION['username']) ? $_SESSION['username'] : ""; ?>
</div>
</header>