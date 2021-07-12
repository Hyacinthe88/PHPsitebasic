<html>
  <head> <style> * { font-size: 15pt; } </style> </head>
  <body>
<?php
    $dsn = 'mysql:host=localhost;dbname=projetweb';  /* Data Source Name */
    $username = 'root';
    $password = '';
    $options = array();
    $dbh = new PDO($dsn, $username, $password, $options) or die("Pb de connexion !");
    $nomClient = $_GET['nom'];
?>
    <h3> Liste des commandes du client <?php echo $nomClient; ?> : </h3>
<?php
  $sth = $dbh->prepare("SELECT * FROM client, commandes WHERE NOM_CLIENT = '$nomClient' AND commandes.ID_CLIENT = client.ID_CLIENT");
  $sth->execute();
  $result = $sth->fetchAll();
  echo "<ul>";
  foreach ($result as $enr) {
	   echo "<li>".$enr['NOM_CLIENT']." ".$enr['PRENOM_CLIENT']." : ".$enr['ID_COMMANDE']." : ".$enr['DATE_COMMANDE']."</li>";
  }
  echo "</ul>";
?>
</body>
</html>