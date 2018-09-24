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
$IDsert=$plan."SE".$x.$y;
		
echo("<table> <TR>	<Th Wcode_articleTH=150 HEIGHT=30  >N° OF: <input type=\"text\" id=\"IDsert\" value=\"".$IDsert."\" /HIDDEN> </Th>
<td>".$data['OF']."</td>
<Th Wcode_articleTH=150 HEIGHT=30  >N° PO:  </Th>
<td><input  type=\"text\"  id=\"PO\" value=\"".$data['PO']."\"/  READONLY></td>
</tr>

<TR>	<Th Wcode_articleTH=150 HEIGHT=30  >Code Produit:  </Th>
<td>".$data3['produit']."</td>
<th>Quantité Plan: </th>
<td>".$data2['qte_p']."</td></tr>



<TR><th>Date & heure: </th>
<td> <input  type=\"text\" size=\"20\" id=\"dateH\" value=\"".$date_h."\"/  READONLY></td>
<Th Wcode_articleTH=150 HEIGHT=30  >Quantité entrée :</Th>
<td><input  type=\"text\" size=\"10\" id=\"qtE\" value=\"".$data2['qte_p']."\"></td></tr>
<td ></td><td colspan=3>
	 <input type=\"button\" id=\"submitbutton\" value=\"Lancer\" onclick=\"ajoutSertissage1()\"/>
</td>	
			
		</tr>
</table>
");


?>