<?php 
include('../connexion/connexionDB.php');
$reception=$_POST['reception'];
$i=0;
$sql = mysql_query("SELECT IDshipment FROM reception where IDreception='$reception'");
$data=mysql_result($sql,0);
echo($data);
?>
