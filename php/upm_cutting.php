<?php
session_start();
include('../connexion/connexionDB.php');
    

 	
	$date_e = date("Y-m-d H:i:s");

	$q_sor = $_POST['q_sor'];
	$q_reb = $_POST['q_reb'];
	
	$short_cbl = @$_POST['short_cbl'];
	$long_cbl = @$_POST['long_cbl'];
	$no_striping = @$_POST['no_striping'];
	$cable_aspect = @$_POST['cable_aspect'];
	$striping_length = @$_POST['striping_length'];
	$other = @$_POST['other'];
	$id = $_SESSION['IDupmCUT'];
	
$sql = "UPDATE upm_cutting SET date_fin='$date_e',
qte_s='$q_sor',q_reb='$q_reb',short_cbl='$short_cbl',long_cbl='$long_cbl',no_striping='$no_striping',cable_aspect='$cable_aspect', striping_length='$striping_length', other='$other' 	
		WHERE id_cut='$id'";


if (!mysql_query($sql)) {
die('Error: ' . mysql_error()); 
    header('Location: ../pages/upm_cutting.php?status=fail');
}else{  
mysql_query($sql2);
unset($_SESSION['IDupmCUT']);
     header('Location: ../pages/upm_cutting_deb.php?status=sent');
}  
mysql_close();
?>