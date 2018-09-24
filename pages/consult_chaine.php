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
Consultation chaine
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
<p class="two">PRODUCTION</p>
<div id="globala">
<div id="mbmcpebul_wrapper" style="max-width: 450px;">
  <ul id="mbmcpebul_table" class="mbmcpebul_menulist css_menu">
  <li class="first_button"><div class="buttonbg gradient_button gradient30" style="width: 142px;"><a href="ajout_chaine.php">Ajout chaine</a></div></li>
  <li><div class="buttonbg gradient_button gradient30" style="width: 143px;"><a href="supp_chain.php">Suppression chaine</a></div></li>
  <li class="last_button"><div class="buttonbg gradient_button gradient30" style="width: 140px;"><a href="consult_chaine.php">Consulter chaine</a></div></li>
  </ul>
</div>
</div>
<p class="there">Consulter Chaine</p>
<br>

<!-- end --> 





<table>
<tr>
<th>RECHERCHE</th>


                <td colspan="3">  
				              <select name="choix">
                              <option selected="selected" value=""></option>
							  <option value="nom">nom</option>
							  <option value="prenom">prenom</option>
							  <option value="num_cin">CIN</option>
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
$req= "SELECT * FROM grh ";
  $r=mysql_query($req) or die(mysql_error());;

  echo'<table  id="myTable" class="tablesorter" cellspacing="0" cellpadding="0"><thead><tr><td>Num_cin</td><td>Nom</td><td>prénom</td><td>date_naissance</td><td>adresse</td><td>num_tel_1</td><td>num_tel_2</td><td>@_mail</td><td>diplôme</td><td>Situation</td><td>date_entré</td><td>salaire</td><td>RIB</td></tr>';
  while($a=mysql_fetch_object($r))
    {
    $num_cin=$a->num_cin;
    $nom=$a->nom;
	$prenom=$a->prenom;
	$date_naissance=$a->date_naissance;
	$adr=$a->adr;
	$tel1=$a->tel1;
	$tel2=$a->tel2;
	$adresse_Email=$a->adresse_Email;
	$dip=$a->dip;
    $situation=$a->situation;
	$date_e=$a->date_e;
	$salaire=$a->salaire;
	$rib=$a->rib;
    echo"<tr><td>$num_cin</td><td>$nom</td><td>$prenom</td><td>$date_naissance</td><td>$adr</td><td>$tel1</td><td>$tel2</td><td>$adresse_Email</td><td>$dip</td><td>$situation</td><td>$date_e</td><td>$salaire</td><td>$rib</td></tr>";
    }
  echo '</thead></table>';


}
else
{
$req= "SELECT * FROM grh WHERE $choix='$rech' ";
  $r=mysql_query($req) or die(mysql_error());;

  echo'<table cellspacing="0" cellpadding="0"><tr><td>Num_cin</td><td>Nom</td><td>prénom</td><td>date_naissance</td><td>adresse</td><td>num_tel_1</td><td>num_tel_2</td><td>@_mail</td><td>diplôme</td><td>Situation</td><td>date_entré</td><td>salaire</td><td>RIB</td></tr>';
  while($a=mysql_fetch_object($r))
    {
    $num_cin=$a->num_cin;
    $nom=$a->nom;
	$prenom=$a->prenom;
	$date_naissance=$a->date_naissance;
	$adr=$a->adr;
	$tel1=$a->tel1;
	$tel2=$a->tel2;
	$adresse_Email=$a->adresse_Email;
	$dip=$a->dip;
    $situation=$a->situation;
	$date_e=$a->date_e;
	$salaire=$a->salaire;
	$rib=$a->rib;
    echo"<tr><td>$num_cin</td><td>$nom</td><td>$prenom</td><td>$date_naissance</td><td>$adr</td><td>$tel1</td><td>$tel2</td><td>$adresse_Email</td><td>$dip</td><td>$situation</td><td>$date_e</td><td>$salaire</td><td>$rib</td></tr>";
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