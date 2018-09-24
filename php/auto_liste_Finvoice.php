<?php
include('../connexion/connexionDB.php');
$val=$_POST['val'];
$Z=$_POST['Z'];

$sql = "SELECT DISTINCT supplier FROM supplier_invoice where supplier LIKE '%$val%'";
$res = mysql_query($sql) or exit(mysql_error());

while($data=mysql_fetch_array($res)) {
   $text=$data["supplier"];
   $text=str_replace(' ','|',$text);
   echo "<li onmouseover=choixListe('".$text."','".$Z."')>".$data["supplier"].'</li>'; 
}

mysql_close();
?>