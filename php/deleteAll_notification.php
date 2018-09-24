<?php
session_start();
 include('../connexion/connexionDB.php');
 $role=$_SESSION['role'];
 $userID=$_SESSION['userID'];

$sql=mysql_query("UPDATE notification SET statut='Y' WHERE ((destinataire='$role' or destinataire='$userID') and (statut='N')) ");

echo("<div class=\"list-group-item divNote\"><center>Vous n'avez aucune notification <img src=\"../image/face2.png\" alt=\"Log Out\" width=\"50\" height=\"25\">  </center></div><br>");

mysql_close();
?>