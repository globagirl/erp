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
consult personnel
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


<p class="there">Consulter Ouvrier</p>
<br>

<!-- end --> 



<form method="post">
<table>
<tr>
<th>RECHERCHE</th>


                <td colspan="3">  
				              <select name="choix">
                              <option selected="selected" value=""></option>
							  <option value="nom">nom</option>
							  <option value="prenom">prenom</option>
							  <option value="tache">tache</option>
                              </select>
				</td>
				
				<td>
                 <input type="text" name="rech">
                </td>
<td>

<input type="submit" value="afficher" target="_blank" id="submitbutton">

</td>
</tr>
</table>

  <?php
include('../connexion/connexionDB.php');

$rech = @$_POST["rech"];
$choix = @$_POST["choix"];
if (($rech=="")&&($choix==""))
{
$req= "SELECT * FROM ouvrier ";
  $r=mysql_query($req) or die(mysql_error());;

  echo'<table cellspacing="0" cellpadding="0">
  <tr>
  <td>Num_cin</td>
  <td>Nom</td>
  <td>prénom</td>
  <td>tache</td>
  </tr>';
  
  while($a=mysql_fetch_object($r))
    {
    $num_cin=$a->num_cin;
    $nom=$a->nom;
	$prenom=$a->prenom;
	$tache=$a->tache;
	
    echo"<tr>
	<td>$num_cin</td>
	<td>$nom</td>
	<td>$prenom</td>
	<td>$tache</td>
	</tr>";
   }
  echo '</thead></table>';


}
else
{
$req= "SELECT * FROM ouvrier WHERE $choix='$rech' ";
  $r=mysql_query($req) or die(mysql_error());;

  echo'<table cellspacing="0" cellpadding="0">
  <tr>
  <td>Num_cin</td>
  <td>Nom</td>
  <td>prénom</td>
  <td>Tache</td>
  </tr>';
  while($a=mysql_fetch_object($r))
    {
    $num_cin=$a->num_cin;
    $nom=$a->nom;
	$prenom=$a->prenom;
	$tache=$a->tache;
	
	
    echo"<tr>
	<td>$num_cin</td>
	<td>$nom</td>
	<td>$prenom</td>
	<td>$tache</td>
	</tr>";
    }
  echo '</table>';
  }
  ?>
<br/>
<br/>
 
</form>




</div>

</div>

</body>

</html>