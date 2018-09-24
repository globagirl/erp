<html>
  <head>
   
	
		<meta charset="utf-8" />
	 <title>Liste de commande</title>
	
<link href="../tablecloth/tablecloth.css" rel="stylesheet" type="text/css" media="screen" />
<script type="text/javascript" src="tablecloth/tablecloth.js"></script>
	
  </head>
  <body>
<h2> Commande à Expédié</h2>
   <?php
 include('../connexion/connexionDB.php');


$query= "SELECT * FROM exped_com ORDER BY date_exped DESC ";
  $r=mysql_query($query) ;
   mysql_close();
   echo'<table border="1" bordercolor="BLUE" ><tr>
  <td>Num PO </td><td>Code Article </td><td>déscription</td><td>Quantité OF</td><td>Date Expedition </td> 
  </tr>';
  while($a=mysql_fetch_object($r))
    {
  
    $num_po = $a->num_po;
	$code_artic = $a->code_artic;
	$descrip = $a->descrip;
	$qte = $a->qte;
	$date_exped = $a->date_exped;
	
	
	
    echo"<tr><td>$num_po</td><td>$code_artic</td><td>$descrip</td><td>$qte</td><td>$date_exped</td></tr>";
    }
  echo '</table>';
  ?>
<br/>
<br/>

  </body>
</html>