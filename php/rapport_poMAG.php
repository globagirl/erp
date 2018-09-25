<?php
include('../connexion/connexionDB.php');
$PO=@$_POST['PO'];
$req=mysql_query ("SELECT * FROM commande2 where PO='$PO' ");
if(mysql_num_rows($req)>0){
    $data=mysql_fetch_array($req);
    $req1=mysql_query ("SELECT * FROM commande_items where PO='$PO' ");
    echo 'yeeeeeeeeeeeeah';
}else{echo 0 ; }
?>