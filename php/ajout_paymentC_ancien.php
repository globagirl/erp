<?php
    session_start ();
    $userID=$_SESSION['userID'];
    include('../connexion/connexionDB.php');
    $refP = $_POST['refP'];
    $dateP =@$_POST['dateP'];
    $client =@$_POST['client'];
    $compte =@$_POST['compte'];
	$payT=0;
	$devise="Euro";
	echo('<div class="scrollY40"><table class="table"><tbody>');
	
	    //vente
	    echo('<tr><td ><b>Vente</b></tr>');
	    $sql1=mysql_query("SELECT num_fact,tot_val,IDpay,devise FROM fact1 where date_pay='$dateP' and statut='paid' and client='$client'");
		while($data1=mysql_fetch_array($sql1)){
		    $tot=$data1['tot_val'];
		    $payT=$payT+$tot;
		    echo('<tr><td>'.$data1['num_fact'].'</td><td>'.$data1['tot_val'].'</td></tr>');
			$devise=$data1['devise'];
		}
		//Achat
		echo('<tr><td ><b>Achat</b></tr>');
	    $sql2=mysql_query("SELECT IDinvoice,IDpay,total,currency,typeI FROM supplier_invoice where dateP='$dateP' and status='paid' and supplier LIKE 'TYCO ELECTRONIC LOGI'");
		while($data2=mysql_fetch_array($sql2)){
		    $tot=$data2['total'];
			$typeI=$data2['typeI'];
			if($typeI != 'Credit'){
		        $payT=$payT-$tot;
			}else{
			    $payT=$payT+$tot;
			}
		    echo('<tr><td>'.$data2['IDinvoice'].'</td><td>'.$data2['total'].'</td></tr>');
			$devise=$data2['currency'];
		}
		//Credit note starz
		echo('<tr><td ><b>Credit note STARZ</b></tr>');
	    $sql3=mysql_query("SELECT idCN,IDpay,amount,devise FROM credit_note_starz where dateP='$dateP' and statut='paid'");
		while($data3=mysql_fetch_array($sql3)){
		    echo('<tr><td>'.$data3['idCN'].'</td><td>'.$data3['amount'].'</td></tr>');
			$devise=$data3['devise'];
		}
	    $payT=round($payT,2);
	
	
		
    echo('</tbody></table></div>');
    echo('<hr><div class="form-group form-inline"><label> Total payment : <label>                             
     <input class="form-control" type="text" id="totalP" name="totalP"  value='.$payT.' READONLY>
	 <button type="button" class="btn btn-danger" onClick="valider_pay();">>> </button></div>');
?>