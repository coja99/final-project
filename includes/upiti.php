<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php  

        class Upiti{
                
            private $conn;
            
            function __construct(){
                //povezujemo se bez baze jer hocemo da napravimo novu ako ne postoji 
                $this->conn = new mysqli('localhost', 'root', '');
                if ($this->conn->error) {
                    die("Greska pri povezivanju: $this->conn->error");
                }

                //kreiramo bazu ako ne postoji
                $this->conn->query("CREATE DATABASE IF NOT EXISTS `poslovi`");

                //selektujemo bazu da bi smo radili sa njom
                $this->conn->select_db('poslovi');
                
            }
        }





    ?>
</body>
</html>