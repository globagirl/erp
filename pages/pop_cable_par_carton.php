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
ajout article
</title>
</head>

<body>
<br>

<p class="there">Cable par carton</p>
<form method="post" action="../pages/pop_cable_par_carton.php">
<table>
	<TR> 
			<TH WIDTH=150 HEIGHT=30  ALIGN="left">Length: </TH> 
			<TD colspan="2"><input type="text"  name="long" SIZE="10"></TD> 
			
		</TR> 
  
  
<TR> 
 <TH WIDTH=150 HEIGHT=30  ALIGN="left">Quantité par box: </TH> 
 <TD colspan="2"> <input type="text" name="qteB"  MAXLENGTH="30" SIZE="10"></TD>
</TR>
<TR> 
 <TH WIDTH=150 HEIGHT=30  ALIGN="left">Taille de lot: </TH> 
 <TD colspan="2"> <input type="text" name="tlot"  MAXLENGTH="30" SIZE="10" ></TD>
</TR>
<TR> 
 <TH WIDTH=150 HEIGHT=30  ALIGN="left">Nombre paquet: </TH> 
 <TD colspan="2"> <input type="text" name="nbrP"  MAXLENGTH="30" SIZE="10"></TD>
</TR>


 


</TABLE> 

<input type="submit" value="Ajouter" id="submitbutton"> 


 
<p>

</p>
 
</form>
</body>
</html>
<?php

include('../connexion/connexionDB.php');
$long = @$_POST['long'];
$qteB = @$_POST['qteB'];
$tlot = @$_POST['tlot'];
$nbrP = @$_POST['nbrP'];
$sql= mysql_query("INSERT INTO cable_par_carton(length, qte_par_box, taille_lot, nbr_paquet) VALUES ('$long','$qteB','$tlot','$nbrP')");

?>