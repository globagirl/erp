<?php
include('../connexion/connexionDB.php');
$val=$_POST['val'];
$Z=$_POST['Z'];

$sql = "SELECT * FROM ordre_fabrication1 where OF LIKE '$val%' and statut='planned'";
$res = mysql_query($sql) or exit(mysql_error());

while($data=mysql_fetch_array($res)) {
   echo "<li onmouseover=choixListe('".$data["OF"]."','".$Z."')>".$data["OF"].'</li>'; 
}
mysql_close();

?>