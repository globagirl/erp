<?php
include('../connexion/connexionDB.php');
$sql = "SELECT REFcompte FROM compte_banque";
$res = mysql_query($sql) or exit(mysql_error());
echo '<option value="s">Selectionnez ... </option><br/>';

while($data=mysql_fetch_array($res)) {
   echo '<option value="'.$data["REFcompte"].'">'.$data["REFcompte"].'</option><br/>';
}

mysql_close();
?>
