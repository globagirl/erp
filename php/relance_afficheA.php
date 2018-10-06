<?php
$PO=$_POST['PO'];
$qty=$_POST['qty'];
include('../connexion/connexionDB.php');
$sql = mysql_query("SELECT * FROM commande_items where POitem='$PO'");
if(mysql_num_rows($sql)<1){
    echo("<td colspan='2'>PO N° ".$PO." Not Found !!</td>");
}else{
    $data1=mysql_fetch_array($sql);
    $produit=$data1['produit'];
    $sql2 = mysql_query("SELECT * FROM produit_article1 where IDproduit='$produit'");
    $i=0;
    echo("<tr><th colspan=2><b>Article :".$produit." </b><input type=\"text\"  value=\"".$produit."\"  id=\"produit\" name=\"produit\"  HIDDEN>
</th></tr>");
    while($data2=mysql_fetch_array($sql2)){
        $i++;
        $qty1=$data2['qte'];
        $b=$qty1*$qty;
        $a="a".$i;
        $q="q".$i;
        echo("<tr><td colspan=2><b>Item ".$i.": </b><input type=\"text\"  value=\"".$data2['IDarticle']."\"  id=\"".$a."\" name=\"".$a."\"  READONLY >
<input type=\"text\"  id=\"".$q."\" name=\"".$q."\" value=\"".$b."\"></td></tr>");
    }
    echo("<tr><td><input type=\"text\"  value=\"".$i."\"  id=\"nbr\" name=\"nbr\"  HIDDEN ></td><td><input type=\"submit\"  value=\"ADD >>\" id=\"submitbutton\"></td></tr>");
}
?>