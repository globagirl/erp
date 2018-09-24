<?php 

include('../connexion/connexionDB.php');
$PO=$_POST['PO'];
$sql = mysql_query("SELECT * FROM commande2 where PO='$PO'");
$data1=mysql_fetch_array($sql);
$sql = mysql_query("SELECT * FROM ordre_fabrication1 where PO='$PO' and statut='shipped'");
$i=0;
while($data=mysql_fetch_array($sql)){
	$i++;
	$tab="tab".$i;
	$OF=$data['OF'];
$sql8 = mysql_query("SELECT max(num_bl) FROM bon_livr ");
$max=mysql_result($sql8,0);	
$BL=$max+$i;

$client=$data1['client'];
$sq=mysql_query("select * from client1 where name_client='$client'");
$data2=mysql_fetch_array($sq);
echo(" <TABLE id=\"".$tab."\" ><TR>	<th colspan=4> N°OF : ".$OF."</th></tr>
<Th Wcode_articleTH=150 HEIGHT=30 >N° BL: </th><td colspan=3>".$BL."</td>

</tr>
<tr><th>Produit: </th><td>".$data['produit']." </td>
<th>Quantité : </th><td>".$data['qte']." PC </td></tr>
<tr><th>Date demandé par client :</th><td> ".$data1['date_demande_client']." </td>
<th>Date Expedition : </th><td>".$data['date_exped_conf']."</td>
<tr><th>Adresse livraison :</th><td><textarea rows=4 cols=40> ".$data2['adress_liv']." </textarea></td>
<th>Adresse Facturation : </th><td><textarea rows=4 cols=40>".$data2['adress_fact']."</textarea></td></tr>
<tr><td></td><td colspan=3>
<input type=\"button\" id=\"submitbutton\" value=\"Valider\" onclick=\"ajoutBL('".$OF."','".$tab."');\"></td></tr>
</table>");	
}




?>