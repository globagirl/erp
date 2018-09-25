<?php
include('../connexion/connexionDB.php');

$sql = "SELECT typeCat,catName FROM invoice_category where typeCat='D' or typeCat='A' ";
$res = mysql_query($sql) or exit(mysql_error());
echo '<option value="s">---Category</option><br/>';
while($data=mysql_fetch_array($res)) {
    echo '<option value="'.$data["catName"].'">'.$data["catName"].'</option><br/>';
}
mysql_close();
?>