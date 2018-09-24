<?php
session_start();
include('../connexion/connexionDB.php');
$userid=$_SESSION['userID'];
$ord=$_POST['ord'];

$sq=mysql_query("DELETE FROM ordre_achat_article1 where IDordre='$ord'");

$sq3=mysql_query("DELETE FROM ordre_prevision WHERE IDordre='$ord'");
$sq2=mysql_query("DELETE FROM ordre_achat2 WHERE IDordre='$ord'");
//Historique
$msg="a supprimé l'ordre d'achat N° <b>".$ord."</b>";
$His=mysql_query("INSERT INTO historique(user_id,action,tab,ligne,date_heure)VALUES('$userid','$msg','ordre_achat2','$ord',NOW())"); 
header('Location: ../pages/delete_ordre_achat.php');
?>