<?php
include('../connexion/connexionDB.php');
$f1 =@$_POST['fact1'];
$f2 =@$_POST['fact2'];
$dateE=@$_POST['dateE'];
if($f2==""){
    $f2=$f1;
}
if($f1!=""){
$sql = mysql_query ("SELECT sum(qte) As sommeQty , count(num_fact) As nbr FROM fact1 WHERE num_fact BETWEEN $f1 AND $f2 ");
}else{
$sql = mysql_query ("SELECT sum(qte) As sommeQty , count(num_fact) As nbr FROM fact1 WHERE date_E LIKE '$dateE'");
}
$data=@mysql_fetch_array($sql);
echo "<div><h2>Total commande :".$data['nbr']."</h2>
<h2>Total qty :".$data['sommeQty']."</h2></div>";
mysql_close();
?>