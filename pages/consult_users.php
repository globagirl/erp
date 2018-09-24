<html>
<head>
<meta charset="utf-8" />

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
<p class="there">Affichages Utilisateurs</p>

<br>
<div id="globals">
  <?php
 include('../connexion/connexionDB.php');
  $query='SELECT * FROM users';
  $r=mysql_query($query);
  mysql_close();
  echo'<table border="1" bordercolor="BLUE"><tr><td>ID</td><td WIDTH=190>Utilisateurs</td><td WIDTH=190>Mot de pass</td><td>Role</td></tr>';
  while($a=mysql_fetch_object($r))
    {
	$id=$a->ID;
    $login=$a->login;
    $pswd=$a->pswd;
	$role=$a->role;

    echo"<tr><td>$id</td><td>$login</td><td>$pswd</td><td>$role</td></tr>";
    }
  echo '</table>';
  ?>

</div>





</div>

</div>

</body>

</html>