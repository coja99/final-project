<?php 
include "./includes/baza.php";
if(isset($_POST['kategorija_ime'])){
    $ime_kategorije = $_POST['kategorija_ime'];
    $connection->dodajKategoriju($_POST['kategorija_ime']);
    header('Location:dodaj-oglas.php');
}




?>