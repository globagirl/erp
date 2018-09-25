 <?php
include('../connexion/connexionDB.php');
$recherche=$_POST['recherche'];
$valeur=@$_POST['valeur'];

$etat=@$_POST['etat'];

if($etat=="a"){
$req1= "SELECT * FROM personnel_contrat";
}else{
$req1= "SELECT * FROM personnel_contrat where etat='$etat'";

}

  $r=mysql_query($req1) or die(mysql_error());

  echo'<table  id="myTable" class="tablesorter" cellspacing="0" cellpadding="0"><thead><tr style=text-align:center><th style=text-align:center><b>Matricule</b></th>
  <th style=text-align:center><b>Nom & Prenom</b></th>
  <th style=text-align:center><b>Catégorie</b></th>
  <th style=text-align:center><b>N° contrat</b></th>
  <th style=text-align:center><b>Type contrat</b></th>
  <th style=text-align:center><b>Date debut</b></th>
  <th style=text-align:center><b>Date fin</b></th>
  <th style=text-align:center><b>Société</b></th>
  <th style=text-align:center><b>Etat</b></th>
  <th></th>
  </tr>';
  while($a=mysql_fetch_object($r))
    {
	
	
	$idC=$a->idC;
    $mat=$a->matricule;
    $numC =$a->numContrat;
	$typ=$a->typeContrat;
	$etat=$a->etat;
	$dateD=$a->dateD;
	$dateF=$a->dateF;
	$comp=$a->company;
	

	if($recherche =="a"){
	$req2= mysql_query("SELECT * FROM personnel_info where matricule ='$mat'");
	$data=mysql_fetch_array($req2);
	$nom=$data['nom'];
	$category=$data['category'];
    echo"<tr ><td  style=\"text-align:center \">$mat</td>
	<td  style=\"text-align:center \">$nom</td>
	<td  style=\"text-align:center \">$category</td>
	<td  style=\"text-align:center \">$numC</td>
	<td  style=\"text-align:center \">$typ</td>
	<td  style=\"text-align:center \">$dateD</td>
	<td  style=\"text-align:center \">$dateF</td>
	<td  style=\"text-align:center \">$comp</td>
	<td  style=\"text-align:center \">$etat</td>
	<td style=text-align:center><p><img src=\"../image/edit_user.png\" onclick=updateContrat('" . $idC . ";  /></td>
	</tr>";
	}else if($recherche == "matricule"){
	$req2= mysql_query("SELECT * FROM personnel_info where matricule ='$mat'");
	$data=mysql_fetch_array($req2);
	$nom=$data['nom'];
	$category=$data['category'];
	$mat2=$data['matricule'];
	if($valeur==$mat2){
	  echo"<tr ><td  style=\"text-align:center \">$mat</td>
	<td  style=\"text-align:center \">$nom</td>
	<td  style=\"text-align:center \">$category</td>
	<td  style=\"text-align:center \">$numC</td>
	<td  style=\"text-align:center \">$typ</td>
	<td  style=\"text-align:center \">$dateD</td>
	<td  style=\"text-align:center \">$dateF</td>
	<td  style=\"text-align:center \">$comp</td>
	<td  style=\"text-align:center \">$etat</td>
	<td style=text-align:center><p><img src=\"../image/edit_user.png\" onclick=updateContrat('" . $idC . ";  /></td>
	</tr>";
	}
    }else if($recherche == "category"){
	$req2= mysql_query("SELECT * FROM personnel_info where matricule ='$mat'");
	$data=mysql_fetch_array($req2);
	$nom=$data['nom'];
	$category=$data['category'];
	$mat2=$data['matricule'];
	if($valeur==$category){
 echo"<tr ><td  style=\"text-align:center \">$mat</td>
	<td  style=\"text-align:center \">$nom</td>
	<td  style=\"text-align:center \">$category</td>
	<td  style=\"text-align:center \">$numC</td>
	<td  style=\"text-align:center \">$typ</td>
	<td  style=\"text-align:center \">$dateD</td>
	<td  style=\"text-align:center \">$dateF</td>
	<td  style=\"text-align:center \">$comp</td>
	<td  style=\"text-align:center \">$etat</td>
	<td style=text-align:center><p><img src=\"../image/edit_user.png\" onclick=updateContrat('" . $idC . ";  /></td>
	</tr>";
	}
    }else if($recherche == "nom"){
	$req2= mysql_query("SELECT * FROM personnel_info where matricule ='$mat'");
	$data=mysql_fetch_array($req2);
	$nom=$data['nom'];
	$category=$data['category'];
	$mat2=$data['matricule'];
	if($valeur==$nom){
 echo"<tr ><td  style=\"text-align:center \">$mat</td>
	<td  style=\"text-align:center \">$nom</td>
	<td  style=\"text-align:center \">$category</td>
	<td  style=\"text-align:center \">$numC</td>
	<td  style=\"text-align:center \">$typ</td>
	<td  style=\"text-align:center \">$dateD</td>
	<td  style=\"text-align:center \">$dateF</td>
	<td  style=\"text-align:center \">$comp</td>
	<td  style=\"text-align:center \">$etat</td>
	<td style=text-align:center><p><img src=\"../image/edit_user.png\" onclick=updateContrat('" . $idC . ";  /></td>
	</tr>";
	}
    }
 
}
 echo '</thead></table>';

  ?>