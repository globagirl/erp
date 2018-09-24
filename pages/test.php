<?php
//include('../connexion/connexionDB.php');
/*$sql = mysql_query("SELECT idRI,qty from reception_items ");
while($data=mysql_fetch_array($sql)){
    $qty=$data['qty'];
    $idRI=$data['idRI'];   
    $sql3 = mysql_query("UPDATE reception_items SET qtyBR='$qty' where idRI='$idRI'");
    
}*/
$ch="net 60";
$val=stristr($ch," ");
$date_p = strtotime("17-02-2018 + ".$val." days");
$date_p= date('Y-m-d',$date_p);
echo $date_p;
//mysql_close();
?>