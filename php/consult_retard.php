 <?php
include('../connexion/connexionDB.php');

$mois=$_POST['mois'];
$year=@$_POST['year'];
$D=$year."-".$mois;
$req= "SELECT * FROM personnel_salaire where nbr_retard >'0' and mois='$D' order by nbr_retard DESC";

echo'<table  id="myTable" class="tablesorter" cellspacing="0" cellpadding="0"><thead><tr>
<th>Matricule</th><th>Nom & prenom</th><th>Catégorie</th><th>Total retard</th>
 <th></th>
  </tr>';

  $r=mysql_query($req) or die(mysql_error());

  
  while($a=mysql_fetch_object($r))
    {
	
	
	
    $mat =$a->matricule;
    $nbr =$a->nbr_retard;
	$req2= mysql_query("SELECT * FROM personnel_info where matricule='$mat'");
	$data=mysql_fetch_array($req2);
	$nom=$data['nom'];
	$cat=$data['category'];
	
    echo"<tr><td>$mat</td><td>$nom</td><td>$cat</td><td>$nbr</td><td><input  type=\"button\"  id=\"bigbutton\" value=\">>\" onclick=\"afficheR('".$mat."');\"> </td></tr>";
    }

	
  echo '</thead></table>';

//echo($val);

  ?>