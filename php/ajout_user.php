<?php
session_start();
include('../connexion/connexionDB.php');
	
// get data from HTMP POST
	

	
    $login = $_POST['login'];
	$pswd = $_POST['pswd'];
	$role = $_POST['role'];
	

 //requete SQL insertion dans database
 
$sql = "INSERT INTO users (login, pswd, role) 
VALUES ('$login', '$pswd', '$role')";



if (!mysql_query($sql)) {
die('Error: ' . mysql_error()); 
    header('Location: ../pages/admin_ajout_users.php?status=fail');
}else{  
     header('Location: ../pages/admin_ajout_users.php?status=sent');
}  
$maxid=mysql_query("select MAX(ID) from users");
$idmax=mysql_result($maxid,0);
$userid=$_SESSION['userID'];
$req=mysql_query("INSERT INTO historique(user_id,action,tab,ligne,date_heure)VALUES('$userid','add','users','$idmax',NOW())"); 

?>