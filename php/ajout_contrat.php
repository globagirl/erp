<?php
session_start();
include('../connexion/connexionDB.php');
    $date1 = $_POST['date1'];
    $date2 = $_POST['date2'];
	$contratID= $_POST['IDcontrat'];	
	$recherche=$_POST['recherche'];	
    $contratT=$_POST['contratT']; 
    $comp=$_POST['comp']; 
    $v1=$_POST['P1'];
 if($recherche != "matricule"){
 $sql2=mysql_query("select matricule from personnel_info where $recherche='$v1'");
 $mat=mysql_result($sql2,0);
 }else{
 $mat=$v1;
 }
	$sql=("INSERT INTO personnel_contrat(numContrat,typeContrat,dateD,dateF,matricule,company)
	VALUES ('$contratID','$contratT','$date1','$date2','$mat','$comp')");
	if (!mysql_query($sql)) {
die('Error: ' . mysql_error()); 
}else{
$sql3=mysql_query("UPDATE personnel_info SET contrat='$contratT' where matricule='$mat'");
 header('Location: ../pages/ajout_contrat.php?status=sent');
}


?>