<?php
session_start();
 $IDoperateur=$_SESSION['userID'];
 include('../connexion/connexionDB.php');
 $sqlOP=mysql_query("select nom from users1 where ID='$IDoperateur'");
 $demandeur=mysql_result($sqlOP,0);
    $PO = $_POST['PO'];
	$qty = $_POST['qty'];
	$cause= $_POST['cause'];
	$detail= $_POST['detail'];
	$produit = $_POST['produit'];
    $nbr=$_POST['nbr'];
	$IDR=$_POST['IDR'];
		
$sql = "INSERT INTO demande_relance(IDrelance,cause, detail, demandeur, qty, statut, PO, produit, dateD) VALUES ('$IDR','$cause', '$detail', '$demandeur', '$qty', 'D', '$PO', '$produit', NOW())";


if (!mysql_query($sql)) {
die('Error: ' . mysql_error()); 
    header('Location: ../pages/relance_demande.php?status=fail');
}else{
$i=0;
while($nbr>$i){
$i++;
 $a="a".$i;
 $q="q".$i;


 $v1=$_POST[$a];
 $v2=$_POST[$q];


	$sql2=mysql_query("INSERT INTO demande_relance_items(IDrelance,item,qty)
	VALUES ('$IDR','$v1','$v2')");
 
}
  $msg= " ".$demandeur."  a déclaré une nouvelle demande de relance <br> Demande ID :  ".$IDR."";
  $sql4=mysql_query("INSERT INTO notification(emetteur, destinataire, message, dateN,chemin) VALUES ('$demandeur','LOG','$msg',NOW(),'relance_confirmation1.php')");
  $His=mysql_query("INSERT INTO historique(user_id,action,tab,ligne,date_heure)VALUES('$IDoperateur','add','demande relance','$IDR',NOW())"); 
    header('Location: ../pages/relance_demande.php?status=sent');
	
   
}  

?>