<?php
session_start();
include('../connexion/connexionDB.php'); 
	$ch_ins = $_POST['ch_ins'];	
    $ag_cont = $_POST['ag_cont']; 
    $num_emb=$_SESSION['IDemb'];
	$qte_s = $_POST['qte_s'];
	$plan=$_POST['plan'];
	
	$sql = "UPDATE pro_emb 	SET  ch_ins='$ch_ins', ag_cont='$ag_cont', date_fin=CURRENT_TIMESTAMP(),qte_s='$qte_s'  	
		WHERE num_emb='$num_emb'";
			
		
	


if (!mysql_query($sql)) {
die('Error: ' . mysql_error()); 
  
}else{  
$sql13=mysql_query("UPDATE plan1 SET date_fin=CURRENT_TIMESTAMP(),statut='finished' where numPlan='$plan'");
$sql1=mysql_query("select OF from plan1 where numPlan='$plan'");
$OF=mysql_result($sql1,0);
$sql2=mysql_query("select * from ordre_fabrication1 where OF='$OF'");
$data2=mysql_fetch_array($sql2);
$sql3=mysql_query("select * from pro_emb where plan LIKE '$OF%'");
$nbr=mysql_num_rows($sql3);
$x=$data2['nbr_plan'];

if($nbr==$x){
 $msg= " la commande N° <b>  ".$data2['PO']."</b> s'est terminée ";
 $sql4=mysql_query("INSERT INTO notification(emetteur, destinataire, message, dateN,chemin) VALUES ('EMB','LOG','$msg',NOW(),'msg')");
}
unset($_SESSION['IDemb']);
mysql_close();
header('Location: ../pages/emballage.php?status=sent');

}  

?>