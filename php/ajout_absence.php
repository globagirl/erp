<?php
session_start();
include('../connexion/connexionDB.php');
    $date1 = $_POST['date1'];
    $date2 = $_POST['date2'];
	$v1= $_POST['P1'];
	
	$recherche=$_POST['recherche'];	
	$etat=$_POST['etat'];	
    
    $nbrH=$_POST['nbrH'];
  

$i=0;

 
 if($recherche != "matricule"){
 $sql2=mysql_query("select matricule from personnel_info where $recherche='$v1'");
 $mat=mysql_result($sql2,0);
 }else{
 $mat=$v1;
 }
    $idAB=$mat."-".$dateD;
	$sql=mysql_query("INSERT INTO personnel_absence(idAB,matricule,nbrH,dateD,dateF,etat)
	VALUES ('$idAB','$mat','$nbrH','$date1','$date2','$etat')");

///////////FIN///////	
	
    header('Location: ../pages/ajout_absence.php?status=sent');



?>