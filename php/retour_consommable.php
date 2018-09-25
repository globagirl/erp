<?php
session_start();
$IDoperateur=$_SESSION['userID'];
include('../connexion/connexionDB.php');
$sqlOP=mysql_query("select nom from users1 where ID='$IDoperateur'");
$magazigner=mysql_result($sqlOP,0);
$qty=$_POST['qty'];
$nom=$_POST['nom'];
$dateR=$_POST['dateR'];
$idCons=$_POST['idCons'];
$sql3=mysql_query("INSERT INTO retour_consommable(IDconsommable, qty, dateR, operateur,magazigner) VALUES ('$idCons','$qty','$dateR','$nom','$magazigner')");
$sql3=mysql_query("UPDATE article1 SET stock=stock+'$qty' WHERE code_article='$idCons'");
header('Location: ../pages/retour_consommable.php?status=sent');
?>