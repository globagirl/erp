<meta charset="utf-8" />
 <?php
   // The function header by sending raw excel
header("Content-type: application/vnd-ms-excel");
 
// Defines the name of the export file "codelution-export.xls"
header("Content-Disposition: attachment; filename=accounting profit.xls");
include('../connexion/connexionDB.php');
include('../include/functions/accounting_profit_functions.php');
function afficheLigneTheo($col1,$long,$OF,$PO,$dateE,$produit,$qty,$revenue,$theo_coast,$theo_coast2,$gross,$grossP,$averageC){
    if($theo_coast< $revenue){
        $col="#D8F6CE";
        }else{
        $col="#F78181";
        }
        echo"<tr >
        <td  style=\"width:15%;background-color:".$col1."\">$PO</td>
        <td  style=\"width:10%;background-color:".$col1."\">$dateE</td>
        <td  style=\"width:15%;background-color:".$col1."\">$produit</td>
        <td  style=\"width:6%;background-color:".$col1."\">$long</td>
        <td  style=\"width:10%;background-color:".$col1."\">$qty</td>
        <td  style=\"width:8%;background-color:".$col."\">$revenue</td>
        <td  style=\"width:15%;background-color:".$col."\"><b>$theo_coast</b></td>
        <td  style=\"width:8%;background-color:".$col1."\">$gross</td>
        <td  style=\"width:8%;background-color:".$col1."\">$grossP %</td>
        <td  style=\"width:5%;background-color:".$col1."\">$averageC</td>	";
  

}
$valeur=@$_POST['valeur'];
$recherche=$_POST['recherche'];
$date1=@$_POST['date1'];
$date2=@$_POST['date2'];
$client=@$_POST['client'];
//
//var_dump($client);
echo '<table class="table table-fixed table-bordered results" id="table3">
<thead style="width:100%">
<tr>

  <th style="width:14.8%;height:60px" class="degraD2"><b>Purchase order N°</b></th>
  <th style="width:9.8%;height:60px" class="degraD2"><b>Shipping date</b></th>
  <th style="width:14.8%;height:60px" class="degraD2"><b>Item ID</b></th>
  <th style="width:5.8%;height:60px" class="degraD2"><b>Lenght in mt</b></th>
  <th style="width:9.9%;height:60px" class="degraD2"><b>Qty</b></th>
  <th style="width:7.9%;height:60px" class="degraD2"><b>Revenue</b></th>
  <th style="width:14.8%;height:60px" class="degraD2"><b>Theoretical costs</b></th>

  <th style="width:7.8%;height:60px" class="degraD2"><b>Gross margin</b></th>
  <th style="width:7.8%;height:60px" class="degraD2"><b>Gross margin %</b></th>
 <th style="width:4.9%;height:60px" class="degraD2"><b>Average</b></th>
  </tr></thead><tbody id="tbody2" style="width:100%">';




if($recherche=="a"){
   $sql1= mysql_query("SELECT POitem,produit,qty,prixU,statut,dateExp FROM commande_items where PO IN (SELECT PO FROM commande2 where client in ($client) and date_exped >= '$date1' and date_exped <= '$date2')");
   
}else{
  $sql1= mysql_query("SELECT POitem,produit,qty,prixU,statut,dateExp FROM commande_items where PO IN (SELECT PO FROM commande2 where client in ($client) and date_exped >= '$date1' and date_exped <= '$date2') and $recherche='$valeur'");
   //SELECTION des commande qui on un OF
   //$sql2= mysql_query("SELECT OF,PO,produit,qte,statut,date_exped_conf FROM ordre_fabrication1 where date_exped_conf >= '$date1' and date_exped_conf <= '$date2' and $recherche='$valeur'");
}
//Initiation des valeurs
$total_qty=0;
$total_revenue=0;
$total_coast=0;
$total_gross_margin=0;
$total_gross_marginP=0;
$total_average=0;
$total_long=0;
$total_longSomme=0;
$devise="EUR";

