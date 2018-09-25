<?php
$demande=$_POST['demande'];
include('../connexion/connexionDB.php');
$sql = mysql_query("SELECT * FROM demande_relance where IDrelance='$demande'");
$data=mysql_fetch_array($sql);

echo("<tr><tr><th>PO N°: </th><td><input type=\"text\"  id=\"PO\" name=\"PO\" value=\"".$data['PO']."\" READONLY></td></tr>
	<tr><th>Article: </th><td><input type=\"text\"  id=\"prd\" name=\"prd\" value=\"".$data['produit']."\" READONLY></td></tr>
	<tr><th>QTY: </th><td><input type=\"text\"  id=\"qte\" name=\"qte\" value=\"".$data['qty']." pc\" READONLY></td></tr>
	");
$sql2 = mysql_query("SELECT * FROM demande_relance_items where IDrelance='$demande'");
while($data2=mysql_fetch_array($sql2)){
    $i++;
    $a="a".$i;
    $q="q".$i;
    echo("<tr><td></td><td><b>Item ".$i.": </b><input type=\"text\"  value=\"".$data2['item']."\"  id=\"".$a."\" name=\"".$a."\"  READONLY >
		<input type=\"text\"  id=\"".$q."\" name=\"".$q."\" value=\"".$data2['qty']."\" READONLY></td></tr>");
}
?>