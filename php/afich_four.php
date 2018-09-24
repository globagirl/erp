<html>
  <head>
    
	
	<meta charset="utf-8" />
	<title>Liste Fournisseur</title>
<link href="../tablecloth/tablecloth.css" rel="stylesheet" type="text/css" media="screen" />
<script type="text/javascript" src="tablecloth/tablecloth.js"></script>
  </head>
  <body>
<h2> Fournisseur</h2>
   <?php
 include('../connexion/connexionDB.php');


$query= "SELECT * FROM fournisseur ";
  $r=mysql_query($query) ;
   mysql_close();
   echo'<table border="1" bordercolor="BLUE" ><tr><td>NOM_Fournisseur</td><td>ADRESSE fournisseur</td><td>ADRESSE magasin</td><td>PAYS fournisseur</td>
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
  echo '</table>';
  ?>
<br/>
<br/>

  </body>
</html>