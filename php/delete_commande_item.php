<?php
session_start();
include('../connexion/connexionDB.php');
$userid=$_SESSION['userID'];
$POi=$_POST['POi'];
$nbr=$_POST['nbr'];
if($nbr>1){
$sql=mysql_query("select * from commande_items where POitem='$POi'");
$data=mysql_fetch_array($sql);
$qty=$data['qty'];
$prix=$data['prixT'];
$po=$data['PO'];
$sq=mysql_query("DELETE FROM commande_items WHERE POitem='$POi'");
$sq2=mysql_query("UPDATE commande2 SET qte_demande=qte_demande-'$qty',prix_total= prix_total-'$prix' WHERE  PO='$po'");


//historique
$His=mysql_query("INSERT INTO historique(user_id,action,tab,ligne,date_heure)VALUES('$userid','delete','commande_items','$POi',NOW())");  

}else{
$sql=mysql_query("select * from commande_items where POitem='$POi'");
$data=mysql_fetch_array($sql);

$po=$data['PO'];
$sq=mysql_query("DELETE FROM commande_items WHERE POitem='$POi'");
$sq2=mysql_query("DELETE FROM commande2 WHERE PO='$po'");
//Historique
$msg="a supprimé la commande N° <b>".$POi."</b>";
$His=mysql_query("INSERT INTO historique(user_id,action,tab,ligne,date_heure)VALUES('$userid','$msg','commande','$POi',NOW())");  
}
?>