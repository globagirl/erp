<?php
include('../connexion/connexionDB.php');
$item=$_POST['item'];
$sql = "SELECT prix FROM article1 where code_article='$item'";
$res = mysql_query($sql) or exit(mysql_error());
 if(mysql_num_rows($res)>0){
	 $prix=mysql_result($res,0);
	 echo($prix);
 }else{
	 echo("NO");
 }
?>