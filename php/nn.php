<?php
include('../connexion/connexionDB.php');
$req= mysql_query("SELECT DISTINCT OF,commande,date_sortie FROM sortie_stock1 WHERE OF IS NOT NULL");
/*if (!mysql_query($req)) {
   die('Error: ' . mysql_error());
}else{*/
while($a=mysql_fetch_array($req))
{
    $OF=$a['OF'];
    $PO=$a['commande'];
    $dateS=$a['date_sortie'];
    $IDsortie="SP".$OF;
    echo $IDsortie."<br>";
    $req2=mysql_query("INSERT INTO bande_sortie(IDsortie, dateS, dateC, OF, PO, statut) VALUES ('$IDsortie','$dateS','$dateS','$OF','$PO','C')");
    //if (mysql_query($req2)) {
    $req3= mysql_query("SELECT IDpaquet,qte FROM sortie_stock1 where OF='$OF'");
    while($a3=@mysql_fetch_array($req3))
    {
        $paq=$a3['IDpaquet'];
        $qte=$a3['qte'];
        $req4=mysql_query("INSERT INTO sortie_items(IDbande,IDpaquet, qte,statut) VALUES ('$IDsortie','$paq','$qte','C')");
    }
    /*}else{
          die('Error: ' . mysql_error());
    }*/
}
//}
mysql_close();
?>