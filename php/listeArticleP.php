<?php
include('../connexion/connexionDB.php');
$IDordre=$_POST['IDordre'];
$sql = "SELECT DISTINCT IDarticle FROM ordre_prevision where IDordre='$IDordre'";
echo '<option value="S">---Select---</option>';
$res = mysql_query($sql) or exit(mysql_error());
while($data=mysql_fetch_array($res)) {
    echo '<option value="'.$data["IDarticle"].'">'.$data["IDarticle"].'</option><br/>';
}
mysql_close();
?>