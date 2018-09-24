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
consulter fournisseur
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
<p class="there">Consulter Fournisseur </p>
<br>

<!-- end --> 


<form method="post">
<table>
<tr>
<th>RECHERCHE</th>


                <td colspan="3">  
				              <select name="choix">
                              <option selected="selected" value=""></option>
							  <option value="nom">Nom fournisseur</option>
							  <option value="adr">Adresse fournisseur</option>
							  
							  
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
$req= "SELECT * FROM fournisseur1 ";
  $r=mysql_query($req) or die(mysql_error());;

  echo'<table  id="myTable" class="tablesorter" cellspacing="0" cellpadding="0"><thead><tr><td>NOM_Fournisseur</td><td>ADRESSE fournisseur</td><td>ADRESSE magasin</td><td>PAYS fournisseur</td>
  <td>Contact 1</td><td>MAIL 1</td><td>TEL 1</td><td>FAX 1</td><td>Contact 2</td><td>MAIL 2</td><td>TEL 2</td><td>FAX 2</td>
  </tr>';
  while($a=mysql_fetch_object($r))
    {
	
	
	
    $nom =$a->nom;
    $adr =$a->adr;
	$adr_magas =$a->adr_magas;
	$pays =$a->pays;
	$contact_1 =$a->contact_1;
	$mail_1 =$a->mail_1;
	$tel_1 =$a->tel_1;
	$fax_1 =$a->fax_1;
	$contact_2 =$a->contact_2;
	$mail_2 =$a->mail_2;
	$tel_2 =$a->tel_2;
	$fax_2 =$a->fax_2;
	
    echo"<tr><td>$nom</td><td>$adr</td><td>$adr_magas</td><td>$pays</td><td>$contact_1</td><td>$mail_1</td><td>$tel_1</td><td>$fax_1</td><td>$contact_2</td><td>$mail_2</td><td>$tel_2</td><td>$fax_2</td></tr>";
    }
  echo '</thead></table>';


}
else
{
$req= "SELECT * FROM fournisseur1  WHERE $choix LIKE '%$rech%'";
  $r=mysql_query($req) or die(mysql_error());;

  echo'<table  id="myTable" class="tablesorter" cellspacing="0" cellpadding="0"><thead><tr><td>NOM_Fournisseur</td><td>ADRESSE fournisseur</td><td>ADRESSE magasin</td><td>PAYS fournisseur</td>
  <td>Contact 1</td><td>MAIL 1</td><td>TEL 1</td><td>FAX 1</td><td>Contact 2</td><td>MAIL 2</td><td>TEL 2</td><td>FAX 2</td>
  </tr>';
  while($a=mysql_fetch_object($r))
    {
	
	
    $nom =$a->nom;
    $adr =$a->adr;
	$adr_magas =$a->adr_magas;
	$pays =$a->pays;
	$contact_1 =$a->contact_1;
	$mail_1 =$a->mail_1;
	$tel_1 =$a->tel_1;
	$fax_1 =$a->fax_1;
	$contact_2 =$a->contact_2;
	$mail_2 =$a->mail_2;
	$tel_2 =$a->tel_2;
	$fax_2 =$a->fax_2;
	
    echo"<tr><td>$nom</td><td>$adr</td><td>$adr_magas</td><td>$pays</td><td>$contact_1</td><td>$mail_1</td><td>$tel_1</td><td>$fax_1</td><td>$contact_2</td><td>$mail_2</td><td>$tel_2</td><td>$fax_2</td></tr>";
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
   
  
  
<br/>
<br/>
 
</form>




</div>

</div>

</body>

</html>