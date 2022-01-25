<?php



class Konekcija
{
    private $connection;
    function __construct()
    {
        //povezujemo se bez baze jer hocemo da napravimo novu ako ne postoji 
        $this->connection = new mysqli('localhost', 'root', '');
        if ($this->connection->error) {
            die("Greska pri povezivanju: $this->connection->error");
        }

        //kreiramo bazu ako ne postoji
        $this->connection->query("CREATE DATABASE IF NOT EXISTS `poslovi`");

        //selektujemo bazu da bi smo radili sa njom
        $this->connection->select_db('poslovi');

        //kreiramo tabelu user ako ne postoji
        $this->connection->query("CREATE TABLE IF NOT EXISTS `user` ( `id_usera` INT NOT NULL AUTO_INCREMENT , `ime` VARCHAR(50) NOT NULL , `prezime` VARCHAR(50) NOT NULL,`email` VARCHAR(50) NOT NULL,`slika` VARCHAR(100),`password` VARCHAR(20) NOT NULL, PRIMARY KEY (`id_usera`))");
        //INSERT IGNORE ignorise duplikate za UNIQUE kolonu (username), tako da nece biti ponavljanja admina u tabeli
        // $this->connection->query("INSERT IGNORE INTO `user`(`username`,`password`) VALUES ('admin@admin','adminpass')");

        $this->connection->query("CREATE TABLE IF NOT EXISTS `kompanija` ( `id_kompanije` INT NOT NULL AUTO_INCREMENT , `ime` VARCHAR(50) NOT NULL , `deskripcija` VARCHAR(100) NOT NULL,`email` VARCHAR(50) NOT NULL,`slika` VARCHAR(100),`password` VARCHAR(20) NOT NULL, PRIMARY KEY (`id_kompanije`))");
        $this->connection->query("CREATE TABLE IF NOT EXISTS `kategorije`(`id_kategorije` INT AUTO_INCREMENT, `ime` VARCHAR(50) NOT NULL,PRIMARY KEY (`id_kategorije`))");
    }

    private function prepareSelectUser()
    {
        return $this->connection->prepare("SELECT * FROM `user` WHERE `password`=? AND `username`=?");
    }
    private function prepKreirajUsera(){
        return $this->connection->prepare("INSERT INTO `user` (`ime`, `prezime`, `email`,`slika`,`password`) VALUES (?,?,?,?,?");
    }
    function KreirajUsera($ime,$prezime,$email,$slika,$password){
        $res = $connection->query("SELECT * FROM `user` WHERE `email` = '$email'");
        if($res->num_rows == 1){
            return "Vec postoji taj korisnik";
        }
        $kreiraj = $this->prepKreirajUsera();
        $kreiraj->bind_param($ime,$prezime,$email,$slika,$password);
        $kreiraj->execute();
        return "Korisnik dodat";
    }

    function proveriKorisnika($user, $pass): bool
    {
        $prepared = $this->prepareSelectUser();
        $prepared->bind_param("ss", $pass, $user);
        $prepared->execute();
        return $prepared->get_result()->num_rows == 1;
    }

    function nizLokacija()
    {
        $query_res = $this->connection->query("SELECT * FROM `location`");
        $result = [];
        foreach ($query_res as $row) {
            array_push($result, [$row['id'], $row['grad'], $row['drzava']]);
        }
        return $result;
    }
}

$connection = new Konekcija();