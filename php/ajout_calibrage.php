<?php
session_start();
include('../connexion/connexionDB.php');
    $IDmat = $_POST['IDmat'];	
	$dateC = $_POST['dateC'];
	$resultat = $_POST['resultat'];
    $certID= $_POST['certID'];	
	//Operator	
 $IDuser=$_SESSION['userID'];
 $sqlOP=mysql_query("select nom from users1 where ID='$IDuser'");
 $user=mysql_result($sqlOP,0);
		
$sql ="INSERT INTO calibrage(IDmat, dateC, dateE, operateur, resultat,certID) VALUES ('$IDmat','$dateC',NOW(),'$user','$resultat','$certID')";


if (!mysql_query($sql)) {
die('Error: ' . mysql_error()); 
}else{
$sql1 = mysql_query("UPDATE materiel SET etatMat='$resultat',lastCal='$dateC' WHERE IDmat='$IDmat'");
header('Location: ../pages/ajout_calibrage.php');	
}

  

?>