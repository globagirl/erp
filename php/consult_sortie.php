 <?php
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
}else if($recherche=="OF"){
$req= "SELECT * FROM sortie_stock1 where OF='$val'";
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
}else if($recherche=="OF"){
$req= "SELECT * FROM sortie_stock1 where OF='$val' and typeS='$statut'";
}
}

  $r=mysql_query($req) or die(mysql_error());

  echo'<table><tr>
  <th>N° sortie</th><th>Article</th>
  <th>Paquet</th><th>Batch</th><th>Commande</th><th>OF</th><th>Qunatité</th><th>Date de sortie</th>
  <th>Operateur</th><th>Type</th>
  </tr>';
  while($a=mysql_fetch_object($r))
    {
	
	
	
    $IDs =$a->IDsortie;
    $paquet =$a->IDpaquet;
	$qte=$a->qte;
	$commande=$a->commande;
	$OF=$a->OF;
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
	$rq= mysql_query("SELECT batch FROM paquet2 where IDpaquet='$paquet'");
	$batch=mysql_result($rq,0);
    echo"<tr><td>$IDs</td><td>$article</td><td>$paquet</td><td>$batch</td><td>$commande</td><td>$OF</td>
	<td>$qte</td><td>$dateS</td><td>$op</td><td>$statut</td></tr>";
    }
  echo '</table>';
  mysql_close();
//echo($val);

  ?>