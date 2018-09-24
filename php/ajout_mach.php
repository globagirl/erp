<?php

include('../connexion/connexionDB.php');
    $num_serie = $_POST['num_serie'];
    $nom_machine = $_POST['nom_machine'];
    $departement = $_POST['departement'];
	$etat = $_POST['etat'];
	
	
	
	
$sql = "INSERT INTO machines (num_serie, nom_machine, departement, etat) 
VALUES ('$num_serie', '$nom_machine', '$departement', '$etat')";


if (!mysql_query($sql)) {
die('Error: ' . mysql_error()); 
    header('Location: ../pages/ajout_machine.php?status=fail');
}else{  
     header('Location: ../pages/ajout_machine.php?status=sent');
}  

?>