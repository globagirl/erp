<?php 
include('../connexion/connexionDB.php');
$supplier=$_POST['supplier'];
$sql = mysql_query("SELECT * FROM supplier_invoice where supplier like '%$supplier%' and status='unpaid'");
$i=0;

while($data1=mysql_fetch_array($sql)){
	$i++;
	$IDinvoice=$data1['IDinvoice'];
	$IDinv=$data1['IDinvoice'];
	$n=strpos($IDinvoice,"-");

    $IDinvoice=substr($IDinvoice,$n+1); 
	$typeI=$data1['typeI'];
	$fileI=$data1['fileI'];
	$dateP="dateP".$i;
	$modeP="modeP".$i;
	$zoneMP="zoneMP".$i;
  	$tab="tab".$i;
	$IDinvoice2=$data1['IDinvoice'];
	echo("<TABLE id=".$tab." ><TR><Th style=\"text-align:center\" colspan=5>Invoice N° : ".$IDinvoice."</Th>
	 <th style=\"text-align:center\">");
	 $sqlF=mysql_query("SELECT * from invoice_files where IDinvoice='$IDinv'");	
	 while($data=mysql_fetch_array($sqlF)){
	echo"<a href=\"../files/invoices/".$data['nameF']."\" target=\"_blank\"><img src=\"../image/viewFile2.png\" alt=\"view\" width=\"30\" height=\"25\"></a>";
	}
	 echo("</th> </tr>");	
	if(($typeI=="Credit") or ($typeI=="Service" )or ($typeI=="Expense" )){
	 
	echo("<tr><td style=\"text-align:center;  background-color:#CEF6EC\" ><b>".$typeI."</b></td>
    <td colspan=2 style=\" background-color:#F7F8E0 ;text-align:center\"><b>Total Price : ".$data1['total']." ".$data1['currency']."</b> </td>
    <td colspan=2 style=\"text-align:center ;  background-color:#F8E0E6\" width=370 px ><b>Payment Date :</b> 
	<input type=\"date\" name=\"".$dateP."\" id=\"".$dateP."\" size=\"12\"></td>
	<td><b>Payment mode : </b>
	<span class=\"custom-dropdown custom-dropdown--white custom-dropdown--small\" >
	 <select id=\"".$modeP."\" onChange=\"afficheMP('".$i."');\" class=\"custom-dropdown__select custom-dropdown__select--white\" >
	    <option value=\"S\">Selectionnez...</option>	  
	    <option value=\"Cache\">Cache</option>
	    <option value=\"Cheque\">Par chéque</option>
	    <option value=\"Virement\">Virement</option>
	    <option value=\"Autre\">Autre..</option>		
	         
			 

   </select> 
   </span></td>
	</tr>
	<tr>
	<td colspan=5 id=\"".$zoneMP."\"></td>
    <td style=\"text-align:center\"> <input type=\"button\" onclick=\"closeInvoice('".$IDinvoice2."','".$i."');\" id=\"add1\" value=\"Paid >>\"></Td></tr></table>");
	}else{
	
    $sql2 = mysql_query("SELECT * FROM supplier_invoice_items where IDinvoice='$IDinvoice2'");
    $j=0;
	 echo "<tr style='text-align:center'>
	 <td style=\"background-color:#A9F5D0; text-align:center\"> <b>Item N° </b> </td>
	<td style=\"text-align:center\"> <b>Reception N° :</b></td>	
	
	<td style=\" text-align:center\"><b>Qty :</b></td>
	<td style=\"text-align:center\"><b>Unit Price :</b> </td>
	<td  colspan=2 style=\" background-color:#F2E0F7 ;text-align:center\"><b>Price</b></td>
	 </tr>";
while($data=mysql_fetch_array($sql2)) {
	$j++;
     
 
	 echo "<tr style='text-align:center'>
	 <td style=\"background-color:#A9F5D0; text-align:center\">".$data['IDitem']."</td>
	<td style=\"text-align:center\"> ".$data['IDreception']."</td>	
	
	<td style=\" text-align:center\">".$data['qty']."</td>
	<td style=\"text-align:center\">".$data['unit_price']." ".$data1['currency']." </td>
	<td  colspan=2 style=\" background-color:#F2E0F7 ;text-align:center\">".$data['price']."  ".$data1['currency']."</td>
	 </tr>";
	
}
 
echo("<tr> 
<Td colspan=2 style=\" background-color:#F7F8E0;text-align:center\"><b>Tax :".$data1['tax']." ".$data1['currency']."</b> </Td>
      <td colspan=2 style=\"text-align:center ;  background-color:#F7F8E0\" width=370 px ><b>Shipment coast : ".$data1['shipCoast']." ".$data1['currency']."</b> 
	  </td>
<Td colspan=2 style=\" background-color:#F8E0E6 ;text-align:center\"><b>Total Price : ".$data1['total']." ".$data1['currency']."</b> </Td></tr><tr>
<Td style=\"text-align:center;  background-color:#CEF6EC\" colspan=2><b>".$typeI."</b></Td>
      <td colspan=2 style=\"text-align:center ;  background-color:#F8E0E6\" width=370 px ><b>Payment Date :</b> 
	  <input type=\"date\" name=\"".$dateP."\" id=\"".$dateP."\" size=\"12\"  ></td>
	  <td colspan=2><b>Payment mode : </b>
	 <span class=\"custom-dropdown custom-dropdown--white custom-dropdown--small\" >
	 <select id=\"".$modeP."\" onChange=\"afficheMP('".$i."');\" class=\"custom-dropdown__select custom-dropdown__select--white\" >
	    <option value=\"S\">Selectionnez...</option>
	    
	    <option value=\"Cache\">Cache</option>
	    <option value=\"Cheque\">Par chéque</option>
	    <option value=\"Virement\">Virement</option>
	    <option value=\"Autre\">Autre..</option>	
			
			 

   </select> 
   </span></td>
	</tr>
	<tr>
	<td colspan=4 id=\"".$zoneMP."\"></td>
	  
	  <td colspan=2 style=\"text-align:center\">
	  <input type=\"button\" onclick=\"closeInvoice('".$IDinvoice2."','".$i."');\" id=\"add1\" value=\"Paid >>\"></Td></tr></table>");
}
}
	?>
	
