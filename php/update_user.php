<?php
session_start();
include('../connexion/connexionDB.php');
$IDuser=$_SESSION['userID'];
$login=$_POST['login'];
$passe1=$_POST['passe1'];
$passe2=$_POST['passe2'];
$sql=mysql_query("SELECT *  FROM users1 WHERE login='$login' and ID='$IDuser' and pswd='$passe1'");
if(mysql_num_rows($sql)>0){
    $sql=mysql_query("UPDATE users1 SET pswd='$passe2' WHERE ID='$IDuser' ");
    echo "Your password has been changed successfully!";
}
else{
    echo "Fail !! PLZ check your LOGIN and PASSWORD";
}
mysql_close();
?>