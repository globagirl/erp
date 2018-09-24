<?php

include('../connexion/connexionDB.php');
$ordre=$_POST['ordre'];
$sql = "SELECT * FROM ordre_achat_article1 where IDordre='$ordre' and ((statut='incomplete') or (statut='waiting'))";
$res = mysql_query($sql) or exit(mysql_error());
echo '<option value="s">---Selectionnez</option><br/>'; 
while($data=mysql_fetch_array($res)) {
   echo '<option value="'.$data["IDarticle"].'">'.$data["IDarticle"].'</option><br/>'; 
}

mysql_close(); 
?>