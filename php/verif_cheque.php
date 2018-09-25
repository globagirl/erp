<?php
include('../connexion/connexionDB.php');
$ref=$_POST['ref'];
$compte=$_POST['compte'];
$sq=mysql_query("select ref FROM transaction_compte WHERE ref LIKE '$ref' and compte='$compte' ");
$nbr=mysql_num_rows($sq);
if($nbr>0){
    echo 1;
}else{
    echo 0;
}
mysql_close();
?>