$i=0;
while($data=mysql_fetch_array($sql1)){
   $PO=$data['POitem'];
   $produit=$data['produit'];
   $qty=$data['qty'];
  // $prixU=$data['prixU'];
   $statut=$data['statut'];
   $dateE=$data['dateExp'];
   $reqL= mysql_query("SELECT price FROM prices where IDproduit='$produit'");
   $dataProd=mysql_fetch_array($reqL);
   $prixU=$dataProd['price'];
   $revenue=calcul_revenue($prixU,$qty);
   $theo_coast=calcul_theo_coast($produit,$qty,$dateE);
   $theo_coast2=calcul_theo_coast2($produit,$qty,$dateE);
   $col="#FAFAFA";
   $i++;
   $XOF="X";
   $gross_margin=calcul_gross_margin($revenue,$theo_coast);
   $gross_marginP=calcul_gross_marginP($theo_coast,$revenue);
   $averageC=calcul_averageC($gross_margin,$qty);
   $long=calcul_long($produit,$qty);
   $long1=$long/$qty;
   afficheLigneTheo($col,$long1,$XOF,$PO,$dateE,$produit,$qty,$revenue,$theo_coast,$theo_coast2,$gross_margin,$gross_marginP,$averageC);
	  $total_qty=$total_qty+$qty;
	  $total_revenue=$total_revenue+$revenue;
	  $total_coast=$total_coast+$theo_coast;
	  //$total_gross_margin=$total_gross_margin+$gross_margin;
      $total_gross_margin=$total_revenue-$total_coast;
	  $total_gross_marginP=$total_gross_marginP+$gross_marginP;
     
      $total_long=$total_long+$long;

}
////

//Les totals
 if($i>0){
   $total_gross_marginP=$total_gross_marginP/$i;
 }
	$total_gross_marginP=round($total_gross_marginP,2);
	if($total_qty>0){
	  $total_average=$total_gross_margin/$total_qty;
	}
 if($total_qty>0){
	  $total_longSomme=$total_long/$total_qty;
	}
 $total_longSomme=round($total_longSomme,2);
 $total_average=round($total_average,2);

	//Format affichage nombre
	$total_qty = number_format($total_qty, 2, ',', ' ');
	$total_revenue = number_format($total_revenue, 2, ',', ' ');
	$total_coast = number_format($total_coast, 2, ',', ' ');
	$total_gross_margin = number_format($total_gross_margin, 2, ',', ' ');

	//Affichage
	  echo '
  <tr>
  <td style=width:30%;height:40px;text-align:right;background-color:#EFEFFB ><b>Total QTY: </b></td>
  <td style=width:70%;height:40px;background-color:#EFEFFB><b>'.$total_qty .' </b></td></tr>
  <tr>
  <td  style=width:30%;height:40px;background-color:#F5ECCE;text-align:right ><b>Total revenues: </b></td>
  <td  style=width:70%;height:40px;background-color:#F5ECCE><b>'.$total_revenue  .' '.$devise.'</b></td></tr>
  <tr>

  <tr><td style=width:30%;height:40px;text-align:right;background-color:#E0F2F7 ><b>Gross margin: </b></td><td style=width:70%;height:40px;background-color:#E0F2F7><b>'.$total_gross_margin .' '.$devise.'</b></td></tr>
  <tr><td style=width:30%;height:40px;text-align:right;background-color:#FAB6B6 ><b>Gross margin %: </b></td><td style=width:70%;height:40px;background-color:#FAB6B6><b> '.$total_gross_marginP.' %</b></td></tr>
  <tr>
  <td style=width:30%;height:40px;text-align:right;background-color:#F8E0EC ><b>Average margin/Cable: </b></td>
  <td style=width:70%;height:40px;background-color:#F8E0EC><b>'.$total_average .' EUR</b></td>
  <tr>
  <td style=width:30%;height:40px;text-align:right;background-color:#F8E0EC ><b>Average length : </b></td>
  <td style=width:70%;height:40px;background-color:#F8E0EC><b>'.$total_longSomme .' M</b></td></tr>
';

echo '</tbody></table>';
mysql_close();
?>
