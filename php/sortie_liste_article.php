<?php
include('../connexion/connexionDB.php');
$produit=$_POST['produit'];

$sql = "SELECT * FROM produit_article1 where IDproduit='$produit'";
echo '<option value="s">---Selectionnez</option><br/>'; 
$res = mysql_query($sql) or exit(mysql_error());
while($data=mysql_fetch_array($res)) {
   echo '<option value="'.$data["IDarticle"].'">'.$data["IDarticle"].'</option><br/>'; 
}
mysql_close();
?>