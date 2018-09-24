<?php
session_start();
include('../connexion/connexionDB.php');
$userid=$_SESSION['userID'];
$IDrelance=$_POST['IDrelance'];

$sql = mysql_query("UPDATE bande_relance SET statut='R',IDvalidateur='$userid',dateV=NOW() where IDrelance='$IDrelance'");

//Historique
    
	$msg="a refusé la bande relance N° <b>".$IDrelance."</b>";
    $His=mysql_query("INSERT INTO historique(user_id,action,tab,ligne,date_heure)VALUES('$userid','$msg','bande_relance','$IDrelance',NOW())"); 
	//
	mysql_close();
	//
	//header('Location: ../pages/bande_relance_info.php');
?>