<?php
include('../connexion/connexionDB.php');
$paq=$_POST['paq'];
$art=@$_POST['art'];
if($paq == "R"){
    $sq=mysql_query("select stock_rebut from article1 where code_article='$art'");
    $paqS=mysql_result($sq,0);
    $paqS=round($paqS,2);
}else{
    $sq=mysql_query("select qte_res,qte_att from paquet2 where IDpaquet='$paq'");
    $data=mysql_fetch_array($sq);
    $qte_res=$data['qte_res'];
    $qte_att=$data['qte_att'];
    $paqS=$qte_res-$qte_att;
    $paqS=round($paqS,2);
}
echo $paqS;
mysql_close();
?>