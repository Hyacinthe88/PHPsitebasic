<html>
  <head> <style> * { font-size: 15pt; } </style> </head>
  <body>
<?php
    $dsn = 'mysql:host=localhost;dbname=Projetweb';  /* Data Source Name */
    $username = 'root'; $password = '';
    $options = array();
    $dbh = new PDO($dsn, $username, $password, $options) or die("Pb de connexion !");
?>
    <h3> Liste et nombre de commandes par clients : </h3>
<?php
  $sth = $dbh->prepare("SELECT * FROM commandes LEFT JOIN client ON commandes.ID_CLIENT = client.ID_CLIENT GROUP BY NOM_CLIENT");
  $sth->execute();
  $result = $sth->fetchAll();
  echo "<ul>";
  $nomClientPrecedent = "";
  $nbCommandes=0;
  $stats = "[['Client','Nombre de commandes']";
  foreach ($result as $enr) {
       if ($nomClientPrecedent != $enr['NOM_CLIENT']) {
		   echo "<li>".$enr['NOM_CLIENT']." ".$enr['PRENOM_CLIENT']." : <br/> ";
		   if ($nomClientPrecedent != "") { $stats .= ",['$nomClientPrecedent',$nbCommandes]";}
	   }
	   $nbCommandes++;
	   $nomClientPrecedent = $enr['NOM_CLIENT'];
	   echo "&nbsp;&nbsp;".$enr['ID_COMMANDE']." : ".$enr['DATE_COMMANDE']."</li>";
  }
  echo "</ul>";
  $stats .= ",['$nomClientPrecedent',$nbCommandes]]";
 /*echo $stats;*/
?>

   <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {
        /*
        var data = google.visualization.arrayToDataTable([
          ['Task', 'Hours per Day'],
          ['Work',     11],
          ['Eat',      2],
          ['Commute',  2],
          ['Watch TV', 2],
          ['Sleep',    7]
        ]);
		*/
        var data = google.visualization.arrayToDataTable(<?php echo $stats; ?>);
        var options = {
          title: 'Nombre de commandes par client'
        };

        var chart = new google.visualization.PieChart(document.getElementById('piechart'));

        chart.draw(data, options);
      }
    </script>
	<div id="piechart" style="width: 900px; height: 500px;"></div>
   </body>
</html>