<?php
include('../connexion/connexionDB.php');
$item=@$_POST['item'];
$cl_four=@$_POST['cl_four'];
$valeur=@$_POST['val'];
if($cl_four=="client"){
    $sq=mysql_query("select price from  prices where IDproduit='$item'");
    if(mysql_num_rows($sq)>0)
    {
        $prix=@mysql_result($sq,0);
        echo $prix;
    }else {
        echo "X";
    }
}else{
    $sq=mysql_query("select prix from article1 where code_article='$item' and supplier LIKE '$valeur'");
    if(mysql_num_rows($sq)>0)
    {
        $prix=@mysql_result($sq,0);
        echo $prix;
    }else {
        echo "X";
    }
}
?>