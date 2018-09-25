<?php
session_start();
include('../connexion/connexionDB.php');
$date_e = date("Y-m-d H:i:s");
$qte_e = @$_POST['qte_e'];
$q_sor = @$_POST['q_sor'];
$q_reb = @$_POST['q_reb'];
$no_stripping = @$_POST['no_stripping'];
$brush = @$_POST['brush'];
$stripping_length = @$_POST['stripping_length'];
$other = @$_POST['other'];
$id =$_SESSION['IDupmSTR'] ;
$sql = "UPDATE upm_stripping SET date_fin='$date_e',q_sor='$q_sor',q_reb='$q_reb',no_stripping='$no_stripping',brush_aspect='$brush',
stripping_lenght='$stripping_length',other='$other' WHERE id_str='$id'";
if (!mysql_query($sql)) {
    die('Error: ' . mysql_error());
    header('Location: ../pages/upm_stripping.php?status=fail');
}else{
    mysql_query($sql2);
    unset($_SESSION['IDupmSTR']);
    header('Location: ../pages/upm_stripping_deb.php?status=sent');
}
mysql_close();
?>