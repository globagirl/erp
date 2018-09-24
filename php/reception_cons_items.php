<?php 
include('../connexion/connexionDB.php');
$demande=$_POST['demande'];
$i=0;

$sql = mysql_query("SELECT * FROM demande_consommable where IDdemande='$demande'");
$data1=mysql_fetch_array($sql);
	  echo(" <TABLE ><TR>	<Th>Request ID: ".$data1['IDdemande']." </Th>
<Th  >Request date : ".$data1['dateD']."</Th>
<Th colspan=2>StoreKeeper : ".$data1['magazigner']." </Th>

</tr>");

 $sql2 = "SELECT * FROM demande_items where IDdemande='$demande'";
$res = mysql_query($sql2) or exit(mysql_error());

echo "<tr><th style='text-align:center' colspan=4> </th></tr>";
while($data=mysql_fetch_array($res)) {
    $cons=$data['IDconsommable'];
	
	$i=$i+1;
	$chek="ch".$i;
	
	$qtyD=$data['qtyD'];
	$qtyS=$data['qtyS'];
	
  	echo "<tr colspan='4'><td><b>Request item : </b>".$cons." </td>
	<td><b>Requested Qty :</b> ".$qtyD." </td><td><b>Received QTY: </b>".$qtyS."</td>
	<td> <input type=\"checkbox\" name=\"".$chek."\" id=\"".$chek."\"  value=\"oui\" >
	 
	 
	</td></tr>";
	
}
echo("<tr colspan='4'><td></td><td colspan='3' style=\"float:center\">

 <input  type=\"text\" id=\"nbr\" name=\"nbr\" value=\"".$i."\"  size=\"5 \" HIDDEN>  
<input type=\"button\" onclick=\"confirmS()\" id=\"add1\" value=\"Submit >>\" style=\"float:left\" > </td>

</tr></table>");
mysql_close();
	?>
	
