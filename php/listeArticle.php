<?php
include('../connexion/connexionDB.php');
$typeA=$_POST['typeA'];
$sql = "SELECT * FROM article1 where typeA='$typeA'";
$res = mysql_query($sql) or exit(mysql_error());
while($data=mysql_fetch_array($res)) {
    echo '<option value="'.$data["code_article"].'">'.$data["code_article"].'</option><br/>';
}
mysql_close();
?>