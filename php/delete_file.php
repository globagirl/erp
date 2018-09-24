<?php
include('../connexion/connexionDB.php');

$F=$_POST['F'];
$T=$_POST['T'];
$F=str_replace('|',' ',$F);
$sq1=mysql_query("select dataF FROM $T WHERE nameF='$F'");
$D=mysql_result($sq1,0);

unlink ($D);

$sq=mysql_query("DELETE FROM $T WHERE nameF='$F'");
mysql_close();

?>