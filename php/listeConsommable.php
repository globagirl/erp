<?php
include('../connexion/connexionDB.php');

$sql = "SELECT * FROM article1 where typeA='Consumable'";	


$res = mysql_query($sql) or exit(mysql_error());
echo '<option value="s">---Selectionnez</option><br/>'; 
while($data=mysql_fetch_array($res)) {
   echo '<option value="'.$data["code_article"].'">'.$data["code_article"].'</option><br/>'; 
}

mysql_close(); 
?>