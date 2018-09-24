<?php
session_start();
include('../connexion/connexionDB.php');
$userid=$_SESSION['userID'];
$IDrelance=$_POST['IDrelance'];

$sql = mysql_query("UPDATE bande_relance SET statut='C',IDvalidateur='$userid',dateV=NOW() where IDrelance='$IDrelance'");
$sql1 = mysql_query("SELECT OF FROM bande_relance where IDrelance='$IDrelance'");
$OF=mysql_result($sql1,0);
//Notification
	$msg= " Vous avez une nouvelle bande de relance <b> OF : ".$OF."</b> ";
    $sql2=mysql_query("INSERT INTO notification(emetteur, destinataire, message, dateN,chemin) VALUES ('$userid','MAG','$msg',NOW(),'msg')");
//Historique
    
	$msg="a validé la bande relance N° <b>".$IDrelance."</b>";
    $His=mysql_query("INSERT INTO historique(user_id,action,tab,ligne,date_heure)VALUES('$userid','$msg','bande_relance','$IDrelance',NOW())"); 
	//
	mysql_close();
	//

?>