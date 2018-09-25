<?php
include('../connexion/connexionDB.php');
$long=@$_POST['long'];
$sq=mysql_query("select * from cable_par_carton where length LIKE '$long'");
if(mysql_num_rows($sq)>0)
{
    $data=mysql_fetch_array($sq);
    $nbr=$data['nbr_paquet'];
    $tlot=$data['taille_lot'];
    echo $nbr."|".$tlot;
}
else {
    echo ("0");
}
mysql_close();
?>