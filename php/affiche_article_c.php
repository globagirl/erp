<?php
include('../connexion/connexionDB.php');
$ordre=$_POST['ordre'];
$i=1;
$sql = mysql_query("SELECT * FROM ordre_achat2 where IDordre='$ordre'");
while($data=mysql_fetch_array($sql)) {
echo(" <TABLE ><TR>	<Th Wcode_articleTH=150 HEIGHT=30  >N ordre d'achat: ".$data['IDordre']." </Th>
<th>Date reception : ".$data['date_recep']." </th>
<th>Prix Total: ".$data['prix_total']." ".$data['devise']." </th>
<th>Fournisseur: ".$data['fournisseur']." </th>
</tr>");
$devise=$data['devise'];	
}

$sql1 = "SELECT * FROM ordre_achat_article1 where IDordre='$ordre'";
$res = mysql_query($sql1) or exit(mysql_error());
while($data=mysql_fetch_array($res)) {
	$art=$data['IDarticle'];
	echo("<TR><Th Wcode_articleTH=150 HEIGHT=30 colspan=\"5\" >Article: ".$data['IDarticle']." </Th></tr>
<tr>
<td>Prix unitaire : ".$data['prix_unitaire']." ".$devise." </td>
<td> Prix totale : ".$data['prix_total']." ".$devise." </td>
<td>Quantité demandée: ".$data['qte_demande']." </td>
<td> Total reçue : ".$data['qte_recue']." </td>
</tr>");
$sql2 = "SELECT * FROM reception_ordre_achat1 where IDordre='$ordre'";
$res2 = mysql_query($sql2) or exit(mysql_error());
while($data2=mysql_fetch_array($res2)) {
	$idRO=$data2['idRO'];
	$sql3 = mysql_query("SELECT qte_recue FROM reception_article_ordre where idRO='$idRO' and IDarticle='$art'");
	$qteR=mysql_result($sql3,0);
	echo("<TR><Th Wcode_articleTH=150 HEIGHT=30  >N° reception: ".$idRO." </Th>
<Th Wcode_articleTH=150 HEIGHT=30  >Shipment NO°: ".$data2['codeClient']." </th>
<td> Quantité reçue : ".$qteR." </td>
<td> Date reception : ".$data2['date_recep']."</td>

</tr>");
}
	
}
echo("</table>");
mysql_close();
?>