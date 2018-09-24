<?php
session_start();
include('../connexion/connexionDB.php');
    $nom = $_POST['four'];
    $adr = $_POST['adr_four'];
	$adr_magas = $_POST['adr_magas'];
	$pays = $_POST['pays'];
	$contact_1 = $_POST['ctc_1'];
	$mail_1 = $_POST['mail_1'];
	$tel_1 = $_POST['tel_1'];
	$fax_1 = $_POST['fax_1'];
	$contact_2 = $_POST['ctc_2'];
	$mail_2 = $_POST['mail_2'];
	$tel_2 = $_POST['tel_2'];
	$fax_2 = $_POST['fax_2'];
	$t = $_POST['t'];
	
$sql = "INSERT INTO fournisseur1 (nom,typeF, adr, adr_magas, pays, contact_1, mail_1, tel_1, fax_1, contact_2, mail_2, tel_2, fax_2) 
VALUES ('$nom','$t' ,'$adr', '$adr_magas', '$pays', '$contact_1', '$mail_1', '$tel_1', '$fax_1', '$contact_2', '$mail_2', '$tel_2', '$fax_2')";
if (!mysql_query($sql)) {
die('Error: ' . mysql_error()); 
    header('Location: ../pages/pop_ajout_fournisseur.php?status=fail');
}else{  
     header('Location: ../pages/pop_ajout_fournisseur.php?status=sent');
}
 mysql_close();

?>