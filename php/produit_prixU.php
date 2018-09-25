<?php
include('../connexion/connexionDB.php');
$produit=@$_POST['produit'];
$sq=mysql_query("select  price from  prices where (IDproduit='$produit') and (marginL = '1') and (marginH ='-1')");
if(mysql_num_rows($sq)>=0)
{
    $prix=mysql_result($sq,0);
    echo ($prix);
}else {
    echo ("0");
}
mysql_close();
?>