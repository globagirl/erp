<?php
include('../connexion/connexionDB.php');
$invoices=@$_POST['invoices'];
$IDinvoiceT=explode(",",$invoices);
$totalT=0;
$currency="EUR";
foreach ($IDinvoiceT as $IDinvoice) {
     $req= mysql_query("SELECT total,currency FROM supplier_invoice where IDinvoice='$IDinvoice'");
     $a=@mysql_fetch_array($req);
     $total =$a['total'];
     $currency =$a['currency'];
     $totalT=$totalT+$total;
     //echo $IDinvoice."<br>";
}
$totalT=round($totalT,3);
echo "Total : ".$totalT." ".$currency;
mysql_close();

?>