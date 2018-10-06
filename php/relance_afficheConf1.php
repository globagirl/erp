<?php
$demande=$_POST['demande'];
include('../connexion/connexionDB.php');
$sql = mysql_query("SELECT * FROM demande_relance where IDrelance='$demande'");
$data=mysql_fetch_array($sql);

echo("<tr><th>Request ID : </th><td>".$data['IDrelance']."</td></tr>
<tr><th>PO N°: </th><td>".$data['PO']."</td></tr>
<tr><th>Article: </th><td>".$data['produit']."</td></tr>
<tr><th>Cause: </th><td>".$data['cause']."</td></tr>
<tr><th>Detail: </th><td>".$data['detail']."</td></tr>
<tr><th>QTY: </th><td>".$data['qty']." PC</td></tr>
");
$sql2 = mysql_query("SELECT * FROM demande_relance_items where IDrelance='$demande'");
while($data2=mysql_fetch_array($sql2)){
    $i++;
    $a="a".$i;
    $q="q".$i;
    echo("<tr><td></td>
		<td><b>Item ".$i.": </b>
		<input type=\"text\"  value=\"".$data2['item']."\"  id=\"".$a."\" name=\"".$a."\"  READONLY >
		<input type=\"text\"  id=\"".$q."\" name=\"".$q."\" value=\"".$data2['qty']."\" READONLY>
		</td></tr>");
}
echo("<tr><td></td><td><input type=\"submit\"  value=\"Confirm >>\" id=\"submitbutton\" \">
<input type=\"button\"  value=\" Refuse>>\" id=\"submitbutton\" onClick=\"refuser();\"></td></tr>");
?>