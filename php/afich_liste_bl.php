<html>
  <head>
  
  
	<meta charset="utf-8" />
	<title>BL</title>
	
<link href="../tablecloth/tablecloth.css" rel="stylesheet" type="text/css" media="screen" />
<script type="text/javascript" src="tablecloth/tablecloth.js"></script>
  </head>
  <body>
<h2> Liste Bon de Livraison</h2>
   <?php
  include('../connexion/connexionDB.php');


$query= "SELECT * FROM bon_livr ORDER BY num_bl DESC ";
  $r=mysql_query($query) ;
   mysql_close();
   echo'<table border="1" bordercolor="BLUE" ><tr>
  <td>Num bl </td>
  <td>Numero po</td>
  <td>code article</td>
  <td>description</td>
  <td>quantité</td>
  <td>Date Expedition </td> 
  </tr>';
  while($a=mysql_fetch_object($r))
    {
    $num_bl = $a->num_bl;
    $num_po = $a->num_po;
	$reference = $a->reference;
	$descrp = $a->descrp;
	$qtu = $a->qtu;
	$date_liv= $a->date_liv;
	
	
	
    echo"<tr><td>$num_bl</td><td>$num_po</td><td>$reference</td><td>$descrp</td><td>$qtu</td><td>$date_liv</td></tr>";
    }
  echo '</table>';
  ?>
<br/>
<br/>

  </body>
</html>