<?php
    include('../connexion/connexionDB.php');
    $typeF = $_POST['typeF'];
    $numF = $_POST['numF'];
	$banque= $_POST['banque'];	
	$devise=$_POST['devise'];	
	$solde=$_POST['solde'];	    
    $etat=$_POST['etat'];  
   
	$sql=mysql_query("INSERT INTO compte_banque(REFcompte,NUMcompte,banque,devise,solde,etat)
	VALUES ('$refC','$numC','$banque','$devise','$solde','$etat')");	
	mysql_close();
    header('Location: ../pages/ajout_compte.php?status=sent');



?>