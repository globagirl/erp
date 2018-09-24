<meta charset="utf-8" />
 <?php
 
  // The function header by sending raw excel
header("Content-type: application/vnd-ms-excel");
 
// Defines the name of the export file "codelution-export.xls"
header("Content-Disposition: attachment; filename=sortie_stock.xls");
include('../connexion/connexionDB.php');

$val=$_POST['valeur'];
$recherche=$_POST['recherche'];
$statut=$_POST['statut'];





if($statut=="a"){
if($recherche=="a"){
$req= "SELECT * FROM sortie_stock1";
}
 else if($recherche=="article"){
$req= "SELECT * FROM sortie_stock1 where IDpaquet like '$val%'";
}
else if($recherche=="paquet"){
$req= "SELECT * FROM sortie_stock1 where  IDpaquet LIKE '%$val%'";
}
else if($recherche=="commande"){
$req= "SELECT * FROM  sortie_stock1 where commande='$val'";
}
else if($recherche=="dateS"){
$req= "SELECT * FROM sortie_stock1 where date_sortie='$val'";
}
}
else{
		if($recherche=="a"){
$req= "SELECT * FROM sortie_stock1 where typeS='$statut'";
}
 else if($recherche=="article"){
$req= "SELECT * FROM sortie_stock1 where IDpaquet='$val%' and typeS='$statut' ";
}
else if($recherche=="paquet"){
$req= "SELECT * FROM sortie_stock1 where  IDpaquet='$val' and typeS='$statut'";
}
else if($recherche=="commande"){
$req= "SELECT * FROM  sortie_stock1 where commande='$val' and typeS='$statut'";
}
else if($recherche=="dateS"){
$req= "SELECT * FROM sortie_stock1 where date_sortie='$val' and typeS='$statut'";
}
}

  $r=mysql_query($req) or die(mysql_error());

  echo'<table  id="myTable" class="tablesorter" cellspacing="0" cellpadding="0"><thead><tr><td>N° sortie</td><td>Article</td>
  <td>Paquet</td><td>Commande</td><td>Qunatité</td><td>Date de sortie</td>
  <td>Operateur</td><td>Type</td>
  </tr>';
  while($a=mysql_fetch_object($r))
    {
	
	
	
    $IDs =$a->IDsortie;
    $paquet =$a->IDpaquet;
	$qte=$a->qte;
	$commande=$a->commande;
	$op=$a->operateur;
	$dateS=$a->date_sortie;
	$statut=$a->typeS;
	if($statut=="s"){
		$statut="-------";
	}
	$P=$paquet;
	$pos="/";
$n=strpos($P,$pos);
$article=substr($P,0,$n); //definir l article ? 
	
    echo"<tr><td>$IDs</td><td>$article</td><td>$paquet</td><td>$commande</td>
	<td>$qte</td><td>$dateS</td><td>$op</td><td>$statut</td></tr>";
    }
  echo '</thead></table>';

//echo($val);

  ?>