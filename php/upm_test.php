<?php
session_start();
include('../connexion/connexionDB.php');
$date_e = date("Y-m-d H:i:s");
$qte_e = $_POST['qte_e'];
$q_sor = $_POST['q_sor'];
$q_reb = $_POST['q_reb'];
$polarity = @$_POST['polarity'];
$short_circuit = @$_POST['short_circuit'];
$continu = @$_POST['continu'];
$hipot = @$_POST['hipot'];
$other = @$_POST['other'];
$id = $_SESSION['IDupmTST'];
$sql = "UPDATE upm_test SET date_fin='$date_e',q_sor='$q_sor',q_reb='$q_reb',polarity='$polarity',short_circuit='$short_circuit',continuity='$continu',
hipot='$hipot',other='$other' WHERE id_tst='$id'";
if (!mysql_query($sql)) {
    die('Error: ' . mysql_error());
    header('Location: ../pages/upm_test.php?status=fail');
}else{
    mysql_query($sql2);
    unset($_SESSION['IDupmTST']);
    header('Location: ../pages/upm_test_deb.php?status=sent');
}
mysql_close();
?>