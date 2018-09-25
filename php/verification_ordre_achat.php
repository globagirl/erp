<?php
session_start();
include('../connexion/connexionDB.php');
$ordre = $_POST['ordre'];
$statut="closed";
$sql="UPDATE ordre_achat2 SET statut='$statut' WHERE IDordre='$ordre'";
if (!mysql_query($sql)) {
    die('Error: ' . mysql_error());
    header('Location: ../pages/verification_ordre_achat.php?status=fail');
}else{
    header('Location: ../pages/verification_ordre_achat.php?status=sent');
}
mysql_close();
?>