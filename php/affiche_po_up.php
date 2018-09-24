<?php
include('../connexion/connexionDB.php');
$PO=$_POST['PO'];

$sq=mysql_query("select * from commande2 where PO='$PO'");
$nb=mysql_num_rows($sq);
if($nb>0){
$i=0;
$data=mysql_fetch_array($sq);
$sql=mysql_query("select * from commande_items where PO='$PO'");


echo("<tr><th>PO</th><td colspan=6><input type=\"text\" name=\"PO\" value=\"".$data['PO']."\" size=20></td></tr>
<th> UPC : </th><td colspan=2><input type=\"text\" name=\"UPC\" value=\"".$data['UPC']."\" size=20></td>
<th>Devise : </th><td>
<select name=\"devise\" id=\"devise\"  style=\"width:120px\">
<option value=\"".$data['devise']."\">".$data['devise']."</option>");
include('../include/utile/devise.php');
echo ("</select>
</td>

</tr>

<tr><th>Client: </th><td colspan=2><select name=\"client\" id=\"client\"  style=\"width:150px\">");
//liste fournisseur
 echo '<option value="'.$data['client'].'">'.$data['client'].'</option><br/>';

$sqlF = "SELECT name_client,nomClient FROM client1";
$resF = mysql_query($sqlF) or exit(mysql_error());
while($dataF=mysql_fetch_array($resF)) {
   echo '<option value="'.$dataF["name_client"].'">'.$dataF["nomClient"].'</option><br/>';
}
//
echo("</select> </td>
<th> Terme de payment: </th><td colspan=2><input type=\"text\" name=\"pay\" value=\"".$data['terme_pay']."\" size=20></td>
</tr>
<tr>
<th> Date demandée par le client : </th><td colspan=2><input type=\"date\" name=\"dateD\" value=\"".$data['date_demande_client']."\" size=20></td>
<th> Date expédition : </th><td colspan=2><input type=\"date\" name=\"dateE\" value=\"".$data['date_exped']."\" size=20></td></tr>
");
while($data1=mysql_fetch_array($sql)) {
$i++;
$POI="poI".$i;
$item="item".$i;
$r="r".$i;
$qte="qte".$i;
$prixT="prixT".$i;
$prixU="prixU".$i;
$stat="S".$i;
$statut=$data1['statut'];
echo("<tr><td> PO/N° : <input type=\"text\" name=\"".$stat."\" id=\"".$stat."\" value=\"".$statut."\" size=2 HIDDEN>
<input type=\"text\" name=\"".$POI."\" id=\"".$POI."\" value=\"".$data1['POitem']."\" size=20></td>");
if($statut=="waiting" or $statut=="planned"){
echo("<td>Item: <input type=\"text\" name=\"".$item."\" id=\"".$item."\" value=\"".$data1['produit']."\" size=20 onBlur=verifierProduit('".$i."')></td>");
}else{
echo("<td>Item: <input type=\"text\" name=\"".$item."\" id=\"".$item."\" value=\"".$data1['produit']."\" size=20 READONLY></td>");
}

if($statut=="waiting" or $statut=="planned"){
echo("<td> Qty : <input type=\"text\" name=\"".$qte."\" id=\"".$qte."\" value=\"".$data1['qty']."\" size=20 onBlur=upPrix('".$i."');></td>");
}else{
echo("<td> Qty : <input type=\"text\" name=\"".$qte."\" id=\"".$qte."\" value=\"".$data1['qty']."\" size=20 READONLY></td>");
}
echo("<td> Prix unitaire: <input type=\"text\" name=\"".$prixU."\" id=\"".$prixU."\" value=\"".$data1['prixU']."\" size=20 READONLY></td>
<td> Prix:<input type=\"text\" name=\"".$prixT."\" id=\"".$prixT."\" value=\"".$data1['prixT']."\" size=20 READONLY></td></tr>");
}

echo("<tr><td></td><td colspan=5><input type=\"button\"  id=\"submitbutton\"  value=\"Prix >>\" onClick=upPrixT('".$i."');>
<input type=\"text\" name=\"prixT\" id=\"prixT\" value=\"".$data['prix_total']."\" size=20 READONLY></td></tr>
<tr><td></td><td colspan=5><input type=\"button\"  id=\"submitbutton\" value=\"Qty >> \" onClick=upQtyT('".$i."');>
<input type=\"text\" name=\"qtyT\" id=\"qtyT\" value=\"".$data['qte_demande']."\" size=20 READONLY>
<tr><td><input type=\"text\" name=\"nbr\" id=\"nbr\" value=\"".$i."\" size=5 HIDDEN></td>
<td colspan=5><input type=\"submit\"  id=\"submitbutton\" value=\"Update >>\" ></td></tr>
</td></tr>");
}else{
echo("PO introuvable");
}
mysql_close();
?>
