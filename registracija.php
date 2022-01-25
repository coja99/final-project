<?php 
    require "./includes/baza.php";
    // require_once("index-logged-out.php");
    if(isset($_POST['emailaddress-register']) && isset($_POST['password-register'])){
        $email = $_POST['emailaddress-register'];
        $pass = $_POST['password-register'];
        $connection->registrujUsera($email,$pass);
        header("Location:index.php");
    } 



?>