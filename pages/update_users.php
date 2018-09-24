
<html>
<head>
<meta charset="utf-8" />
<link href="../tablecloth/tablecloth.css" rel="stylesheet" type="text/css" media="screen" />
<script type="text/javascript" src="tablecloth/tablecloth.js"></script>
<link rel="stylesheet" type="text/css" href="../css/style.css"/>
<link rel="stylesheet" href="../CSS/mbcsmbmcp.css" type="text/css" />
<script src="../jquery/jquery-latest.min.js"></script>
<script type='text/javascript' src='../jquery/menu_jquery.js'></script>



<title>
STARZ ELECS ERP
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
<BR>
<p class="two">Administration</p>
<div id="globaln">
<div id="mbmcpebul_wrapper" style="max-width: 557px;">
  <ul id="mbmcpebul_table" class="mbmcpebul_menulist css_menu">
  <li class="first_button"><div class="buttonbg gradient_button gradient30"><a href="admin_ajout_users.php">Ajout Utilisateur</a></div></li>
  <li><div class="buttonbg gradient_button gradient30" style="width: 152px;"><a href="admin_supp_users.php">Suppression Utilisateur&nbsp;</a></div></li>
  <li><div class="buttonbg gradient_button gradient30" style="width: 149px;"><a href="admin_modif_users.php">Modification Utilisateur&nbsp;</a></div></li>
  <li class="last_button"><div class="buttonbg gradient_button gradient30" style="width: 143px;"><a href="admin_affich_users.php">Affichages Utilisateurs</a></div></li>
  </ul>
</div>
</div>

<p class="there">Modification Utilisateur</p>
<BR>
<form method="post" action="../php/admin_modif_user.php" name='form' >


<TABLE BORDER="0"> 
		<TR> 
			<Th WIDTH=120 HEIGHT=30  ALIGN="left" >Login a modifier:</Th> 
			<TD><input  type="text" name="login_old" SIZE="20"></TD> 
		</tr>

		<TR> 
			<Th WIDTH=120 HEIGHT=30  ALIGN="left" >Login:</Th> 
			<TD><input  type="text" name="login" SIZE="20"></TD> 
		</tr>	
		<TR> 
			<TH WIDTH=120 HEIGHT=30  ALIGN="left">Mot de pass:</TH> 
			<TD><input  type="password" name="pswd" SIZE="20"></TD> 
		</TR> 	
		<TR> 
			 <th WIDTH=120 HEIGHT=30  ALIGN="left">Droit d'accès:</th>
			 <td>
			 <select name="role">
				<option value="ADM">ADM</option>
				<option value="COM">COM</option>
				<option value="GRH">GRH</option>
				<option value="LOG">LOG</option>
				<option value="MAG">MAG</option>
				<option value="QUA">QUA</option>
				<option value="MAI">MAI</option>
				<option value="EXP">EXP</option>
				<option value="TST">TST</option>
				<option value="TSF">TSF</option>
				<option value="DEC">DEC</option>
				<option value="ASS">ASS</option>
				<option value="SRT">SRT</option>
				<option value="EMB">EMB</option>
				<option value="UPM-CUT">UPM-CUT</option>
                <option value="UPM-WSI">UPM-WSI</option>
                <option value="UPM-STR">UPM-STR</option>
                <option value="UPM-CRI">UPM-CRI</option>
                <option value="UPM-PIN">UPM-PIN</option>
                <option value="UPM-TST">UPM-TST</option>
                <option value="UPM-MLD">UPM-MLD</option>
                <option value="UPM-PAK">UPM-PAK</option>

			</select>
			</td>
			
		</TR> 	

</TABLE> 

<Th HEIGHT=30 ><input type="submit" value="Modifier" id="bigbutton">
<input type="reset" value="Vider les cases" id="bigbutton"></Th> 
	
</form>


<?php
if(!empty($_GET['status']))
{ 
     $status = $_GET['status']; 
     if  ($status=="sent")
	 {echo '<SCRIPT LANGUAGE="JavaScript">alert(\'Utilisateur a été modifé avec succès \');</SCRIPT>';}
	 else if ($status=="fail")
	 {echo '<SCRIPT LANGUAGE="JavaScript">alert(\'Erreur de connexion au serveur\');</SCRIPT>';}
	 else if ($status=="fail2")
	 {echo '<SCRIPT LANGUAGE="JavaScript">alert(\'n existe pas\');</SCRIPT>';}
} 

?>



</div>

</div>

</body>

</html>