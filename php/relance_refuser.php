<?php
session_start();
 $IDoperateur=$_SESSION['userID'];
 include('../connexion/connexionDB.php');
 $sqlOP=mysql_query("select nom from users1 where ID='$IDoperateur'");
 $user=mysql_result($sqlOP,0);
   
	$demande=$_POST['demande'];
		
$sql = "UPDATE demande_relance SET statut='R',dateV=NOW(),verificateur='$user' WHERE IDrelance='$demande'";


if (!mysql_query($sql)) {
die('Error: ' . mysql_error()); 
    header('Location: ../pages/relance_confirmation.php?status=fail');
}else{
  $His=mysql_query("INSERT INTO historique(user_id,action,tab,ligne,date_heure)VALUES('$IDoperateur','add','refuser relance','$demande',NOW())"); 
    header('Location: ../pages/relance_confirmation.php?status=sent');
	
   
}  

?>