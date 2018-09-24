<html>
  <head>
  <meta charset="utf-8" />
  <link href="../tablecloth/tablecloth.css" rel="stylesheet" type="text/css" media="screen" />
<script type="text/javascript" src="../tablecloth/tablecloth.js"></script>
<link rel="stylesheet" type="text/css" href="../css/style.css"/>
<script src="../jquery/jquery-latest.min.js"></script>
<script type='text/javascript' src='../jquery/menu_jquery.js'></script>
<link rel="stylesheet" href="../CSS/mbcsmbmcp.css" type="text/css" />
    <title>Liste OF</title>
	<link href="../tablecloth/tablecloth.css" rel="stylesheet" type="text/css" media="screen" />
<script type="text/javascript" src="tablecloth/tablecloth.js"></script>
  </head>
  <body>
<h2> Liste Ordre de Fabrication</h2>
  




<form method="post">
<table>
<tr>
<th>RECHERCHE</th>


                <td colspan="3">  
				              <select name="choix">
                              <option selected="selected" value=""></option>
							  <option value="PO">Num° PO</option>
							  <option value="produit">code article</option>
							  <option value="qte">QTE</option>
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

$query= "SELECT * FROM ordre_fabrication1 ORDER BY OF DESC ";
  $r=mysql_query($query) ;
   mysql_close();
   echo'<table border="1" bordercolor="BLUE" ><tr><td>Num OF</td><td>Num PO </td><td>Code Article </td><td>Nombre de lot</td>
  <td>Quantité OF</td><td>Date lancement </td> </tr>';
  while($a=mysql_fetch_object($r))
    {
    $num_of =$a->OF;
    $num_po_client = $a->PO;
	$code_artic = $a->produit;
	$nbr_lot = $a->nbr_plan;
	
	$qte_of = $a->qte;
	$date_lance_cmd = $a->date_lance;
	
	
	
    echo"<tr><td>$num_of</td><td>$num_po_client</td><td>$code_artic</td><td>$nbr_lot</td>
	<td>$qte_of</td><td>$date_lance_cmd</td></tr>";
    }
  echo '</table>';
  
  }
  else
  
  {
  
  $query= "SELECT * FROM ordre_fabrication1 WHERE $choix='$rech' ";
  $r=mysql_query($query) ;
   mysql_close();
   echo'<table border="1" bordercolor="BLUE" ><tr><td>Num OF</td><td>Num PO </td><td>Code Article </td><td>Nombre de lot</td>
  <td>Quantité OF</td><td>Date lancement </td> </tr>';
  while($a=mysql_fetch_object($r))
    {
    $num_of =$a->OF;
    $num_po_client = $a->PO;
	$code_artic = $a->produit;
	$nbr_lot = $a->nbr_plan;
	
	$qte_of = $a->qte;
	$date_lance_cmd = $a->date_lance;
	
	
    echo"<tr><td>$num_of</td><td>$num_po_client</td><td>$code_artic</td><td>$nbr_lot</td>
	<td>$qte_of</td><td>$date_lance_cmd</td></tr>";
    }
  echo '</table>';
  
  }
  ?>
<br/>
<br/>
</form>
  </body>
</html>