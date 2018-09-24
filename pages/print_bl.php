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
impression BL
</title>

<SCRIPT>
function deletepo()
{
document.form.num_po.value="";
document.form.num_po.style.background="#FFFFFF";
}

function pop_up(url){
window.open(url,'win2','status=no,toolbar=no,scrollbars=yes,titlebar=no,menubar=no,resizable=yes,width=1076,height=768,directories=no,location=no') 
}
function excelBL(){
	document.form1.action="../php/excel_BL.php";
    document.form1.submit(); 
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
}elseif($role=="CONS"){
	include('../menu/menuConsommable.php');	
	}
else{
	 header('Location: ../deny.php');
}
?>
</div>
<div id='contenu'>
<!-- began --> 
<BR>

<p class="there">Impression BL</p>
<br>

<!-- end --> 

<form  name="form1" id="form1" method="POST" action="../tcpdf/b_liv.php">

<br>

<TABLE BORDER="0"> 

		<TR> 
		<input href="#" onclick="pop_up('../pages/pop_consult_BL.php');" type="button" value="Afficher  Liste BL" id="bigbutton" ><br>

	
		
			<Th WIDTH=100 HEIGHT=30  ALIGN="left" >NUM° BL  </Th> 
			<TD><input  type="text" name="num_bl_1" SIZE="10"  ></TD>

			<Th WIDTH=100 HEIGHT=30  ALIGN="left" >A</Th> 
			<TD><input  type="text" name="num_bl_2" SIZE="10"  ></TD>
			</TR> 
			<tr>
			<Td></td>
			<td colspan=3>
			<input type="submit" id="submitbutton" value="print >>">
            <input type="button" id="submitbutton" onclick="excelBL();" value="EXCEL >>" />

			</td >
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