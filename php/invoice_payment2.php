<?php
session_start();//Invoice payment par mode de payement
$IDoperateur=$_SESSION['userID'];
include('../connexion/connexionDB.php');
$invoice = $_POST['invoice2'];
$dateP=$_POST['dateP'];
$modePay=$_POST['modeP'];
$montant=$_POST['montant'];

if($modePay=="Autre"){
    $ref = $_POST['refP'];
    if($ref != ""){
	    $modePay=$ref;
	}
}
$sql = "UPDATE supplier_invoice SET dateP='$dateP',status='paid' WHERE IDinvoice LIKE '$invoice'";
       
if (!mysql_query($sql)) {
die('Error: ' . mysql_error()); 
mysql_close();
	
}else{

if(($modePay=="Virement")||($modePay=="Cheque")){
    $ref = $_POST['refP'];
	$NC=$_POST['NC'];
	$sql2=mysql_query("INSERT INTO invoice_mode_pay(reference, modeP, compte, dateP, num_invoice,montant) VALUES ('$ref','$modePay','$NC','$dateP','$invoice','$montant')");
}else{    
	$sql2=mysql_query("INSERT INTO invoice_mode_pay(modeP,dateP, num_invoice,montant) VALUES ('$modePay','$dateP','$invoice','$montant')");
}
//historique
       $msg= "a payé la facture  N°   ".$invoice."";
	   $HIS=mysql_query("INSERT INTO historique(user_id,action,tab,ligne,date_heure)VALUES('$IDoperateur','$msg','Invoice','$Iinvoice',NOW())");
	   //
mysql_close();
header('Location: ../pages/invoice_payment.php');  
}     

?>