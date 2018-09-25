<?php
session_start();
include('../connexion/connexionDB.php');
$reception = $_POST['reception'];
$statut="closed";
$sql="UPDATE reception_ordre_achat1 SET statut='$statut' WHERE idRO='$reception'";
if (!mysql_query($sql)) {
    die('Error: ' . mysql_error());
    header('Location: ../pages/verification_reception_ordre.php?status=fail');
}else{
    header('Location: ../pages/verification_reception_ordre.php?status=sent');
}
mysql_close();
?>