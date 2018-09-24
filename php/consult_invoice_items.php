<?php 
session_start();
?>
<html>
<head>
<meta charset="utf-8" />
<link href="../tablecloth/tablecloth.css" rel="stylesheet" type="text/css" media="screen" />
<script type="text/javascript" src="tablecloth/tablecloth.js"></script>
<link rel="stylesheet" type="text/css" href="../css/style.css"/>
<script src="../jquery/jquery-latest.min.js"></script>
<script type='text/javascript' src='../jquery/menu_jquery.js'></script>
<title>
Consult invoice items
</title>
</head>
<body>
<form role="form" method="post" name="form1" id="form1" action="../php/update_invoice.php" enctype="multipart/form-data">
<?php

include('../connexion/connexionDB.php');
if(isset($_POST['invoice'])){
$invoice=$_POST['invoice'];
$_SESSION['invoice']=$invoice;	
}else{
    $invoice=$_SESSION['invoice'];
	$sql1 = mysql_query("SELECT * FROM supplier_invoice where IDinvoice='$invoice'");
	$data1=mysql_fetch_array($sql1);
    $IDinvoice=$invoice;
	$n=strpos($IDinvoice,"-");
	$four=$data1['supplier'];
    $IDinvoice=substr($IDinvoice,$n+1); 
	echo(" <table><tr>	<th colspan=4>Invoice N°: ".$IDinvoice."
	<input name=\"inv\" value=\"".$invoice."\" HIDDEN><input name=\"four\" value=\"".$four."\" HIDDEN>
	</th></tr><tr><td colspan=2> <b>Status: </b>".$data1['status']."</td>
	<td> <b>Shipment coast :</b>".$data1['shipCoast']."</td>
	<td><b> Tax:</b>".$data1['tax']."</td></tr>");
	$stat=$data1['status'];
	if($stat=='paid'){
	    $sql11 = mysql_query("SELECT * FROM invoice_mode_pay where num_invoice='$invoice'");
		while($data11=mysql_fetch_array($sql11)){
            $compte=$data11['compte'];	
            if($compte != ""){
			    $sql12 = mysql_query("SELECT * FROM compte_banque where REFcompte='$compte'");
				$data12=mysql_fetch_array($sql12);
                echo "<tr><td><b>Mode: </b>".$data11['modeP']."</td><td><b>REF: </b>".$data11['reference']."</td><td><b>Compte :</b>".$data12['NUMcompte']."</td><td><b>Banque :</b>".$data12['banque']."</td></tr>";				
            }else{            			
	             echo "<tr><td colspan=3><b>Mode de payment : </b>".$data11['modeP']."</td><td></td></tr>";
			}
	    }
	    echo ('</table>');
	}
?>
<table><tr><th colspan=2> ADD new file </th></tr>
<tr><td> </td><td>  <input type="file" name="imgfact[]"  multiple></td></tr>
<tr><td> </td><td>  <input type="submit" value="ADD >>" id="submitbutton"></td></tr>
</table>
<?php
echo(" <table><tr>	<th colspan=6 >Invoice Items  

<input name=\"inv\" value=\"".$invoice."\" HIDDEN><input name=\"four\" value=\"".$four."\" HIDDEN>
</th></tr>

<tr><td> Item ID</td>
<td>Reception ID  </td>
<td>Purchase Order N° </td>
<td>Qty </td>
<td>Unit price </td>
<td>Price </td></tr>
");
$sql = mysql_query("SELECT * FROM supplier_invoice_items where IDinvoice='$invoice'");
 while($data=mysql_fetch_array($sql)){
	echo("<tr><td> ".$data['IDitem']."</td>
<td>".$data['IDreception']." </td>
<td>".$data['IDordre']." </td>
<td>".$data['qty']." </td>
<td> ".$data['unit_price']." ".$data1['currency']."</td>
<td> ".$data['price']." ".$data1['currency']."</td>
</tr>"); 
 }
echo("<tr>	<Th Wcode_articleTH=150 HEIGHT=30 colspan=6 >Total Price: ".$data1['total']." ".$data1['currency']."</th></tr>
</table>");	
}
mysql_close();

?>
</form>
</body>
</html>