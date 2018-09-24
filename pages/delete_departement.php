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
sup département 
</title>

<SCRIPT LANGUAGE="javascript">
function deletepo()
{
document.form.num_po.value="";
document.form.num_po.style.background="#FFFFFF";
}


</SCRIPT>

<script>
function pop_up(url){
window.open(url,'win2','status=no,toolbar=no,scrollbars=yes,titlebar=no,menubar=no,resizable=yes,width=1076,height=768,directories=no,location=no') 
}
</script>


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
  <li><div class="buttonbg gradient_button gradient30" style="width: 108px;"><div class="arrow"><a>Agent Qualité</a></div></div>
    <ul>
    <li class="first_item"><a href="ajout_ag_qual.php">Ajout Agent Qualité</a></li>
    <li><a href="grh_consult_ag_qual.php">Consulter Agent Qualité</a></li>
    <li class="last_item"><a href="grh_supp_ag_qual.php">Suppression Agent Qualité</a></li>
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


<p class="there">Suppression département</p>
<br>

<!-- end --> 

<form name="form" method="post" action="../php/grh_supp_dep.php">

<br>
<br>
<br>
<TABLE BORDER="0"> 

		<TR> 
		<input href="#" onclick="pop_up('../php/grh_afficher_dep.php');" type="button" value="Afficher détails Département" id="bigbutton"><br>
<br>
		<br>
		<H3> Entrer ID dep </H3>
			<Th WIDTH=100 HEIGHT=30  ALIGN="left" >ID Dép</Th> 
			<TD><input  type="text" name="dep_id" SIZE="10"  onFocus="deletepo()"></TD> 
			</TR> 
</TABLE> 
<br>
<br>



<input type="submit" value="supprimer" id="submitbutton">



 
<p>

</p>
 
</form>


</div>

</div>

</body>

</html>