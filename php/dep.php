<?php

include('../connexion/connexionDB.php');
    $dep_id = $_POST['dep_id'];
    $nom = $_POST['nom'];
    $chef_dep = $_POST['chef_dep'];
	$nbr_opr = $_POST['nbr_opr'];
	$nbr_tech = $_POST['nbr_tech'];
	
	
	
	
$sql = "INSERT INTO ajout_departement (dep_id, nom, chef_dep, nbr_opr,nbr_tech) 
VALUES ('$dep_id', '$nom', '$chef_dep', '$nbr_opr','$nbr_tech')";


if (!mysql_query($sql)) {
die('Error: ' . mysql_error()); 
    header('Location: ../pages/ajout_dep.php?status=fail');
}else{  
     header('Location: ../pages/ajout_dep.php?status=sent');
}  

?>