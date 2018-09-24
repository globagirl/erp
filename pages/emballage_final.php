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
Emballage final
</title>

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
if($role=="EMB"){
include('../menu/menuEMB.php');	
}

else if($role=="ADM"){
include('../menu/menuAdmin.php');	
}else if($role=="CONS"){
include('../menu/menuConsommable.php');	
}
else{
header('Location: ../deny.php');
}
?>
</div>
<div id='contenu'>


<br>
<p class="there">Emballage final</p>
<br>

<!-- end --> 


<form method="post" action="../php/emballage_final.php">


<table> 

		<tr> 
		<td></td>
		<td>
			<INPUT type= "radio" name="etat" value="Manque" checked> Manque
            <INPUT type= "radio" name="etat" value="Surnombre"> Surnombre
		</td>	
		</tr> 

  
  
<tr> 
 <th>Ordre de fabrication </th> 
 <td> <input type="text" name="OF" SIZE="20" placeholder="N° OF" ></td>
 </tr>
</TR> <th>Quantité </th> 
 <td> <input type="text" name="qte" SIZE="20" placeholder="Manque/Surnombre"></TD>
</TR>



<tr> 
 <th >QTY reçue  </th> 
 <td > <input type="text" name="recue" SIZE="20" placeholder="0"> </td> 
</tr>
<tr> 
 <TH WIDTH=200 HEIGHT=30  ALIGN="left">QTY retourné</TH> 
 <TD ><input type="text" name="retour" SIZE="20" placeholder="0"></TD>
</tr> 

 


 <Th ></Th> 
 <Td><input type="submit" id="submitbutton" value="Valider"> </Td>
</TR>
		
		
		
</TABLE> 




		 
		
		 
	
 
</form>


</div>

</div>

</body>

</html>