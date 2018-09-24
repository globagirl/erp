<?php
include('../connexion/connexionDB.php');
    $num_cin = $_POST['num_cin'];
    $nom = $_POST['nom'];
	$prenom = $_POST['prenom'];
	$tache = $_POST['tache'];
	
	
	
$sql = "INSERT INTO ouvrier (num_cin, nom,prenom, tache) 
VALUES ('$num_cin', '$nom', '$prenom', '$tache')";


if (!mysql_query($sql)) {
die('Error: ' . mysql_error()); 
    header('Location: ../pages/ajout_ouvr.php?status=fail');
}else{  
     header('Location: ../pages/ajout_ouvr.php?status=sent');
}  

?>