<?php
include('../connexion/connexionDB.php');
$art=$_POST['art'];
$sql = mysql_query("SELECT stock FROM article1 where code_article LIKE '$art'");
$S1=mysql_result($sql,0);
$sql1 = mysql_query("SELECT sum(qte_res) FROM paquet2 where IDarticle LIKE '$art'");
$S2=mysql_result($sql1,0);
$S2=round($S2,2);
$sql2 = mysql_query("UPDATE article1 SET stock='$S2' where code_article LIKE '$art'");
echo '<div class="well"> <p> <b>Old stock : </b> '.$S1.'</p></div>';
echo '<div class="well"> <p><b> New stock : </b>'.$S2.'</p></div>';
mysql_close();
?>