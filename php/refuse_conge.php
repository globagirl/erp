<?php
include('../connexion/connexionDB.php');
$IDC=$_POST['IDC'];
$sql=mysql_query("select demandeur from personnel_demande_conge where ID='$IDC'");
$DM=@mysql_result($sql,0);
$sql2=mysql_query("UPDATE personnel_demande_conge SET etat='NC' where ID='$IDC'");
$message="Your request for leave has been <b>Refused </b>";
$sql4=mysql_query("INSERT INTO notification(emetteur, destinataire, message, statut, dateN) VALUES ('GRH','$DM','$message','N',NOW())");
?>