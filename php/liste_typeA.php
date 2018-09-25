<?php
include('../connexion/connexionDB.php');
$sql = "SELECT * FROM  article_type where description='Production'";
$res = mysql_query($sql) or exit(mysql_error());
echo '<option value="s">---Selectionnez</option><br/>';
while($data=mysql_fetch_array($res)) {
    echo '<option value="'.$data["IDtype"].'">'.$data["IDtype"].'</option><br/>';
}
mysql_close();
?>