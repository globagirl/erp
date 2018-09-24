<?php
session_start ();
if( !isset($_SESSION["role"]) ){
    header('Location: ../index.php');
    exit();
}else{
$role=$_SESSION['role'];
$userID=$_SESSION['userID'];
}
?>
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
consulter client 
</title>



</head>

<body>

<div id="entete">
<div id="logo">
</div>
<div id="boton">
<?php 
include('../include/logOutIMG.php');
?>	
</div>
</div>

<div id="main">
<div id="menu">
<?php
if($role=="ADM"){
include('../menu/menuAdmin.php');	
}

elseif($role=="COM"){
include('../menu/menuCommercial.php');	
}
else{
	 header('Location: ../deny.php');
}
?>
</div>
<div id='contenu'>
<br>

<p class="there">Consulter client </p>
<br>

<!-- end --> 

<form method="post">
<table>
<tr>
<th>RECHERCHE</th>


                <td colspan="3">  
				              <select name="choix">
                              <option selected="selected" value=""></option>
							  <option value="name_client">Nom client</option>
							  <option value="adr_client">Adresse client</option>
							  <option value="adress_fact">Adresse facturation</option>
							  <option value="adress_liv">Adresse livraison</option>
							  <option value="pays_client"> Pays client</option>
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
$req= "SELECT * FROM client1 ";
  $r=mysql_query($req) or die(mysql_error());;

  echo'<table><thead><tr><td>ID_CLIENT</td><td>NOM_CLIENT</td><td>ADRESSE CLIENT</td><td>ADRESSE FACTURATION</td><td>ADRESSE LIVRAISON</td><td>PAYS CLIENT</td>
  <td>Contact 1</td><td>MAIL 1</td><td>TEL 1</td><td>FAX 1</td><td>Contact 2</td><td>MAIL 2</td><td>TEL 2</td><td>FAX 2</td>
  </tr>';
  while($a=mysql_fetch_object($r))
    {
    $name_client =$a->name_client;
    $adr_client = $a->adr_client;
	$adress_fact = $a->adress_fact;
	$adress_liv = $a->adress_liv;
	$pays_client = $a->pays_client ;
	$cont1 = $a->cont1;
	$mail1 = $a->mail1;
	$tel1 = $a->tel1;
	$fax1 = $a->fax1;
	$cont2 = $a->cont2;
	$mail2 = $a->mail2;
	$tel2 = $a->tel2;
	$fax2 = $a->fax2;
	$nomClient =$a->nomClient;
    echo"<tr><td>$name_client</td><td>$nomClient</td><td>$adr_client</td><td>$adress_fact</td><td>$adress_liv</td><td>$pays_client</td>
	<td>$cont1</td><td>$mail1</td><td>$tel1</td><td>$fax1</td><td>$cont2</td><td>$mail2</td><td>$tel2</td><td>$fax2</td></tr>";
    }
  echo '</thead></table>';


}
else

{
$req= "SELECT * FROM client1 WHERE $choix LIKE '%$rech%' ";
  $r=mysql_query($req) or die(mysql_error());;

  echo'<table  id="myTable" class="tablesorter" cellspacing="0" cellpadding="0"><thead><tr><td>NOM_CLIENT</td><td>ADRESSE CLIENT</td><td>ADRESSE FACTURATION</td><td>ADRESSE LIVRAISON</td><td>PAYS CLIENT</td>
  <td>Contact 1</td><td>MAIL 1</td><td>TEL 1</td><td>FAX 1</td><td>Contact 2</td><td>MAIL 2</td><td>TEL 2</td><td>FAX 2</td>
  </tr>';
  while($a=mysql_fetch_object($r))
    {
    $name_client =$a->name_client;
    $nomClient =$a->nomClient;
    $adr_client = $a->adr_client;
	$adress_fact = $a->adress_fact;
	$adress_liv = $a->adress_liv;
	$pays_client = $a->pays_client ;
	$cont1 = $a->cont1;
	$mail1 = $a->mail1;
	$tel1 = $a->tel1;
	$fax1 = $a->fax1;
	$cont2 = $a->cont2;
	$mail2 = $a->mail2;
	$tel2 = $a->tel2;
	$fax2 = $a->fax2;
	
    echo"<tr><td>$name_client</td><td>$nomClient</td><td>$adr_client</td><td>$adress_fact</td><td>$adress_liv</td><td>$pays_client</td>
	<td>$cont1</td><td>$mail1</td><td>$tel1</td><td>$fax1</td><td>$cont2</td><td>$mail2</td><td>$tel2</td><td>$fax2</td></tr>";
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