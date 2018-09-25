<?php
session_start();
include('../connexion/connexionDB.php');
$userID=$_SESSION['userID'];
$idTrans= $_POST['idTrans'];
$ref = $_POST['ref'];
$sql1=mysql_query("UPDATE transaction_compte SET ref='$ref' WHERE IDtrans='$idTrans'");
$msg="a modifié la refrence de la  transaction N° <b>".$IDtrans."</b> ,";
$His=mysql_query("INSERT INTO historique(user_id,action,tab,ligne,date_heure)VALUES('$userID','$msg','update_transaction','$IDtrans',NOW())");
?>