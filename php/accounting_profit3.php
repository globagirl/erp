 <?php
include('../connexion/connexionDB.php');
include('../include/functions/accounting_profit_functions.php');
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

  <th style="width:10%;height:60px" class="degraD2"><b>Purchase order N°</b></th>
  <th style="width:10%;height:60px" class="degraD2"><b>Shipping date</b></th>
  <th style="width:10%;height:60px" class="degraD2"><b>Item ID</b></th>

  <th style="width:6%;height:60px" class="degraD2"><b>Qty</b></th>
  <th style="width:8%;height:60px" class="degraD2"><b>Revenue</b></th>
  <th style="width:9.5%;height:60px" class="degraD2"><b>Theoretical costs</b></th>
  <th style="width:9%;height:60px" class="degraD2"><b>Real costs</b></th>
  <th style="width:7%;height:60px" class="degraD2"><b>Waist </b></th>
  <th style="width:8%;height:60px" class="degraD2"><b>Waist %</b></th>
  <th style="width:8%;height:60px" class="degraD2"><b>Gross margin</b></th>
  <th style="width:8%;height:60px" class="degraD2"><b>Gross margin %</b></th>
 <th style="width:4.5%;height:60px" class="degraD2"><b>Average</b></th>
  </tr></thead><tbody id="tbody2" style="width:100%">';




if($recherche=="a"){
   $sql1= mysql_query("SELECT POitem,produit,qty,prixU,statut,dateExp FROM commande_items where PO IN (SELECT PO FROM commande2 where client in ($client) and date_exped >= '$date1' and date_exped <= '$date2') and (statut='waiting' or statut='incomplete')");
   //SELECTION des commande qui on un OF
   $sql2= mysql_query("SELECT OF,PO,produit,qte,statut,date_exped_conf FROM ordre_fabrication1 where date_exped_conf >= '$date1' and date_exped_conf <= '$date2'");
}else{
  $sql1= mysql_query("SELECT POitem,produit,qty,prixU,statut,dateExp FROM commande_items where PO IN (SELECT PO FROM commande2 where client in ($client) and date_exped >= '$date1' and date_exped <= '$date2') and (statut='waiting' or statut='incomplete') and $recherche='$valeur'");
   //SELECTION des commande qui on un OF
   $sql2= mysql_query("SELECT OF,PO,produit,qte,statut,date_exped_conf FROM ordre_fabrication1 where date_exped_conf >= '$date1' and date_exped_conf <= '$date2' and $recherche='$valeur'");
}
//Initiation des valeurs
$total_qty=0;
$total_revenue=0;
$total_coast=0;
$total_gross_margin=0;
$total_gross_marginP=0;
$total_average=0;
$total_waist=0;
$total_waistP=0;
$total_long=0;
$total_longSomme=0;
$devise="EUR";

