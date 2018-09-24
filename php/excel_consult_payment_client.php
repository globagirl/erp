<meta charset="utf-8" />
 <?php
 
  // The function header by sending raw excel
header("Content-type: application/vnd-ms-excel");
 
// Defines the name of the export file "codelution-export.xls"
header("Content-Disposition: attachment; filename=payment client.xls");
include('../connexion/connexionDB.php');
    
    $val1=@$_POST['valeur1'];
    $val2=@$_POST['valeur2'];
    $recherche=@$_POST['recherche'];  
	
    if ($recherche=="A"){
        $req= "SELECT * FROM payment_client";
    }else if($recherche=="dateE" || $recherche=="dateP"){
        $req= "SELECT * FROM payment_client where $recherche >= '$val1' and $recherche <= '$val2'";
    }else{
		$req= "SELECT * FROM payment_client where $recherche LIKE '$val1'";
	}
	 echo '<table>
			    <tr>
					<th>N° payment</th>
					<th>Client</th>
					<th>Date payment</th>
					<th>Compte</th>
				    <th>Montant</th>
					</tr>';
	
    $r=mysql_query($req) or die(mysql_error());
	$x=0;
    while($a=mysql_fetch_array($r)){       
	    $x++;
        $IDpay=$a['IDpay'];	
        $solde=$a['solde'];		
        $solde=str_replace(".",",",$solde);		
		echo ('<tr>
		<td>'.$a['IDpay'].'</td>
		<td>'.$a['client'].'</td>
		<td>'.$a['dateP'].'</td>
		<td>'.$a['compte'].'</td>
		<td>'.$solde.'</td></tr>');
		
    }
  

echo '</table>';

  ?>