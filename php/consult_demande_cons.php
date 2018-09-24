    <?php
include('../connexion/connexionDB.php');

 $valeur=$_POST['valeur'];
 $recherche=$_POST['recherche'];
 $statut=$_POST['statut']; 

  if($statut=="a"){
if ($recherche=="a"){
$req= "SELECT * FROM demande_consommable";
}else if($recherche == "IDconsommable"){
$req1= mysql_query("SELECT DISTINCT IDdemande FROM demande_items where $recherche LIKE '%$valeur%'");

$req= "x";
}else{
$req= "SELECT * FROM demande_consommable where  $recherche='$valeur'";
}
}else{
if ($recherche=="a"){
$req= "SELECT * FROM demande_consommable where statut='$statut'";
}else if($recherche == "IDconsommable"){
$req1= mysql_query("SELECT DISTINCT IDdemande FROM demande_items where $recherche LIKE '%$valeur%'");

$req= "x";
}else{
$req= "SELECT * FROM demande_consommable where  $recherche='$valeur' and statut='$statut'";
}
}

   echo'<table border="1" bordercolor="BLUE" ><tr>
  <td>Demande N° </td>
  <td>Demandeur</td>
  <td>Magazigner</td>
  <td>Date demande</td>
  <td>Date sortie</td> 
  <td>Date confirmation</td>
 
  <td> Etat </td>
  <td></td>
  </tr>';

if($req=="x"){
 
 while($data=mysql_fetch_object($req1)){
 $ID=$data->IDdemande;
 if($statut=="a"){
 $req= "SELECT * FROM demande_consommable where IDdemande='$ID'";
 }else{
 $req= "SELECT * FROM demande_consommable  where IDdemande='$ID' and statut='$statut'";
 }
 $r=mysql_query($req) or die(mysql_error());
 
  while($a=mysql_fetch_object($r))
    {
    $ID = $a->IDdemande;
    $dem = $a->demandeur;
	$mag = $a->magazigner;
	$dateD = $a->dateD;
	$dateS = $a->dateS;
	$dateC = $a->dateC;
	$etat=$a->statut;
	if($etat=="D"){
	$e="En attente";
	}else if($etat=="D"){
	$e="Sortie";
	}else{
	$e="Confirmée";
	}
	
	
    echo"<tr><td>$ID</td><td>$dem</td><td>$mag</td><td>$dateD</td><td>$dateS</td><td>$dateC</td><td>$e</td>
	<td><input  type=\"button\"  value=\">>\" onclick=\"afficheItems('".$ID."');\"></td></tr>";
    }
 }
}else{
  $r=mysql_query($req) or die(mysql_error());
 
  while($a=mysql_fetch_object($r))
    {
      $ID = $a->IDdemande;
    $dem = $a->demandeur;
	$mag = $a->magazigner;
	$dateD = $a->dateD;
	$dateS = $a->dateS;
	$dateC = $a->dateC;
	$etat=$a->statut;
	if($etat=="D"){
	$e="En attente";
	}else if($etat=="D"){
	$e="Sortie";
	}else{
	$e="Confirmée";
	}
	
	
    echo"<tr><td>$ID</td><td>$dem</td><td>$mag</td><td>$dateD</td><td>$dateS</td><td>$dateC</td><td>$e</td>
	<td><input  type=\"button\"  value=\">>\" onclick=\"afficheItems('".$ID."');\"></td></tr>";
    }
	}
  echo '</table>';
  ?>
