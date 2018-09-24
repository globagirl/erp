<?php
session_start ();
$role=$_SESSION['role'];
$userID=$_SESSION['userID'];
?>
<html>
<head>
<meta charset="utf-8" />
<link href="../tablecloth/tablecloth.css" rel="stylesheet" type="text/css" media="screen" />
<script type="text/javascript" src="../tablecloth/tablecloth.js"></script>
<link rel="stylesheet" type="text/css" href="../css/style.css"/>
<script src="../jquery/jquery-latest.min.js"></script>
<script type='text/javascript' src='../jquery/menu_jquery.js'></script>
<link rel="stylesheet" href="../CSS/mbcsmbmcp.css" type="text/css" />
<title>
consulter stock
</title>
<SCRIPT LANGUAGE="javascript">

function verifchamp()
{
var id_box = document.getElementById("id_box").value;
if(id_box=="")
{
alert("champs ne doit pas etre vide");
return false;
}
else
{
  $.ajax({
 type: "POST",
 url: "../php/afficher_carton.php",
 data: {id_box:id_box}
 }).done(function( result ) {
 if (result==01)
 {
 alert( " Paquet non valid  ");
 }
 else{
 
alert( " Numero PO = "+result);
  $("#msg2").html( " Le Numero PO de ce box : "+id_box+" est "+result );
 }

 });
}
}
</SCRIPT>
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
elseif($role=="EMB"){
include('../menu/menuEMB.php');	
}
elseif($role=="PRD"){
include('../menu/menuProduction.php');	
}
else{
	 header('Location: ../deny.php');
}
?>
</div>
<div id='contenu'>


<br>
<p class="two">Suivis Emballage</p>

<p class="there">Consulter les Cartons</p>
<br>
<!-- end --> 



<form method="post">
<table>
<tr>
<th>Num° paquet: </th>
<td>
<input type="text" name="numpo" id="id_box">
<input type="text" name="okok" id="id_box" hidden>
</td>

<td>
<input type="button" value="afficher" id="submitbutton" onclick="verifchamp()">


</td>
</tr>
</table>

 
<br/>
<br/>
 
</form>

 <div STYLE="font-family: Arial Black; 
font-size: 18px; color:#FF3300" id="msg2">
 </div>


</div>

</div>

</body>

</html>