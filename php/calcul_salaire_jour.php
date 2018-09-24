<?php
include('../connexion/connexionDB.php');
$recherche=$_POST['recherche'];
$valeur=$_POST['valeur'];

$nbm_mois=$_POST['nbm'];

//Fonction d 'affiche
function affiche_resultat($mat, $sB,$nbm,$salaireJ)
  {
    $req6= mysql_query("SELECT nom,category FROM personnel_info where matricule ='$mat'");
	$data=mysql_fetch_array($req6);
	$nom=$data['nom'];
	$category=$data['category'];
    echo"<tr ><td  style=\"width:10%;height:60px;text-align:center\">".$mat."</td>
	<td  style=\"width:25%;height:60px;text-align:center \">".$nom."</td>
	<td  style=\"width:20%;height:60px;text-align:center \">".$category."</td>	
	<td  style=\"width:20%;height:60px;text-align:center;background-color:#F8FBEF\">".$sB."</td>
	<td  style=\"width:10%;height:60px;text-align:center \">".$nbm."</td>
	<td  style=\"width:15%;height:60px;text-align:center \"><b>".$salaireJ."</b></td>

	</tr>";
  }
//

    echo '<div><div class="col-lg-12">
		<p style="float:right"><img src="../image/print.png" onclick="printPS();" alt="Print" style="cursor:pointer;" width="60" height="50"  />
		<img src="../image/excel.png" onclick="excelPS();" alt="Excel" style="cursor:pointer;" width="60" height="50"  />
		</p>
        </div>	</div>
		<table  class="table table-fixed results" id="table3">
				<thead style="width:100%">       
			        <tr>
						<th style="width:9.8%;height:60px;text-align:center">Matricule</th>
						<th style="width:24.8%;height:60px;text-align:center">Nom & prenom</th>
						<th style="width:19.8%;height:60px;text-align:center" >Category</th>						
						<th style="width:19.8%;height:60px;text-align:center">Salaire brut</th>
						<th style="width:9.8%;height:60px;text-align:center">Total minute</th>
						<th style="width:14.8%;height:60px;text-align:center">Salaire Journalier </th>
						
						
				    </tr>
				</thead>
			<tbody id="tbody" style="width:100%">';  
    if($recherche=="A"){
       $req1= "SELECT * FROM personnel_info where etat like 'actif'";
    }else{
	   $req1= "SELECT * FROM personnel_info where etat like 'actif' and matricule='$valeur'";
	}
    $r=mysql_query($req1) or die(mysql_error());
	while($a=mysql_fetch_object($r)){
	$matricule=$a->matricule;
	$typeS=$a->typeS;
	$salaire_brut=$a->salaire;

    if($typeS !="V"){
	
    $nbm_mois=10080;
    
	}
	$totalM=480;

	$salaireJ =($salaire_brut/$nbm_mois)*$totalM;

	$salaireJ=round($salaireJ);	
    affiche_resultat($matricule, $salaire_brut,$totalM,$salaireJ);
    }
     mysql_close();

  ?>