<?php
include('../connexion/connexionDB.php');
/////Purchase
$supplier=$_POST['supplier'];
$sql = mysql_query("SELECT * FROM reception where supplier='$supplier' and status='received'");
$j=0;
$devise="";
$total=0;
while($data1=mysql_fetch_array($sql)){
    $j++;
    $i=0;
    $recep="R".$j;
    echo("<TABLE ><TR><Th  colspan=3>Reception ID : ".$data1['IDreception']."</Th>
	  <Th colspan=3>Shipment N° : ".$data1['IDshipment']."<input type=\"text\" size=\"5 \" name=\"".$recep."\" id=\"".$recep."\" value=\"".$data1['IDreception']."\"/ HIDDEN> </Th>
      <Th colspan=2>StoreKeeper : ".$data1['storekeeper']." </Th>
     </tr>");
    $reception=$data1['IDreception'];
    $sql2 = "SELECT * FROM reception_items where IDreception='$reception' and status='received'";
    $res = mysql_query($sql2) or exit(mysql_error());
    echo "<tr><th style='text-align:center' colspan='10'></th></tr>";
    echo "<tr ><td style=\"text-align:center\">Purshase order</td> 
 <td style=\"background-color:#A9F5D0 ;text-align:center\" >Item </td><td style=\"text-align:center\">Description</td>
 <td style=\"text-align:center\">Required Qty </td><td  style=\"background-color:#F2E0F7 ; text-align:center\" >Received Qty </td>
 <td style=\"text-align:center\">Unit price</td><td style=\"background-color:pink ; text-align:center\" >Price</td><td></td></tr>";
    $Tcheck="chek".$j;
    $nbr="nbr".$j;
    while($data=mysql_fetch_array($res)) {
    	$article=$data['item'];
        $ordre=$data['IDorder'];
        $sqlD=mysql_query("select devise from ordre_achat2 where IDordre='$ordre'");
        $devise=mysql_result($sqlD,0);
        $sqlU=mysql_query("select * from article1 where code_article='$article'");
        $dataA=mysql_fetch_array($sqlU);
        //$unit=mysql_result($sqlU,0);
        $sqlO=mysql_query("select * from ordre_achat_article1 where IDarticle='$article' and IDordre='$ordre'");
        $data2=mysql_fetch_array($sqlO);
        $i++;
        $chek="ch".$i.$j;
        $ord="O".$i.$j;
        $ar="ar".$i.$j;
        $id="id".$i.$j;
        $unitP=$data2['prix_facture']; //En cas de modification de prix dans la facture
        $qty=$data['qtyBR']; // En s'interesse seulement au qte reçue dans la bande reception
        $price=$unitP*$qty;
        echo "<tr style='text-align:center'>
	<td style=\"text-align:center\">".$data['IDorder']." <input type=\"text\" size=\"5 \" name=\"".$ord."\" id=\"".$ord."\" value=\"".$data['IDorder']."\"/ HIDDEN><input type=\"text\" size=\"2 \" name=\"".$id."\" id=\"".$id."\" value=\"".$data['idRI']."\"/ HIDDEN> 
	</td>
	 <td style=\"background-color:#A9F5D0; text-align:center\">".$data['item']."<input  type=\"text\" size=\"5 \" name=\"".$ar."\" id=\"".$ar."\" value=\"".$data['item']."\"/ HIDDEN></td>
	 <td style=\"text-align:center\">".$dataA['description']."</td>
	<td style=\"text-align:center\">".$data2['qte_demande']." ".$dataA['unit']." </td>
	<td style=\"background-color:#F2E0F7 ; text-align:center\">".$data['qtyBR']."  ".$dataA['unit']."</td>
	<td style=\"text-align:center \"> ".$unitP." ".$devise."</td>
	 <td style=\"background-color:pink ; text-align:center\">".$price." ".$devise."</td>
	 <td style=\"text-align:left\"><input type=\"checkbox\" name=\"".$chek."\" id=\"".$chek."\"  value=\"oui\" onclick=\"addPrice('".$chek."','".$price."');\">
	</td></tr>";
    }
    echo("<input  type=\"text\" id=\"".$nbr."\" name=\"".$nbr."\" value=\"".$i."\"  size=\"5 \" /HIDDEN></table>");
}
echo("<table><tr><td><b>Tax:</b>
<input  type=\"text\" id=\"tax\" name=\"tax\" placeholder=\"0\"  size=\"15 \" onBlur=\"addTax();\"  onFocus=\"saveTax();\"> 
</td><td><b>Frais:</b>
<input  type=\"text\" id=\"coastShip\" name=\"coastShip\" placeholder=\"0\"  size=\"15 \"  onBlur=\"addCoastS();\"  onFocus=\"saveCoastS();\" > 
</td>
<td > <b>Total : </b>
<input  type=\"text\" id=\"total\" name=\"total\" value=\"".$total."\"  size=\"15 \" /READONLY> 
<input  type=\"text\" id=\"devise\" name=\"devise\" value=\"".$devise."\"  size=\"5 \"/READONLY> 
<input  type=\"text\" id=\"coursTND\" name=\"coursTND\" placeholder=\"Cours TND\"  size=\"10 \"> 
<input  type=\"text\" id=\"j\" name=\"j\" value=\"".$j."\"  size=\"5 \" /HIDDEN> <td></td>
</tr>
<tr><td style=\" background-color:#F2E0F7 ;text-align:center\">
<input type=\"file\" name=\"imgFact[]\"  multiple>
</td><td colspan=2 style=\" background-color:#F2E0F7 ;text-align:center\">
<b>Date facture:</b>
<input  type=\"date\" id=\"dateF\" name=\"dateF\" placeholder=\"0\"  size=\"15 \"  > 
</td>
<td><input type=\"button\" onclick=\"addI2();\" id=\"add1\" value=\"Submit >> \"  style=\"float:left\">
</td></tr></table></div>");
mysql_close();
?>