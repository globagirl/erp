<?php

session_start ();
include('../connexion/connexionDB.php');


    $idCF=$_SESSION['idCF'] ;
	$ag_cont = $_POST['ag_cont'];
	$plan = $_POST['plan'];

	$pass_fail=$_POST['CONT_fluke'];
	
	
$sql = "UPDATE pro_contr_fluke SET ag_cont='$ag_cont',
date_fin=CURRENT_TIMESTAMP(),pass_fail='$pass_fail' WHERE num_fluk='$idCF'";

if (!mysql_query($sql)) {
die('Error: ' . mysql_error()); 
    
	
}else{
$sql2 = mysql_query("UPDATE plan1 SET statut='Fin test fluke' where numPlan='$plan'");
if($pass_fail=='fail'){
$msg="Le résultat du controle FLUKE pour le plan : <b>".$plan."</b> est <b> FAIL </b>";
   $sql4=mysql_query("INSERT INTO notification(emetteur, destinataire, message, dateN,chemin) VALUES ('FLUKE','LOG','$msg',NOW(),'msg')");
}	
unset($_SESSION['idCF']);
     mysql_close();
     header('Location: ../pages/controle_fluke.php?status=sent');
}  

?>