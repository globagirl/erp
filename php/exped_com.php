<?php
include('../connexion/connexionDB.php');


    $num_of = $_POST['num_of'];
	// $date_crea = $_POST['date_crea'];
    $num_po = $_POST['num_po_client'];
    $code_artic = $_POST['code_artic'];
	$descrip = $_POST['descrp'];
	$qte = $_POST['qte_of'];
	$date_exped = $_POST['date_exped'];
	

	
	
$sql = "INSERT INTO exped_com (num_of, date_crea, num_po, code_artic, descrip, qte, date_exped) 
VALUES ('$num_of', CURRENT_TIMESTAMP(), '$num_po', '$code_artic', '$descrip', '$qte', '$date_exped')";


if (!mysql_query($sql)) {
die('Error: ' . mysql_error()); 
    header('Location: ../pages/expedition.php?status=fail');
}else{  
     header('Location: ../pages/expedition.php?status=sent');
}  

?>