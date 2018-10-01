<?php
session_start();
include('../connexion/connexionDB.php');
$IDuser=$_SESSION['userID'];
$sqlOP=mysql_query("select nom from users1 where ID='$IDuser'");
$user=mysql_result($sqlOP,0);
$msg=$_POST['msg'];
$des=$_POST['des'];
///Traitement du fichier
$fichier = basename($_FILES['myfile']['name']);
$fichier1=$_FILES['myfile']['tmp_name'];
//verifier existance
$sqlF=mysql_query("SELECT * from message_files where nameF like '%$fichier'");
$max1=mysql_num_rows($sqlF);
$max1++;
$fichierName=$max1.'-'.$fichier;
//
$taille = filesize($_FILES['myfile']['tmp_name']);
$extensions = array('.png', '.gif', '.jpg', '.jpeg');
$extension = strrchr($_FILES['myfile']['name'], '.');
$typeF=$_FILES['myfile']['type'];
rename($fichier,$fichierName);
$destination='../files/messageFiles/'.$fichierName;
if(move_uploaded_file($fichier1,$destination)){
    $sql1=mysql_query("INSERT INTO message_files(nameF, typeF, sizeF, upDateF, dataF) VALUES ('$fichierName','$typeF','$taille',NOW(),'$destination')");
    $msg2= $msg." <a href=\"../files/messageFiles/".$fichierName."\" target=\"_blank\">".$fichierName."</a>";
    $sql4=mysql_query("INSERT INTO message(emetteur, destinataire, messageText, dateM,fileM) VALUES ('$IDuser','$des','$msg2',NOW(),'$fichierName')");
    //Notification
    $msg= " you've got a message From : <b>".$user."</b>";
    $sql4=mysql_query("INSERT INTO notification(emetteur, destinataire, message, dateN,chemin) VALUES ('$user','$des','$msg',NOW(),'msg')");
    header('Location: ../pages/home.php');
}else{
    echo("PLZ contact the system manager!!");
}
mysql_close();
?>