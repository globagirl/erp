<?php
session_start();
include('../connexion/connexionDB.php');
    $IDmat = $_POST['IDmat'];
	$desc= $_POST['desc'];	
	$dateC = $_POST['dateC'];
	$cal = $_POST['cal'];
	$certID = $_POST['certID'];

	
		
$sql = "INSERT INTO materiel(IDmat, description, etatMat, calibrage) VALUES ('$IDmat','$desc','Conform','$cal')";


if (!mysql_query($sql)) {
die('Error: ' . mysql_error()); 
}else{
//Operator	
 $IDuser=$_SESSION['userID'];
 $sqlOP=mysql_query("select nom from users1 where ID='$IDuser'");
 $user=mysql_result($sqlOP,0);	
//Calibrage 
 $req=mysql_query("INSERT INTO calibrage(IDmat, dateC, dateE, operateur, resultat,certID) VALUES ('$IDmat','$dateC',NOW(),'$user','Conform','$certID')");

 

foreach($_POST['A'] as $alert){

$req1=mysql_query("INSERT INTO rappel_calibrage(IDmat,rappel) VALUES ('$IDmat','$alert')");
}

header('Location: ../pages/ajout_materiel.php');	
}

  

?>