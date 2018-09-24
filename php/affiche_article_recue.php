<?php 
include('../connexion/connexionDB.php');
$reception=$_POST['reception'];
$i=0;
$sql = mysql_query("SELECT * FROM reception where IDreception='$reception'");
$data1=mysql_fetch_array($sql);
	  echo(" <TABLE ><TR>	<Th>Shipment N°: ".$data1['IDshipment']."<input  type=\"text\" id=\"IDreception\" name=\"IDreception\" value=\"".$data1['IDreception']."\"  size=\"5 \" HIDDEN> </Th>
<Th  >Reception date : ".$data1['dateR']."</Th>
<Th colspan=2>Operator : ".$data1['operator']." </Th>

</tr>");

 $sql2 = "SELECT * FROM reception_items where IDreception='$reception'";
$res = mysql_query($sql2) or exit(mysql_error());

echo "<tr><th style='text-align:center' colspan='4'></th></tr>";
while($data=mysql_fetch_array($res)) {
	$i=$i+1;
	$Z="Z".$i;
	$chek="ch".$i;
	$chekB="chB".$i;
	$chekB2="chB2".$i;
	$ord="O".$i;
	$ar="ar".$i;
	$qtr="qtr".$i;
	$paq="paq".$i;
	$suite="suite".$i;
	$batch="batch".$i;
  	echo "<tr colspan='4'><td colspan='4' id=\"".$Z."\">Purshase order <input type=\"text\" size=\"5 \" name=\"".$ord."\" id=\"".$ord."\" value=\"".$data['IDorder']."\"/  READONLY> 
	Item:  <input  type=\"text\" size=\"15 \" name=\"".$ar."\" id=\"".$ar."\" value=\"".$data['item']."\"/  READONLY>
	Received Qty:  <input  type=\"text\" size=\"5 \" name=\"".$qtr."\" id=\"".$qtr."\" value=\"".$data['qty']."\"/  READONLY>
	 <input type=\"checkbox\" name=\"".$chek."\" id=\"".$chek."\"  value=\"oui\" onclick=\"afficheCase('".$i."');\">
	Box Qty : <input  type=\"text\" size=\"5 \" name=\"".$paq."\" id=\"".$paq."\" onclick=\"clickZoneP('".$paq."');\"  onBlur=\" blurZoneP('".$paq."');\"/ DISABLED>
	AfterPart:  <input  type=\"text\" size=\"5 \" name=\"".$suite."\" id=\"".$suite."\"  onclick=\"clickZoneS('".$suite."');\" onBlur=\" blurZoneS('".$suite."');\" / DISABLED>
	<input  type=\"text\" id=\"".$batch."\" name=\"".$batch."\" placeholder=\"BATCH N°\" size=\"15 \" /DISABLED>
      <input type=\"button\" name=\"".$chekB."\" id=\"".$chekB."\"  value=\">>\" onclick=\"afficheBatch('".$i."');\" DISABLED>
 <input type=\"button\" name=\"".$chekB2."\" id=\"".$chekB2."\"  value=\"<<\" onclick=\"removeBatch('".$i."');\" DISABLED>		  
	</td></tr>";
	
}
echo("<tr colspan='4'><td colspan='3' style=\"text-align:center\">
<b>Palette : </b>
 <input  type=\"text\" id=\"pal\" name=\"pal\" placeholder=\"0\"  size=\"15 \" >
 <input  type=\"text\" id=\"nbr\" name=\"nbr\" value=\"".$i."\"  size=\"5 \" HIDDEN>  </td> <td>
<input type=\"button\" onclick=\"addS()\" id=\"add1\" value=\"Submit >>\" style=\"float:left\" > </td>

</tr></table>");
mysql_close();
?>
	
