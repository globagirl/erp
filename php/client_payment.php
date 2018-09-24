<?php

include('../connexion/connexionDB.php');
    $fact = $_POST['fact'];

    $dateP = $_POST['dateP'];

	

$sql = "UPDATE fact1 SET statut='paid',date_pay='$dateP' WHERE num_fact='$fact'";

if (!mysql_query($sql)) {
die('Error: ' . mysql_error()); 
   
}else{

 
    header('Location: ../pages/client_payment.php?status=sent');
	 
} 
mysql_close(); 

?>