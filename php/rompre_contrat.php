<?php
session_start();
include('../connexion/connexionDB.php');
    $contratID = $_POST['contratID'];
 
	$sql=("UPDATE personnel_contrat SET etat='rompu' where idC='$contratID'");
	if (!mysql_query($sql)) {
die('Error: ' . mysql_error()); 
}else{
 header('Location: ../pages/rompre_contrat.php?status=sent');
}


?>