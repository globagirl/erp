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
  <li><div class="buttonbg gradient_button gradient30" style="width: 152px;"><a href="admin_supp_users.php">Suppression Utilisateur</a></div></li>
  <li><div class="buttonbg gradient_button gradient30" style="width: 149px;"><a href="admin_modif_users.php">Modification Utilisateur</a></div></li>
  <li class="last_button"><div class="buttonbg gradient_button gradient30" style="width: 143px;"><a href="admin_affich_users.php">Affichages Utilisateurs</a></div></li>
  </ul>
</div>
</div>

<p class="there">Suppresion Utilisateur</p>
<form method="post" action="../php/admin_supp_user.php" name='form' >


<br>

<TABLE BORDER="0"> 

		<TR> 
			<Th WIDTH=120 HEIGHT=30  ALIGN="left" >Login:</Th> 
			<TD><input  type="text" name="login" SIZE="20"></TD> 
		</tr>	

</TABLE> 

<Th HEIGHT=30 ><input type="submit" value="Supprimer" id="bigbutton">
<input type="reset" value="Vider les cases" id="bigbutton"></Th> 
	
</form>


<?php
if(!empty($_GET['status']))
{ 
     $status = $_GET['status']; 
     if  ($status=="sent")
	 {echo '<SCRIPT LANGUAGE="JavaScript">alert(\'Utilisateur a été supprimé avec succès \');</SCRIPT>';}
	 else if ($status=="fail")
	 {echo '<SCRIPT LANGUAGE="JavaScript">alert(\'Erreur de connexion au serveur\');</SCRIPT>';}
	 else if ($status=="fail")
	 {echo '<SCRIPT LANGUAGE="JavaScript">alert(\'login n\'existe pas dans la base de données \');</SCRIPT>';}
} 

?>



</div>

</div>

</body>

</html>