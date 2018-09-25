<?php
session_start();
include('../connexion/connexionDB.php');
$userID=$_SESSION['userID'];
$IDtrans = $_POST['IDtrans'];
$compte = $_POST['compte'];
$sql2=mysql_query("SELECT typeT,montant,IDtrans,ref,modeT,etat FROM transaction_compte WHERE IDtrans='$IDtrans'");
$a=mysql_fetch_array($sql2);
$etat=$a['etat'];
$modeT=$a['modeT'];
$ref=$a['ref'];
$typeT=$a['typeT'];
$montant=$a['montant'];
//$compteVal=$a['compteVal'];
if($etat == 'R'){
    if($typeT == 'RT'){
        $sql4=mysql_query("UPDATE compte_banque SET soldeR=soldeR+'$montant' WHERE  REFcompte='$compte'");
    }else{
        $sql4=mysql_query("UPDATE compte_banque SET soldeR=soldeR-'$montant' WHERE  REFcompte='$compte'");
    }
}
$sql3=mysql_query("DELETE FROM transaction_compte WHERE  IDtrans='$IDtrans'");
$msg=" a supprimé un ".$modeT."  N° <b>".$ref."</b> Montant ".$montant;
$His=mysql_query("INSERT INTO historique(user_id,action,tab,ligne,date_heure)VALUES('$userID','$msg','transactionDelete','$IDtrans',NOW())");
mysql_close();
?>