<?php
include('../connexion/connexionDB.php');
$supplier=$_POST['supplier'];
$sql = "SELECT * FROM ordre_achat2 where ((statut='waiting' or statut='incomplete') and (fournisseur='$supplier'))";
$res = mysql_query($sql) or exit(mysql_error());
echo '<option value="s">---Select---</option><br/>';
while($data=mysql_fetch_array($res)) {
    echo '<option value="'.$data["IDordre"].'">'.$data["IDordre"].'</option><br/>';
}
mysql_close();
?>