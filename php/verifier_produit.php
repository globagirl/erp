<?php
include('../connexion/connexionDB.php');
$prd=$_POST['prd'];
$sq=mysql_query("select  code_produit from  produit1 where code_produit LIKE '$prd'");
if(mysql_num_rows($sq)>0){
	echo ("1");	
}else {
	echo ("0");
}
mysql_close();
?>