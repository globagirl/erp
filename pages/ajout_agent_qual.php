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
Ajout agent qualité
</title>

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


<p class="there">Ajout Agent Qualité</p>
<br>

<!-- end --> 


<form method="post" name="form1"  >



</form>
	

 <form method="post" name="form1"  >
	

 
		<TR> 
<TD>
<input onclick="pop_up('../pages/afich_pers.php');" type="button" value="Afficher personnel" id="bigbutton"><br>			</TD>		
			<br>
<br><br>
  <Th WIDTH=90 HEIGHT=30 ALIGN="left" >N°CIN:</Th> 
            <TD colspan="3"><input type="text" name="num_cin" SIZE="30" MAXLENGTH="30"></TD>
			
			</TR> 
			

        </TR> 
</form> 

<form method="post" action="../php/ajout_ag_qual.php">


<TABLE BORDER="0"> 

		<TH HEIGHT=30 colspan="2" bgcolor="#F0E68C" >


                               <?php
							   
							   
							   include('../connexion/connexionDB.php');
								
								$num_cin= @$_POST['num_cin'];
																
								?>
	
								Num°CIN: 							   
						    
							     <?php
							echo $num_cin;
							echo "<input name=\"num_cin\" value=\"".$num_cin."\"/  hidden> ";
						   ?>	
  
  
		<TR> 
			<TH WIDTH=150 HEIGHT=30  ALIGN="left">Nom</TH> 
			<TD>
			
			<?php
								
								$n = mysql_query("SELECT nom FROM grh WHERE num_cin = '$num_cin' ");

								$n = mysql_fetch_array($n);
								
								echo "<input type=\"text\"  name=\"nom\" value=\"".$n['nom']."\"/ readonly>";
								$n = $n['nom'];
							
								?>
			
			</TD> 
		 </TR>
<TR>		 
			<Th WIDTH=30 HEIGHT=30 ALIGN="left">Prenom </Th> 
            <Td> 
			<?php
								
								$p = mysql_query("SELECT prenom FROM grh WHERE num_cin = '$num_cin' ");

								$p = mysql_fetch_array($p);
								
								echo "<input type=\"text\"  name=\"prenom\" value=\"".$p['prenom']."\"/ readonly>";
								$p = $p['prenom'];
							
								?>
			
			</Td> 
			 </TR>
     <TR>       
  <Th WIDTH=30 HEIGHT=30 ALIGN="left">Tache </Th> 
          
			
			<TD colspan="3">
<select name="tache">
<option selected="selected" value="cont_assem">contrôle assemblage</option>
<option value="cont_serti">contrôle sertissage</option>
<option value="test">Test</option>
<option value="emballage">Emballage</option>

</select>
			
			</Td>

 
 </TR>
 
 
 
 
 
 

 
		
</TABLE> 

<input type="submit"> 


		 
		
		 
	
 
</form>


</div>

</div>

</body>

</html>