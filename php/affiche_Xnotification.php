<?php
session_start ();
$role=$_SESSION['role'];
$userID=$_SESSION['userID'];
include('../connexion/connexionDB.php');
$sql = mysql_query("SELECT * FROM notification where ((destinataire='$role' or destinataire='$userID') and (statut='N')) ORDER BY IDnote DESC");
$i=0;
//echo("<br>");

$X=mysql_num_rows($sql);

echo($X);
//echo ("<input type=text value=\"".$X."\" id=\"Xnote2\" size=1>"); ;

mysql_close();
?>