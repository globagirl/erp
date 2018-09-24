<?php
session_start();
include('../connexion/connexionDB.php');
$userid=$_SESSION['userID'];
$idPA=$_POST['idPA'];

$sql1=mysql_query("SELECT * FROM personnel_avance WHERE idPA='$idPA'");
$data=mysql_fetch_array($sql1);
$sql2=mysql_query("DELETE FROM personnel_avance WHERE idPA='$idPA'");

//Historique
$msg="a supprimé l avance du personnel N° ".$data['matricule']." , Date avance :".$data['dateA']." , Montant : ".$data['montant'];
$His=mysql_query("INSERT INTO historique(user_id,action,tab,ligne,date_heure)VALUES('$userid','$msg','avance','$idPA',NOW())");  

?>