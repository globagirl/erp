<?php
include('../connexion/connexionDB.php');
$qty=@$_POST['qty'];
$PO=@$_POST['PO'];
$OF=@$_POST['OF'];
$sql=mysql_query("select qte from ordre_fabrication1 where PO='$PO' and OF !='$OF'");
$somme=0;
while($data=mysql_fetch_array($sql)) {
    $somme=$data['qte']+$somme;
}
$sql2=mysql_query("select qty from commande_items where POitem='$PO'");
$qtyC=mysql_result($sql2,0);
$total=$qty+$somme;
if($total>$qtyC){
    echo "1";
}else if($total==$qtyC){
    echo "planned";
}else{
    echo "incomplete";
}
mysql_close();
?>