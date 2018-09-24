<?php
session_start();
include('../connexion/connexionDB.php');
    $mat = $_POST['mat'];
    $newMat = $_POST['newMat'];

$sql=mysql_query("INSERT INTO personnel_doublep(newMat,mat)	VALUES ('$newMat','$mat')");

	
    header('Location: ../pages/ajout_doubleP.php');



?>