<?php
include('../connexion/connexionDB.php');

$D=$_POST['D'];
$sq=mysql_query("DELETE FROM personnel_doublep WHERE newMat='$D'");

?>