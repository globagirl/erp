<html>
  <head>
  <meta charset="utf-8" />
    <title>OF</title>
	
	<link href="../tablecloth/tablecloth.css" rel="stylesheet" type="text/css" media="screen" />
<script type="text/javascript" src="tablecloth/tablecloth.js"></script>
	
  </head>
  <body>
<h2> Ordre de Fabrication</h2>
<form method="post">
<table>
<tr>
<th>RECHERCHE</th>


                <td colspan="3">  
				              <select name="choix">
                              <option selected="selected" value=""></option>
							  <option value="date_exped">Date Expédition</option>
							  
                              </select>
				</td>
				
				<td>
                 <input type="date" name="rech"/>
                </td>
<td>

<input type="submit" value="afficher" target="_blank" id="submitbutton">
</input>

</td>
</tr>
</table>


   <?php
  include('../connexion/connexionDB.php');

$rech = @$_POST["rech"];
$choix = @$_POST["choix"];
if (($rech=="")&&($choix==""))
{

$query= "SELECT * FROM ordre_fabrication ORDER BY num_of DESC ";
  $r=mysql_query($query) ;
   mysql_close();
   
     echo'<table  id="myTable" class="tablesorter" cellspacing="0" cellpadding="0"><thead><tr><td>Num OF</td><td>Num PO </td><td>Code Article </td><td>déscription</td><td>Quantité OF</td><td>Date Expedition </td> </tr>';

  
  while($a=mysql_fetch_object($r))
    {
    $num_of =$a->num_of;
    $num_po_client = $a->num_po_client;
	$code_artic = $a->code_artic;
	$descrp = $a->descrp;
	$qte_of = $a->qte_of;
	$date_exped = $a->date_exped;
	
	
	
    echo"<tr><td>$num_of</td><td>$num_po_client</td><td>$code_artic</td><td>$descrp</td><td>$qte_of</td><td>$date_exped</td></tr>";
    }
  echo '</table>';
  }
  
  
  
  
  else
  {
  $query= "SELECT * FROM ordre_fabrication WHERE $choix='$rech' ";
  $r=mysql_query($query) ;
   mysql_close();
   echo'<table  id="myTable" class="tablesorter" cellspacing="0" cellpadding="0"><tr><td>Num OF</td><td>Num PO </td><td>Code Article </td><td>déscription</td><td>Quantité OF</td><td>Date Expedition </td> </tr>';

  while(@$a=mysql_fetch_object($r))
    {
    $num_of =$a->num_of;
    $num_po_client = $a->num_po_client;
	$code_artic = $a->code_artic;
	$descrp = $a->descrp;
	$qte_of = $a->qte_of;
	$date_exped = $a->date_exped;
	
	
	
    echo"<tr><td>$num_of</td><td>$num_po_client</td><td>$code_artic</td><td>$descrp</td><td>$qte_of</td><td>$date_exped</td></tr>";
    }
  echo '</table>';
  }
  ?>
<br/>
<br/>
</form>
  </body>
</html>