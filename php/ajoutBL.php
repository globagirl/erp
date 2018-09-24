<?php 
include('../connexion/connexionDB.php');
$OF=$_POST['OF'];
$sql8 = mysql_query("SELECT max(num_bl) FROM bon_livr ");
$max=mysql_result($sql8,0);	
$BL=$max+1;
$sql = mysql_query("SELECT * FROM ordre_fabrication1 where OF='$OF'");
$data=mysql_fetch_array($sql);
$PO=$data['PO'];
$sql1 = mysql_query("SELECT * FROM commande2 where PO='$PO'");
$data1=mysql_fetch_array($sql1);

$client=$data1['client'];
$sq=mysql_query("select * from client1 where name_client='$client'");
$data2=mysql_fetch_array($sq);


$produit=$data['produit'];
$qte=$data['qte'];
$dateEX=$data['date_exped_conf'];
$adliv=$data2['adress_liv'];
$adfact=$data2['adress_fact'];
$sql8 = mysql_query("SELECT * FROM produit1 where code_produit='$produit'");
$data3=mysql_fetch_array($sql8);
$desc=$data3['description'];
$qtbP=$data3['nbr_box'];
//$nbrLot=$data['nbr_plan'];
if($qtbP>$qte){
$box=1;

}else{
$box=$qte/$qtbP;

}
$sql99 = mysql_query("INSERT INTO bon_livr (num_bl, num_po, OF,date_bl, adress_fact, date_liv, adress_liv, reference, descrp, qtu,etat_fact,nbr_box) 
VALUES ('$BL', '$PO','$OF', NOW(), '$adfact', '$dateEX', '$adliv', '$produit', '$desc', '$qte','unbilled','$box')");

$sql=mysql_query("SELECT statut from commande2 where PO='$PO'");
$stat=mysql_result($sql,0);

if($stat=="incomplete"){
	$statut="incomplete";
}else{
	$statut="unbilled";
	}
$sql11=mysql_query("UPDATE commande2 SET statut='$statut' where PO='$PO'");
$sql11=mysql_query("UPDATE ordre_fabrication1 SET statut='closed' where OF='$OF'");
echo("OK");
?>