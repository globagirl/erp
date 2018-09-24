 <?php
include('../connexion/connexionDB.php');
$recherche=$_POST['recherche'];
$valeur=$_POST['valeur'];
$mois=$_POST['mois'];
$nbm_mois=$_POST['nbm'];
$dateM1=$_POST['dateM1'];
$dateM2=$_POST['dateM2'];
$avance=$_POST['avance'];
$mise=$_POST['mise'];
$pay=$_POST['pay'];
//Fonction d 'affiche
function affiche_resultat($mat, $sB,$SB,$nbm,$retard,$mis,$TA,$S,$sA)
  {
    $req6= mysql_query("SELECT nom,category FROM personnel_info where matricule ='$mat'");
	$data=mysql_fetch_array($req6);
	$nom=$data['nom'];
	$category=$data['category'];
    echo"<tr ><td  style=\"width:10%;height:60px;text-align:center\">".$mat."</td>
	<td  style=\"width:15%;height:60px;text-align:center \">".$nom."</td>
	<td  style=\"width:10%;height:60px;text-align:center \">".$category."</td>	
	<td  style=\"width:10%;height:60px;text-align:center;background-color:#F8FBEF\">".$sB."</td>
	<td  style=\"width:10%;height:60px;text-align:center \">".$nbm."</td>
	<td  style=\"width:10%;height:60px;text-align:center ;background-color:#F6CED8\">".$SB."</td>
	<td  style=\"width:5%;height:60px;text-align:center \">".$retard."</td>
	<td  style=\"width:5%;height:60px;text-align:center \">".$mis."</td>
	<td  style=\"width:5%;height:60px;text-align:center \">".$TA."</td>		
	<td  style=\"width:9.8%;height:60px;text-align:center\">".$S."</td>
	<td  style=\"width:9.8%;height:60px;text-align:center;background-color:#F7819F\">".$sA."</td>
	</tr>";
  }
