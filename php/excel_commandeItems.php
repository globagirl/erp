 <?php
  // The function header by sending raw excel
header("Content-type: application/vnd-ms-excel");
 
// Defines the name of the export file "codelution-export.xls"
header("Content-Disposition: attachment; filename=commandes.xls");
include('../connexion/connexionDB.php');

 $valeur=$_POST['search'];






  echo'<table  id="myTable" class="tablesorter" cellspacing="0" cellpadding="0"><thead><tr><td>PO</td><td>Produit</td><td>Quantité</td>
<td>Date Expédition</td><td>statut</td>
  
  </tr>';
  
 
    $req= mysql_query("SELECT * FROM commande2  order by date_exped DESC");
   $nbrL=@mysql_num_rows($req);
   while($a=@mysql_fetch_object($req))
    {

    $PO =$a->PO;    
	$dateE=$a->date_exped;	
	$req1= mysql_query("SELECT * FROM commande_items where PO='$PO'");
	while($data=@mysql_fetch_array($req1)){
	$prd=$data['produit'];
	$qte=$data['qty'];
	$stat=$data['statut'];
	$val=$PO.$dateE.$prd.$qte.$stat;
	$pos = strpos($val, $valeur);
	if($pos != false){
	echo('<tr>
	<td >'.$PO.'</td>
	<td >'.$data['produit'].'</td>
	<td>'.$data['qty'].'</td>
	<td>'.$dateE.'</td>
	<td>'.$data['statut'].'</td>
    </tr>
	');
	}
	}
	
	}	
  
  echo '</thead></table>';

//echo($val);

  ?>