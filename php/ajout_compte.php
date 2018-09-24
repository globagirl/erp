<?php
    include('../connexion/connexionDB.php');
    $refC = $_POST['refC'];
    $numC = $_POST['numC'];
	$banque= $_POST['banque'];	
	$devise=$_POST['devise'];	
	$solde=$_POST['solde'];	    
    $etat=$_POST['etat'];  
   
	$sql=mysql_query("INSERT INTO compte_banque(REFcompte,NUMcompte,banque,devise,solde,etat)
	VALUES ('$refC','$numC','$banque','$devise','$solde','$etat')");	
    header('Location: ../pages/ajout_compte.php?status=sent');



?>