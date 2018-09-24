<?php 
//Payment par mode de payment
include('../connexion/connexionDB.php');
$invoice=$_POST['invoice'];
$modeP=$_POST['modeP'];
$invoice="-".$invoice;

$sql = mysql_query("SELECT * FROM supplier_invoice where IDinvoice LIKE '%$invoice'");
$i=0;
$data1=mysql_fetch_array($sql);
	
	$typeI=$data1['typeI'];
	$IDinvoice=$data1['IDinvoice'];
	$IDinv=$data1['IDinvoice'];
	$n=strpos($IDinvoice,"-");
    $IDinvoice=substr($IDinvoice,$n+1); 
	$fileI=$data1['fileI'];
	
	echo("<table><tr><th  style=\"text-align:center\" colspan=4>Invoice N° : ".$IDinvoice."</Th>
	<th style=\"text-align:center\">");
	$sqlF=mysql_query("SELECT * from invoice_files where IDinvoice='$IDinv'");	
	while($data=mysql_fetch_array($sqlF)){
	echo"<a href=\"../files/invoices/".$data['nameF']."\" target=\"_blank\"><img src=\"../image/viewFile2.png\" alt=\"view\" width=\"30\" height=\"25\"></a>";
	}
	echo("</th></tr>");
    $IDinvoice2=$data1['IDinvoice'];
	if($typeI=="Purchase"){	
        $sql2 = mysql_query("SELECT * FROM supplier_invoice_items where IDinvoice='$IDinvoice2'");   
	    echo "<tr style='text-align:center'>
	    <td style=\"background-color:#A9F5D0; text-align:center\"> <b>Item N° </b> </td>
	    <td style=\"text-align:center\"> <b>Reception N° </b></td>	
	    <td style=\" text-align:center\"><b>Qty </b></td>
	    <td style=\"text-align:center\"><b>Unit Price </b> </td>
	    <td  style=\" background-color:#F2E0F7 ;text-align:center\"><b>Price</b></td>
	    </tr>";
        while($data=mysql_fetch_array($sql2)) { 
	        echo "<tr style='text-align:center'>
	        <td style=\"background-color:#A9F5D0; text-align:center\">".$data['IDitem']."</td>
	        <td style=\"text-align:center\"> ".$data['IDreception']."</td>	
	        <td style=\" text-align:center\">".$data['qty']."</td>
	        <td style=\"text-align:center\">".$data['unit_price']." ".$data1['currency']." </td>
	        <td  style=\" background-color:#F2E0F7 ;text-align:center\">".$data['price']."  ".$data1['currency']."</td>
	        </tr>";	
        }
	}
		echo("<tr><td style=\"text-align:center \"><b>Status:".$data1['status']."</b></td>
		<td style=\"text-align:center;  background-color:#CEF6EC\" ><b>".$typeI."</b></td> 
        <td style=\"text-align:center; background-color:#F7F8E0\" colspan=2><b>Supplier: ".$data1['supplier']."</b></td> 
        <td  style=\" background-color:#F8E0E6 ;text-align:center\"><b>Total Price : ".$data1['total']." ".$data1['currency']."</b> </td></tr>
	    <tr>		
        <td colspan=2 style=\"text-align:center ;  background-color:#CEF6EC\" ><b>Payment Date :</b> 
	    <input type=\"date\" name=\"dateP\" id=\"dateP\" size=\"12\"></td>");
        if($modeP=="Autre"){
            echo '<td colspan=2 style=\"text-align:center\"><input type="text" name="refP" placeholder="Autre mode de payment" size="40"></td>';
        }else if($modeP!="Cache"){
		    echo '<td colspan=2  style=\"text-align:center\">
			<input type="text" name="refP" placeholder="Réference" size="20">
			<select id="NC"  name="NC" ></select>
			</td>';
        }else{
            echo '<td colspan=2 style=\"text-align:center\"></td>';
        }	
	echo ("<td><input  type=\"text\" name=\"montant\" placeholder=\"Montant \" ></td></tr><tr><td colspan=4></td><td style=\"text-align:left\">
	<input   style=\"float:center\" type=\"submit\" id=\"add1\" value=\"Paid >>\">
	<input  type=\"text\" name=\"invoice2\" value=\"".$IDinvoice2."\" HIDDEN></td>
	</tr></table>");
	mysql_close();

?>
	
