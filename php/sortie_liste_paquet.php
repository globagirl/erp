<?php
include('../connexion/connexionDB.php');
$article=$_POST['article'];
$sql = "SELECT * FROM paquet2 where IDarticle='$article' and qte_res>0";
$res = mysql_query($sql) or exit(mysql_error());
echo '<option value="S">---Select---</option><br/>';
echo '<option value="R">---Rebut---</option><br/>';
while($data=mysql_fetch_array($res)) {
    echo '<option value="'.$data["IDpaquet"].'">'.$data["IDpaquet"].'</option><br/>';
}
mysql_close();
?>