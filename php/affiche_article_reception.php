<?php
include('../connexion/connexionDB.php');
$reception=$_POST['reception'];
$i=1;
$sql = mysql_query("SELECT * FROM reception_ordre_achat1 where idRO='$reception'");
while($data=mysql_fetch_array($sql)) {
echo(" <table><tr>	<th>N ordre d'achat: ".$data['IDordre']." </th>
<th>Shipment NO°: ".$data['codeClient']." </th>
<th>Date reception : ".$data['date_recep']." </th>

</tr>");
}

$sql1 = "SELECT * FROM reception_article_ordre where idRO='$reception'";
$res = mysql_query($sql1) or exit(mysql_error());
while($data=mysql_fetch_array($res)) {
	
	echo("<tr><th>Article: ".$data['IDarticle']." </Th>

<td>Quantité reçue : ".$data['qte_recue']."</td>
<td> Nombre Paquet : ".$data['nbr_paquet']."</td>
</tr>");

}
	

echo("</table>");
mysql_close();
?>