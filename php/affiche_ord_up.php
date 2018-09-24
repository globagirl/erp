<?php
include('../connexion/connexionDB.php');
$ord=$_POST['ord'];

$sq=mysql_query("select * from ordre_achat2 where IDordre='$ord' and statut='waiting'");
$nb=mysql_num_rows($sq);
if($nb>0){
$i=0;
$data=mysql_fetch_array($sq);
$sql=mysql_query("select * from ordre_achat_article1 where IDordre='$ord'");


echo("<tr><th> Ordre N° : </th><td colspan=3><input type=\"text\" name=\"ord\" value=\"".$data['IDordre']."\" size=20 READONLY></td></tr>
<tr><th>Fournisseur: </th><td>
<select name=\"four\" id=\"four\"  style=\"width:220px\">");
//liste fournisseur 
 echo '<option value="'.$data['fournisseur'].'">'.$data['fournisseur'].'</option><br/>'; 
			   
$sqlF = "SELECT * FROM fournisseur1 ";
$resF = mysql_query($sqlF) or exit(mysql_error());
while($dataF=mysql_fetch_array($resF)) {
   echo '<option value="'.$dataF["nom"].'">'.$dataF["nom"].'</option><br/>'; 
}
//
echo("</select> </td>
<th>Devise : </th><td>
<select name=\"devise\" id=\"devise\"  style=\"width:120px\">
<option value=\"".$data['devise']."\">".$data['devise']."</option>
<option value=\"EUR\">EUR</option>
<option value=\"TND\">TND</option>
<option value=\"GBP\">GBP</option>
<option value=\"USD\">USD</option>
</select>
</td>
</tr>
<tr><th> Date demandée par Starz: </th><td><input type=\"date\" name=\"dateD\" value=\"".$data['date_demand_starz']."\" size=20></td>

<th> Terme de payment: </th><td ><input type=\"text\" name=\"pay\" value=\"".$data['terme_pay']."\" size=20></td></tr>
<tr><th> Tax : </th><td><input type=\"text\" name=\"tax\" id=\"tax\" value=\"".$data['tax']."\" size=20></td>
<th> Transport : </th><td><input type=\"text\" name=\"transport\" id=\"transport\" value=\"".$data['transport']."\" size=20></td></tr>");
while($data1=mysql_fetch_array($sql)) {
$i++;

$item="item".$i;
$qte="qte".$i;

$prixT="prixT".$i;
$ordX="ordX".$i;
$prixU="prixU".$i;
$statut=$data1['statut'];


echo("<tr><td>Item: <input type=\"text\" name=\"".$item."\" id=\"".$item."\" value=\"".$data1['IDarticle']."\" size=20  onBlur=afficheP('".$i."')>
<input type=\"text\" name=\"".$ordX."\" id=\"".$ordX."\" value=\"".$data1['idOA']."\" size=20 HIDDEN></td>");



echo("<td> Qty : <input type=\"text\" name=\"".$qte."\" id=\"".$qte."\" value=\"".$data1['qte_demande']."\" size=20 onBlur=upPrix('".$i."');></td>");

echo("<td> Prix unitaire: <input type=\"text\" name=\"".$prixU."\" id=\"".$prixU."\" value=\"".$data1['prix_unitaire']."\" size=20 READONLY></td>
<td> Prix:<input type=\"text\" name=\"".$prixT."\" id=\"".$prixT."\" value=\"".$data1['prix_total']."\" size=20 READONLY></td></tr>");
}

echo("<tr><td></td><td colspan=3><input type=\"button\"  id=\"submitbutton\"  value=\"Prix >>\" onClick=upPrixT('".$i."');>
<input type=\"text\" name=\"prixT\" id=\"prixT\" value=\"".$data['prix_total']."\" size=20 READONLY></td></tr>

<tr><td><input type=\"text\" name=\"nbr\" id=\"nbr\" value=\"".$i."\" size=5 HIDDEN></td>
<td colspan=3><input type=\"submit\"  id=\"submitbutton\" value=\"Update >>\" ></td></tr>
</td></tr>");
}else{
echo("<tr><td>Ordre introuvable ou déja traité</td></tr>");
}
?>