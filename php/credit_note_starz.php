<?php
session_start();
include('../connexion/connexionDB.php');
$fact=@$_POST['fact'];
$cl_four=@$_POST['cl_four'];
$valeur=@$_POST['valeur'];
$amount=@$_POST['amount'];
$devise=@$_POST['devise'];
$CN=@$_POST['CN'];

$sql = "INSERT INTO credit_note_starz(idCN,amount,devise,IDfact,dateCN,supplier,type)
VALUES ('$CN','$amount','$devise','$fact',NOW(),'$valeur','$cl_four')";


if (!mysql_query($sql)) {
die('Error: ' . mysql_error());

}else{


    header('Location: ../pages/credit_note_starz.php');

}

?>
