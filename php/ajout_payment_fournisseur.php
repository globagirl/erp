<?php
    session_start ();
    $userID=$_SESSION['userID'];
    include('../connexion/connexionDB.php');
    $refP = $_POST['refP'];
    $dateP =@$_POST['dateP'];
    $four =@$_POST['four'];
    $compte =@$_POST['compte'];
    $note =@$_POST['note'];
	$payT=0;
	$devise="EUR";
	echo('<div class="scrollY40"><table class="table"><tbody>');
	 
	$sql=mysql_query("SELECT solde,IDpay FROM payment_fournisseur where IDpay='$refP'");
	if(mysql_num_rows($sql)>0){
	   
		//Achat
		echo('<tr><td ><b>Achat</b></tr>');
	    $sql2=mysql_query("SELECT IDinvoice,IDpay,total,currency FROM supplier_invoice where IDpay='$refP'");
		while($data2=mysql_fetch_array($sql2)){
		    echo('<tr><td>'.$data2['IDinvoice'].'</td><td>'.$data2['total'].'</td></tr>');
			$devise=$data2['currency'];
		}
		//Credit note starz
		echo('<tr><td ><b>Credit note STARZ</b></tr>');
	    $sql3=mysql_query("SELECT idCN,IDpay,amount,devise FROM credit_note_starz where IDpay='$refP'");
		while($data3=mysql_fetch_array($sql3)){
		    echo('<tr><td>'.$data3['idCN'].'</td><td>'.$data3['amount'].'</td></tr>');
			$devise=$data3['devise'];
		}
		$data=mysql_fetch_array($sql);
		$payT=$data['solde'];
	
	}else{	
	    
	    $sql1=mysql_query("INSERT INTO payment_fournisseur(IDpay, dateP, dateE, fournisseur,compte,operateur)
	    VALUES ('$refP','$dateP',NOW(),'$four','$compte','$userID')");
	}	
    echo('</tbody></table></div>');
    echo('<hr><div><h2>'.$payT.' '.$devise.'</h2></div>');
?>