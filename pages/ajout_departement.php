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
ajout département 
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
<p class="two">GRH</p>
<div id="globalc">
<div id="mbmcpebul_wrapper" style="max-width: 420px;">
  <ul id="mbmcpebul_table" class="mbmcpebul_menulist css_menu">
  <li class="first_button"><div class="buttonbg gradient_button gradient30"><div class="arrow"><a>Personnel</a></div></div>
    <ul>
    <li class="first_item"><a href="grh_ajout_personnel.php">Ajout Personnel</a></li>
    <li><a href="grh_consult_pers.php">Consulter Personnel</a></li>
    <li class="last_item"><a href="grh_supp_pers.php">Suppression Personnel</a></li>
    </ul></li>
  <li><div class="buttonbg gradient_button gradient30" style="width: 108px;"><div class="arrow"><a>Agent Qualite</a></div></div>
    <ul>
    <li class="first_item"><a href="ajout_ag_qual.php">Ajout Agent Qualite</a></li>
    <li><a href="grh_consult_ag_qual.php">Consulter Agent Qualite</a></li>
    <li class="last_item"><a href="grh_supp_ag_qual.php">Suppression Agent Qualite</a></li>
    </ul></li>
  <li><div class="buttonbg gradient_button gradient30" style="width: 96px;"><div class="arrow"><a>Ouvrier</a></div></div>
    <ul>
    <li class="first_item"><a href="ajout_ouvr.php">Ajouter Ouvrier</a></li>
    <li><a href="grh_consult_ouvr.php">Consulter Ouvrier</a></li>
    <li class="last_item"><a href="grh_supp_ouvr.php">Suppression Ouvrier</a></li>
    </ul></li>
  <li class="last_button"><div class="buttonbg gradient_button gradient30" style="width: 103px;"><div class="arrow"><a>Departement</a></div></div>
    <ul>
    <li class="first_item"><a href="grh_ajout_dep.php">Ajout Departement</a></li>
    <li><a href="grh_consult_dep.php">Consulter Departement</a></li>
    <li class="last_item"><a href="grh_supp_dep.php">Suppression Departement</a></li>
    </ul></li>
  </ul>
</div>
</div>


<p class="there">Ajout Departement</p>
<br>

<!-- end --> 

<form method="post" action="../php/dep.php">


<TABLE BORDER="0"> 

		<TR> 
			<Th WIDTH=150 HEIGHT=30  ALIGN="left" >Departement ID: </Th> 
			<TD colspan="3"><input type="text" name="dep_id" SIZE="8" MAXLENGTH="8" colspan="2"></TD> 
			
		</TR> 
  
  
		<TR> 
			<TH WIDTH=150 HEIGHT=30  ALIGN="left">Nom : </TH> 
			<TD colspan="3"><input type="text" name="nom" SIZE="30" MAXLENGTH="30"></TD> 
			
		</TR> 
  
  
<TR> 
 <TH WIDTH=150 HEIGHT=30  ALIGN="left">Chef Departement : </TH> 
 <TD colspan="3"> <input type="text" name="chef_dep" SIZE="30" MAXLENGTH="30"></TD>
</TR>



<TR> 
 <TH WIDTH=100 HEIGHT=30  ALIGN="left">Nombre d'operateur : </TH> 
 // <TD colspan="3"> <input type="text" name="nbr_opr" SIZE="20"> </TD> 

</TR>
 
<TR> 
 <TH WIDTH=100 HEIGHT=30  ALIGN="left">Nombre technicien : </TH> 
 <TD colspan="3"> <input type="text" name="nbre_tech" SIZE="20" ></TD> 

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