<?php
session_start();
include('../connexion/connexionDB.php');
    $num_cin = $_POST['num_cin'];
    $nom = $_POST['nom'];
	$prenom = $_POST['prenom'];
	$tache = $_POST['tache'];
	
	
	
$sql = "INSERT INTO agent_qual (cin, nom,prenom, tache) VALUES ('$num_cin', '$nom', '$prenom', '$tache')";


if (!mysql_query($sql)) {
die('Error: ' . mysql_error()); 
    header('Location: ../pages/ajout_ag_qual.php?status=fail');
}else{  
     header('Location: ../pages/ajout_ag_qual.php?status=sent');
	 $userid=$_SESSION['userID'];
$req=mysql_query("INSERT INTO historique(user_id,action,tab,ligne,date_heure)
VALUES('$userid','add','agent_qual','$num_cin',NOW())"); 
}  

?>