<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<style>
<?php include 'styles/style.css'; ?>
</style>

<h1>Registera dig</h1>


<p>
    <label for="name">Namn</label>
    <input type="text" name="name" id="name"> 
</p>

<p>
    <label for="surname">Efternamn</label>
<input type="text" name="surname" id="surname">
</p>


<p>
    <label for="email">Mejladress</label>
    <input type="email" name="email" id="email">
</p>

<p>
    <label for="phonenumber">Telefonnummer</label>
    <input type="number" name="phonenumber" id="phonenumber">
</p>

<p>
    <label for="username">Användarnamn</label>
    <input type="text" name="username" id="username">
</p>

<p>
    <label for="password">Välj lösenord</label>
    <input type="password" name="password" id="password">
</p>

<hr>
        <p>
            <input type="submit" value="Registrera">
            <input type="reset" value="Nollställ">
        </p>

</body>
</html>