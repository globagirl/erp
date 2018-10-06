<?php
//affichage des article demandé dans une relance dans une liste 
include('../connexion/connexionDB.php');
$demande=$_POST['demande'];
$sql = "SELECT * FROM demande_relance_items where IDrelance='$demande'";
echo '<option value="s">---Select---</option><br/>';
$res = mysql_query($sql) or exit(mysql_error());
while($data=mysql_fetch_array($res)) {
    echo '<option value="'.$data["item"].'">'.$data["item"].'</option><br/>';
}
?>