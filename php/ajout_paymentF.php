<?php
    include('../connexion/connexionDB.php');
    $typeF = $_POST['typeF'];
    $numF = $_POST['numF'];
    $refP = $_POST['refP'];
    $dateP = $_POST['dateP'];
	if($typeF=='V'){
	    $sql1=mysql_query("SELECT tot_val FROM fact1 where num_fact='$numF'");
		$montant=mysql_result($sql1,0);
	    $sql2=mysql_query("UPDATE fact1 SET statut='paid',date_pay='$dateP',IDpay='$refP' where num_fact='$numF'");
	    $sql3=mysql_query("UPDATE payment_client SET solde=solde+'$montant' where IDpay='$refP'");
	}else if($typeF=='A'){
	    $sql1=mysql_query("SELECT total,typeI FROM supplier_invoice where IDinvoice LIKE '%-$numF'");
		//$montant=mysql_result($sql1,0);
		$data=mysql_fetch_array($sql1);
		$montant=$data['total'];
		$typeI=$data['typeI'];
	    $sql2=mysql_query("UPDATE supplier_invoice SET status='paid',dateP='$dateP',IDpay='$refP',mode_pay='Compte client' where IDinvoice LIKE '%-$numF'");

		    $sql3=mysql_query("UPDATE payment_fournisseur SET solde=solde+'$montant' where IDpay='$refP'");

	}else if($typeF=='FE'){
	    $sql1=mysql_query("SELECT montant FROM facture_echantillon  where numFact='$numF'");
		$montant=mysql_result($sql1,0);
	    $sql2=mysql_query("UPDATE  facture_echantillon  SET statut='paid',dateP='$dateP',IDpay='$refP' where numFact='$numF'");
		$sql3=mysql_query("UPDATE payment_client SET solde=solde+'$montant' where IDpay='$refP'");
	}else if($typeF=='CN'){
	    $sql1=mysql_query("SELECT amount FROM credit_note_starz  where idCN='$numF'");
		$montant=mysql_result($sql1,0);
	    $sql2=mysql_query("UPDATE credit_note_starz  SET statut='paid',dateP='$dateP',IDpay='$refP' where idCN='$numF'");
		$sql3=mysql_query("UPDATE payment_client SET solde=solde-'$montant' where IDpay='$refP'");
	}
?>
