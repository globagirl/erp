 <?php
include('../connexion/connexionDB.php');
$recherche=$_POST['recherche'];
$valeur=@$_POST['valeur'];

$date1=@$_POST['date1'];
$date2=@$_POST['date2'];

if(($date1=="")and ($date2=="")){
$req1= "SELECT * FROM personnel_avance";
}else if( ($date1!="")and ($date2!="")){
$req1= "SELECT * FROM personnel_avance where ((dateA >= '$date1') and (dateA <= '$date2'))";

}

  $r=mysql_query($req1) or die(mysql_error());

  echo'<table  id="myTable" class="tablesorter" cellspacing="0" cellpadding="0"><thead><tr style=text-align:center><th style=text-align:center><b>Matricule</b></th>
  <th style=text-align:center><b>Nom & Prenom</b></th>
  <th style=text-align:center><b>Catégorie</b></th>
  <th style=text-align:center><b>Date</b></th>
  <th style=text-align:center><b>Montant</b></th>
 <th></th>
 <th></th>
 
  </tr>';
  while($a=mysql_fetch_object($r)){	
	$idPA=$a->idPA;
    $mat=$a->matricule;
    $M =$a->dateA;
	$montant=$a->montant;
	if($recherche =="a"){
	$req2= mysql_query("SELECT * FROM personnel_info where matricule ='$mat'");
	$data=mysql_fetch_array($req2);
	$nom=$data['nom'];
	$category=$data['category'];
    echo"<tr ><td  style=\"text-align:center \">$mat</td>
	<td  style=\"text-align:center \">$nom</td>
	<td  style=\"text-align:center \">$category</td>
	<td  style=\"text-align:center \">$M</td>
	<td  style=\"text-align:center \">$montant</td>
	<td><p style=\"float:center\"><img src=\"../image/edit_user.png\" onclick=updateAvance('".$idPA."'); alt=\"see\" style=\"cursor:pointer;\" width=\"30\" height=\"30\"  /></td>
	<td><p style=\"float:center\"><img src=\"../image/delete.png\" onclick=deleteAvance('".$idPA."'); alt=\"Update\" style=\"cursor:pointer;\" width=\"30\" height=\"30\"  /></td>
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
	<td  style=\"text-align:center \">$M</td>
	<td  style=\"text-align:center \">$montant</td>
	<td><p style=\"float:center\"><img src=\"../image/edit_user.png\" onclick=updateAvance('".$idPA."'); alt=\"see\" style=\"cursor:pointer;\" width=\"30\" height=\"30\"  /></td>
	<td><p style=\"float:center\"><img src=\"../image/delete.png\" onclick=deleteAvance('".$idPA."'); alt=\"Update\" style=\"cursor:pointer;\" width=\"30\" height=\"30\"  /></td>
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
	<td  style=\"text-align:center \">$M</td>
	<td  style=\"text-align:center \">$montant</td>
	<td><p style=\"float:center\"><img src=\"../image/edit_user.png\" onclick=updateAvance('".$idPA."'); alt=\"see\" style=\"cursor:pointer;\" width=\"30\" height=\"30\"  /></td>
	<td><p style=\"float:center\"><img src=\"../image/delete.png\" onclick=deleteAvance('".$idPA."'); alt=\"Update\" style=\"cursor:pointer;\" width=\"30\" height=\"30\"  /></td>
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
	<td  style=\"text-align:center \">$M</td>
	<td  style=\"text-align:center \">$montant</td>
	<td><p style=\"float:center\"><img src=\"../image/edit_user.png\" onclick=updateAvance('".$idPA."'); alt=\"see\" style=\"cursor:pointer;\" width=\"30\" height=\"30\"  /></td>
	<td><p style=\"float:center\"><img src=\"../image/delete.png\" onclick=deleteAvance('".$idPA."'); alt=\"Update\" style=\"cursor:pointer;\" width=\"30\" height=\"30\"  /></td>
	</tr>";
	}
    }
 
}
echo '</thead></table>';
mysql_close();
 ?>