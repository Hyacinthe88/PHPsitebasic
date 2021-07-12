<html>
   <body>
<?php
$dsn='mysql:host=localhost;dbname=Projetweb';
$username='root';
$password= '';
$options=array();
$dbh=new PDO($dsn,$username,$password,$options) or die ("pb de connexion")
?>
   <h3> ListeCommandes:</h3>
   <?php
   $sth=$dbh->prepare("SELECT* FROM Commandes");
   $sth->execute();
   $result=$sth->fetchAll();   /* Prendre tout le tableau issu de l'execution preccédent*/
   echo "<ul>";
   foreach ($result as $enr) {
	   echo "<li>".$enr['ID_COMMANDE']." ".$enr['DATE_COMMANDE']."<li>";
   }
   echo "</ul>";
   ?>
    </body>
 </html>  