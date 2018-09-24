<?php
// The function header by sending raw excel
header("Content-type: application/vnd-ms-excel");
 
// Defines the name of the export file "codelution-export.xls"
header("Content-Disposition: attachment; filename=planning.xls");
 
// Add data table
?>

<meta charset="utf-8" />
<table border="1">
    <tr>
    	
	<th>Catégories </th> 
    <th>Num° OF </th> 
  <th>Num° PO</th> 
  <th>Code Produit </th> 
  <th>Longueur </th> 
  <th>QTY</th> 
  <th>Date d'échéance </th> 
 <th>Signature </th> 
	</tr>
	<?php
	    $d= @$_POST['dat_exp'];
       
	//connection to mysql
	include('../connexion/connexionDB.php');
	
	//query get data
	$sql = mysql_query ("SELECT * FROM ordre_fabrication1  WHERE date_exped_conf= '$d' ORDER BY (select categorie from produit1 where produit1.code_produit= ordre_fabrication1.produit) ASC");
 
	while($data = mysql_fetch_assoc($sql)){
	$produit=$data['produit'];
 $PO=$data['PO'];
 $sql2 = mysql_query ("SELECT * FROM produit1  WHERE code_produit= '$produit' ");
 $row3 = @mysql_fetch_array($sql2);

		echo '
		<tr>
			
			<td>'.$row3['categorie'].'</td>
			<td>'.$data['OF'].'</td>
			<td>'.$data['PO'].'</td>
			<td>'.$data['produit'].'</td>
			<td>'.$row3['longueur'].'</td>
			<td>'.$data['qte'].'</td>
			<td>'.$data['date_exped_conf'].'</td>
			<td></td>
			
		</tr>
		';
		
	}
	?>