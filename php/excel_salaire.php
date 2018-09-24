 <meta charset="utf-8" />
 <?php
   // The function header by sending raw excel
header("Content-type: application/vnd-ms-excel");
 
// Defines the name of the export file "codelution-export.xls"
header("Content-Disposition: attachment; filename=salaire.xls");
//
include('../connexion/connexionDB.php');
$recherche=$_POST['recherche'];
$valeur=@$_POST['valeur'];

$dateD=@$_POST['dateD'];
$dateF=@$_POST['dateF'];
/*
$year=@$_POST['year'];
$D=$year."-".$d1;
$D2=$D."-01";
$D2= strtotime($D2);
$D2= strftime("%B",$D2);*/
if($recherche=="A"){
   $req="SELECT matricule,nom,category FROM personnel_info";
}else{
   $req="SELECT matricule,nom,category FROM personnel_info where $recherche ='$valeur'";
}
//$req1= "SELECT * FROM personnel_salaire where dateD='$dateD' and dateF='$dateF'";
$nbrPersonnel=0;
$totalS=0;
$totalSI=0;

  $r=mysql_query($req) or die(mysql_error());

  echo'
		<table  class="table table-fixed results" id="table3">
				<thead style="width:100%">   
  <tr>
  <th style="width:9.8%;height:60px;text-align:center">Matricule</th>
  <th style="width:14.8%;height:60px;text-align:center">Nom & Prenom</th>
  <th style="width:14.8%;height:60px;text-align:center">Catégorie</th> 
  <th style="width:9.8%;height:60px;text-align:center">Salaire Brut</th>
  <th style="width:9.8%;height:60px;text-align:center">Minutes</th>
  <th style="width:4.8%;height:60px;text-align:center">Total minute</th>
  <th style="width:9.8%;height:60px;text-align:center">Total en H</th>
  <th style="width:9.8%;height:60px;text-align:center">Salaire</th>
  <th style="width:4.8%;height:60px;text-align:center"> Avances</th> 
  <th style="width:9.8%;height:60px;text-align:center"> NET </th>
  <th style="width:9.8%;height:60px;text-align:center"> NET arrondi</th>
  <th style="width:9.8%;height:60px;text-align:center"> Salaire Intermédiaire</th>
 
  </tr></thead><tbody>';
  while($data=mysql_fetch_array($r)){	
	
    $mat=$data['matricule'];
	$req1= mysql_query("SELECT * FROM personnel_salaire where dateD >='$dateD' and dateF <='$dateF' and matricule='$mat' and salaireA > '0'");
    if(mysql_num_rows($req1) > 0 ){
	$nbrPersonnel++;
	while($a=mysql_fetch_object($req1)){
    $sB=$a->salaire_base;
    $nbmois=$a->nbm_mois;
    $nbm=$a->nbm_travail;
    $SB=$a->salaireB;
    $TA=$a->total_avance;    
    $S=$a->salaire;
    $sA=$a->salaireA;
    $sI=$a->salaireI;
    $mois=$a->mois;
	$nbrHT=$nbm/60;
    $nbrHT=round($nbrHT,2);	
	$nom=$data['nom'];
	$category=$data['category'];	
	$totalS=$totalS+$sA;
	$totalSI=$totalSI+$sI;
    echo"<tr ><td  style=\"width:10%;height:60px;text-align:center \">".$mat."</td>
	<td  style=\"width:15%;height:60px;text-align:center \">".$nom."</td>
	<td  style=\"width:15%;height:60px;text-align:center \">".$category."</td>	
	<td  style=\"width:10%;height:60px;text-align:center ;background-color:#F8FBEF\">".$sB."</td>
	<td  style=\"width:5%;height:60px;text-align:center \">".$nbmois."</td>
	<td  style=\"width:5%;height:60px;text-align:center \">".$nbm."</td>
	<td  style=\"width:10%;height:60px;text-align:center \">".$nbrHT."</td>
	<td  style=\"width:10%;height:60px;text-align:center ;background-color:#F6CED8\">".$SB."</td>
	<td  style=\"width:5%;height:60px;text-align:center \">".$TA."</td>
	<td  style=\"width:10%;height:60px;text-align:center \">".$S."</td>
	<td  style=\"width:10%;height:60px;text-align:center ;background-color:#F7819F\">".$sA."</td>
	<td  style=\"width:10%;height:60px;text-align:center ;background-color:#F7819F\">".$sI."</td>
	</tr>";
	
	}
	}
  }
$moy=$totalS/$nbrPersonnel;
$moyI=$totalSI/$nbrPersonnel;
$moy=round($moy);
$moyI=round($moyI);
 echo '<tr style="text-align:center">
  <td><b> NBR personnel : '.$nbrPersonnel.'</b></td><td colspan=3><b> Total: '.$totalS.' TND</b></td>
  <td colspan=3><b> Moyenne salaire: '.$moy.' TND</b></td></tr><tr style="text-align:center">
  <td><b> </b></td><td colspan=3><b> Total salaire intermédaire: '.$totalSI.' TND</b></td>
  <td colspan=3><b> Moyenne salaire: '.$moyI.' TND</b></td></tr>
</tbody></table>';
mysql_close();
  ?>