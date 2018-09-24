<?php
include('../connexion/connexionDB.php');
$invoice=$_POST['invoice'];
$supplier=$_POST['supplier'];

$invoice="-".$invoice;

$sq=mysql_query("select  IDinvoice from  supplier_invoice where IDinvoice LIKE '%$invoice' and supplier LIKE '$supplier'");
if(mysql_num_rows($sq)>0)
{
	
	echo ("1");
	
}
else {
	echo ("0");
}

mysql_close();
?>