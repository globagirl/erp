<?php
session_start();
$IDoperateur=$_SESSION['userID'];
include('../connexion/connexionDB.php');
      //historique
     $HIS=mysql_query("INSERT INTO historique(user_id,action,date_heure)VALUES('$IDoperateur','disconnect',NOW())"); 
	   //
mysql_close();
session_unset();
session_destroy();
header('Location: ../index.php?status=sent');
?>