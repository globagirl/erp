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
Consulter article
</title>
</head>
<body>
<?php
include('../connexion/connexionDB.php');
if(isset($_POST['valeur'])){
$produit=$_POST['valeur'];
$_SESSION['produit']=$produit;	
}
else{
	$produit=$_SESSION['produit'];
	$sql1 = mysql_query("SELECT * FROM produit1 where code_produit='$produit'");
	$data1=mysql_fetch_array($sql1);

echo(" <table ><tr>	<th HEIGHT=30 colspan=5 >Produit: ".$produit."</th></tr>

<tr><td> Code Article</td>
<td>Type </td>
<td>Quantité </td></tr>");
$sql = mysql_query("SELECT * FROM produit_article1 where IDproduit='$produit'");
 while($data=mysql_fetch_array($sql)){
	 $art=$data['IDarticle'];
	 $sql2 = mysql_query("SELECT * FROM article1 where code_article='$art'");
	$data2=mysql_fetch_array($sql2);
	 
	echo("<tr><td  HEIGHT=30> ".$data['IDarticle']."</td>
    <td>".$data2['typeA']." </td>
    <td>".$data['qte']." ".$data2['unit']."</td>
    </tr>"); 
  }
    echo("<tr>	<th colspan=5 >Catégorie: ".$data1['categorie']."</th></tr>
    </table>");	
  }
mysql_close();

?>
</body>
</html>