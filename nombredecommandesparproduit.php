<html>
  <head> <style> * { font-size: 15pt; } </style> </head>
  <body>
<?php
    $dsn = 'mysql:host=localhost;dbname=Projetweb';  /* Data Source Name */
    $username = 'root'; $password = '';
    $options = array();
    $dbh = new PDO($dsn, $username, $password, $options) or die("Pb de connexion !");
?>
    <h3> Liste et nombre des commandes par produit : </h3>
<?php
  $sth = $dbh->prepare("SELECT  * FROM ligne_de_commande LEFT JOIN produit ON  ligne_de_commande.ID_PRODUIT = produit.ID_PRODUIT");
  $sth->execute();
  $result = $sth->fetchAll();
  echo "<ul>";
  $nomproduitPrecedent = "";
  $nbCommandes=0;
  $stats = "[['Nom_Produit','Nombre de commandes']";
   
  foreach ($result as $enr) {
       if ($nomproduitPrecedent != $enr['Nom_Produit']) {
		   echo "<li>".$enr['Nom_Produit']." ".$enr['Prix_Unitaire']." : <br/> ";
		   if ($nomproduitPrecedent != "") { $stats .= ",['$nomproduitPrecedent',$nbCommandes]";}
		  
	   }
	   $nbCommandes++;
	   $nomproduitPrecedent = $enr['Nom_Produit'];
	   echo "&nbsp;&nbsp;".$enr['Nom_Produit']." : ".$enr['Prix_Unitaire']."</li>";
  }
  echo "</ul>";
  $stats .= ",['$nomproduitPrecedent',$nbCommandes]]";
?>


   <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {
        
        var data = google.visualization.arrayToDataTable(<?php echo $stats; ?>);
        var options = {
          title: 'Nombre de commandes par produit'
        };

        var chart = new google.visualization.PieChart(document.getElementById('piechart'));

        chart.draw(data, options);
      }
    </script>
	<div id="piechart" style="width: 900px; height: 500px;"></div>
   </body>
</html>