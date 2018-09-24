 <meta charset="utf-8" />
 <?php
  // The function header by sending raw excel
header("Content-type: application/vnd-ms-excel");
 
// Defines the name of the export file "codelution-export.xls"
header("Content-Disposition: attachment; filename=facture.xls");
include('../connexion/connexionDB.php');

$f1=@$_POST['num_f_1'];
$f2 =@$_POST['num_f_2'];
$dateE=@$_POST['dateE'];
if($f2==""){
    $f2=$f1;
}
if($f1!=""){
$sql= "SELECT * FROM fact1 WHERE num_fact BETWEEN $f1 AND $f2 ";
}else{
$sql="SELECT * FROM fact1 WHERE date_E LIKE '$dateE'";
}


  echo'<table border="1px">
  <tr><td>N° facture </td><td>N° BL</td><td>Client</td><td>PO </td>
  <td> Produit </td><td>Description</td><td>Révision</td> <td> QTY </td><td>Prix unitaire</td><td>Prix total</td><td>Date Facture</td><td>Date Expedition</td>
  
  </tr>';


  $r=mysql_query($sql) or die(mysql_error());
   while($a=mysql_fetch_array($r))
    {	
  	$fact=$a['num_fact'];
	$req1= mysql_query("SELECT * FROM fact_items where idF='$fact'");
	while($row = mysql_fetch_array($req1)){
	$item=$row['produit'];
	$req2= mysql_query("SELECT description,draw_rev FROM produit1 where code_produit='$item'");
	$dataProd = mysql_fetch_array($req2);
	$desc = $dataProd['description'];
	$rev = $dataProd['draw_rev'];
	
	//
	
    echo"<tr><td>".$a['num_fact']."</td><td>".$a['num_fact']."</td><td>".$a['client']."</td><td>".$row['PO']."</td><td>".$row['produit']."</td><td>".$desc."</td><td>".$rev."</td><td>".$row['qty']."</td><td>".$row['prixU']."</td><td>".$row['prixT']."</td><td>".$a['date_fact']."</td><td>".$a['date_E']."</td></tr>";
    }
	}
   
   
  echo '</table>';
  mysql_close();
//echo($val);

  ?>