<?php
include('../connexion/connexionDB.php');
$PO=$_POST['PO'];

$sq=mysql_query("select * from commande_items where POitem='$PO'");
if(mysql_num_rows($sq)>0){
$data1=mysql_fetch_array($sq);
$produit=$data1['produit'];
$qte=$data1['qty'];

$i=0;
////////////////////////
$sql = "SELECT * FROM produit_article1 where IDproduit='$produit'";
$res = mysql_query($sql) or exit(mysql_error());
 echo"<table ><thead> 

 <th colspan=5><b> Item ID : ".$produit."<b><input type=\"texte\" value=\"".$produit."\" id=\"PRD\" name= \"PRD\" /HIDDEN></td></tr>";
while($data=mysql_fetch_array($res)) {
	$i++;
	$b1=$data["qte"];
	$besoin=$b1*$qte;
	$art=$data["IDarticle"];
	
	$sql2=mysql_query("select * from article1 where code_article='$art'");
	$data2=mysql_fetch_array($sql2);
    $stock=$data2["stock"];	
	$unit=$data2["unit"];
  echo"<tr><th>Article ".$i." </th><td style=\" background-color:#F8E0E6  ;text-align:center\">$art</td>
  <td style=\" text-align:center\">$besoin  $unit</td>
  <th>Stock</th><td style=\"background-color:#F2E0F7 ; text-align:center\">$stock $unit</td></tr>";
}
echo '</thead></table>';
}else{
echo "0"; 
}
mysql_close();
?>
