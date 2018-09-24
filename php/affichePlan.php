<?php
include('../connexion/connexionDB.php');
$plan=$_POST['plan'];

$sql = mysql_query("SELECT * FROM plan1 where numPlan='$plan'");
$data2=mysql_fetch_array($sql);
$OF=$data2['OF'];
$qte_p=$data2['qte_p'];
$sql2 = mysql_query("SELECT * FROM ordre_fabrication1 where OF='$OF'");
$data=mysql_fetch_array($sql2);
$date_h = date("Y-m-d H:i:s");
$PO=$data['PO'];
$sql3 = mysql_query("SELECT * FROM commande_items where POitem='$PO'");
$data3=mysql_fetch_array($sql3);
$x=rand(1, 99);
$y=rand(8, 89);
$IDdecoup=$plan."D".$x.$y;
		
echo("<table> <TR>	<Th Wcode_articleTH=150 HEIGHT=30  >N° OF:  </Th>
<td> <input  type=\"OF\" id=\"OF\" name=\"OF\" value=\"".$OF."\"/  READONLY><input  type=\"text\" id=\"IDdecoup\" name=\"IDdecoup\" value=\"".$IDdecoup."\"/  HIDDEN> </td>
<Th Wcode_articleTH=150 HEIGHT=30  >N° PO:  </Th>
<td><input  type=\"text\"  id=\"PO\"  name=\"PO\"  value=\"".$data['PO']."\"/  READONLY></td>
</tr>

<TR>	<Th Wcode_articleTH=150 HEIGHT=30  >Code Produit:  </Th>
<td><input  type=\"text\"  id=\"PRD\"  name=\"PRD\"  value=\"".$data['produit']."\"/  READONLY></td>
<th>Quantité Plan: </th>
<td><input  type=\"text\"  id=\"qteP\"  name=\"qteP\"  value=\"".$data2['qte_p']."\"/  READONLY></td></tr>



<TR><th>Date & heure: </th>
<td> <input  type=\"text\" size=\"20\" id=\"dateH\" name=\"dateH\" value=\"".$date_h."\"/  READONLY></td>
<Th Wcode_articleTH=150 HEIGHT=30  >Quantité entrée :</Th>
<td><input  type=\"text\" size=\"10\" id=\"qteE\" name=\"qteE\" value=\"".$data2['qte_p']."\"></td></tr>
<tr><td></td>
<td colspan=\"4\">
	 <input type=\"submit\" id=\"submitbutton\" value=\"Lancer\"/></div>  
</td>	
			
		</tr>
</table>
");


?>