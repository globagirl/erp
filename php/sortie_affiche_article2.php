<?php
include('../connexion/connexionDB.php');
$PRD=$_POST['PRD'];


$i=0;
////////////////////////
$sql = "SELECT * FROM produit_article1 where IDproduit='$PRD'";
$res = mysql_query($sql) or exit(mysql_error());
 echo"<table ><thead>";
while($data=mysql_fetch_array($res)) {
	$i++;

	$art=$data["IDarticle"];
	
	$sql2=mysql_query("select * from article1 where code_article='$art'");
	$data2=mysql_fetch_array($sql2);
    $stock=$data2["stock"];	
	$unit=$data2["unit"];
  echo"<tr><th>Article ".$i." </th><td style=\" background-color:#F8E0E6  ;text-align:center\">$art</td>
  
  <th>Stock</th><td style=\"background-color:#F2E0F7 ; text-align:center\">$stock $unit</td></tr>";
}
echo '</thead></table>';
?>
