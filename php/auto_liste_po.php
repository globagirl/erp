<?php
include('../connexion/connexionDB.php');
$val=$_POST['val'];
$Z=$_POST['Z'];

$sql = "SELECT * FROM commande_items where POitem LIKE '$val%'";
$res = mysql_query($sql) or exit(mysql_error());

while($data=mysql_fetch_array($res)) {
   echo "<li onmouseover=choixListe('".$data["POitem"]."','".$Z."')>".$data["POitem"].'</li>'; 
}
mysql_close();

?>