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
consulter machine
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


<p class="there">Consulter Machine</p>
<br>

<!-- end --> 


<form method="post">

  <?php
include('../connexion/connexionDB.php');


$rech = @$_POST["rech"];
$choix = @$_POST["choix"];
if (($rech=="")&&($choix==""))
{
$req= "SELECT * FROM machines ";
  $r=mysql_query($req) or die(mysql_error());;

  echo'<table  id="myTable" class="tablesorter" cellspacing="0" cellpadding="0"><thead><tr><td>NUM° Serie </td><td>Nom_machine</td><td>Zone</td><td>Etat</td></tr>';
  while($a=mysql_fetch_object($r))
    {
    $num_serie=$a->num_serie;
    $nom_machine=$a->nom_machine;
	$zone=$a->zone;
	$etat=$a->etat;
	
    echo"<tr><td>$num_serie</td><td>$nom_machine</td><td>$zone</td><td>$etat</td></tr>";
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