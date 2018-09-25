<?php
session_start();
include('../connexion/connexionDB.php');
$date_e = date("Y-m-d H:i:s");
$qte_e = @$_POST['qte_e'];
$q_sor = @$_POST['q_sor'];
$q_reb = @$_POST['q_reb'];
$blurr = @$_POST['blurr'];
$miss = @$_POST['miss'];
$box = @$_POST['box'];
$other = @$_POST['other'];
$id = $_SESSION['IDupmPAK'];
$sql = "UPDATE upm_packaging SET date_fin='$date_e',
qte_s='$q_sor',q_reb='$q_reb',blurred_printing_of_label='$blurr',misplaced_label='$miss',box_acpect='$box ',other='$other' WHERE id_pak='$id'";
$sq=mysql_query("select plan from upm_packaging where id_pak='$id'");
$plan=mysql_result($sq,0);
$sql13=mysql_query("UPDATE plan1 SET date_fin=CURRENT_TIMESTAMP() where numPlan='$plan'");
if (!mysql_query($sql)) {
    die('Error: ' . mysql_error());
    header('Location: ../pages/upm_packaging.php?status=fail');
}else{
    mysql_query($sql2);
    unset($_SESSION['IDupmPAK']);
    header('Location: ../pages/upm_packaging_deb.php?status=sent');
}
mysql_close();
?>