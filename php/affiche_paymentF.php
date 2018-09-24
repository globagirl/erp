<?php
    include('../connexion/connexionDB.php');
    $typeF = $_POST['typeF'];
    $numF = $_POST['numF'];

    if($typeF=='V'){
	    $sql1=mysql_query("SELECT num_fact,tot_val,statut FROM fact1 where num_fact='$numF'");
	}else if($typeF=='A'){
	    $sql1=mysql_query("SELECT IDinvoice,total,status FROM supplier_invoice where IDinvoice LIKE '%-$numF'");
	}else if($typeF=='FE'){
	    $sql1=mysql_query("SELECT numFact,montant,statut FROM facture_echantillon where numFact='$numF'");
	}else if($typeF=='CN'){
	    $sql1=mysql_query("SELECT idCN,amount,statut FROM credit_note_starz where idCN='$numF'");
	}

	if(mysql_num_rows($sql1)>0){
	    $data1=mysql_fetch_array($sql1);
	    if($typeF=='V'){
	        $val=$data1['tot_val'];
	        $stat=$data1['statut'];
	    }else if($typeF=='A'){
	        $val=$data1['total'];
			$stat=$data1['status'];
    }else if($typeF=='FE'){
	        $val=$data1['montant'];
			$stat=$data1['statut'];
	    }else if($typeF=='CN'){
	        $val=$data1['amount'];
			$stat=$data1['statut'];
	    }
		echo '<div class="alert alert-success col-lg-10"><b> Montant : '.$val.'</b>';
		if($stat=='unpaid'){
		    echo '<span class="pull-right"><button type="button" class="btn btn-success" onClick="ajoutFacture();">Payer >> </button><br></span></div>';
		}else{
			echo '<br>Facture déja payé !!</div>';
		}
	}else{
	    echo '<div class="alert alert-danger"><b>Facture introuvable !! </b></div>';
	}

  mysql_close();
?>
