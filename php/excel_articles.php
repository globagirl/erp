<meta charset="utf-8" />
 <?php
  // The function header by sending raw excel
header("Content-type: application/vnd-ms-excel");
 
// Defines the name of the export file "codelution-export.xls"
header("Content-Disposition: attachment; filename=articles.xls");
include('../connexion/connexionDB.php');

 $DD=@$_POST['date1'];
 $DF=@$_POST['date2'];

  echo'<table  id="myTable" class="tablesorter" cellspacing="0" cellpadding="0"><thead><tr><td>PO/N°</td><td>Produit</td><td>Quantité</td>
  
  </tr>';

while($DF>=$DD) 
{ 

$sql2 = mysql_query ("SELECT DISTINCT PO FROM pro_emb WHERE date_fin LIKE '$DD%'");
while($data=@mysql_fetch_array($sql2)){
$PO=$data['PO'];
$sql3 = mysql_query ("SELECT * FROM commande_items WHERE POitem LIKE '$PO'");
$data3=@mysql_fetch_array($sql3);
$produit=$data3['produit'];
$qty=$data3['qty'];
 echo"<tr><td>$PO</td><td>$produit</td><td>$qty</td></tr>";
}
//
$dateNext= strtotime($DD."+ 1 day");

$DD= date('Y-m-d', $dateNext);

} 


  echo '</thead></table>';

//echo($val);

  ?>