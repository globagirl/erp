<?php
include('../connexion/connexionDB.php');
$IDtrans=$_POST['IDtrans'];
$req= "UPDATE  transaction_compte SET verif='Y',dateC=NOW() WHERE  IDtrans ='$IDtrans' ";
$r=mysql_query($req) or die(mysql_error());
mysql_close();
?>