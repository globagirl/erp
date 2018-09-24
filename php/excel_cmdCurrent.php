<meta charset="utf-8" />
 <?php
 
  // The function header by sending raw excel
header("Content-type: application/vnd-ms-excel");
 
// Defines the name of the export file "codelution-export.xls"
header("Content-Disposition: attachment; filename=profits.xls");
    include('../connexion/connexionDB.php');
    echo "<table><tr><th>PO</th><th>Qty</th><th>date exped</th><th>Statut</th></tr>";
	$dateJ=date("Y-m-d");
    $jourJ=strtotime($dateJ);
    $num = strftime("%m",$jourJ);
	$year= strftime("%Y",$jourJ);
	$YN=$year."-".$num;

	//Not shipped yet 
	$qtyCMD=0;
	$nbrCMD=0;
	$req= mysql_query("SELECT date_exped,PO FROM commande2 where (client='1003' or client = '1004') and date_exped LIKE '$YN-%'");
	
	while($data=mysql_fetch_array($req)){	    
	    $PO=$data['PO'];
		$req1= mysql_query("SELECT qty,POitem,statut FROM commande_items where statut !='closed' and PO='$PO'");
		while($data1=mysql_fetch_array($req1)){
	        $nbrCMD++;
			echo "<tr><td>".$data1['POitem']."</td><td>".$data1['qty']."</td><td>".$data['date_exped']."</td><td>".$data1['statut']."</td></tr>";
			$qty=$data1['qty'];
	        $qtyCMD=$qtyCMD+$qty;
	    }
	}
	
	$req2= mysql_query("SELECT num_fact,date_E FROM fact1 where (client='1003' or client = '1004')  and date_E LIKE '%$YN-%'");
	while($data2=mysql_fetch_array($req2)){
	    $fact=$data2['num_fact'];
        $req3= mysql_query("SELECT qty,PO FROM fact_items where  idF='$fact'");
		while($data3=mysql_fetch_array($req3)){
	        $nbrCMD++;
			echo "<tr><td>".$data3['PO']."</td><td>".$data3['qty']."</td><td>".$data2['date_E']."</td><td>closed</td></tr>";
			$qty=$data3['qty'];
	        $qtyCMD=$qtyCMD+$qty;
	    }
	}
	echo "<tr><td><b> Total qty : ".$qtyCMD."</td><td><b> Total commande : ".$nbrCMD."</td></tr></table>"
	
?>