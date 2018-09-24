<?php
session_start(); 
$IDoperateur=$_SESSION['userID'];
include('../connexion/connexionDB.php');
$nameF=$_POST['nameF'];
$IDinvoice=$_POST['IDinvoice'];
$nameF=str_replace('|',' ',$nameF);
$sq1=mysql_query("select dataF FROM invoice_files WHERE nameF='$nameF'");
$D=mysql_result($sq1,0);
unlink ($D);
$sq=mysql_query("DELETE FROM invoice_files WHERE nameF='$nameF'");
//historique
$msg= "  a supprimé une image de la facture  ".$IDinvoice."";
$HIS=mysql_query("INSERT INTO historique(user_id,action,tab,ligne,date_heure)VALUES('$IDoperateur','$msg','Invoice','$IDinvoice',NOW())"); 
mysql_close();

?>