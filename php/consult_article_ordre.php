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
Consulter article Ordre
</title>
</head>
<body>
<?php
include('../connexion/connexionDB.php');
if(isset($_POST['ordre'])){
$ordre=$_POST['ordre'];
$_SESSION['ordre']=$ordre;	
}
else{
	$ordre=$_SESSION['ordre'];
	$sql1 = mysql_query("SELECT * FROM ordre_achat2 where IDordre='$ordre'");
	$data1=mysql_fetch_array($sql1);

echo(" <TABLE ><TR>	<Th Wcode_articleTH=150 HEIGHT=30 colspan=5 >N° ordre: ".$ordre."</th></tr>

<tr><td> Article</td>
<td>Quantité demandée  </td>
<td>Quantité reçue </td>
<td>Prix unitaire </td>
<td>Prix totale </td></tr>
");
$sql = mysql_query("SELECT * FROM ordre_achat_article1 where IDordre='$ordre'");
 while($data=mysql_fetch_array($sql)){
	echo("<TR><td  HEIGHT=30> ".$data['IDarticle']."</td>
<td>".$data['qte_demande']." </td>
<td>".$data['qte_recue']." </td>
<td> ".$data['prix_unitaire']." ".$data1['devise']."</td>
<td> ".$data['prix_total']." ".$data1['devise']."</td>
</tr>"); 
 }
echo("<TR>	<Th Wcode_articleTH=150 HEIGHT=30 colspan=5 >Prix Total: ".$data1['prix_total']." ".$data1['devise']."</th></tr>
</table>");	
}

mysql_close();
?>
</body>
</html>