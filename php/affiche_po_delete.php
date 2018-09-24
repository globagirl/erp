<?php
include('../connexion/connexionDB.php');
$PO=$_POST['PO'];

$sq=mysql_query("select * from commande2 where PO='$PO'");
$nb=mysql_num_rows($sq);
if($nb>0){
$i=0;
$data=mysql_fetch_array($sq);
$sql=mysql_query("select * from commande_items where PO='$PO'");


echo("<tr><th> PO : </th><td colspan=6><input type=\"text\" name=\"PO\" value=\"".$data['PO']."\" size=20 READONLY></td></tr>
<tr><th>Client: </th><td colspan=2><input type=\"text\" name=\"client\" value=\"".$data['client']."\" size=20 READONLY></td>
<th> Terme de payment: </th><td colspan=2><input type=\"text\" name=\"pay\" value=\"".$data['terme_pay']."\" size=20 READONLY></td></tr>
<tr>
<th> Date demandée par le client : </th><td colspan=2><input type=\"date\" name=\"dateD\" value=\"".$data['date_demande_client']."\" size=20 READONLY></td>
<th> Date expédition : </th><td colspan=2><input type=\"date\" name=\"dateE\" value=\"".$data['date_exped']."\" size=20 READONLY></td>
</tr>");
while($data1=mysql_fetch_array($sql)) {
$i++;
$POI="poI".$i;
$item="item".$i;
$r="r".$i;
$qte="qte".$i;
$prixT="prixT".$i;
$prixU="prixU".$i;
$statut=$data1['statut'];
$CMD=$data1['POitem'];
echo("<tr id=".$CMD."><td> PO/N° :<br/> <input type=\"text\" name=\"".$POI."\" id=\"".$POI."\" value=\"".$data1['POitem']."\" size=20 READONLY></td>");

echo("<td>Item:<br /> <input type=\"text\" name=\"".$item."\" id=\"".$item."\" value=\"".$data1['produit']."\" size=20 READONLY></td>");



echo("<td> Qty :<br/> <input type=\"text\" name=\"".$qte."\" id=\"".$qte."\" value=\"".$data1['qty']."\" size=20  READONLY></td>");

echo("<td> Prix unitaire:<br> <input type=\"text\" name=\"".$prixU."\" id=\"".$prixU."\" value=\"".$data1['prixU']."\" size=20 READONLY></td>
<td> Prix:<br><input type=\"text\" name=\"".$prixT."\" id=\"".$prixT."\" value=\"".$data1['prixT']."\" size=20 READONLY></td>
<td><input type=\"button\"  id=\"bigbutton\" value=\"X \" onClick=deleteI('".$CMD."','".$statut."','".$i."');>
</td></tr>");
}

echo("<tr><td></td><td colspan=6><input type=\"button\"  id=\"submitbutton\"  value=\"Prix >>\" onClick=upPrixT('".$i."');>
<input type=\"text\" name=\"prixT\" id=\"prixT\" value=\"".$data['prix_total']."\" size=20 READONLY></td></tr>
<tr><td><input type=\"text\" name=\"nbr\" id=\"nbr\" value=\"".$i."\" size=5 HIDDEN></td><td colspan=6><input type=\"button\"  id=\"submitbutton\" value=\"Qty >> \" onClick=upQtyT('".$i."');>
<input type=\"text\" name=\"qtyT\" id=\"qtyT\" value=\"".$data['qte_demande']."\" size=20 READONLY></td></tr>
");
}else{
echo("PO introuvable");
}
?>