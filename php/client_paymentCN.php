<?php

include('../connexion/connexionDB.php');


    $CN = $_POST['fact'];
    $dateP = $_POST['dateP'];
   	
	

$sql = "UPDATE credit_note_starz SET statut='paid',dateP='$dateP' WHERE idCN='$CN'";

if (!mysql_query($sql)) {
die('Error: ' . mysql_error()); 
   
}else{


 
    header('Location: ../pages/client_payment.php?status=sent');
 
}  
mysql_close();
?>