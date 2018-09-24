<?php
session_start();
include('../connexion/connexionDB.php');
    $dateP = $_POST['dateP'];
    $nbrH = $_POST['nbrH'];
	$recherche=$_POST['recherche'];	
    $personnel=$_POST['P1'];
    $message=$_POST['message'];
	if($recherche != "matricule"){
        $sql2=mysql_query("select matricule from personnel_info where $recherche='$personnel'");
		$mat=mysql_result($sql2,0);
    }else{
        $mat=$personnel;
    }
	$sql=mysql_query("INSERT INTO personnel_permission(matricule,dateP,nbrH,message)VALUES ('$mat','$dateP','$nbrH','$message')");	
    header('Location: ../pages/ajout_permission.php?status=sent');



?>