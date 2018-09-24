<?php
    session_start ();
    $userID=$_SESSION['userID'];
    include('../connexion/connexionDB.php');
    $refP = $_POST['refP'];
    $dateP =@$_POST['dateP'];
    $client =@$_POST['client'];
    $compte =@$_POST['compte'];
	$payT=0;
	$devise="EUR";
	echo('<div class="scrollY40"><table class="table"><tbody>');

	$sql=mysql_query("SELECT solde,IDpay FROM payment_client where IDpay='$refP'");
	if(mysql_num_rows($sql)>0){
	    //vente
	    echo('<tr><td ><b>Vente</b></tr>');
	    $sql1=mysql_query("SELECT num_fact,tot_val,IDpay,devise FROM fact1 where IDpay='$refP' order by num_fact DESC");
		while($data1=mysql_fetch_array($sql1)){
		    echo('<tr><td>'.$data1['num_fact'].'</td><td>'.$data1['tot_val'].'</td></tr>');
			$devise=$data1['devise'];
		}
		//Achat
		echo('<tr><td ><b>Achat</b></tr>');
	    $sql2=mysql_query("SELECT IDinvoice,IDpay,total,currency FROM supplier_invoice where IDpay='$refP'");
		while($data2=mysql_fetch_array($sql2)){
		    echo('<tr><td>'.$data2['IDinvoice'].'</td><td>'.$data2['total'].'</td></tr>');
			$devise=$data2['currency'];
		}
		//Facture echantillant
		echo('<tr><td ><b>Facture echantillant</b></tr>');
	    $sql3=mysql_query("SELECT numFact,IDpay,montant,devise FROM facture_echantillon where IDpay='$refP'");
		while($data3=mysql_fetch_array($sql3)){
		    echo('<tr><td>'.$data3['numFact'].'</td><td>'.$data3['montant'].'</td></tr>');
			$devise=$data3['devise'];
    }
      //
      //Credit note starz
  		echo('<tr><td ><b>Credit note STARZ</b></tr>');
  	    $sql4=mysql_query("SELECT idCN,IDpay,amount,devise FROM credit_note_starz where IDpay='$refP'");
  		while($data4=mysql_fetch_array($sql4)){
  		    echo('<tr><td>'.$data4['idCN'].'</td><td>'.$data4['amount'].'</td></tr>');
  			$devise=$data4['devise'];
		}
		$data=mysql_fetch_array($sql);
		$payT=$data['solde'];

	}else{

	    $sql1=mysql_query("INSERT INTO payment_client(IDpay, dateP, dateE, client,compte,operateur)
	    VALUES ('$refP','$dateP',NOW(),'$client','$compte','$userID')");
	}
    echo('</tbody></table></div>');
    echo('<hr><div><h2>'.$payT.' '.$devise.'</h2></div>');
?>
