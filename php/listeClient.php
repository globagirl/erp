<?php
include('../connexion/connexionDB.php');
$sql = "SELECT * FROM client1";
$res = mysql_query($sql) or exit(mysql_error());
echo '<option value="s">---Select---</option><br/>';
while($data=mysql_fetch_array($res)) {
    echo '<option value="'.$data["name_client"].'">'.$data["nomClient"].'</option><br/>';
}
mysql_close();
?>