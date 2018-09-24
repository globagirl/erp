<html>
  <head>
  
		
	<meta charset="utf-8" /> 

	<title>Afficher Machine</title>
<link href="../tablecloth/tablecloth.css" rel="stylesheet" type="text/css" media="screen" />
<script type="text/javascript" src="tablecloth/tablecloth.js"></script>
	
	
  </head>
  <body>
<h2> Machine</h2>
  <?php
 include('../connexion/connexionDB.php');
  $query='SELECT * FROM machines';
  $r=mysql_query($query);
   mysql_close();
   echo'<table border="1" bordercolor="BLUE" ><tr><td>Num_Serie </td><td> Nom_Machine </td></tr>';
   while($a=mysql_fetch_object($r))
    {
    $num_serie=$a->num_serie;
    $nom_machine=$a->nom_machine;
	 
    echo"<tr><td>$num_serie</td><td>$nom_machine</td></tr>";
    }
  echo '</table>';
  ?>
<br/>
<br/>

  </body>
</html>