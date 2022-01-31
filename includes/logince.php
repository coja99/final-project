<?php
include_once("./baza.php");
if(isset($_POST['emailaddress']) && isset($_POST['password'])) {
    if($connection->proveriKorisnikaa($_POST['emailaddress'],$_POST['password'])) {
        
        
        $_SESSION['emailaddress'] = $_POST['emailaddress'];
        header('Location:../indexx.php');
    }
    $greska = true;
}
?>