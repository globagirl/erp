<html>
  <head>
    
	
	<meta charset="utf-8" />
	
	<title> Ordre Achat</title>
	
<link href="../tablecloth/tablecloth.css" rel="stylesheet" type="text/css" media="screen" />

<script type="text/javascript" src="tablecloth/tablecloth.js"></script>

  </head>
  
  
  <body>
  
  
<h2>liste ordre achat </h2>



   <?php
include('../connexion/connexionDB.php');



$query= "SELECT * FROM ordre_achat ORDER BY num_ordre_achat DESC";
  $r=mysql_query($query) ;
   mysql_close();
   echo'<table border="1" bordercolor="BLUE" >
   
   
   <tr>
   
 
   <td>Num _ordre _ achat</td>
   <td>fournisseur</td>
   <td>date demandé</td>
   <td>Code Article</td>
   <td>quantité</td>
   <td>prix unit</td>
   <td>prix total </td>
   
  
  </tr>';
  while($a=mysql_fetch_object($r))
    {
    $num_ordre_achat =$a->num_ordre_achat;
	$fournisseur = $a->fournisseur;
    $date_demand_starz = $a->date_demand_starz;
	$code_article = $a->code_article;
   	$qtu = $a->qtu;
	$prix_unit = $a->prix_unit;
	$prix_total= $a->prix_total;
	
	
	
    echo"<tr>
	
	<td>$num_ordre_achat</td>
	<td>$fournisseur</td>
	<td>$date_demand_starz</td>
	<td>$code_article</td>
	<td>$qtu</td>
	<td>$qtu</td>
	<td>$prix_unit</td>
	<td>$prix_total</td>
	
	</tr>";
    }
  echo '</table>';
  ?>
<br/>
<br/>

  </body>
</html>