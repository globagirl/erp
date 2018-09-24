<?php
include('../connexion/connexionDB.php');
$val=$_POST['val'];
$Z=$_POST['Z'];

$sql = "SELECT code_article,stock_min FROM  article1 where code_article LIKE '$val%'";
$res = mysql_query($sql) or exit(mysql_error());

while($data=mysql_fetch_array($res)) {
   echo "<li onmouseover=choixListe('".$data["code_article"]."','".$Z."')>".$data["code_article"].'</li>'; 
}
mysql_close();

?>