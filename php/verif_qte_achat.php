<?php 
include('../connexion/connexionDB.php');
$art=$_POST['art'];
$qte=$_POST['qte'];

$sql = mysql_query("SELECT restrictCMD FROM article1 where code_article='$art'");
$x=mysql_result($sql,0);
$y=$qte%$x;
if($y > 0){
  echo $x;
}else{
  echo $y;
}


?>
	
