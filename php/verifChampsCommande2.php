<?php
include('../connexion/connexionDB.php');
$PO=@$_POST['PO'];

$sq=mysql_query("select  PO from  commande2 where PO='$PO'");
if(mysql_num_rows($sq)>0)
{
	
	echo ("0");
	
}
else {
	echo ("1");
}


?>