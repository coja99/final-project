<?php include "./includes/baza.php";
include_once "./dodaj-oglas.php";
if(isset($_POST['oglas_ime']) && isset($_POST['oglas_pozicija']) && isset($_POST['oglas_firma']) && isset($_POST['oglas_kategorija']) && isset($_POST['oglas_deskripcija'])){
    $oglas_ime = $_POST['oglas_ime'];
    $oglas_pozicija = $_POST['oglas_pozicija'];
    $oglas_firma = $_POST['oglas_firma'];
    $oglas_kategorija = $_POST['oglas_kategorija'];
    $oglas_deskripcija = $_POST['oglas_deskripcija'];

    $this->connection->dodajOglas()->bind_param($oglas_ime,$oglas_pozicija,$oglas_deskripcija,$oglas_firma,$oglas_kategorija);
    $this->connection->execute();
    header('Location:./search-jobs.php');

}
    


?>