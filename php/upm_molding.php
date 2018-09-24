<?php
session_start();
include('../connexion/connexionDB.php');
   
  
 	
	$date_e = date("Y-m-d H:i:s");
	$qte_e = $_POST['qte_e'];
	$q_sor = $_POST['q_sor'];
	$q_reb = $_POST['q_reb'];
	
	$air = @$_POST['air'];
	$burn = @$_POST['burn'];
	$burr = @$_POST['burr'];
	$cavity = @$_POST['cavity'];
	$deforme = @$_POST['deforme'];
	$other = @$_POST['other'];
	$id = $_SESSION['IDupmMLD'];
	
$sql = "UPDATE upm_mold SET date_fin='$date_e',
q_sor='$q_sor',q_reb='$q_reb',air_bubbles_presence='$air' , burns='$burn',burr='$burr',cavity='$cavity',deformed_molding='$deforme',other='$other' WHERE id_mld='$id'";


if (!mysql_query($sql)) {
die('Error: ' . mysql_error()); 
    header('Location: ../pages/upm_Molding.php?status=fail');
}else{  
mysql_query($sql2);
unset($_SESSION['IDupmMLD']);
     header('Location: ../pages/upm_Molding_deb.php?status=sent');
}  
mysql_close();
?>