<html>
  <head>
    
	
	
	<meta charset="utf-8" />
	<title>Liste de Facture</title>
	
<link href="../tablecloth/tablecloth.css" rel="stylesheet" type="text/css" media="screen" />
<script type="text/javascript" src="tablecloth/tablecloth.js"></script>



  </head>
  
  
  <body>
<h2> FACTURE </h2>
   <?php
 include('../connexion/connexionDB.php');


$query= "SELECT * FROM fact1 ORDER BY num_fact DESC";
  $r=mysql_query($query) ;
   mysql_close();
   echo'<table border="1" bordercolor="BLUE" ><tr>
   
 
   <td>Num _ FACT</td>
   <td>Num _ BL</td>
   <td>Num _ PO</td>
   <td>Code Article</td>
   <td>Description</td>
  <td>Quantité</td>
  <td>Prix Total</td>
  <td>Date fact </td>
  
  
  </tr>';
  while($a=mysql_fetch_object($r))
    {
	$num_fact = $a->num_fact;
    $num_bl =$a->num_bl;
    $num_po = $a->num_po;
	$ref = $a->ref;
    $descrip = $a->descrip;
	$qte= $a->qte;
	$tot_val= $a->tot_val;
	$date_fact = $a->date_fact;
	
	
	
	
    echo"<tr>
	<td>$num_fact</td>
	<td>$num_bl</td>
	<td>$num_po</td>
	<td>$ref</td>
	<td>$descrip</td>
	<td>$qte</td>
	<td>$tot_val</td>
	<td>$date_fact</td>
	
	
	</tr>";
    }
  echo '</table>';
  ?>
<br/>
<br/>

  </body>
</html>