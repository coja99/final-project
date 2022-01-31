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
        $this->connection->query("CREATE DATABASE IF NOT EXISTS `poslovi`");
        $this->connection->select_db('poslovi');
        $this->connection->query("CREATE TABLE IF NOT EXISTS `user` ( `id_usera` INT  AUTO_INCREMENT , `ime` VARCHAR(50) , `prezime` VARCHAR(50),`email` VARCHAR(50) NOT NULL,`slika` VARCHAR(100),`password` VARCHAR(20) NOT NULL, `poslodavac` BOOLEAN , PRIMARY KEY (`id_usera`))");

        $this->connection->query("CREATE TABLE IF NOT EXISTS `kompanija` ( `id_kompanije` INT  AUTO_INCREMENT , `ime` VARCHAR(50) NOT NULL , `deskripcija` VARCHAR(100) NOT NULL,`email` VARCHAR(50) NOT NULL,`slika` VARCHAR(100),`password` VARCHAR(20) NOT NULL, PRIMARY KEY (`id_kompanije`))");
        $this->connection->query("CREATE TABLE IF NOT EXISTS `kategorije`(`id_kategorije` INT AUTO_INCREMENT, `ime` VARCHAR(50) NOT NULL,PRIMARY KEY (`id_kategorije`))");
        $this->connection->query("CREATE TABLE IF NOT EXISTS `oglas`(`id_oglasa` INT AUTO_INCREMENT, `ime_oglasa` VARCHAR(50),`pozicija`VARCHAR(50),`deskripcija` VARCHAR(50),`id_firme` INT (10),`id_kategorije` INT(10),PRIMARY KEY (`id_oglasa`))");
        $this->connection->query("CREATE TABLE IF NOT EXISTS `prijave`(`id_prijave` INT AUTO_INCREMENT,`id_oglasa` INT , `id_firme` INT NOT NULL,`id_usera` INT, PRIMARY KEY (`id_prijave`))");
    }

    private function prepareSelectUser()
    {
        return $this->connection->prepare("SELECT * FROM `user` WHERE `email`=? AND `password`=?");
    }
    function proveriKorisnikaa($email, $pass): bool {
        $prepared = $this->prepareSelectUser();
        $prepared->bind_param("ss",$email,$pass);
        $prepared->execute();
        return $prepared->get_result()->num_rows == 1;
    }
    private function prepKreirajUsera(){
        return $this->connection->prepare("INSERT INTO `user` (`ime`, `prezime`, `email`,`slika`,`password`) VALUES (?,?,?,?,?)");
    }
    function KreirajUsera($ime,$prezime,$email,$slika,$password){
        $res = $this->connection->query("SELECT * FROM `user` WHERE `email` = '$email'");
        if($res->num_rows == 1){
            return "Vec postoji taj korisnik";
        }
        $kreiraj = $this->prepKreirajUsera();
        $kreiraj->bind_param($ime,$prezime,$email,$slika,$password);
        $kreiraj->execute();
        return "Korisnik dodat";
    }
    function prepRegistracija(){
        return $this->connection->prepare("INSERT INTO `user`(`email`,`password`) VALUES (?,?)");
    }
    function registrujUsera($email,$password){
        $kreiraj = $this->prepRegistracija();
        $kreiraj->bind_param("ss",$email,$password);
        password_hash($password,PASSWORD_BCRYPT);
        $kreiraj->execute();
        return "Uspesna registracija";
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
    function optionSelectCateogryName(){
         $rezultat = "SELECT * FROM `kategorije`";
         $res = $this->connection->query($rezultat);
         if($res->num_rows > 0){
             while($row = $res->fetch_assoc()) {
                 echo "<option value=".$row['id_kategorije'].">".$row['ime']."</option>";
             }
         }
         

    }
    function prikaziSveFirme(){
        $rezultat = "SELECT * FROM `kompanija`";
        $res = $this->connection->query($rezultat);
        if($res->num_rows > 0){
            while($row = $res->fetch_assoc()) {
                echo "<option value=".$row['id_kompanije'].">".$row['ime']."</option>";
            }
        }
    }
    
    function prikaziKategoriju(){
        $rezultat = "SELECT `ime` FROM `kategorije`";
        $sabiranje = "SELECT COUNT(*) AS `broj`,`kategorije`.`ime` FROM `kategorije` INNER JOIN `oglas` ON `kategorije`.`id_kategorije` = `oglas`.`id_kategorije` WHERE `kategorije`.`id_kategorije` = `oglas`.`id_kategorije` GROUP BY `ime` ;";
        $sab = $this->connection->query($sabiranje);
        $res = $this->connection->query($rezultat);
        if($res->num_rows > 0){
            while($row = $res->fetch_assoc()) {
                while($row = $sab->fetch_assoc()) {
                echo "<div class=\"col-xl-3 col-md-6\">
				    <a href=\"jobs-list-layout-1.html\" class=\"photo-box small\" data-background-image=\"images/job-category-01.jpg\">
					    <div class=\"photo-box-content\">
						    <h3>".$row['ime']."</h3>
                            
						    <span>".$row['broj']."</span>
                        
					    </div>
				    </a>
			    </div>";
                }
            }
        }
    }
    function dodajOglas($ime,$pozicija,$deskripcija,$id_firme,$id_kategorije){
        $rezultat = "INSERT INTO `oglas`( `ime_oglasa`, `pozicija`, `deskripcija`, `id_firme`, `id_kategorije`) VALUES (?,?,?,?,?)";
        $res = $this->connection->prepare($rezultat);
        $res->bind_param("sssii",$ime,$pozicija,$deskripcija,$id_firme,$id_kategorije);
        $res->execute();
        return $res;
    }
    function dodajFirmu(){
        $rezultat = "INSERT INTO `kompanija`(`ime`, `deskripcija`, `email`, `slika`, `password`) VALUES (?,?,?,?,?)";
    }
    function cuvanjePodatakaDashboard(){

    }
    function prikaziOglasIndex(){
        $upit = "SELECT * FROM `oglas`";
        $res = $this->connection->query($upit);
        if($res->num_rows > 0){
           while($row = $res->fetch_assoc()){
            echo "<div class=\"task-listing\">

            
            <div class=\"task-listing-details\">
            
                <div class=\"task-listing-description\">
                    <h3 class=\"task-listing-title\">".$row['ime_oglasa']."</h3>
                    <ul class=\"task-icons\">
                    </ul>
                    <div class=\"task-tags margin-top-15\">
                       ".$row['deskripcija']."
                    </div>
                </div>
            </div>
            <div class=\"task-listing-bid\">
							<div class=\"task-listing-bid-inner\">
								
								<span class=\"button button-sliding-icon ripple-effect\">Apply now<i class=\"icon-material-outline-arrow-right-alt\"></i></span>
							</div>
						</div>
        </div>";
           }
           
        }
        
    }
    function prikaziSearchJobs(){
        $upit = "SELECT * FROM `oglas`";
        $ime_komp = "SELECT `kompanija`.`ime`
        FROM `kompanija`
        INNER JOIN `oglas`
        ON `kompanija`.`id_kompanije` = `oglas`.`id_firme`";
        $res = $this->connection->query($upit);
        if($res->num_rows > 0){
           while($row = $res->fetch_assoc()){
            echo "<div class=\"task-listing\">

            
            <div class=\"task-listing-details\">
            
                <div class=\"task-listing-description\">
                    <h3 class=\"task-listing-title\">".$row['ime_oglasa']."</h3>
                    <h5 class=\"task-listing-title\">".$row['ime_oglasa']."</h5>
                    <ul class=\"task-icons\">
                    </ul>
                    <div class=\"task-tags margin-top-15\">
                       ".$row['deskripcija']."
                    </div>
                </div>
            </div>
            <div class=\"task-listing-bid\">
							<div class=\"task-listing-bid-inner\">
								
								<span class=\"button button-sliding-icon ripple-effect\">Apply now<i class=\"icon-material-outline-arrow-right-alt\"></i></span>
							</div>
						</div>
        </div>";
           }
           
        }
        
    }
    function prikaziOglasJobSearch(){
        $upit = "SELECT * FROM `oglas`";
        $res = $this->connection->query($upit);
        if($res->num_rows > 0){
           while($row = $res->fetch_assoc()){
                
           }
           
        }
    }
    function zbirOglasa(){
        $upit = "SELECT ime_oglasa, COUNT(*) 
        FROM oglas 
        GROUP BY ime_oglasa;";
        $res = $this->connection->query($upit);
        if($res->num_rows > 0){
            while($row = $res->fetch_assoc()){
                echo count($row);
            }
            
         }
    }
}

$connection = new Konekcija();


