<?php 
session_start();
?>
<html>
<head>
<meta charset="utf-8" />
<link href="../tablecloth/tablecloth.css" rel="stylesheet" type="text/css" media="screen" />
<script type="text/javascript" src="tablecloth/tablecloth.js"></script>
<link rel="stylesheet" type="text/css" href="../css/style.css"/>
<script src="../jquery/jquery-latest.min.js"></script>
<script type='text/javascript' src='../jquery/menu_jquery.js'></script>
<title>
Consult commande items
</title>
</head>
<body>

<?php

include('../connexion/connexionDB.php');
if(isset($_POST['PO'])){
$PO=$_POST['PO'];
$_SESSION['PO']=$PO;	
}
else{
	$PO=$_SESSION['PO'];
	$sql1 = mysql_query("SELECT * FROM commande2 where PO='$PO'");
	$data1=mysql_fetch_array($sql1);
    
echo(" <TABLE ><TR>	<Th Wcode_articleTH=150 HEIGHT=30 colspan=7 >PO N°: ".$PO."</th></tr>

<tr><td> PO/N°</td>
<td>Item ID  </td>

<td>Qty </td>
<td>Prix unitaite </td>
<td>Prix </td>
<td>Statut </td>

");
$sql = mysql_query("SELECT * FROM commande_items where PO='$PO'");
 while($data=mysql_fetch_array($sql)){
	echo("<TR>
<td>".$data['POitem']." </td>
<td>".$data['produit']." </td>

<td>".$data['qty']." </td>
<td> ".$data['prixU']." </td>
<td> ".$data['prixT']." </td>
<td> ".$data['statut']." </td>

</tr>"); 
 }
echo("<TR>	<Th Wcode_articleTH=150 HEIGHT=30 colspan=7 > Prix Total : ".$data1['prix_total']."</th></tr>
</table>");	
}


?>
</body>
</html>