<?php
session_start ();
include('../connexion/connexionDB.php');
$date_e = date("Y-m-d H:i:s");
$q_sor = @$_POST['q_sor'];
$q_reb = @$_POST['q_reb'];
$ws_missing = @$_POST['ws_missing'];
$strip_miss = @$_POST['strip_miss'];
$strip_length = @$_POST['strip_length'];
$ws_pos = @$_POST['ws_pos'];
$ws_aspect = @$_POST['ws_aspect'];
$contact_aspect = @$_POST['contact_aspect'];
$other = @$_POST['other'];
$id = $_SESSION['IDupmCRI'];
$sql = "UPDATE upm_crimping SET date_fin='$date_e',qte_s='$q_sor',q_reb='$q_reb',wire_seal_missing='$ws_missing',
stripping_missing='$strip_miss',length_of_stripping='$strip_length',position_of_wire_seal='$ws_pos',
wire_seal_aspect='$ws_aspect',contact_aspect='$contact_aspect',other='$other' WHERE id_cri='$id'";
if (!mysql_query($sql)) {
    die('Error: ' . mysql_error());
    echo '<SCRIPT LANGUAGE="JavaScript">alert(\'Database error: Error connecting to database!\');</SCRIPT>';
}else{
    unset($_SESSION['IDupmCRI']);
    //  echo '<SCRIPT LANGUAGE="JavaScript">alert(\'Terminé avec Succèes\');</SCRIPT>';
    header('Location: ../pages/upm_crimping_deb.php?status=sent');
}
mysql_close();
?>
