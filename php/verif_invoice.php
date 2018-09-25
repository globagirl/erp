<?php
include('../connexion/connexionDB.php');
$fact=@$_POST['fact'];
$cl_four=@$_POST['cl_four'];
$valeur=@$_POST['val'];
if($cl_four=="client"){
    $sq=mysql_query("select * from  fact1 where client LIKE '$valeur' and num_fact='$fact'");
    if(mysql_num_rows($sq)>0)
    {
        echo "yes";
    }else {
        echo 0;
    }
}else{
    $iv="-".$fact;
    $sq=mysql_query("select * from supplier_invoice where IDinvoice LIKE '%$iv' and supplier LIKE '$valeur'");
    if(mysql_num_rows($sq)>0)
    {
        echo "yes";
    }else {
        echo 0;
    }
}
mysql_close();
?>