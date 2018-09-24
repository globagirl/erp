<?php
include('../connexion/connexionDB.php');
$sql = "SELECT * FROM produit1";
$res = mysql_query($sql) or exit(mysql_error());
echo '<option value="s">---Selectionnez</option><br/>'; 
while($data=mysql_fetch_array($res)) {
   echo '<option value="'.$data["code_produit"].'">'.$data["code_produit"].'</option><br/>'; 
}

mysql_close(); 
?>