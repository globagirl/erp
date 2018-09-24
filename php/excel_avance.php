 <meta charset="utf-8" />
 <?php
  // The function header by sending raw excel
header("Content-type: application/vnd-ms-excel");
 
// Defines the name of the export file "codelution-export.xls"
header("Content-Disposition: attachment; filename=avance.xls");
include('../connexion/connexionDB.php');
$recherche=$_POST['recherche'];
$valeur=@$_POST['valeur'];

$date1=@$_POST['date1'];
$date2=@$_POST['date2'];

if(($date1=="")and ($date2=="")){
$req1= "SELECT * FROM personnel_avance";
}else if( ($date1!="")and ($date2!="")){
echo "<center><h3> Liste des avances</h3></center><center><h4> Du ".$date1." au ".$date2."</h4></center>";
$req1= "SELECT * FROM personnel_avance where ((dateA >= '$date1') and (dateA <= '$date2'))";

}

  $r=mysql_query($req1) or die(mysql_error());

  echo'<table border="1px">
  <tr style="text-align:center"><th style=text-align:center><b>Matricule</b></th>
  <th style=text-align:center><b>Nom & Prenom</b></th>
  <th style=text-align:center><b>Catégorie</b></th>
  <th style=text-align:center><b>Date</b></th>
  <th style=text-align:center><b>Montant</b></th>

 
  </tr>';
  while($a=mysql_fetch_object($r))
    {
	
	
	
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
	</tr>";
	}
    }
 
}
 echo '</table>';

  ?>