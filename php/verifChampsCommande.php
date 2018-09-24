<?php
include('../connexion/connexionDB.php');
$produit=@$_POST['produit'];
$qty=@$_POST['qty'];
$sql=mysql_query("select  code_produit from  produit1 where code_produit='$produit' and statut='C'");
if(mysql_num_rows($sql)>0){
$sq=mysql_query("select  price from  prices where ((IDproduit='$produit') and (marginL <= '$qty')and (marginH >='$qty' or marginH ='-1')) ");
if(mysql_num_rows($sq)>0)
{
	$prix=mysql_result($sq,0);
	echo ($prix);
	
}
else {
	echo ("0");
}
}else {
	echo ("0");
}
mysql_close();
?>