<?php
include('../connexion/connexionDB.php');
$sql = "SELECT * FROM fournisseur1 ";
$res = mysql_query($sql) or exit(mysql_error());
echo '<option value="s">---Selectionnez</option><br/>';
while($data=mysql_fetch_array($res)) {
    echo '<option value="'.$data["nom"].'">'.$data["nom"].'</option><br/>';
}
mysql_close();
?>