<?php

include('../connexion/connexionDB.php');

$invoice=$_POST['invoice'];


echo('<table  class="table table-fixed " >
	    <thead style="width:100%">
		<tr>
		<th style="width:25%;height:60px;text-align:center"> Item ID</th>
		<th style="width:20%;height:60px;text-align:center">Reception </th>
		<th style="width:15%;height:60px;text-align:center">Order N° </th>
		<th style="width:10%;height:60px;text-align:center">Qty </th>
		<th style="width:15%;height:60px;text-align:center">Unit price </th>
		<th style="width:15%;height:60px;text-align:center">Price </th>
		</tr>
		</thead>
		<tbody id="tbody" style="width:100%">');
$sql = mysql_query("SELECT * FROM supplier_invoice_items where IDinvoice='$invoice'");
 while($data=mysql_fetch_array($sql)){
 $qty=$data['qty'];
 $unitP=$data['unit_price'];
 $price=$qty*$unitP;
 echo("<tr>
 <td style=\"width:25%;height:40px;text-align:center\"> ".$data['IDitem']."</td>
<td style=\"width:20%;height:40px;text-align:center\">".$data['IDreception']." </td>
<td style=\"width:15%;height:40px;text-align:center\">".$data['IDordre']." </td>
<td style=\"width:10%;height:40px;text-align:center\">".$data['qty']." </td>
<td style=\"width:15%;height:40px;text-align:center\"> ".$data['unit_price']."</td>
<td style=\"width:15%;height:40px;text-align:center\"> ".$price."</td>
</tr>"); 
 }
echo("</tbody></table>");	

mysql_close();

?>
