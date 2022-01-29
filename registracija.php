<?php 
    require "./includes/baza.php";
    // require_once("index-logged-out.php");
    if(isset($_POST['emailaddress-register']) && isset($_POST['password-register'])){
        $email = $_POST['emailaddress-register'];
        $pass = $_POST['password-register'];
        $hashed_password = password_hash($password, PASSWORD_BCRYPT);
        if(password_verify($password, $hashed_password)) {
            $connection->registrujUsera($email,$pass);
            header("Location:index.php");
        } 
        
    } 



?>