//
if($recherche=="A"){
    $req01= mysql_query("SELECT matricule,dateP FROM personnel_pointage where dateP >='$dateM1' and dateP <='$dateM2' and (statut='n' or statut='PN') ");
}else{
    $req01= mysql_query("SELECT matricule,dateP FROM personnel_pointage where dateP >='$dateM1' and dateP <='$dateM2' and (statut='n' or statut='PN') and matricule='$valeur'");
}
if(mysql_num_rows($req01)>0){
echo('<table><tr><td style=background-color:#F6CED8>Il y a des pointages non validé , Veillez vérifier les pointages SVP !!</td></tr></table>');
}else{
    echo '<div><div class="col-lg-12">
		<p style="float:right"><img src="../image/print.png" onclick="printPS();" alt="Print" style="cursor:pointer;" width="60" height="50"  />
		<img src="../image/excel.png" onclick="excelPS();" alt="Excel" style="cursor:pointer;" width="60" height="50"  />
		</p>
        </div>	</div>
		<table  class="table table-fixed results" id="table3">
				<thead style="width:100%">       
			        <tr>
						<th style="width:9.8%;height:60px;text-align:center">Matricule</th>
						<th style="width:14.8%;height:60px;text-align:center">Nom & prenom</th>
						<th style="width:9.8%;height:60px;text-align:center" >Category</th>						
						<th style="width:9.8%;height:60px;text-align:center">Salaire brut</th>
						<th style="width:9.8%;height:60px;text-align:center">Total minute</th>
						<th style="width:9.8%;height:60px;text-align:center">Salaire</th>
						<th style="width:4.8%;height:60px;text-align:center">Retards</th>
						<th style="width:4.8%;height:60px;text-align:center">Mise à pied</th>
						<th style="width:4.8%;height:60px;text-align:center">Avances</th>
						<th style="width:9.8%;height:60px;text-align:center">Salaire net</th>
						<th style="width:9.8%;height:60px;text-align:center">Net arrondi</th>
						
						
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
	$salaireInter=$a->salaireI;
    if($typeS=="V"){
	//Total minute de travail 
	
	$totalM=0;
	$totalRetard=0;    
    $dateX=$dateM1;
	
    while($dateX <= $dateM2){
	$sun=strtotime($dateX);
    $sun=strftime ( "%a",$sun);
    $req2 = mysql_query("SELECT idP,totalMF,etat FROM personnel_pointage where dateP LIKE '$dateX' and matricule='$matricule'");
	$nbr=mysql_num_rows($req2);
    if($nbr>0){
	    $a2=mysql_fetch_object($req2);
        $mTJ =$a2->totalMF;	
        $etatP =$a2->etat;		
       	
        //s'il est aussi public holiday en aura un salaire double
		$req311= mysql_query("SELECT dateD,dateF FROM public_holiday where dateD <= '$dateX' and dateF >= '$dateX' and typePH='FP'");
	    if(mysql_num_rows($req311)>0){
		  $mTJ=$mTJ*2;
		  $idP =$a2->idP;	
		  $reqFP=mysql_query("UPDATE personnel_pointage SET etat='FP' where idP='$idP'");
        }		
        
		$totalM=$totalM+$mTJ;
		if($etatP=="R"){
	        $totalRetard++;
	    }
    }else if(($sun != "Sun")&&($sun != "Sat")){ // verifier s'il s'agit d'un jour ferié
	    $req311= mysql_query("SELECT dateD,dateF FROM public_holiday where dateD >= '$dateX' and dateF <= '$dateX' and typePH='FP'");
	    if(mysql_num_rows($req311)>0){
		    $dataPH=mysql_fetch_array($req311);
			//definir le  jour avant le public holiday
			$datePH=$dataPH['dateD'];
			$datePH= strtotime($datePH);
			//définir que le jour avant déffirent se sun ou sat 			
			$dateAPH=strtotime("-1 day",$datePH);
			$dateAPH2=strftime ("%a",$dateAPH);
			if(($dateAPH2 != "Sun")&&($dateAPH2 != "Sat")){
		         $dateAPH=date("Y-m-d",$dateAPH);				
		    }else if($dateAPH2 == "Sat"){			     
				 $dateAPH=strtotime("-2 days",$datePH);
				 $dateAPH=date("Y-m-d",$dateAPH);				 
			}else{			
			     $dateAPH=strtotime("-3 days",$datePH);
				 $dateAPH=date("Y-m-d",$dateAPH);
			}
			//definir le jour aprés le public holiday
			$datePHF=$dataPH['dateF'];
			$datePHF= strtotime($datePHF);
			//définir que le jour avant déffirent se sun ou sat 			
			$dateAPHF=strtotime("+1 day",$datePHF);
			$dateAPHF2=strftime ("%a",$dateAPHF);
			if(($dateAPHF2 != "Sun")&&($dateAPHF2 != "Sat")){
		         $dateAPHF=date("Y-m-d",$dateAPHF);				
		    }else if($dateAPHF2 == "Sat"){			     
				 $dateAPHF=strtotime("+3 days",$datePHF);
				 $dateAPHF=date("Y-m-d",$dateAPHF);				 
			}else{			
			     $dateAPHF=strtotime("+2 days",$datePHF);
				 $dateAPHF=date("Y-m-d",$dateAPHF);
			}
			$reqPH = mysql_query("SELECT dateP,matricule FROM personnel_pointage where (dateP LIKE '$dateAPH')  and (matricule='$matricule')");
			$reqPHF = mysql_query("SELECT dateP,matricule FROM personnel_pointage where (dateP LIKE '$dateAPHF')  and (matricule='$matricule')");
			if((mysql_num_rows($reqPH)>0) && (mysql_num_rows($reqPHF)>0) ){			
 		        $totalM=$totalM+480;
			}
	    }else{//il s'agit d'une absence
	        $req312= mysql_query("SELECT dateD,matricule  FROM personnel_conge where dateD like '$dateX' and matricule='$matricule'");
	        $cdAb=$matricule."-".$dateX;
	        if(mysql_num_rows($req312)>0){
			    $req313= mysql_query("INSERT INTO personnel_absence(idAB,matricule,nbrH,dateD,dateF,Etat) VALUES ('$cdAb','$matricule','8','$dateX','$dateX','Conge')");
	        }else{
	            $req313= mysql_query("INSERT INTO personnel_absence(idAB,matricule,nbrH,dateD,dateF) VALUES ('$cdAb','$matricule','8','$dateX','$dateX')");
	        }
	    }//fin si
	}
	//ajout d'un jour
	$dateX=strtotime($dateX);
    $dateX=strtotime("+1 day",$dateX);
    $dateX=date("Y-m-d",$dateX);
	}//fin while
	

	
	//Congé
	$req31= mysql_query("SELECT nbrH,matricule FROM personnel_conge where dateD like '$mois%' and matricule='$matricule' and payC='P'");
	if(mysql_num_rows($req31)>0){
	    while($a31=mysql_fetch_object($req31)){
	        $nbrH =$a31->nbrH;
         $nbrHM=$nbrH*60;
         $totalM=$totalM+$nbrHM;
        }
	}
	//Salaire1	
	$salaire =($salaire_brut/$nbm_mois)*$totalM;
	$salaireI=($salaireInter/$nbm_mois)*$totalM;
	$salaire=round($salaire,3);
	
	//Total avance
    $totalA=0;
    if($avance=="true"){
	$req3= mysql_query("SELECT montant,matricule FROM personnel_avance where dateA like '$mois%' and matricule='$matricule'");
	
	while($a3=mysql_fetch_object($req3)){
        $montant =$a3->montant;	
		$totalA=$totalA+$montant;
    }
	}
	//Total mise à pied
	$totalMise=0;
	if($mise=="true"){
	$reqM= mysql_query("SELECT montant,matricule FROM personnel_mise where dateM like '$mois%' and matricule='$matricule'");
	
	while($aM=mysql_fetch_object($reqM)){
        $montantMise =$aM->montant;	
	    $totalMise=$totalMise+$montantMise;
    }
	}
	
	//Salaire2
	//$arrondi=$a->arrondi;//Arrondi a vérifier
	//$salaireC =($salaire -$totalA-$totalMise)-$arrondi;
	$arrondi=0;
	$salaireC =($salaire-$totalA)-$totalMise;
	$salaireI = ($salaireI-$totalA)-$totalMise;
	$salaireC=round($salaireC,3);
	//Salaire3
	$salaireF=round($salaireC);
	$salaireI=round($salaireI);
	//$arrondi2=$salaireF-$salaireC;
	//Determiner ID 
	$x=rand(1,999);
	$IDP=$matricule."/".$mois."/".$x;
	$reqV=mysql_query("SELECT matricule,mois from personnel_salaire where matricule='$matricule' and dateD='$dateM1' and dateF='$dateM2'");
	$nbrV=mysql_num_rows($reqV);
	if($nbrV>0){
	   
	   $req3= mysql_query("UPDATE personnel_salaire SET salaire_base='$salaire_brut',nbm_mois='$nbm_mois',nbm_travail='$totalM',salaireB='$salaire',nbr_retard='$totalRetard',total_avance='$totalA',total_mise='$totalMise',arrondi='$arrondi',salaire='$salaireC',salaireA='$salaireF',salaireI='$salaireI' WHERE matricule='$matricule' and dateD='$dateM1' and dateF='$dateM2'");
	   affiche_resultat($matricule, $salaire_brut,$salaire,$totalM,$totalRetard,$totalMise,$totalA,$salaireC,$salaireF);
	}else{
	if($pay=="true"){
	   
	   $req3= "INSERT INTO personnel_salaire(idSP,matricule, salaire_base, mois,dateD,dateF,nbm_mois, nbm_travail, salaireB,nbr_retard, total_avance,total_mise,salaire, salaireA,salaireI) VALUES ('$IDP','$matricule','$salaire_brut','$mois','$dateM1','$dateM2','$nbm_mois','$totalM','$salaire','$totalRetard','$totalA','$totalMise','$salaireC','$salaireF','$salaireI')";
	   if (!mysql_query($req3)) {
	   die('Error: ' . mysql_error()); 
  
       }else{
	   affiche_resultat($matricule, $salaire_brut,$salaire,$totalM,$totalRetard,$totalMise,$totalA,$salaireC,$salaireF);
	   }
	}else{
	//Affichage
	   affiche_resultat($matricule, $salaire_brut,$salaire,$totalM,$totalRetard,$totalMise,$totalA,$salaireC,$salaireF);
	}
	   //$sql=mysql_query("UPDATE personnel_info SET arrondi='$arrondi2' where matricule='$matricule' ");
	}
	}else{
	//Cas salaire FIXE**************************************************************************************************************** 
	//Total avance 
	$dateM=$mois."-01";
	$dateMM2= strtotime($dateM);
    $dateMF= strtotime("next month",$dateMM2);
    $dateMF=strtotime("-1 day",$dateMF);
    $dateMF=date("Y-m-d",$dateMF);
	$req3= mysql_query("SELECT montant,matricule FROM personnel_avance where dateA like '$mois%' and matricule='$matricule'");
	$totalA=0;
	while($a3=mysql_fetch_object($req3))
    {
    $montant =$a3->montant;	
	$totalA=$totalA+$montant;
    }
	//Total mise à pied
	$reqM= mysql_query("SELECT montant,matricule FROM personnel_mise where dateM like '$mois%' and matricule='$matricule'");
	$totalMise=0;
	while($aM=mysql_fetch_object($reqM))
    {
    $montantMise =$aM->montant;	
	$totalMise=$totalMise+$montantMise;
    }
	//Total absence
	$reqAB= mysql_query("SELECT nbrH,matricule FROM personnel_absence where dateD like '$mois%' and matricule='$matricule'");
	$totalAbsence=0;
	while($AB=mysql_fetch_object($reqAB))
    {
    $nbhABC =$AB->nbrH;	
	$totalAbsence=$totalAbsence+$nbhABC;
    }
	if($totalAbsence >0){
	$prixM=$salaire_brut/$nbm_mois;
	$retir= $prixM*($totalAbsence*60);
	$salaireF1=$salaire_brut-$totalA-$totalMise-$retir;
	$salaireF=$salaireF1-$totalA-$totalMise;
	$nbm_travail=$nbm_mois-($totalAbsence*60);
	}else{
	$salaireF=$salaire_brut-$totalA-$totalMise;
	$salaireF1=$salaireF;
	$nbm_travail=$nbm_mois;
	}
	//Salaire2
	$arrondi=$a->arrondi;
	$salaireF2 =$salaireF1-$arrondi;
	//Salaire3
	$salaireF3=round($salaireF2);
	$arrondi2=$salaireF3-$salaireF2;
	//Determiner ID 
	$IDP=$matricule."/".$mois;
	$reqV=mysql_query("SELECT matricule,mois from personnel_salaire where idSP='$IDP'");
	$nbrV=mysql_num_rows($reqV);
	if($nbrV>0){
	   $req3= mysql_query("UPDATE personnel_salaire SET salaire_base='$salaire_brut',dateD='$dateM',dateF='$dateMF',nbm_mois='$nbm_mois',nbm_travail='$nbm_travail',salaireB='$salaireF1',total_avance='$totalA',total_mise='$totalMise',arrondi='$arrondi',salaire='$salaireF2',salaireA='$salaireF3' WHERE idSP='$IDP'");
	   affiche_resultat($matricule, $salaire_brut,$salaireF1,$totalM,$totalRetard,$totalMise,$totalA,$salaireF2,$salaireF3);
	}else{
	   $req3= mysql_query("INSERT INTO personnel_salaire(idSP,matricule, salaire_base, mois,dateD,dateF, nbm_mois, nbm_travail, salaireB, total_avance,total_mise,arrondi, salaire, salaireA) VALUES ('$IDP','$matricule','$salaire_brut','$mois','$dateM','$dateMF','$nbm_mois','$nbm_travail','$salaireF1','$totalA','$totalMise','$arrondi','$salaireF2','$salaireF3')");
	   affiche_resultat($matricule, $salaire_brut,$salaireF1,$totalM,$totalRetard,$totalMise,$totalA,$salaireF2,$salaireF3);
	}
	//
	//$sqlArrondi=mysql_query("UPDATE personnel_info SET arrondi='$arrondi2' where matricule='$matricule' ");
	}
	}

 mysql_close();
}
  ?>