<?php 
include('../connexion/connexionDB.php');
$OF=$_POST['OF'];

$sql="UPDATE ordre_fabrication1 SET statut='finished',date_fin=NOW() where OF='$OF'";

if (!mysql_query($sql)) {
die('Error: ' . mysql_error()); 
    header('Location: ../pages/closeOF.php?status=fail');
}else{  
$sql13=mysql_query("UPDATE plan1 SET statut='closed' where OF='$OF'");
$sq=mysql_query("select PO from ordre_fabrication1 where OF='$OF'");
$PO=mysql_result($sq,0);
////		
$sql=mysql_query("SELECT * from commande_items where PO='$PO'");
$data=mysql_fetch_array($sql);
$stat=$data['statut'];
$POG=$data['PO'];

if($stat=="incomplete"){
	$statut="incomplete";
}else{
	$statut="finished";
}
$sql11=mysql_query("UPDATE commande_items SET statut='$statut' where POitem='$PO'");
$sql11=mysql_query("UPDATE commande2 SET statut='in progres' where PO='$POG'");
	
     header('Location: ../pages/closeOF.php?status=sent');

}  

?>