<?php
session_start();
include('../connexion/connexionDB.php');
$demande=$_POST['demande'];
$IDoperateur=$_SESSION['userID'];
$sqlOP=mysql_query("select nom from users1 where ID='$IDoperateur'");
$user=@mysql_result($sqlOP,0);
$sql = "UPDATE demande_relance SET statut='C2',dateV=NOW(),verificateur='$user' WHERE IDrelance='$demande'";
if (!mysql_query($sql)) {
    die('Error: ' . mysql_error());
    header('Location: ../pages/relance_confirmation2.php?status=fail');
}else{
//Notification
    $msg= " La DIRECTION  a confirmé la demande de relance N° :  ".$demande."";
    $sql4=mysql_query("INSERT INTO notification(emetteur, destinataire, message, dateN,chemin) VALUES ('$user','MAG','$msg',NOW(),'relance_sortie.php')");
    //Historique
    $His=mysql_query("INSERT INTO historique(user_id,action,tab,ligne,date_heure)VALUES('$IDoperateur','add','confirmation relance','$demande',NOW())");
    header('Location: ../pages/relance_confirmation2.php');
}
?>