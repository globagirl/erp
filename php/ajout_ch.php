<?php

include('../connexion/connexionDB.php');
    $ch_id = $_POST['ch_id'];
    $nom = $_POST['nom'];
    $dep = $_POST['dep'];
	$type = $_POST['type'];
	$chef_lig = $_POST['chef_lig'];

	
$sql = "INSERT INTO ajout_chaine (ch_id, nom, dep, type) VALUES ('$ch_id', '$nom', '$dep', '$type')";


if (!mysql_query($sql)) {
die('Error: ' . mysql_error()); 
    header('Location: ../pages/ajout_chaine.php?status=fail');
}else{  
     header('Location: ../pages/ajout_chaine.php?status=sent');
}  

?>