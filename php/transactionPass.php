<?php
session_start();
include('../connexion/connexionDB.php');
    $userID=$_SESSION['userID'];	
    $IDtrans = $_POST['IDtrans'];    
    
	$sql1=mysql_query("SELECT * FROM transaction_compte WHERE IDtrans='$IDtrans'");
	$data1=mysql_fetch_array($sql1);
	$compte=$data1['compte'];
	$montant=$data1['montant'];
	$typeT=$data1['typeT'];
	$sql2=mysql_query("SELECT max(IDtrans) FROM transaction_compte");
	$nbr=mysql_result($sql2,0);
	$nbr++;
	
	$sql4=mysql_query("UPDATE transaction_compte SET etat='R',IDtrans='$nbr' WHERE IDtrans='$IDtrans'");
	if($typeT=='RT'){       
		$sql5=mysql_query("UPDATE compte_banque SET soldeR=soldeR-'$montant' WHERE REFcompte='$compte'");
	}else{
	    $sql5=mysql_query("UPDATE compte_banque SET soldeR=soldeR+'$montant' WHERE REFcompte='$compte'");
	}
	
	

	$msg="a validé  la transaction N° <b>".$IDtrans."</b> , son nouveau ID est devenue ".$nbr;
    $His=mysql_query("INSERT INTO historique(user_id,action,tab,ligne,date_heure)VALUES('$userID','$msg','transactionPass','$nbr',NOW())"); 
   

mysql_close();

?>