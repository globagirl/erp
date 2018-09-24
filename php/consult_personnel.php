 <?php
include('../connexion/connexionDB.php');

$val=@$_POST['valeur'];
$recherche=@$_POST['recherche'];
$statut=@$_POST['statut'];
if($statut=="a"){
if($recherche=="a"){

$req= "SELECT * FROM personnel_info";

} else {

 $req= "SELECT * FROM personnel_info where $recherche LIKE '%$val%'";
 }
}else{
if($recherche=="a"){
$req= "SELECT * FROM personnel_info where etat LIKE '$statut'";

} else {

 $req= "SELECT * FROM personnel_info where $recherche LIKE '%$val%' and etat LIKE '$statut'";
 }
 }

  $r=mysql_query($req) or die(mysql_error());
  $nbrP=@mysql_num_rows($r);

  echo'<table><tr><td colspan=6></td><td colspan=3><center><b>Total: '.$nbrP.'</b></center></td></tr>
  <tr>
  <th>Matricule</th><th>NCIN</th>
  <th>Nom & Prenom</th>
  <th>Adresse</th>
  <th>TEL </th>
  <th>Salaire brut</th>
  <th></th>
  <th></th>
  <th></th>
  </tr>';
  while($a=mysql_fetch_object($r))
    {
	
	$mat=$a->matricule;
    $ncin=$a->NCIN;
    $nom=$a->nom;
	$salaire=$a->salaire;
	$etat=$a->etat;
	$adr = $a->adresse1;
	
	$req2=mysql_query("select tel from personnel_tel where matricule='$mat'");
	$tel=@mysql_result($req2,0);
	
	
    echo"<tr><td>$mat";
	$reqDP=mysql_query("select mat,newMat from personnel_doublep where mat='$mat'");
	if(mysql_num_rows($reqDP)>0){
	  while($dataDP=mysql_fetch_array($reqDP)){
	   echo " / ".$dataDP['newMat'];
	  }
	
	}
	echo "</td><td>$ncin</td><td>$nom</td><td>$adr</td><td>$tel</td>
	<td>$salaire</td>	
	
	<td><p style=\"float:center\"><img src=\"../image/viewFile.png\" onclick=afficheP2('".$mat."'); alt=\"see\" style=\"cursor:pointer;\" width=\"30\" height=\"30\"  /></td>
	<td><p style=\"float:center\"><img src=\"../image/edit_user.png\" onclick=afficheP('".$mat."'); alt=\"Update\" style=\"cursor:pointer;\" width=\"40\" height=\"40\"  /></td>
	";
 if($etat=="actif"){
 echo "<td style=\"background:#A9F5D0\"><p style=\"float:center\"><img src=\"../image/changeTo.png\" onclick=inactifP('".$mat."'); alt=\"Update\" style=\"cursor:pointer;\" width=\"30\" height=\"30\"  /></td></tr>";
 }else{
  echo "<td style=\"background:#F78181\"><p style=\"float:center\"><img src=\"../image/changeTo.png\" onclick=actifP('".$mat."'); alt=\"Update\" style=\"cursor:pointer;\" width=\"30\" height=\"30\"  /></td></tr>";
 }
    }
  echo '</table>';
mysql_close();

  ?>