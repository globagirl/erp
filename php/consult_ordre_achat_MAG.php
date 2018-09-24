 <?php
include('../connexion/connexionDB.php');

$statut=$_POST['statut'];
$valeur=$_POST['valeur'];
$recherche=$_POST['recherche'];





if($statut=="a"){
if($recherche=="a"){
$req= "SELECT * FROM ordre_achat2";
}
 else if($recherche =="IDarticle"){
$req2= "SELECT * FROM ordre_achat_article1 where IDarticle LIKE '$valeur'";
$req="x";
}
else {
$req= "SELECT * FROM ordre_achat2 where  $recherche LIKE '$valeur'";
}
}
else{
if($recherche=="a"){
$req= "SELECT * FROM ordre_achat2 where statut ='$statut'";
}
 else if($recherche =="IDarticle"){
$req2= "SELECT IDordre FROM ordre_achat_article1 where IDarticle LIKE '$valeur' ";
$req="x";
}
else {
$req= "SELECT * FROM ordre_achat2 where  $recherche LIKE '$valeur' and statut ='$statut'";
}
}
echo'<table  id="myTable" class="tablesorter" cellspacing="0" cellpadding="0"><thead><tr><td>N° ordre</td><td>Fournisseur</td><td>Date demandée par Starz</td>
  <td>Date reception</td><td>Statut</td><td></td>
  </tr>';
if($req != "x"){
  $r=mysql_query($req) or die(mysql_error());

  
  while($a=mysql_fetch_object($r))
    {
	
	
	
    $ordre =$a->IDordre;
    $fournisseur =$a->fournisseur;
	$dateD=$a->date_demand_starz;
	$dateR=$a->date_recep;

	$statut=$a->statut;
	
	$transport=$a->transport;
	if($statut=="waitingS"){
		$statut="Waiting items";
	}
	
    echo"<tr><td>$ordre</td><td>$fournisseur</td>
	<td>$dateD</td><td>$dateR</td><td>$statut</td><td><input  type=\"button\"  id=\"bigbutton\" value=\">>\" onclick=\"afficheA('".$ordre."');\"></tr>";
    }
}else{
$r2=mysql_query($req2) or die(mysql_error());
while($data=mysql_fetch_array($r2)){
$IDordre=$data['IDordre'];
$req= mysql_query("SELECT * FROM ordre_achat2 where IDordre='$IDordre'");
  while($a=mysql_fetch_object($req))
    {
	
	
	
    $ordre =$a->IDordre;
    $fournisseur =$a->fournisseur;
	$dateD=$a->date_demand_starz;
	$dateR=$a->date_recep;

	$statut=$a->statut;
	
	$transport=$a->transport;
	if($statut=="waitingS"){
		$statut="Waiting items";
	}
	
    echo"<tr><td>$ordre</td><td>$fournisseur</td>
	<td>$dateD</td><td>$dateR</td><td>$statut</td><td><input  type=\"button\"  id=\"bigbutton\" value=\">>\" onclick=\"afficheA('".$ordre."');\"></tr>";
    }

}
}
	
  echo '</thead></table>';

//echo($val);

  ?>