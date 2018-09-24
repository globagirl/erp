<?php

session_start ();
include('../connexion/connexionDB.php');
  $plan=$_POST['plan'];



	$ch_ins = $_POST['ch_ins'];
	$nbr_opr = $_POST['nbr_opr'];
	$op_1=$_POST['op_1'];
	$op_2=$_POST['op_2'];
	$op_3=$_POST['op_3'];
	$op_4=$_POST['op_4'];
	$op_5=$_POST['op_5'];
	$op_6=$_POST['op_6'];
	$op_7=$_POST['op_7'];
    $ag_cont = $_POST['ag_cont']; 	
	$qte_e = $_POST['qte_e'];
	$qte_s = $_POST['qte_s'];
	$nbr_def = $_POST['nbr_def'];
	$denud = $_POST['denud'];
	$emp_cmp = $_POST['emp_cmp'];
	$dist_p = $_POST['dist_p'];
	$long_p = $_POST['long_p'];
	$acc_mqt = $_POST['acc_mqt'];
	
	
$sql = "UPDATE pro_assem SET ch_ins='$ch_ins', nbr_opr='$nbr_opr', 
op_1='$op_1', op_2='$op_2',op_3='$op_3',op_4='$op_4',op_5='$op_5',op_6='$op_6',op_7='$op_7',ag_cont='$ag_cont',
date_fin=CURRENT_TIMESTAMP(),qte_s='$qte_s',nbr_def='$nbr_def',denud='$denud', emp_cmp='$emp_cmp',dist_p='$dist_p',long_p ='$long_p ',acc_mqt='$acc_mqt'

		WHERE plan='$plan'";

if (!mysql_query($sql)) {
die('Error: ' . mysql_error());
    mysql_close(); 
    header('Location: ../pages/assemblage_fin.php?status=fail');
	
}else{
     unset($_SESSION['IDassemb']);
	 mysql_close();
     header('Location: ../pages/assemblage_fin.php?status=sent');
}  

?>