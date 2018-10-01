<?php
session_start();
include('../connexion/connexionDB.php');
$IDuser=$_SESSION['userID'];
$sqlOP=mysql_query("select nom from users1 where ID='$IDuser'");
$user=mysql_result($sqlOP,0);
$msg=$_POST['msg'];
$des=$_POST['des'];
$sql4="INSERT INTO message(emetteur, destinataire, messageText, dateM) VALUES ('$IDuser','$des','$msg',NOW())";
if (mysql_query($sql4)) {
//Notification
    $msg= " You have a message from : <b>".$user."</b>";
    $sql4=mysql_query("INSERT INTO notification(emetteur, destinataire, message, dateN,chemin) VALUES ('$user','$des','$msg',NOW(),'msg')");
    echo "1";
}else{
    echo "Fail !! PLZ try agian!! ";
}
mysql_close();
?>