<?php 
include_once "./includes/baza.php";

if (isset($_POST['firma_ime']) && isset($_POST['firma_email'])&& isset($_POST['firma_deskripcija']) ) {
 $ime = $_POST['firma_ime'];
 $email = $_POST['firma_email'];
 $deskripcija = $_POST['firma_deskripcija'];
 $connection->kreirajFirmu($ime,$deskripcija,$email);
 header('Location:dodaj-oglas.php');


}



?>