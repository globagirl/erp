<?php
session_start();
include('../connexion/connexionDB.php');
    $nomF = $_POST['nomF'];	
	$desc = $_POST['desc'];
	$f1 = $_POST['f1'];
    $f2= $_POST['f2'];	

		
$sql ="INSERT INTO formation_starz(nomF, descF, formateur1, formateur2) VALUES ('$nomF','$desc','$f1','$f2')";


if (!mysql_query($sql)) {
die('Error: ' . mysql_error()); 
}else{

header('Location: ../pages/ajout_formation.php');	
}

  

?>