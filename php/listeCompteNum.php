<?php
include('../connexion/connexionDB.php');
$sql = "SELECT REFcompte,NUMcompte,banque FROM compte_banque";
$res = mysql_query($sql) or exit(mysql_error());


while($data=mysql_fetch_array($res)) {
   echo '<option value="'.$data["REFcompte"].'">'.$data["banque"].'/'.$data['NUMcompte'].'</option><br/>';
}

mysql_close();
?>
