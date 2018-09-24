<?php 
include('../connexion/connexionDB.php');
$OF=$_POST['OF'];
$i=1;
$sql = mysql_query("SELECT * FROM ordre_fabrication1 where OF='$OF'");
while($data=mysql_fetch_array($sql)) {
echo(" <TABLE ><TR>	<Th Wcode_articleTH=150 HEIGHT=30  >N° PO: ".$data['PO']." </Th>
<th>Produit: ".$data['produit']." </th>
<th>Quantité : ".$data['qte']." </th>
<th>Date lancement : ".$data['date_lance']." </th>
<th>Date Expedition : ".$data['date_lance']." </th>

</tr>");
}

$sql1 = "SELECT * FROM plan1 where OF='$OF'";
$res = mysql_query($sql1) or exit(mysql_error());
while($data=mysql_fetch_array($res)) {
	$numPlan=$data['numPlan'];
	echo("<TR><Th Wcode_articleTH=150 HEIGHT=30 colspan=2>Plan: ".$data['numPlan']." </Th>

<td>Quantité: ".$data['qte_p']."</td>
<td> Debut : ".$data['date_debut']."</td>
<td> Fin : ".$data['date_fin']."</td>
</tr>
<tr><th colspan=2></th><th>Défaut</th><th>Date debut</th><th>Date Fin</th></tr>
");

$sql2 = "SELECT * FROM decoup where plan='$numPlan'";
$res2 = mysql_query($sql2) or exit(mysql_error());
while($data2=mysql_fetch_array($res2)) {
echo("<TR><Th Wcode_articleTH=150 HEIGHT=30 colspan=2>Découpage </Th>

<td> ".$data2['q_reb']."</td>
<td> ".$data2['date_debut']."</td>
<td>".$data2['date_fin']."</td>
</tr>");	
}
$sql2 = "SELECT * FROM pro_contr_fluke where plan='$numPlan'";
$res2 = mysql_query($sql2) or exit(mysql_error());
while($data2=mysql_fetch_array($res2)) {
echo("<TR><Th Wcode_articleTH=150 HEIGHT=30 colspan=2>Controle Fluke </Th>

<td>".$data2['pass_fail']."</td>
<td> ".$data2['date_debut']."</td>
<td> ".$data2['date_fin']."</td>
</tr>");	
}
////////
$sql2 = "SELECT * FROM pro_assem where plan='$numPlan'";
$res2 = mysql_query($sql2) or exit(mysql_error());
while($data2=mysql_fetch_array($res2)) {
echo("<TR><Th Wcode_articleTH=150 HEIGHT=30 colspan=2>Assemblage </Th>

<td>".$data2['nbr_def']."</td>
<td>".$data2['date_debut']."</td>
<td> ".$data2['date_fin']."</td>
</tr>");	
}
////////////
$sql2 = "SELECT * FROM pro_sertiss where plan='$numPlan'";
$res2 = mysql_query($sql2) or exit(mysql_error());
while($data2=mysql_fetch_array($res2)) {
echo("<TR><Th Wcode_articleTH=150 HEIGHT=30 colspan=2>Sertissage </Th>

<td>".$data2['nbr_def']."</td>
<td>  ".$data2['date_debut']."</td>
<td>".$data2['date_fin']."</td>
</tr>");	
}
///////
$sql2 = "SELECT * FROM pro_test_pol where plan='$numPlan'";
$res2 = mysql_query($sql2) or exit(mysql_error());
while($data2=mysql_fetch_array($res2)) {
echo("<TR><Th Wcode_articleTH=150 HEIGHT=30 colspan=2>Test Polarité </Th>

<td>".$data2['nbr_def']."</td>
<td> ".$data2['date_debut']."</td>
<td>".$data2['date_fin']."</td>
</tr>");	
}
////////////
$sql2 = "SELECT * FROM pro_emb where plan='$numPlan'";
$res2 = mysql_query($sql2) or exit(mysql_error());
while($data2=mysql_fetch_array($res2)) {
echo("<TR><Th Wcode_articleTH=150 HEIGHT=30 colspan=2>Emballage </Th>

<td>-------</td>
<td> ".$data2['date_debut']."</td>
<td>".$data2['date_fin']."</td>
</tr>");	
}
}
	

echo("</table>")
?>