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
Consultation Département 
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


<p class="there">Consulter Département</p>
<br>

<!-- end --> 



<form method="post">

  <?php
include('../connexion/connexionDB.php');

$rech = @$_POST["rech"];
$choix = @$_POST["choix"];
if (($rech=="")&&($choix==""))
{
$req= "SELECT * FROM ajout_departement ";
  $r=mysql_query($req) or die(mysql_error());;

  echo'<table  id="myTable" class="tablesorter" cellspacing="0" cellpadding="0"><thead><tr><td>ID département </td><td>Nom_département </td><td>chef_département</td><td>nombre_opérateur</td><td>nombre_technicien</td></tr>';
  while($a=mysql_fetch_object($r))
    {
    $dep_id=$a->dep_id;
    $nom=$a->nom;
	$chef_dep=$a->chef_dep;
	$nbr_opr=$a->nbr_opr;
	$nbr_tech=$a->nbr_tech;
	
    echo"<tr><td>$dep_id</td><td>$nom</td><td>$chef_dep</td><td>$nbr_opr</td><td>$nbr_tech</td></tr>";
    }
  echo '</thead></table>';


}

  ?>
  
  
<br/>
<br/>
 
</form>




</div>

</div>

</body>

</html>