<?php
include('../connexion/connexionDB.php');
$supplier=$_POST['supplier'];
$sql = "SELECT * FROM reception where status='waiting' and supplier='$supplier'";
$res = mysql_query($sql) or exit(mysql_error());
echo '<option value="s"> Reception ID</option><br/>';
while($data=mysql_fetch_array($res)) {
    echo '<option value="'.$data["IDreception"].'">'.$data["IDreception"].'</option><br/>';
}
mysql_close();
?>