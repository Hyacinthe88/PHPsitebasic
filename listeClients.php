<html>
   <body>
<?php
$dsn='mysql:host=localhost;dbname=projetweb';
$username='root';
$password= '';
$options=array();
$dbh=new PDO($dsn,$username,$password,$options) or die ("pb de connexion")/* connexion à la base avec les paramètres préccedents
sinon on a 'OR DIE' */
?>
   <h3> Liste des clients :</h3>
   <?php
   $sth=$dbh->prepare("SELECT * FROM client");
   $sth->execute();
   $result=$sth->fetchAll();  /* Prendre tout le tableau en memoire  issu de l'execution preccédent*/
   echo "<ul>";
   foreach ($result as $enr) {
	   echo "<li>".$enr['NOM_CLIENT']."  ".$enr['PRENOM_CLIENT']."</li>";
   }
   echo "</ul>";
   ?>
    </body>
 </html>  