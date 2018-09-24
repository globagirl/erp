<?php
session_start ();
$role=$_SESSION['role'];
$userID=$_SESSION['userID'];
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
Imprimer code paquet
</title>
<script>
function afficheZ(){
 var liste = document.getElementById('recherche');
  var typeR = liste.options[liste.selectedIndex].value;
  if(typeR=="codeR" || typeR=="IDpaquet" || typeR=="IDarticle" ){
  $('#Z').html('<input type="text" id="val" name="val"> ');
  }else{
  $('#Z').html('<input type="date" id="val" name="val"> ');
}
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
elseif($role=="MAG"){
include('../menu/menuMagazin.php');	
}
else{
session_unset();
   session_destroy();
	 header('Location: ../deny.php');
}
?>
</div>
<div id='contenu'>
<br>
<p class="there">Imprimer Code Paquet</p>

<br>
<form name="form" method="post" action="../tcpdf/id_box.php" >


<TABLE BORDER="0"> 

		<TR> 
		
			<Th WIDTH=100 HEIGHT=30  ALIGN="left" >Recherche</Th> 
			<TD>
			<span class="custom-dropdown custom-dropdown--white custom-dropdown--small">
			<select name="recherche" id="recherche" onChange="afficheZ();" style="width:250px" class="custom-dropdown__select custom-dropdown__select--white" >
			<option value="dateE">Date entrée stock</option>
             <option value="dateR">Date reception</option>
			 <option value="IDpaquet">Code paquet</option>
			 
			 <option value="codeR">Reception ID </option>
			 <option value="IDarticle">Article </option>
            </select> 
			</span>
			</td></tr>
			<td></td>
			<TD id="Z"> <input type="date" name="val" id="val"> </TD> 
			</tr>
			<tr>
			<td></td>
			<td>
			<input type="submit" value="Print" id="submitbutton">
			</td>
		</TR> 
		
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