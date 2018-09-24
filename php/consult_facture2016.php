<meta charset="utf-8" />
 <?php
 
  // The function header by sending raw excel
header("Content-type: application/vnd-ms-excel");
 
// Defines the name of the export file "codelution-export.xls"
header("Content-Disposition: attachment; filename=facture2016.xls");
include('../connexion/connexionDB2.php');
$sql = mysql_query ("SELECT * FROM fact where date_fact LIKE '2016-%'");
echo '<table border="1"><tr><th>N° facture</th>
<th>Date facturation</th>
<th>PO</th>	
<th>Produit</th>
<th>Qty</th>
<th>Prix unitaire</th>
<th>Total</th>																  
<th>Devise</th>																  
</tr>';
while($data=@mysql_fetch_array($sql)){
    $prix=round($data['prix_uni'],4);
	$prix=str_replace(".",",",$prix);
	$tot=round($data['tot_val'],4);
	$tot=str_replace(".",",",$tot);
	echo '<tr>
	<td>'.$data['num_fact'].'</td>
	<td>'.$data['date_fact'].'</td>
	<td>'.$data['num_po'].'</td>
	<td>'.$data['ref'].'</td>
	<td>'.$data['qte'].'</td>
	<td>'.$prix.'</td>
	<td>'.$tot.'</td>
	<td>'.$data['devise'].'</td>
	</tr>';

}


echo '</table>';
mysql_close();

  ?>