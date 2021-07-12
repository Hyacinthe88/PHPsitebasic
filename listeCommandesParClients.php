<html>
  <head> <style> * { font-size: 15pt; } </style> </head>
  <body>
<?php
    $dsn = 'mysql:host=localhost;dbname=Projetweb';  /* Data Source Name */
    $username = 'root'; $password = '';
    $options = array();
    $dbh = new PDO($dsn, $username, $password, $options) or die("Pb de connexion !");
?>
    <h3> Liste des commandes par clients : </h3>
<?php
  $sth = $dbh->prepare("SELECT * FROM commandes LEFT JOIN client ON commandes.ID_CLIENT = client.ID_CLIENT GROUP BY NOM_CLIENT");
  $sth->execute();
  $result = $sth->fetchAll();
  echo "<ul>";
  $nomClientPrecedent = "";
  foreach ($result as $enr) {
       if ($nomClientPrecedent != $enr['NOM_CLIENT']) echo "<li>".$enr['NOM_CLIENT']." ".$enr['PRENOM_CLIENT']." : <br/> ";
	   $nomClientPrecedent = $enr['NOM_CLIENT'];
	   echo "&nbsp;&nbsp;".$enr['ID_COMMANDE']." : ".$enr['DATE_COMMANDE']."</li>";
  }
  echo "</ul>";
?>
  </body>
</html>