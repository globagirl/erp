<?php
include('../connexion/connexionDB.php');
$ID=$_POST['ID'];
$val=$_POST['val'];
$sql2=mysql_query("UPDATE personnel_absence SET Etat='$val' where idAB='$ID'");
?>