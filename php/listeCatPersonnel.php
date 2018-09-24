<?php
include('../connexion/connexionDB.php');

$sql = "SELECT DISTINCT category FROM personnel_info ";
$res = mysql_query($sql) or exit(mysql_error());
echo '<option value="s">---Category</option><br/>'; 
while($data=mysql_fetch_array($res)) {
   echo '<option value="'.$data["category"].'">'.$data["category"].'</option><br/>'; 
}

mysql_close(); 
?>