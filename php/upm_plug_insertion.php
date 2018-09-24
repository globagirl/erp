<?php
session_start();
include('../connexion/connexionDB.php');
   

 	
	$date_e = date("Y-m-d H:i:s");
	$qte_e = $_POST['qte_e'];
	$q_sor = $_POST['q_sor'];
	$q_reb = $_POST['q_reb'];
	
	$contact = @$_POST['contact'];
	$reverse_wire = @$_POST['reverse_wire'];
	$other = @$_POST['other'];
	$id =$_SESSION['IDupmPLG'];
	
$sql = "UPDATE upm_plug_insertion SET date_fin='$date_e',q_sor='$q_sor',q_reb='$q_reb',reversed_wire='$reverse_wire ',
contact_position_problem='$contact',other='$other' WHERE id_plg='$id'";


if (!mysql_query($sql)) {
die('Error: ' . mysql_error()); 
    header('Location: ../pages/upm_plug_ins.php?status=fail');
}else{  
mysql_query($sql2);
unset($_SESSION['IDupmPLG']);
     header('Location: ../pages/upm_plug_ins_deb.php?status=sent');
}  
mysql_close();
?>