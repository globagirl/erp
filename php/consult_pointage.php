 <?php
include('../connexion/connexionDB.php');
$recherche=$_POST['recherche'];
$valeur=@$_POST['valeur'];

$date1=@$_POST['date1'];
$date2=@$_POST['date2'];

if(($date1=="")and ($date2=="")){
if($recherche=="a"){
$req1= "SELECT * FROM personnel_pointage";
}else{
$req2= mysql_query("SELECT * FROM personnel_info where $recherche ='$valeur'");
$data=mysql_fetch_array($req2);
$mat=$data['matricule'];
$req1= "SELECT * FROM personnel_pointage where matricule='$mat'";
}
}else if( ($date1!="")and ($date2!="")){
if($recherche=="a"){
$req1= "SELECT * FROM personnel_pointage where ((dateP >= '$date1') and (dateP <= '$date2'))";
}else{
$req2= mysql_query("SELECT * FROM personnel_info where $recherche ='$valeur'");
$data=mysql_fetch_array($req2);
$mat=$data['matricule'];
$req1= "SELECT * FROM personnel_pointage where ((dateP >= '$date1') and (dateP <= '$date2') and (matricule='$mat'))";
}
}

  $r=mysql_query($req1) or die(mysql_error());

  echo'<table><tr style=text-align:center><th style=text-align:center><b>Matricule</b></th>
  <th style=text-align:center><b>Nom & Prenom</b></th>
  <th style=text-align:center><b>Catégorie</b></th>
  <th style=text-align:center><b>Date</b></th>
  <th style=text-align:center><b>Heure Debut</b></th>
  <th style=text-align:center><b>Heure Fin</b></th>
  <th style=text-align:center><b>Total en mn</b></th>
  <th style=text-align:center><b>Soustraction</b></th>
  <th style=text-align:center><b>Total </b></th> 
  <th style=text-align:center><b>Etat</b></th>
 
  </tr>';
  while($a=mysql_fetch_object($r)){	
    $mat=$a->matricule;
    $dateP =$a->dateP;
	$hD=$a->heureD;
	$hF=$a->heureF;
	$statut=$a->statut;
	$etat=$a->etat;
	$tm=$a->totalM;
	$tmF=$a->totalMF;
	$mnRT=$a->retard;
    //Soustraction
	if($mnRT<5){
	    $sous=5;
	}else if($mnRT>= 6 && $mnRT<= 15){
	    $sous=120;
	}else if($mnRT>= 16){
	    $sous=240;
	}
	
	if($statut=="n"){
	$col="#F5A9BC";
	}else if($etat=="R"){
	$col="#F5DA81";
	}else{
	$col="#E0F8F1";
	}
	
	if($recherche =="a"){
	$req2= mysql_query("SELECT * FROM personnel_info where matricule ='$mat'");
	$data=mysql_fetch_array($req2);
	$nom=$data['nom'];
	$category=$data['category'];
    echo"<tr ><td  style=\"text-align:center ;background-color:".$col."\">$mat</td>
	<td  style=\"text-align:center ;background-color:".$col."\">$nom</td>
	<td  style=\"text-align:center ;background-color:".$col."\">$category</td>
	<td  style=\"text-align:center ;background-color:".$col."\">$dateP</td>
	<td  style=\"text-align:center ;background-color:".$col."\">$hD</td>
	<td  style=\"text-align:center ;background-color:".$col."\">$hF</td>
	<td  style=\"text-align:center ;background-color:".$col."\">$tm</td>
	<td  style=\"text-align:center ;background-color:".$col."\">$sous</td>
	<td  style=\"text-align:center ;background-color:".$col."\">$tmF</td>
	<td  style=\"text-align:center ;background-color:".$col."\">$etat</td></tr>";
	}else{ 
	$nom=$data['nom'];
	$category=$data['category'];
	
	
	  echo"<tr ><td  style=\"text-align:center ;background-color:".$col."\">$mat</td>
	<td  style=\"text-align:center ;background-color:".$col."\">$nom</td>
	<td  style=\"text-align:center ;background-color:".$col."\">$category</td>
	<td  style=\"text-align:center ;background-color:".$col."\">$dateP</td>
	<td  style=\"text-align:center ;background-color:".$col."\">$hD</td>
	<td  style=\"text-align:center ;background-color:".$col."\">$hF</td>
    <td  style=\"text-align:center ;background-color:".$col."\">$tm</td>
	<td  style=\"text-align:center ;background-color:".$col."\">$sous</td>
	<td  style=\"text-align:center ;background-color:".$col."\">$tmF</td>
	<td  style=\"text-align:center ;background-color:".$col."\">$etat</td></tr>";
	}
  
 
}
 echo '</table>';
 mysql_close();
  ?>