<?php
include('../connexion/connexionDB.php');

$sql = "SELECT DISTINCT categorie FROM produit1 ";
$res = mysql_query($sql) or exit(mysql_error());
echo '<option value="s">---Category</option><br/>'; 
while($data=mysql_fetch_array($res)) {
$cat=$data["categorie"];
if($cat != ""){
   echo '<option value="'.$data["categorie"].'">'.$data["categorie"].'</option><br/>'; 
}
}
mysql_close(); 
?>