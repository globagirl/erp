<html>
  <head>
    
	
		<meta charset="utf-8" />
	<title>Liste CLIENT</title>
	
<link href="../tablecloth/tablecloth.css" rel="stylesheet" type="text/css" media="screen" />
<script type="text/javascript" src="tablecloth/tablecloth.js"></script>
  </head>
  <body>
<h2> CLIENT</h2>
   <?php
include('../connexion/connexionDB.php');



$query= "SELECT * FROM client ";
  $r=mysql_query($query) ;
   mysql_close();
   echo'<table border="1" bordercolor="BLUE" ><tr><td>NOM_CLIENT</td><td>ADRESSE CLIENT</td><td>ADRESSE FACTURATION</td><td>ADRESSE LIVRAISON</td><td>PAYS CLIENT</td>
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
	
    echo"<tr><td>$name_client</td><td>$adr_client</td><td>$adress_fact</td><td>$adress_liv</td><td>$pays_client</td>
	<td>$cont1</td><td>$mail1</td><td>$tel1</td><td>$fax1</td><td>$cont2</td><td>$mail2</td><td>$tel2</td><td>$fax2</td></tr>";
    }
  echo '</table>';
  ?>
<br/>
<br/>

  </body>
</html>