 <?php
   // The function header by sending raw excel
header("Content-type: application/vnd-ms-excel");

// Defines the name of the export file "codelution-export.xls"
header("Content-Disposition: attachment; filename=produits.xls");
include('../connexion/connexionDB.php');

$valeur=$_POST['valeur'];
$recherche=$_POST['recherche'];

if($recherche=="a"){
$req= "SELECT * FROM produit1";
}else if($recherche=="Article"){
$req= "SELECT DISTINCT * FROM produit1 where code_produit IN (SELECT IDproduit from produit_article1 where IDarticle LIKE '$valeur')";
}else{
$req= "SELECT * FROM produit1 where $recherche='$valeur'";
}






  $r=mysql_query($req) or die(mysql_error());

  echo'<table  id="myTable" class="tablesorter" cellspacing="0" cellpadding="0"><thead><tr><td>Produit</td><td>Description</td><td>Categorie</td>
  <td>taille du lot</td><td>Longueur</td><td>Poids</td><td>Prix unitaire</td><td></td>
  </tr>';
  while($a=mysql_fetch_object($r))
    {



    $produit =$a->code_produit;
    $long =$a->longueur;
	$desc=$a->description;
	$tLot=$a->taille_lot;
  $poids=$a->poids;
	$cat=$a->categorie;
    $req1= mysql_query("SELECT price FROM prices where IDproduit LIKE '$produit' or IDproduit ='$produit'");
	$price=@mysql_result($req1,0);
	if($price !=""){
	$col="#D8F6CE";
	}else{
	$col="#FD3838";
	}
    echo"<tr><td>$produit</td><td>$desc</td><td>$cat</td><td>$tLot</td><td>$long</td><td>$poids</td>
	<td style=\"text-align:center ;background-color:".$col."\">$price</td>

	</tr>";
    }
  echo '</thead></table>';

//echo($val);

  ?>
