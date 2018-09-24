<?php
include('../connexion/connexionDB.php');
$val=$_POST['val'];
$Z=$_POST['Z'];

$sql = "SELECT * FROM produit1 where code_produit LIKE'$val%' and statut='C'";
$res = mysql_query($sql) or exit(mysql_error());

while($data=mysql_fetch_array($res)) {
   echo "<li onmouseover=choixListe('".$data["code_produit"]."','".$Z."')>".$data["code_produit"].'</li>'; 
}
mysql_close();

?>