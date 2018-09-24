<?php
 session_start ();
include('../connexion/connexionDB.php');

    $num_sert=$_SESSION['IDsert'];
	$num_ch = $_POST['num_ch'];
	$nom_opr = $_POST['nom_opr'];
    $ag_cont = $_POST['ag_cont']; 
	
	$qte_s = $_POST['qte_s'];
	$qte_e = $_POST['qte_e'];
	$nbr_def = $_POST['nbr_def'];
	$long_pair = $_POST['long_pair'];
	$pro_souil = $_POST['pro_souil'];
	$sh_end = $_POST['sh_end'];
	$ang_pl_end = $_POST['ang_pl_end'];
	$boots_end = $_POST['boots_end'];
	$cable_r = $_POST['cable_r'];
	$pin_end = $_POST['pin_end'];
 $alum_end = $_POST['alum_end'];
	$plan = $_POST['plan'];
	
	
	
$sql = "UPDATE pro_sertiss SET  num_ch='$num_ch', nom_opr='$nom_opr', 

ag_cont='$ag_cont',date_fin=CURRENT_TIMESTAMP(), qte_s='$qte_s', nbr_def='$nbr_def', long_pair='$long_pair', prod_s='$pro_souil', sh_end='$sh_end', ang_pl_end='$ang_pl_end',
boots_end='$boots_end', cable_r='$cable_r', pin_end ='$pin_end', alum_end ='$alum_end' WHERE num_sert='$num_sert'";
		
				

if (!mysql_query($sql)) {
die('Error: ' . mysql_error()); 
    header('Location: ../pages/sertissage_fin.php?status=fail');
}else{  
$sql2 = mysql_query("UPDATE plan1 SET statut='Fin sertissage',nbr_defaut=nbr_defaut+'$nbr_def' where numPlan='$plan'");

$x=($nbr_def*100)/$qte_e;
$x= round ( $x,2);	
if($x>7){
$msg="Le pourcentage des defauts de sertissage est <b>".$x." %</b><br> <b> Plan : ".$plan."</b>";
   $sql4=mysql_query("INSERT INTO notification(emetteur, destinataire, message, dateN,chemin) VALUES ('SRT','LOG','$msg',NOW(),'msg')");
}	

     unset($_SESSION['IDsert']);
	 mysql_close();
     header('Location: ../pages/sertissage.php?status=sent');
}  

?>