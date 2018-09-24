<?php
include('../connexion/connexionDB.php');
$R=$_POST['R'];;
$val=$_POST['val'];
$Z=$_POST['Z'];

$sql = "SELECT * FROM  personnel_info where $R LIKE'%$val%'";
$res = mysql_query($sql) or exit(mysql_error());
if($R=="NCIN"){
while($data=mysql_fetch_array($res)) {
   echo "<li onmouseover=choixListe('".$data["NCIN"]."','".$Z."')>".$data["NCIN"]."</li>"; 
 }  
}else if($R=="nom"){
while($data=mysql_fetch_array($res)) {
$text=$data["nom"];
$text=str_replace(' ','|',$text);
$text=str_replace(' ','|',$text);
$text=str_replace(' ','|',$text);
$text=str_replace(' ','|',$text);
echo "<li onmouseover=choixListe('".$text."','".$Z."')>".$data["nom"]."</li>"; 
   }
}else{
while($data=mysql_fetch_array($res)) {
   echo "<li onmouseover=choixListe('".$data["matricule"]."','".$Z."')>".$data["matricule"]."</li>"; 
}
}
mysql_close();
?>