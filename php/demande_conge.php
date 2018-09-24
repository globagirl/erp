<?php
session_start();
include('../connexion/connexionDB.php');
    $userID=$_SESSION['userID'];
    $matricule =$_POST['matricule'];
    $typeC = $_POST['typeC'];    
    $nbrH = $_POST['nbrH'];    
    $dateD = $_POST['dateD'];
    $dateF =@$_POST['dateF'];
	if($dateF==""){
	$dateF=$dateD;
	}

    $sql=mysql_query("INSERT INTO personnel_demande_conge(matricule, typeC, dateD, dateF, dateE,nbrH,demandeur) VALUES ('$matricule','$typeC','$dateD','$dateF',NOW(),'$nbrH','$userID')");

	
    header('Location: ../pages/demande_conge.php');



?>