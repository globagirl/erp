 <meta charset="utf-8" />
 <?php
   // The function header by sending raw excel
header("Content-type: application/vnd-ms-excel");
 
// Defines the name of the export file "codelution-export.xls"
header("Content-Disposition: attachment; filename=bon livraison.xls");
include('../connexion/connexionDB.php');

$x=@$_POST['num_bl_1']; 
$y=@$_POST['num_bl_2'];		
$sql =("SELECT * FROM bon_livr_items WHERE idBL BETWEEN $x AND $y ");
  echo'<table border="1px">
  <tr><td>N° BL </td><td>Client</td><td>PO </td>
  <td> Produit </td> <td> QTY </td><td>NBR BOX</td><td>Date Expédition</td><td>Date demandée</td>
  
  </tr>';


  $r=mysql_query($sql) or die(mysql_error());
   while($a=mysql_fetch_object($r))
    {
	
    $BL =$a->idBL;
    $PO=$a->PO;	
	$item=$a->IDproduit;	
	$qty=$a->qty;	
	$box=$a->box;	
	$req1= mysql_query("SELECT * FROM bon_livr where num_bl='$BL'");
	$row = mysql_fetch_array($req1);
	$cl=$row['client'];
	$dateE=$row['date_bl'];
	$dateC=$row['date_liv'];
    echo"<tr><td>$BL</td><td>$cl</td><td>$PO</td><td>$item</td><td>$qty</td><td>$box</td><td>$dateE</td><td>$dateC</td></tr>";
    }
   
   
  echo '</table>';

//echo($val);

  ?>