<?php 

include('../connexion/connexionDB.php');
$client=$_POST['client'];

$sql8 = mysql_query("SELECT max(num_bl) FROM bon_livr ");
$max=mysql_result($sql8,0);	
$BL=$max+1;

$sq=mysql_query("select * from client1 where name_client='$client'");
$data2=mysql_fetch_array($sq);
echo(" <TABLE id=\"tab1\">

<tr><th>Adresse livraison :</th><td><textarea rows=4 cols=40 name=\"adL\" READONLY> ".$data2['adress_liv']." </textarea></td>
<th>Adresse Facturation : </th><td><textarea rows=4 cols=40 name=\"adF\" READONLY>".$data2['adress_fact']."</textarea></td></tr>
<tr><th>N° BL:".$BL." <input type=\"text\" name=\"BL\" value=\"".$BL."\" size=2 HIDDEN></th><td colspan=3>

<input type=type=\"text\"  name=\"PO\" id=\"PO\" size=\"25\" placeholder=\"N° PO\">
			

<input type=\"button\" id=\"submitbutton\" value=\" >>\" onclick=\"ajoutPO();\"></td></tr></table>");	

echo("<table id=\"tab\">
<tr id=\"TR1\"><td> PO </td><td> PO/N° </td><td>OF</td><td>Produit</td><td>Date Expédition </td> <td> Qty </td><td>NBR Box </td><td></td></tr>
<tr><td> </td><td colspan=7> <input type=\"button\" id=\"submitbutton\" value=\"Submit >>\" onClick=\"ajoutBL();\"></td></tr>
</table>");	
mysql_close();




?>