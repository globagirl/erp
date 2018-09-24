<?php
include('../connexion/connexionDB.php');

$PH=$_POST['PH'];
$sq=mysql_query("DELETE FROM public_holiday WHERE idPH='$PH'");

?>