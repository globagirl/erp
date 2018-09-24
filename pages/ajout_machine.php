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
<link rel="stylesheet" href="../CSS/mbcsmbmcp.css" type="text/css" />

<title>
Ajout Machine
</title>

</head>

<body>



<div id="entete">

<div id="logo">


</div>

<div id="boton">



</div>


</div>


<div id="main">


<div id="contenu">
<!-- began --> 
<BR>
<p class="two">MAINTENANCE</p>
<div id="globalc">
<div id="mbmcpebul_wrapper" style="max-width: 450px;">
  <ul id="mbmcpebul_table" class="mbmcpebul_menulist css_menu">
  <li class="first_button"><div class="buttonbg gradient_button gradient30"style="width: 210px;"><div class="arrow"><a>Gestion des Machines</a></div></div>
    <ul>
    <li class="first_item"><a href="ajout_machine.php" title="">Ajout Machine</a></li>
    <li><a href="consult_machine.php" title="">Consulter Machine</a></li>
    <li class="last_item"><a href="supp_mach.php" title="">Suppression Machine</a></li>
    </ul></li>
  <li class="last_button"><div class="buttonbg gradient_button gradient30" style="width: 216px;"><div class="arrow"><a>Gestion des pieces de rechange</a></div></div>
    <ul>
    <li class="first_item"><a title="">************</a></li>
    <li class="last_item"><a title="">************</a></li>
    </ul></li>
  </ul>
</div>
</div>


<p class="there">Ajout Machine</p>
<br>

<!-- end --> 

<form method="post" action="../php/ajout_mach.php">


<TABLE BORDER="0"> 

		<TR> 
			<Th WIDTH=150 HEIGHT=30  ALIGN="left" >Numero de serie: </Th> 
			<TD colspan="3"><input type="text" name="num_serie" SIZE="8" MAXLENGTH="8" colspan="2"></TD> 
			
		</TR> 
  
  
		<TR> 
			<TH WIDTH=150 HEIGHT=30  ALIGN="left">Nom : </TH> 
			<TD colspan="3"><input type="text" name="nom_machine" SIZE="30" MAXLENGTH="30"></TD> 
			
		</TR> 
  
  
<TR> 
 <TH WIDTH=150 HEIGHT=30  ALIGN="left">Zone : </TH> 
 <TD colspan="3"> <input type="text" name="zone" SIZE="30" MAXLENGTH="30"></TD>
</TR>
<TR> 
 <TH WIDTH=150 HEIGHT=30  ALIGN="left">Etat : </TH> 
 <TD colspan="3"> <input type="text" name="etat" SIZE="30" MAXLENGTH="30"></TD>
</TR>



</TABLE> 

<input type="submit">



 
<p>

</p>
 
</form>


</div>

</div>

</body>

</html>