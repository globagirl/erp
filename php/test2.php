<?php
include('../connexion/connexionDB.php');
/*
$sql=mysql_query("SELECT * FROM historique_prices");
while($data=@mysql_fetch_array($sql)){
 $typeH=$data['typeH'];
 $item=$data['item'];
 $prixA=$data['ancien_prix'];
 $prixN=$data['nouveau_prix'];
 $dateM=$data['dateM'];
 $x=rand(1,999);
 $y=rand(8,989);
 $z=rand(1,999);
 $ID=$x.$y.$z;
 if($typeH=="client"){
  $sql1=mysql_query("INSERT INTO update_prices_product(ID, item, ancien_prix, nouveau_prix, dateM) VALUES
  ('$ID','$item','$prixA','$prixN','$dateM')");
 }else{
  $four=$data['cl_four'];
  $sql1=mysql_query("INSERT INTO update_prices_item(ID,four, item, ancien_prix, nouveau_prix, dateM) VALUES
  ('$ID','$four','$item','$prixA','$prixN','$dateM')");
 }
}
*/
$jourJ=date("Y-m-d");
$jourJ=strtotime($jourJ);
$num = strftime("%m",$jourJ);
echo $num;
mysql_close();
?>