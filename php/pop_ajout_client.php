<?php
session_start();
include('../connexion/connexionDB.php');
$name_client = $_POST['clt'];
$adr_client = $_POST['adr_clt'];
$adress_fact = $_POST['adr_liv'];
$adress_liv = $_POST['adr_fact'];
$pays_client = $_POST['pays'];
$cont1 = $_POST['ctc_1'];
$mail1 = $_POST['mail_1'];
$tel1 = $_POST['tel_1'];
$fax1 = $_POST['fax_1'];
$cont2 = $_POST['ctc_2'];
$mail2 = $_POST['mail_2'];
$tel2 = $_POST['tel_2'];
$fax2 = $_POST['fax_2'];
$sql = "INSERT INTO client1 (name_client, adr_client, adress_fact, adress_liv, pays_client, cont1, cont2, tel1, tel2, mail1, mail2, fax1,fax2) 
VALUES ('$name_client', '$adr_client', '$adress_fact', '$adress_liv', '$pays_client', '$cont1', '$cont2', '$tel1', '$tel2', '$mail1', '$mail2', '$fax1','$fax2')";
if (!mysql_query($sql)) {
    die('Error: ' . mysql_error());
    header('Location: ../pages/pop_ajout_client.php?status=fail');
}else{
    header('Location: ../pages/pop_ajout_client.php?status=sent');
}
mysql_close();
?>