<?php
session_start();
include('../connexion/connexionDB.php');
$date_e = date("Y-m-d H:i:s");
$qte_e = $_POST['qte_e'];
$q_sor = $_POST['q_sor'];
$q_reb = $_POST['q_reb'];
$pos = @$_POST['pos'];
$orientation = @$_POST['orientation'];
$other = @$_POST['other'];
$id = $_SESSION['IDupmWSI'];
$sql = "UPDATE upm_ws_insertion SET date_fin='$date_e',q_sor='$q_sor',q_reb='$q_reb',
wire_seal_position_problem='$pos',orientation_problem='$orientation',other='$other' WHERE id_wsi='$id'";
if (!mysql_query($sql)) {
    die('Error: ' . mysql_error());
    header('Location: ../pages/upm_ws_insertion.php?status=fail');
}else{
    mysql_query($sql2);
    unset($_SESSION['IDupmWSI']);
    header('Location: ../pages/upm_ws_insertion_deb.php?status=sent');
}
mysql_close();
?>