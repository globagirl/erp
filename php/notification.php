<?php
session_start();
 include('../connexion/connexionDB.php');
$IDnote=$_POST['IDnote'];
$sql=mysql_query("UPDATE notification SET statut='Y',dateV=NOW() WHERE IDnote='$IDnote'");
$sql2=mysql_query("SELECT chemin  FROM notification WHERE IDnote='$IDnote'");
$chemin=mysql_result($sql2,0);
echo $chemin;
mysql_close();
?>