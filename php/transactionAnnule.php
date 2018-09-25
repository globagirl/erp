<?php
session_start();
include('../connexion/connexionDB.php');
$userID=$_SESSION['userID'];
$IDtrans = $_POST['IDtrans'];
$compte = $_POST['compte'];
$sql2=mysql_query("SELECT typeT,montant,ref,IDtrans FROM transaction_compte WHERE IDtrans='$IDtrans'");
$a=mysql_fetch_array($sql2);
$typeT=$a['typeT'];
$montant=$a['montant'];
$ref=$a['ref'];
//$compteVal=$a['compteVal'];
if($typeT == 'RT'){
    //$compteVal=$compteVal+$montant;
    $sql1=mysql_query("UPDATE transaction_compte SET etat='AN' WHERE IDtrans='$IDtrans'");
    //$sql4=mysql_query("UPDATE compte_banque SET soldeR=soldeR+'$montant' WHERE  REFcompte='$compte'");
}else{
    //$compteVal=$compteVal-$montant;
    $sql1=mysql_query("UPDATE transaction_compte SET etat='AN' WHERE IDtrans='$IDtrans' ");
    //$sql4=mysql_query("UPDATE compte_banque SET soldeR=soldeR-'$montant' WHERE  REFcompte='$compte'");
}
$msg="a annule  la transaction ayant la reference <b>".$ref."</b>";
$His=mysql_query("INSERT INTO historique(user_id,action,tab,ligne,date_heure)VALUES('$userID','$msg','transactionAnnule','$IDtrans',NOW())");
mysql_close();
?>