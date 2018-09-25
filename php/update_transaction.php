<?php
session_start();
include('../connexion/connexionDB.php');
$userID=$_SESSION['userID'];
$idTrans= $_POST['idTrans'];
$montant = $_POST['montant'];
$sql=mysql_query("SELECT * FROM transaction_compte where IDtrans='$idTrans'");
$data=@mysql_fetch_array($sql);
$montantA=$data['montant'];
$compte=$data['compte'];
$typeT=$data['typeT'];
$etat=$data['etat'];
if($typeT == 'RT'){	  //retrait
    $sql1=mysql_query("UPDATE transaction_compte SET montant='$montant' WHERE IDtrans='$idTrans'");
    if($etat=="R"){
        $sql2=mysql_query("UPDATE compte_banque SET soldeR=soldeR+'$montantA' WHERE REFcompte='$compte'");
        $sql3=mysql_query("UPDATE compte_banque SET soldeR=soldeR-'$montant' WHERE REFcompte='$compte'");
    }
}else{ //recharge
    $sql1=mysql_query("UPDATE transaction_compte SET montant='$montant' WHERE IDtrans='$idTrans'");
    if($etat=="R"){
        $sql2=mysql_query("UPDATE compte_banque SET soldeR=soldeR-'$montantA' WHERE REFcompte='$compte'");
        $sql3=mysql_query("UPDATE compte_banque SET soldeR=soldeR+'$montant' WHERE REFcompte='$compte'");
    }
}
$msg="a modifié la transaction N° <b>".$IDtrans."</b> , ancien montant ".$montantA;
$His=mysql_query("INSERT INTO historique(user_id,action,tab,ligne,date_heure)VALUES('$userID','$msg','update_transaction','$IDtrans',NOW())");
?>