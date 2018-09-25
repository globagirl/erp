<?php
include('../connexion/connexionDB.php');
$IDordre=$_POST['IDordre'];
$art=$_POST['art'];
$sql = "SELECT * FROM ordre_prevision where IDordre='$IDordre' and IDarticle='$art'";
$res = mysql_query($sql) or exit(mysql_error());
while($data=mysql_fetch_array($res)){
    echo '<p> '.$data['dateP'].' ==> '.$data['qty'];
}
mysql_close();
?>