<?php

include('../connexion/connexionDB.php');

$invoice=$_POST['invoice'];

	$sql1 = mysql_query("SELECT * FROM supplier_invoice where IDinvoice='$invoice'");
	$data1=mysql_fetch_array($sql1);
    $IDinvoice=$invoice;
	$n=strpos($IDinvoice,"-");
	$four=$data1['supplier'];
    $IDinvoice=substr($IDinvoice,$n+1); 
	echo(" <div class=\"col-lg-12\" ><div class=\"row\"><div class=\"col-lg-12 well\" >Invoice N°: ".$IDinvoice."
    </div>
	<div class=\"col-lg-4 well\" > <b>Status: </b>".$data1['status']."</div>
	<div class=\"col-lg-4 well\" > <b>Shipment coast :</b>".$data1['shipCoast']."</div>
	<div class=\"col-lg-4 well\" ><b> Tax:</b>".$data1['tax']."</div>");
	$stat=$data1['status'];
	if($stat=='paid'){
	    $sql11 = mysql_query("SELECT * FROM invoice_mode_pay where num_invoice='$invoice'");
		echo '<div class="well" ><table  class="table table-fixed">
				<thead style="width:100%">       
			        <tr>
					<th style="width:19.8%;height:60px;text-align:center">Mode</th>
					<th style="width:24.8%;height:60px;text-align:center">Réference</th>
					<th style="width:19.8%;height:60px;text-align:center">Montant</th>
					<th style="width:34.8%;height:60px;text-align:center">Compte/Banque</th>
					</tr>
				</thead>
				<tbody>
					';
					
					
		while($data11=mysql_fetch_array($sql11)){
            $compte=$data11['compte'];	
            if($compte != ""){
			    $sql12 = mysql_query("SELECT NUMcompte,banque FROM compte_banque where REFcompte='$compte'");
				$data12=mysql_fetch_array($sql12);
                echo '<tr><td style="width:20%;height:60px;text-align:center">'.$data11['modeP'].'</td>
				<td style="width:25%;height:60px;text-align:center">'.$data11['reference'].'</td>
				<td style="width:20%;height:60px;text-align:center">'.$data11['montant'].'</td>
				<td style="width:35%;height:60px;text-align:center">'.$data12['NUMcompte'].' / '.$data12['banque'].' </td></tr>';
						
            }else{            			
	            echo '<tr><td style="width:20%;height:60px;text-align:center">'.$data11['modeP'].'</td>
				<td style="width:25%;height:60px;text-align:center"></td>
				<td style="width:20%;height:60px;text-align:center">'.$data11['montant'].'</td>
				<th style="width:35%;height:60px;text-align:center"></td></tr>';
			}
	    }
	    echo ('</tbody></table></div>');
	}
	mysql_close();
	//echo $invoice;
?>
