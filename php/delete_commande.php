<?php
session_start();
include('../connexion/connexionDB.php');

$PO=$_POST['PO'];
$userid=$_SESSION['userID'];
$sq=mysql_query("DELETE FROM commande_items WHERE POitem='$PO'");
$sq2=mysql_query("DELETE FROM commande2 WHERE PO='$PO'");
//Historique
$msg="a supprimé la commande N° <b>".$PO."</b>";
$His=mysql_query("INSERT INTO historique(user_id,action,tab,ligne,date_heure)VALUES('$userid','$msg','commande','$POi',NOW())");  

mysql_close();
//$sq=mysql_query("UPDATE  commande_items SET statut='KKKK'  WHERE POitem='$PO'");
?>