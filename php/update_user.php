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
echo "Mot de passe modifié avec succés";
}
else{
echo "Fail !! vérifier votre LOGIN & MOT DE PASSE ";
}
mysql_close();
?>