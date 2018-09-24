 
 <html>
<head>
<meta charset="utf-8" />
<link href="../tablecloth/tablecloth.css" rel="stylesheet" type="text/css" media="screen" />
<script type="text/javascript" src="../tablecloth/tablecloth.js"></script>
<link rel="stylesheet" type="text/css" href="../css/style.css"/>
<script src="../jquery/jquery-latest.min.js"></script>
<script type='text/javascript' src='../jquery/menu_jquery.js'></script>
<link rel="stylesheet" href="../CSS/mbcsmbmcp.css" type="text/css" />



<title>
Expédition
</title>
</head>

<body>
<h2> Liste PO à expédier </h2>

 <?php
include('../connexion/connexionDB.php');

$req= "SELECT * FROM commande_items where statut='in progres' or statut='incomplete'  ";




  echo'<table  id="myTable" class="tablesorter" cellspacing="0" cellpadding="0"><thead><tr><td>PO</td><td>Produit </td><td>Quantité</td>
  
  </tr>';
  
 
 
   $r=mysql_query($req) or die(mysql_error());
  while($a=mysql_fetch_object($r))
    {
	
	
	
    $PO =$a->POitem;
    $prd =$a->produit;
	
	$qte=$a->qty;
	
	
	
    echo"<tr><td>$PO</td><td>$prd</td><td>$qte</td>
	</tr>";
    }
	
  echo '</thead></table>';

//echo($val);

  ?>
  </body>
  </html>