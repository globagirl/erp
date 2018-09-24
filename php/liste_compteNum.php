<?php
include('../connexion/connexionDB.php');
$sql = "SELECT * FROM compte_banque ";
$res = mysql_query($sql) or exit(mysql_error());
 
while($data=mysql_fetch_array($res)) {
   echo '<option value="'.$data["REFcompte"].'">'.$data["NUMcompte"].' / '.$data["banque"].'</option><br/>'; 
}

mysql_close(); 
?>