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
Consult demande items
</title>
</head>
<body>

<?php

include('../connexion/connexionDB.php');
if(isset($_POST['ID'])){
$ID=$_POST['ID'];
$_SESSION['ID']=$ID;	
}
else{
	$ID=$_SESSION['ID'];
	$sql1 = mysql_query("SELECT * FROM demande_consommable where IDdemande='$ID'");
	$data1=mysql_fetch_array($sql1);
    
echo(" <TABLE ><TR>	<Th Wcode_articleTH=150 HEIGHT=30 colspan=3 >Demande N°: ".$ID."</th></tr>

<tr><td> Consumable ID</td>
<td>Qty demandée  </td>
<td>Qty sortie</td>


");
$sql = mysql_query("SELECT * FROM demande_items where IDdemande='$ID'");
 while($data=mysql_fetch_array($sql)){
	echo("<TR>
<td>".$data['IDconsommable']." </td>
<td>".$data['qtyD']." </td>
<td>".$data['qtyS']." </td>


</tr>"); 
 }
echo("<TR>	<Th Wcode_articleTH=150 HEIGHT=30 colspan=3 ></th></tr>
</table>");	
}


?>
</body>
</html>