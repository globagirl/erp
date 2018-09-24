
<?php
session_start();
include('../connexion/connexionDB.php');
    $idC = $_POST['idC'];
    $date1 = $_POST['date1'];
    $date2 = $_POST['date2'];		
    $numC=$_POST['numC']; 
    $contratT=$_POST['contratT']; 
    $comp=$_POST['comp']; 
    $req= mysql_query("UPDATE personnel_contrat SET numContrat='$numC',typeContrat='$contratT',dateD='$date1',dateF='$date2',company='$comp' WHERE idC='$idC'");
	header('Location: ../pages/consult_contrat.php');
?>