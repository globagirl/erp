<?php
session_start();
$IDoperateur=$_SESSION['userID'];
include('../connexion/connexionDB.php');
$invoice = $_POST['invoice'];
$dateP=$_POST['dateP'];
$modePay=$_POST['modeP'];

$sql = "UPDATE supplier_invoice SET dateP='$dateP',status='paid',mode_pay='$modePay' WHERE IDinvoice='$invoice'";
       
if (!mysql_query($sql)) {
die('Error: ' . mysql_error()); 
   return "0";
	
}else{
$sql1=mysql_query("SELECT total FROM supplier_invoice  WHERE IDinvoice='$invoice'");
$total=mysql_result($sql1,0);
if(($modePay=='Virement')||($modePay=='Cheque') ){
    $ref = $_POST['ref'];
	$NC=$_POST['NC'];
	$sql2=mysql_query("INSERT INTO invoice_mode_pay(reference, modeP, compte, dateP, num_invoice,montant) VALUES ('$ref','$modePay','$NC','$dateP','$invoice','$total')");
}else{    
	$sql2=mysql_query("INSERT INTO invoice_mode_pay(modeP,dateP, num_invoice ,montant) VALUES ('$modePay','$dateP','$invoice','$total')");
}
//historique
       $msg= "a payé la facture  N°   ".$invoice."";
	   $HIS=mysql_query("INSERT INTO historique(user_id,action,tab,ligne,date_heure)VALUES('$IDoperateur','$msg','Invoice','$Iinvoice',NOW())");
	   //
	
return "1";	   
}     


?>