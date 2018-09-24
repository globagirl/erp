 <?php
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

  $r=mysql_query($req) or die(mysql_error());

  echo'<div><div class="col-md-12">
		<p style="float:right"><img src="../image/print.png" onclick="printSalaire();" alt="Print" style="cursor:pointer;" width="60" height="50"  />
		<img src="../image/excel.png" onclick="excelSalaire();" alt="Excel" style="cursor:pointer;" width="60" height="50"  />
		</p>
        </div>	</div>
		<table  class="table table-fixed results" id="table3">
				<thead style="width:100%">   
  <tr>
  <th style="width:9.8%;height:60px;text-align:center">Matricule</th>
  <th style="width:14.8%;height:60px;text-align:center">Nom & Prenom</th>
  <th style="width:14.8%;height:60px;text-align:center">Catégorie</th> 
  <th style="width:9.8%;height:60px;text-align:center">Salaire Brut</th>
  <th style="width:4.8%;height:60px;text-align:center">Total minute</th>
  <th style="width:9.8%;height:60px;text-align:center">Total en H</th>
  <th style="width:9.8%;height:60px;text-align:center">Salaire</th>
  <th style="width:4.8%;height:60px;text-align:center"> Avances</th> 
  <th style="width:9.8%;height:60px;text-align:center"> NET </th>
  <th style="width:9.8%;height:60px;text-align:center"> NET arrondi</th>
 
  </tr></thead><tbody>';
  while($data=mysql_fetch_array($r)){	
	
    $mat=$data['matricule'];
	$req1= mysql_query("SELECT * FROM personnel_salaire where dateD >='$dateD' and dateF <='$dateF' and matricule='$mat'");
    if(mysql_num_rows($req1) > 0 ){
	$nbrPersonnel++;
	while($a=mysql_fetch_object($req1)){
    $sB=$a->salaire_base;
    $nbm=$a->nbm_travail;
    $SB=$a->salaireB;
    $TA=$a->total_avance;    
    $S=$a->salaire;
    $sA=$a->salaireA;
    $mois=$a->mois;
	$nbrHT=$nbm/60;
    $nbrHT=round($nbrHT,2);	
	$nom=$data['nom'];
	$category=$data['category'];	
	$totalS=$totalS+$sA;
    echo"<tr><td  style=\"width:10%;height:60px;text-align:center \">".$mat."</td>
	<td  style=\"width:15%;height:60px;text-align:center \">".$nom."</td>
	<td  style=\"width:15%;height:60px;text-align:center \">".$category."</td>	
	<td  style=\"width:10%;height:60px;text-align:center ;background-color:#F8FBEF\">".$sB."</td>
	<td  style=\"width:5%;height:60px;text-align:center \">".$nbm."</td>
	<td  style=\"width:10%;height:60px;text-align:center \">".$nbrHT."</td>
	<td  style=\"width:10%;height:60px;text-align:center ;background-color:#F6CED8\">".$SB."</td>
	<td  style=\"width:5%;height:60px;text-align:center \">".$TA."</td>
	<td  style=\"width:10%;height:60px;text-align:center \">".$S."</td>
	<td  style=\"width:10%;height:60px;text-align:center ;background-color:#F7819F\">".$sA."</td>
	</tr>";
	
	}
	}
  }
$moy=$totalS/$nbrPersonnel;
$moy=round($moy);
 echo '<tr style="text-align:center">
  <td><b> NBR personnel : '.$nbrPersonnel.'</b></td><td colspan=3><b> Total: '.$totalS.' TND</b></td>
  <td colspan=3><b> Moyenne salaire: '.$moy.' TND</b></td></tr>
</tbody></table>';
mysql_close();
  ?>