<?php
session_start();
include('../connexion/connexionDB.php');
$userid=$_SESSION['userID'];
$idPC=$_POST['idPC'];

$sql1=mysql_query("SELECT * FROM personnel_conge WHERE idPC='$idPC'");
$data=mysql_fetch_array($sql1);
$sql2=mysql_query("DELETE FROM personnel_conge WHERE idPC='$idPC'");

//Historique
$msg="a supprimé l avance du personnel N° ".$data['matricule']." , Date debut :".$data['dateD']." ,Date fin :".$data['dateF']." , Montant : ".$data['montant'];
$His=mysql_query("INSERT INTO historique(user_id,action,tab,ligne,date_heure)VALUES('$userid','$msg','avance','$idPC',NOW())");  

?>