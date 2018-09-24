<meta charset="utf-8" />
 <?php

  // The function header by sending raw excel
header("Content-type: application/vnd-ms-excel");

// Defines the name of the export file "codelution-export.xls"
header("Content-Disposition: attachment; filename=fact.xls");
include('../connexion/connexionDB.php');

$sql=mysql_query("SELECT IDinvoice,IDordre,IDitem,unit_price FROM supplier_invoice_items where IDinvoice IN (Select IDinvoice FROM supplier_invoice  where supplier LIKE '%Commscope%') GROUP BY IDinvoice,IDitem");
echo "<table>
<tr><td>CS invoice</td><td>Invoice date </td><td>item</td><td>QTY</td>
<td>CS Invoice price </td><td>Total Invoice price</td>
<td>STARZ old price </td><td>Total STARZ old price</td>
<td>Purchase price</td><td>Total Purchase price</td>
<td>ST prices Janvier</td><td>Total ST prices Janvier</td>
<td>Status</td>
</tr>";
while($data=mysql_fetch_array($sql)){
	$item=$data['IDitem'];
	$prix=$data['unit_price'];
	$IDinvoice=$data['IDinvoice'];
  $IDordre=$data['IDordre'];

$sq=mysql_query("SELECT sum(qty) FROM supplier_invoice_items where IDinvoice='$IDinvoice' and $IDordre='$IDordre' and IDitem='$item'");
$qty=mysql_result($sq,0);
 $sql1=mysql_query("SELECT dateF,status FROM supplier_invoice where IDinvoice LIKE '$IDinvoice'");
//	$dateF=@mysql_result($sql1,0);
 $dataInv=mysql_fetch_array($sql1);
 $dateF=$dataInv['dateF'];
 $status=$dataInv['status'];
 $sql2=mysql_query("SELECT prix_unitaire FROM ordre_achat_article1 where IDarticle LIKE '$item' and IDordre='$IDordre'");
	$prixOrder=@mysql_result($sql2,0);

 $sql3=mysql_query("SELECT prix FROM article1 where code_article LIKE '$item'");
 $STprice=mysql_result($sql3,0);

 $sql4=mysql_query("SELECT ancien_prix FROM historique_prices where item LIKE '$item' and dateM >= '2017-11-1'");
 if (mysql_num_rows($sql4)<1) {
    $STpriceOld=$STprice;
 }else{
    $STpriceOld=mysql_result($sql4,0);
 }
 //if($prixOrder != $prix || $STprice != $prix || $STpriceOld != $prix){
//	if($prixOrder > $prix || $STprice > $prix ){
  if($prixOrder < $prix || $STprice < $prix ){
	    $n=strpos($IDinvoice,"-");
      $IDinvoice=substr($IDinvoice,$n+1);
      $P1=$qty*$prix;
      $P1=round($P1,3);
      //
      $P2=$qty*$STpriceOld;
      $P2=round($P2,3);
      //
      $P3=$qty*$prixOrder;
      $P3=round($P3,3);
      //
      $P4=$qty*$STprice;
      $P4=round($P4,3);
		   //echo "<tr><td>".$IDinvoice."</td><td>".$item."</td><td>".$qty."</td><td>".$prixT."</td><td>".$prix."</td><td>".$prix2."</td><td>".$realCoast."</td><td>".$P." %</td></tr>";
		   echo "<tr><td>".$IDinvoice."</td><td>".$dateF."</td><td>".$item."</td><td>".$qty."</td>
       <td>".$prix."</td><td>".$P1."</td>
     <td>".$STpriceOld."</td><td>".$P2."</td>
     <td>".$prixOrder."</td><td>".$P3."</td>
     <td>".$STprice."</td><td>".$P4."</td>
     <td>".$status."</td>
     </tr>";
	}
}
echo "</table>";
mysql_close();
	?>
