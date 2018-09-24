<?php
include('../connexion/connexionDB.php');
$ordre=@$_POST['ordre'];

$sq=mysql_query("select * from  reception_ordre_achat1 where IDordre='$ordre'");
if(mysql_num_rows($sq)>0)
{
	$nbr=mysql_num_rows($sq);
	$nbr++;
	echo ("R".$ordre."-".$nbr);
	
}
else {
	$nbr=1;
	echo ("R".$ordre."-".$nbr);
}


?>