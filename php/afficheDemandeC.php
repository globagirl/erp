<?php 
include('../connexion/connexionDB.php');
$demande=$_POST['demande'];
$i=0;
$sql = mysql_query("SELECT * FROM demande_consommable where IDdemande='$demande'");
$data1=mysql_fetch_array($sql);
	  echo(" <TABLE ><TR>	<Th>Request ID: ".$data1['IDdemande']." </Th>
<Th  >Request date : ".$data1['dateD']."</Th>
<Th colspan=2>Operator : ".$data1['demandeur']." </Th>

</tr>");

 $sql2 = "SELECT * FROM demande_items where IDdemande='$demande'";
$res = mysql_query($sql2) or exit(mysql_error());

echo "<tr><th style='text-align:center' colspan='4'></th></tr>";
while($data=mysql_fetch_array($res)) {
    $con=$data['IDconsommable'];
	$sql = mysql_query("SELECT stock FROM article1 where code_article='$con'");
	$stock=mysql_result($sql,0);
	$i=$i+1;
	$chek="ch".$i;
	$cons="C".$i;
	$stk="S".$i;
	$qtyD="qtyD".$i;
	$qtyS="qtyS".$i;
	
  	echo "<tr colspan='4'><td colspan='4'>Request item <input type=\"text\" size=\"15 \" name=\"".$cons."\" id=\"".$cons."\" value=\"".$con."\"/  READONLY> 
	Stock:  <input  type=\"text\" size=\"15 \" name=\"".$stk."\" id=\"".$stk."\" value=\"".$stock."\"/  READONLY>
	Requested Qty:  <input  type=\"text\" size=\"5 \" name=\"".$qtyD."\" id=\"".$qtyD."\" value=\"".$data['qtyD']."\"/  READONLY>
	 <input type=\"checkbox\" name=\"".$chek."\" id=\"".$chek."\"  value=\"oui\" onclick=\"afficheCase('".$chek."','".$qtyS."');\">
	 <input  type=\"text\" size=\"5 \" name=\"".$qtyS."\" id=\"".$qtyS."\"   onBlur=\" verifS('".$stk."','".$qtyS."');\"/ DISABLED>
	 
	</td></tr>";
	
}
echo("<tr colspan='4'><td colspan='3' style=\"float:center\">

 <input  type=\"text\" id=\"nbr\" name=\"nbr\" value=\"".$i."\"  size=\"5 \" HIDDEN>  </td> <td>
<input type=\"button\" onclick=\"addS()\" id=\"add1\" value=\"Submit >>\" style=\"float:left\" > </td>

</tr></table>");

	?>
	
