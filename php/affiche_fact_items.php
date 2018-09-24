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
Consult BL items
</title>
</head>
<body>

<?php

include('../connexion/connexionDB.php');
if(isset($_POST['fact'])){
$fact=$_POST['fact'];
$_SESSION['fact']=$fact;	
}
else{
	$fact='8013061'; //$_SESSION['fact'];
	$sql1 = mysql_query("SELECT * FROM fact1 where num_fact='$fact'");
	$data1=mysql_fetch_array($sql1);
    
echo(" <TABLE ><TR>	<Th Wcode_articleTH=150 HEIGHT=30 colspan=6 >Facture N°: ".$fact."</th></tr>

<tr><td> Item ID</td>
<td>PO client  </td>
<td>OF </td>
<td>Qty </td>
<td>Prix unitaire </td>
<td>Prix </td>

");
$sql = mysql_query("SELECT * FROM fact_items where idF='$fact'");
 while($data=mysql_fetch_array($sql)){
	echo("<TR><td  HEIGHT=30> ".$data['produit']."</td>
<td>".$data['PO']." </td>
<td>".$data['OF']." </td>
<td>".$data['qty']." </td>
<td> ".$data['prixU']." </td>
<td> ".$data['prixT']." </td>

</tr>"); 
 }
echo("<TR>	<Th Wcode_articleTH=150 HEIGHT=30 colspan=6 > Total : ".$data1['tot_val']."</th></tr>
</table>");	
}


?>
</body>
</html>