<?php
session_start();
$IDoperateur=$_SESSION['userID'];
include('../connexion/connexionDB.php');
  $file = $_FILES['expF'];
    
	if(!file_exists($_FILES['expF']['tmp_name'])){
	 $msg= " demi wilyééé";
  $sql4=mysql_query("INSERT INTO notification(emetteur, destinataire, message, dateN,chemin) VALUES ('ADM','ADM','$msg',NOW(),'msg')");
	}else{
	

///Traitement du fichier 
	$fichier = basename($_FILES['expF']['name']);
	$fichier1=$_FILES['expF']['tmp_name'];
	
    $taille = filesize($_FILES['expF']['tmp_name']);
    $extensions = array('.png', '.gif', '.jpg', '.jpeg');
    $extension = strrchr($_FILES['expF']['name'], '.');
    $typeF=$_FILES['expF']['type'];
	
   $msg= " wilyééééééééééééééééé";
  $sql4=mysql_query("INSERT INTO notification(emetteur, destinataire, message, dateN,chemin) VALUES ('ADM','ADM','$msg',NOW(),'msg')");
  

}
mysql_close();
?>