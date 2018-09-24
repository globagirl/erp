<?php
 session_start ();
include('../connexion/connexionDB.php');

     $plan=$_POST['plan'];
	$ch_ins = $_POST['ch_ins'];
	
	$op_1=$_POST['op_1'];
	$op_2=$_POST['op_2'];
    $ag_cont = $_POST['ag_cont']; 
	$date_recep = $_POST['date_recep'];
	$qte_e = $_POST['qte_e'];
	$qte_s = $_POST['qte_s'];
	$nbr_def = $_POST['nbr_def'];
	$qlty = $_POST['qlty'];
	$p_cc = $_POST['p_cc'];
	$cntn = $_POST['cntn']; 
	$p_inv = $_POST['p_inv'];
	
		


$sql = "UPDATE pro_test_pol SET  ch_ins='$ch_ins',op_1='$op_1', op_2='$op_2', ag_cont='$ag_cont', date_fin=CURRENT_TIMESTAMP(),
 qte_s='$qte_s', nbr_def='$nbr_def', qlty='$qlty',p_cc='$p_cc', cntn='$cntn', p_inv='$p_inv'
WHERE plan='$plan'";


 if (!mysql_query($sql)) {
die('Error: ' . mysql_error()); 
    
}else{ 
$x=($nbr_def*100)/$qte_e;
$x= round ( $x,2);	
if($x>5){
$msg="Le pourcentage des defauts du TEST POLARITE est <b>".$x." %</b><br> <b> Plan : ".$plan."</b>";
   $sql4=mysql_query("INSERT INTO notification(emetteur, destinataire, message, dateN,chemin) VALUES ('TST','LOG','$msg',NOW(),'msg')");
}	
 
$sql2 = mysql_query("UPDATE plan1 SET statut='FIN Test',nbr_defaut=nbr_defaut+'$nbr_def' where numPlan='$plan'");
unset($_SESSION['IDtp']);	
mysql_close();
     header('Location: ../pages/test_pol_fin.php?status=sent');
}  

?>