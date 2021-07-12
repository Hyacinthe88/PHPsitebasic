<html>
  <head> <style> * { font-size: 20pt; } </style> </head>
  <body>
<?php
    $dsn = 'mysql:host=localhost;dbname=projetweb';  /* Data Source Name */
    $username = 'root'; $password = '';
    $options = array();
    $dbh = new PDO($dsn, $username, $password, $options) or die("Pb de connexion !");
    $nomproduit = $_GET['Nom'];
?>
?>
    <h3> Liste et nombre de l'article <?php echo $nomproduit; ?> par mois  : </h3>
<?php
  $sth = $dbh->prepare("SELECT * FROM commandes, ligne_de_commande, Produit WHERE  ligne_de_commande.ID_COMMANDE=commandes.ID_COMMANDE AND ligne_de_commande.ID_PRODUIT=Produit.ID_PRODUIT AND Nom_Produit='$nomproduit'");
  $sth->execute();
  $result = $sth->fetchAll();
  echo "<ul>";
  $DatePrecedent = "";
  $stats = "[['DATE_COMMANDE','Nombre de commandes']";
  foreach ($result as $enr) {
       if ($DatePrecedent != $enr['DATE_COMMANDE']) {
       echo "<li>".$enr['DATE_COMMANDE']."  : <br/> ";
       if ($DatePrecedent != "") { $stats .= ",['$DatePrecedent',$nbCommandes]";}
       $nbCommandes=0;
     }
     $nbCommandes++;
     $DatePrecedent = $enr['DATE_COMMANDE'];
     echo "&nbsp;&nbsp;".$enr['ID_Ligne']." : ".$enr['Nom_Produit']." </li>";
  }
  echo "</ul>";
  $stats .= ",['$DatePrecedent',$nbCommandes]]";
  //echo $stats;
?>
<html>
  <head>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">

      // Load Charts and the corechart and barchart packages.
      google.charts.load('current', {'packages':['corechart']});

      // Draw the pie chart and bar chart when Charts is loaded.
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {
        /*
        var data = new google.visualization.DataTable();
        data.addColumn('string', 'Topping');
        data.addColumn('number', 'Slices');
        data.addRows([
          ['Mushrooms', 3],
          ['Onions', 1],
          ['Olives', 1],
          ['Zucchini', 1],
          ['Pepperoni', 2]
        ]);
        */
    var data = google.visualization.arrayToDataTable(<?php echo $stats; ?>);
    
    // graph hitgolograme
        var barchart_options = {title:'Nombre de commandes par mois',
                       width:800,
                       height:500,
                       legend: 'none'};
        var barchart = new google.visualization.BarChart(document.getElementById('barchart_div'));
        barchart.draw(data, barchart_options);
    
    
        // graph courbes
    var options = {
          title: 'Nombre de commandes par mois',
      width:500,
          height:400,
          curveType: 'function',
          legend: { position: 'bottom' }
        };

        var chart = new google.visualization.LineChart(document.getElementById('curve_chart'));

        chart.draw(data, options);
    
    }
</script>
<body>
    <!--Table and divs that hold the pie charts-->
    <table class="columns">
      <tr>
        <td><div id="piechart_div" style="border: 1px solid #ccc"></div></td>
        <td><div id="barchart_div" style="border: 1px solid #ccc"></div></td>
    <td><div id="curve_chart"   style="border: 1px solid #ccc"></div></td>
      </tr>
    </table>
  </body>
</html>