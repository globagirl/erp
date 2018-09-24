<?php
    session_start ();
    $userID=$_SESSION['userID'];
    include('../connexion/connexionDB.php');
    $refP = $_POST['refP'];
    $dateP =@$_POST['dateP'];
    $client =@$_POST['client'];
    $compte =@$_POST['compte'];
    $totalP =@$_POST['totalP'];
	$payT=0;
	
	//Ajout payment
	$sql=mysql_query("INSERT INTO payment_client(IDpay, dateP, dateE, client,compte,solde,operateur)
	    VALUES ('$refP','$dateP',NOW(),'$client','$compte','$totalP','$userID')");
	
	//Vente
	$sql1=mysql_query("UPDATE fact1 SET IDpay='$refP' where date_pay='$dateP' and statut='paid' and client='$client'");
	
	//Achat
    $sql2=mysql_query("UPDATE supplier_invoice  SET IDpay='$refP' where dateP='$dateP' and status='paid' and supplier='TYCO ELECTRONIC LOGI'");
	mysql_close();
	header('Location: ../pages/payment_client_ancien.php');	

?>