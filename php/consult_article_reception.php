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
Liste des articles reception
</title>
</head>
<body>
<?php
include('../connexion/connexionDB.php');
if(isset($_POST['reception'])){
$reception=$_POST['reception'];
$_SESSION['reception']=$reception;	
}
else{
	$reception=$_SESSION['reception'];


echo(" <table ><tr>	<th  colspan=5 >N° Reception: ".$reception."</th></tr>
<tr><td>N° ordre: </td>
<td> Article</td>

<td>Quantité reçue </td>
<td>Nombre paquet </td>

");
$sql = mysql_query("SELECT * FROM reception_items where IDreception='$reception'");
 while($data=mysql_fetch_array($sql)){
	echo("<tr><td  HEIGHT=30> ".$data['IDorder']."</td>
	<td  HEIGHT=30> ".$data['item']."</td>

<td>".$data['qty']." </td>
<td> ".$data['box']." </td>

</tr>"); 
 }
echo("</table>");	
}

mysql_close();
?>
</body>
</html>