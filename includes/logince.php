<?
include_once("./includes/baza.php");
if(isset($_POST['emailaddress']) && isset($_POST['password'])) {
    if($connection->proveriKorisnikaa($_POST['emailaddress'],$_POST['password'])) {
        $_SESSION['user'] = $_POST['user'];
        header('Location:./index.php');
    }
    $greska = true;
}
?>