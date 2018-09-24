<?php
session_start();
include('../connexion/connexionDB.php');
    $dateM = $_POST['dateM'];
	$montant= $_POST['montant'];
	$nom= $_POST['nom'];
	$recherche=$_POST['recherche'];	
    $nbr=$_POST['nbr'];
  

$i=0;


while($nbr>$i){
 $i++; 
 $P="P".$i; 
 $v1=$_POST[$P];
 if($recherche != "matricule"){
 $sql2=mysql_query("select matricule from personnel_info where $recherche='$v1'");
 $mat=mysql_result($sql2,0);
 }else{
 $mat=$v1;
 }
	$sql=mysql_query("INSERT INTO personnel_mise(matricule, dateM,montant)
	VALUES ('$mat','$dateM','$montant')");
 
}


	
///////////FIN///////	
	
    header('Location: ../pages/ajout_avance.php?status=sent');



?>