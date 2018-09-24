<?php
include('../connexion/connexionDB.php');
$ord=$_POST['ord'];

$sq=mysql_query("select * from ordre_achat2 where IDordre='$ord'and statut='waiting'");
$nb=mysql_num_rows($sq);
if($nb>0){
$i=0;
$data=mysql_fetch_array($sq);
$sql=mysql_query("select * from ordre_achat_article1 where IDordre='$ord'");


echo("<tr><th> Ordre N° : </th><td colspan=4><input type=\"text\" name=\"ord\" value=\"".$data['IDordre']."\" size=20 READONLY></td></tr>
<tr><th>Fournisseur: </th><td colspan=4>
<input type=\"text\" name=\"four\" id=\"four\" value=\"".$data['fournisseur']."\" READONLY></td></tr>
<tr><th> Date demandée par Starz: </th><td><input type=\"date\" name=\"dateD\" value=\"".$data['date_demand_starz']."\" size=20 READONLY></td>

<th> Terme de payment: </th><td colspan=2><input type=\"text\" name=\"pay\" value=\"".$data['terme_pay']."\" size=20 READONLY></td></tr>
<tr><th> Tax : </th><td ><input type=\"text\" name=\"tax\" id=\"tax\" value=\"".$data['tax']."\" size=20 READONLY></td>
<th> Transport : </th><td colspan=2><input type=\"text\" name=\"transport\" id=\"transport\" value=\"".$data['transport']."\" size=20 READONLY></td></tr>");
while($data1=mysql_fetch_array($sql)) {
$i++;

$item="item".$i;
$qte="qte".$i;

$prixT="prixT".$i;
$ordX="ordX".$i;
$prixU="prixU".$i;
echo("<tr><td>Item: <input type=\"text\" name=\"".$item."\" id=\"".$item."\" value=\"".$data1['IDarticle']."\" size=20  onBlur=afficheP('".$i."')><input type=\"text\" name=\"".$ordX."\" id=\"".$ordX."\" value=\"".$data1['idOA']."\" size=20 HIDDEN></td>");
echo("<td> Qty : <input type=\"text\" name=\"".$qte."\" id=\"".$qte."\" value=\"".$data1['qte_demande']."\" size=20 READONLY></td>");
echo("<td> Prix unitaire: <input type=\"text\" name=\"".$prixU."\" id=\"".$prixU."\" value=\"".$data1['prix_unitaire']."\" size=20 READONLY></td>
<td> Prix:<input type=\"text\" name=\"".$prixT."\" id=\"".$prixT."\" value=\"".$data1['prix_total']."\" size=20 READONLY></td>
<td><input type=\"button\"  id=\"bigbutton\" value=\"X \" onClick=deleteI('".$ordX."');></td>
</tr>");
}



echo("<tr><td></td><td colspan=4><b>Prix Total : </b>
<input type=\"text\" name=\"prixT\" id=\"prixT\" value=\"".$data['prix_total']."\" size=20 READONLY></td></tr>

<tr><td><input type=\"text\" name=\"nbr\" id=\"nbr\" value=\"".$i."\" size=5 HIDDEN></td>
<td colspan=4><input type=\"button\"  id=\"submitbutton\"  onClick=deleteOrd(); value=\"DELETE >>\" ></td></tr>
</td></tr>");
}else{
echo("<tr><td>Ordre introuvable ou déja traité</td></tr>");
}
?>