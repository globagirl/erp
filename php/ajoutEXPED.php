<?php
session_start ();
include('../connexion/connexionDB.php');
$OF=$_POST['OF'];
$idEXP="EX".$OF;
$sql=mysql_query("select PO,date_exped_conf from ordre_fabrication1 where OF='$OF'");
$data=mysql_fetch_array($sql); 
$PO=$data['PO'];
$dateE=$data['date_exped_conf'];
 $sql = mysql_query("INSERT INTO expedition (idEXP,PO,OF,date_exp,date_crea) VALUES ('$idEXP','$PO','$OF','$dateE',NOW())");
 /////update commande item
$sql2=mysql_query("SELECT POitem,statut from commande_items where POitem='$PO'");
$data2=mysql_fetch_array($sql2);
$stat=$data2['statut'];

if($stat=="incomplete"){
	$statut="incomplete";
}else{
$statut="finished";
}
$sql11=mysql_query("UPDATE commande_items SET statut='$statut' where POitem='$PO'");


///Update OF 
if($stat != "planned"){
$sql11=mysql_query("UPDATE ordre_fabrication1 SET statut='finished',date_fin=NOW() where OF='$OF'");
}
echo("OK");
mysql_close();
 ?>