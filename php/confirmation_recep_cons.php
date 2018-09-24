<?php 
session_start();
 include('../connexion/connexionDB.php');
  $IDoperateur=$_SESSION['userID'];

 $sqlOP=mysql_query("select nom from users1 where ID='$IDoperateur'");
 $user=mysql_result($sqlOP,0);

$demande=$_POST['demande'];


$sql2 = "SELECT * FROM demande_items where IDdemande='$demande'";
$res = mysql_query($sql2) or exit(mysql_error());

while($data=mysql_fetch_array($res)) {

	
	$CONS=$data['IDconsommable'];
	$QTY=$data['qtyS'];
	

 

$sql3=mysql_query("UPDATE article1 SET stock=stock-'$QTY' WHERE code_article='$CONS'");


}

$sql7=mysql_query("UPDATE demande_consommable SET statut='C',dateC=NOW() WHERE IDdemande='$demande'");
//Notification
$msg= " ".$user."  a confirmé la reception de la demande de consommable  N°   ".$demande."";
 $sql4=mysql_query("INSERT INTO notification(emetteur, destinataire, message, dateN,chemin) VALUES ('$user','MAG','$msg',NOW(),'msg')");
 
 //Historique 
 $msg2= "  a confirmé la reception de la demande de consommable  N°   ".$demande."";
 $HIS=mysql_query("INSERT INTO historique(user_id,action,tab,ligne,date_heure)VALUES('$IDoperateur','$msg2','sortie consommable','$idD',NOW())"); 
header('Location: ../pages/confirmation_recep_cons.php?status=sent');
mysql_close();
?>