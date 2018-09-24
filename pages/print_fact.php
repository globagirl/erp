<?php
session_start ();
if( !isset($_SESSION["role"]) ){
    header('Location: ../index.php');
    exit();
}else{
$role=$_SESSION['role'];
$userID=$_SESSION['userID'];
}
?>
<html>
<head>
<meta charset="utf-8" />
<link href="../tablecloth/tablecloth.css" rel="stylesheet" type="text/css" media="screen" />
<script type="text/javascript" src="tablecloth/tablecloth.js"></script>
<link rel="stylesheet" type="text/css" href="../css/style.css"/>
<script src="../jquery/jquery-latest.min.js"></script>
<script type='text/javascript' src='../jquery/menu_jquery.js'></script>
<link rel="stylesheet" href="../CSS/mbcsmbmcp.css" type="text/css" />


<title>
Impression facture
</title>

<SCRIPT >
function deletepo()
{
document.form.num_po.value="";
document.form.num_po.style.background="#FFFFFF";
}
function printEN(){
		document.form1.action="../tcpdf/factu.php";
		document.form1.submit();
}
function excelFact(){
	document.form1.action="../php/excel_facture.php";
    document.form1.submit(); 
}

function pop_up(url){
window.open(url,'win2','status=no,toolbar=no,scrollbars=yes,titlebar=no,menubar=no,resizable=yes,width=1076,height=768,directories=no,location=no'); 
}
</script>


</head>

<body>
<div id="entete">
<div id="logo">
</div>
<div id="boton">
<?php 
include('../include/logOutIMG.php');
?>	
</div>
</div>

<div id="main">
<div id="menu">
<?php
if($role=="ADM"){
include('../menu/menuAdmin.php');	
}
elseif($role=="COM"){
include('../menu/menuCommercial.php');	
}
else{
	 header('Location: ../deny.php');
}
?>
</div>
<div id='contenu'>
<br>
<p class="there">Impression Facture</p>
<br>

<!-- end --> 


<form name="form1" id="form1" method="POST" action="../tcpdf/factu2.php">

<TABLE BORDER="0"> 

		<TR> 
		<input onclick="pop_up('../pages/pop_consult_facture.php');" type="button" value="Factures" id="bigbutton"><br>

		
			<Th WIDTH=200 HEIGHT=30  ALIGN="left" colspan="1">NUM° Facture  </Th> 
			<TD><input id="f1" type="text" name="num_f_1" SIZE="10"  ></TD>

			<Th WIDTH=50 HEIGHT=30  ALIGN="left" >à</Th> 
			<TD><input  id="f2" type="text" name="num_f_2" SIZE="10"  ></TD>
			</TR> 
			<tr>
				<Th WIDTH=200 HEIGHT=30  ALIGN="left" >Date expédition</Th> 
			<TD colspan=3><input  type="date" name="dateE" SIZE="10"  ></TD>
			</tr>
			<tr>
			<td></td>
			<TD colspan=3>
		<input type="button" onclick="printEN()" value="Print >>" id="submitbutton">
		<input type="button" id="submitbutton" onclick="excelFact();" value="EXCEL >>" />
		</TD>
			</tr>
</TABLE> 
<br>
<br>






 
<p>

</p>
 
</form>


</div>

</div>

</body>

</html>