$i=0;
while($data=mysql_fetch_array($sql1)){
   $PO=$data['POitem'];
   $produit=$data['produit'];
   $qty=$data['qty'];
   $prixU=$data['prixU'];
   $statut=$data['statut'];
   $dateE=$data['dateExp'];

   if($statut=="incomplete"){
      $sql12= mysql_query("SELECT sum(qte) FROM ordre_fabrication1 where PO='$PO'");
	    $qteT=@mysql_result($sql12,0);
	    $qty=$qty-$qteT;
   }
   $revenue=calcul_revenue($prixU,$qty);
   $theo_coast=calcul_theo_coast($produit,$qty,$dateE);
   $theo_coast2=calcul_theo_coast2($produit,$qty,$dateE);
	 $real_coast=$theo_coast;
	 $waist=0;
	 $waistP=0;
   $col="#F6CECE";
   $i++;
   $XOF="X";
	 $gross_margin=calcul_gross_margin($revenue,$real_coast);
	 $gross_marginP=calcul_gross_marginP($real_coast,$revenue);
   $averageC=calcul_averageC($gross_margin,$qty);

	  afficheLigne($col,$XOF,$PO,$dateE,$produit,$qty,$revenue,$theo_coast,$theo_coast2,$real_coast,$waist,$waistP,$gross_margin,$gross_marginP,$averageC);
	  $total_qty=$total_qty+$qty;
	  $total_revenue=$total_revenue+$revenue;
	  $total_coast=$total_coast+$real_coast;
	  //$total_gross_margin=$total_gross_margin+$gross_margin;
    $total_gross_margin=$total_revenue-$total_coast;
	  $total_gross_marginP=$total_gross_marginP+$gross_marginP;
	  $total_waist=$total_waist+$waist;
   $long=calcul_long($produit,$qty);
   $total_long=$total_long+$long;

}
////
while($data2=mysql_fetch_array($sql2)){
   $PO=$data2['PO'];
   $sql31=@mysql_query("SELECT PO FROM commande2 where  client in ($client) and PO='$PO'");
   if(mysql_num_rows($sql31)>0){
   $OF=$data2['OF'];
   $produit=$data2['produit'];
   $qty=$data2['qte'];
   $statut=$data2['statut'];
   $dateE=$data2['date_exped_conf'];
   $sql21= mysql_query("SELECT prixU FROM commande_items where PO='$PO'");
   $prixU=@mysql_result($sql21,0);
   if($statut=="planned"){
    $revenue=calcul_revenue($prixU,$qty);
    $theo_coast=calcul_theo_coast($produit,$qty,$dateE);
    $theo_coast2=calcul_theo_coast2($produit,$qty,$dateE);
	  $real_coast=$theo_coast;
	  $waist=0;
	  $waistP=0;
	  $gross_margin=calcul_gross_margin($revenue,$real_coast);
	  $gross_marginP=calcul_gross_marginP($real_coast,$revenue);
	  $averageC=calcul_averageC($gross_margin,$qty);
	  $i++;
	  $col="#FAFAFA";
    $XOF="X";
	  afficheLigne($col,$XOF,$PO,$dateE,$produit,$qty,$revenue,$theo_coast,$theo_coast,$real_coast,$waist,$waistP,$gross_margin,$gross_marginP,$averageC);
	  $total_qty=$total_qty+$qty;
	  $total_revenue=$total_revenue+$revenue;
	  $total_coast=$total_coast+$real_coast;

	  //$total_gross_margin=$total_gross_margin+$gross_margin;
    $total_gross_margin=$total_revenue-$total_coast;
	  $total_gross_marginP=$total_gross_marginP+$gross_marginP;
	  $total_waist=$total_waist+$waist;
   $long=calcul_long($produit,$qty);
   $total_long=$total_long+$long;

   }else{
   $revenue=calcul_revenue($prixU,$qty);
   $theo_coast=calcul_theo_coast($produit,$qty,$dateE);
   $theo_coast2=calcul_theo_coast2($produit,$qty,$dateE);
	  $real_coast=calcul_real_coast($OF);
	  $waist=calcul_waist($real_coast,$theo_coast);
	  $waistP=calcul_waistP($waist,$theo_coast);
    $gross_margin=calcul_gross_margin($revenue,$real_coast);
    $gross_margin_theo=calcul_gross_margin($revenue,$theo_coast);
	  $gross_marginP=calcul_gross_marginP($real_coast,$revenue);
	  $averageC=calcul_averageC($gross_margin,$qty);
	  $i++;
	  $col="#FAFAFA";
	  afficheLigne($col,$OF,$PO,$dateE,$produit,$qty,$revenue,$theo_coast,$theo_coast2,$real_coast,$waist,$waistP,$gross_margin,$gross_marginP,$averageC);
	  $total_qty=$total_qty+$qty;
	  $total_revenue=$total_revenue+$revenue;
	  $total_coast=$total_coast+$real_coast;
	  //$total_gross_margin=$total_gross_margin+$gross_margin;
    $total_gross_margin=$total_revenue-$total_coast;
	  $total_gross_marginP=$total_gross_marginP+$gross_marginP;
	  $total_waist=$total_waist+$waist;
    $long=calcul_long($produit,$qty);
    $total_long=$total_long+$long;

   }
 }//Fin if
}
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
	if($total_revenue>0){
	  $total_waistP=($total_waist/$total_revenue)*100;
	}
 $total_waistP=round($total_waistP,2);
	//Format affichage nombre
	$total_qty = number_format($total_qty, 2, ',', ' ');
	$total_revenue = number_format($total_revenue, 2, ',', ' ');
	$total_coast = number_format($total_coast, 2, ',', ' ');
	$total_gross_margin = number_format($total_gross_margin, 2, ',', ' ');
	$total_waist = number_format($total_waist, 2, ',', ' ');
	//Affichage
	  echo '
  <tr>
  <td style=width:30%;height:40px;text-align:right;background-color:#EFEFFB ><b>Total QTY: </b></td>
  <td style=width:70%;height:40px;background-color:#EFEFFB><b>'.$total_qty .' </b></td></tr>
  <tr>
  <td  style=width:30%;height:40px;background-color:#F5ECCE;text-align:right ><b>Total revenues: </b></td>
  <td  style=width:70%;height:40px;background-color:#F5ECCE><b>'.$total_revenue  .' '.$devise.'</b></td></tr>
  <tr>
  <td style=width:30%;height:40px;text-align:right;background-color:#F8E0EC ><b>Component cost: </b></td>
  <td style=width:70%;height:40px;background-color:#F8E0EC><b>'.$total_coast .' '.$devise.'</b></td></tr>
  <tr><td style=width:30%;height:40px;text-align:right;background-color:#E0F2F7 ><b>Gross margin: </b></td><td style=width:70%;height:40px;background-color:#E0F2F7><b>'.$total_gross_margin .' '.$devise.'</b></td></tr>
  <tr><td style=width:30%;height:40px;text-align:right;background-color:#FAB6B6 ><b>Gross margin %: </b></td><td style=width:70%;height:40px;background-color:#FAB6B6><b> '.$total_gross_marginP.' %</b></td></tr>
  <tr>
  <td style=width:30%;height:40px;text-align:right;background-color:#F8E0EC ><b>Average margin/Cable: </b></td>
  <td style=width:70%;height:40px;background-color:#F8E0EC><b>'.$total_average .' EUR</b></td></tr>

    <td style=width:30%;height:40px;text-align:right;background-color:#F8E0EC ><b>Waisted cost: </b></td>
  <td style=width:70%;height:40px;background-color:#F8E0EC><b>'.$total_waist .' '.$devise.'</b></td></tr>
  <tr><td style=width:30%;height:40px;text-align:right;background-color:#F5A9BC ><b>Waisted cost (%): </b></td>
  <td style=width:70%;height:40px;background-color:#F5A9BC><b>'.$total_waistP .' %</b></td></tr>
  <td style=width:30%;height:40px;text-align:right;background-color:#F8E0EC ><b>Average length : </b></td>
  <td style=width:70%;height:40px;background-color:#F8E0EC><b>'.$total_longSomme .' M</b></td></tr>
';

echo '</tbody></table>';
mysql_close();
?>
