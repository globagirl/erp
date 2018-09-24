<html>
  <head>
   
	
		<meta charset="utf-8" />
	 <title>Liste de CHAINE</title>
	
<link href="../tablecloth/tablecloth.css" rel="stylesheet" type="text/css" media="screen" />
<script type="text/javascript" src="tablecloth/tablecloth.js"></script>
	
  </head>
  <body>
<h2>Chaine</h2>
  <?php
  include('../connexion/connexionDB.php');
  $query='SELECT * FROM ajout_chaine';
  $r=mysql_query($query);
   mysql_close();
   echo'<table border="1" bordercolor="BLUE" ><tr><td>Id_chaine </td><td> déscription chaine </td></tr>';
   while($a=mysql_fetch_object($r))
    {
    $ch_id=$a->ch_id;
    $nom=$a->nom;
	 
    echo"<tr><td>$ch_id</td><td>$nom</td></tr>";
    }
  echo '</table>';
  ?>
<br/>
<br/>

  </body>
</html>