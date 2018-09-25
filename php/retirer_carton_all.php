<?php
include('../connexion/connexionDB.php');
$IDpalette= $_POST['IDpalette'];
$sq=@mysql_query("SELECT statut FROM palette where IDpalette='$IDpalette'");
$statut=mysql_result($sq,0);
if($statut != "closed"){
    $x=0;
    $sql1=@mysql_query("SELECT IDcarton,IDpalette FROM carton_palette where IDpalette LIKE '$IDpalette'");
    while($data=@mysql_fetch_array($sql1)){
        $IDcarton=$data["IDcarton"];
        $sql2=@mysql_query("UPDATE carton_palette SET IDpalette='X' WHERE IDcarton='$IDcarton'");
    }
    $sql3=@mysql_query("UPDATE palette SET nbrCarton='$x',totalQte='$x',poids='$x' WHERE IDpalette='$IDpalette'");
}
mysql_close();
?>