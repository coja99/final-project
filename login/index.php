<?php
include_once_once('./includes/baza.php');
session_start();


//ako korisnik vec postoji u sesiji
if(isset($_SESSION['user'])) {
    header('Location: ./index.php');
}

//ako korisnik vec postoji u cookies
if(isset($_COOKIE['user'])) {
    $_SESSION['user'] = $_COOKIE['user'];
    header('Location: ./index.php');
}

//ako se korisnik upravo ulogovao
if(isset($_POST['user']) && isset($_POST['pass'])) {
    if($connection->proveriKorisnika($_POST['user'],$_POST['pass'])) {
        //ako je checkiran keep me logged in
        if(isset($_POST['keep'])) {
            setcookie("user",$_POST['user'],time()+60*60*24);
        }
        $_SESSION['user'] = $_POST['user'];
        header('Location: ./index.php');
    }
    $greska = true;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form method="POST" action="./login.php">
        <label for="user" >Username: </label>
        <input type="email" id="user" name="user" />
        <br>
        <label for="pass" >Password: </label>
        <input type="password" id="pass" name="pass" />
        <br>
        <label for="keep" >Keep me logged in: </label>
        <input type="checkbox" name="keep" id="keep" /> 
        <br> 
        <input type="submit" value="Login" />
    </form>
    <?php if(isset($greska) && $greska) :?>
        <div id='greska'>Pogrešan unos. Proveri lozinku ili korisničko ime.</div>
    <?php endif; ?>
</body>
</html>