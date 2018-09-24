 <?php
include('../connexion/connexionDB.php');
$mois=$_POST['mois'];
$year=$_POST['year'];
$nbm_mois=$_POST['nbm_mois'];
$mois=$year."-".$mois;

$req01= mysql_query("SELECT * FROM personnel_pointage where dateP like '$mois%' and statut='n'");
if(mysql_num_rows($req01)>0){
echo('<table><tr><td style=background-color:#F6CED8>Il y a des pointages non validé , Veillez vérifier les pointages SVP !!</td></tr></table>');
}else{
    $req1= "SELECT * FROM personnel_info where etat like 'actif'";
    $r=mysql_query($req1) or die(mysql_error());
	while($a=mysql_fetch_object($r)){
	$matricule=$a->matricule;
	$typeS=$a->typeS;
	$salaire_brut=$a->salaire;
    if($typeS=="V"){
	
	//Total minute de travail 
	
	$totalM=0;
	$totalRetard=0;
	$dateM1=$mois."-01";
    $dateM= strtotime($dateM1);
    $dateM2= strtotime("next month",$dateM);
    $dateM2=strtotime("-1 day",$dateM2);
    $dateM2=date("Y-m-d",$dateM2);
    $dateX=$dateM1;
	
    while($dateX <= $dateM2){
	$sun=strtotime($dateX);
    $sun=strftime ( "%a",$sun);
    $req2 = mysql_query("SELECT * FROM personnel_pointage where dateP LIKE '$dateX' and matricule='$matricule'");
	$nbr=mysql_num_rows($req2);
    if($nbr>0){
	    $a2=mysql_fetch_object($req2);    
        $mTJ =$a2->totalMF;	
        $etatP =$a2->etat;
		$totalM=$totalM+$mTJ;
		if($etatP=="R"){
	        $totalRetard++;
	    }
    }else if(($sun != "Sun")&&($sun != "Sat")){ // verifier s'il s'agit d'un jour ferié
	    $req311= mysql_query("SELECT * FROM public_holiday where dateD >= '$dateX' and dateF <= '$dateX' and typePH='FP'");
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
			$reqPH = mysql_query("SELECT * FROM personnel_pointage where (dateP LIKE '$dateAPH')  and (matricule='$matricule')");
			$reqPHF = mysql_query("SELECT * FROM personnel_pointage where (dateP LIKE '$dateAPHF')  and (matricule='$matricule')");
			if((mysql_num_rows($reqPH)>0) && (mysql_num_rows($reqPHF)>0) ){			
 		        $totalM=$totalM+480;
			}
	    }else{//il s'agit d'une absence
	        $req312= mysql_query("SELECT * FROM personnel_conge where dateD like '$dateX' and matricule='$matricule'");
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
	$req31= mysql_query("SELECT * FROM personnel_conge where dateD like '$mois%' and matricule='$matricule' and payC='P'");
	if(mysql_num_rows($req31)>0){
	    while($a31=mysql_fetch_object($req31)){
	        $nbrH =$a31->nbrH;
			$nbrHM=$nbrH*60;	
			$totalM=$totalM+$nbrHM;
        }
	}
	//Salaire1	
	$salaire =($salaire_brut/$nbm_mois)*$totalM;
	//Total avance 
	$req3= mysql_query("SELECT * FROM personnel_avance where dateA like '$mois%' and matricule='$matricule'");
	$totalA=0;
	while($a3=mysql_fetch_object($req3)){
        $montant =$a3->montant;	
		$totalA=$totalA+$montant;
    }
	//Total mise à pied
	$reqM= mysql_query("SELECT * FROM personnel_mise where dateM like '$mois%' and matricule='$matricule'");
	$totalMise=0;
	while($aM=mysql_fetch_object($reqM)){
        $montantMise =$aM->montant;	
	    $totalMise=$totalMise+$montantMise;
    }
	
	//Salaire2
	//$arrondi=$a->arrondi;//Arrondi a vérifier
	//$salaireC =($salaire -$totalA-$totalMise)-$arrondi;
	$arrondi=0;
	$salaireC =($salaire -$totalA)-$totalMise;
	//Salaire3
	$salaireF=round($salaireC);
	//$arrondi2=$salaireF-$salaireC;
	//Determiner ID 
	$IDP=$matricule."/".$mois;
	$reqV=mysql_query("SELECT * from personnel_salaire where idSP='$IDP'");
	$nbrV=mysql_num_rows($reqV);
	if($nbrV>0){
	$req3= mysql_query("UPDATE personnel_salaire SET salaire_base='$salaire_brut',nbm_mois='$nbm_mois',nbm_travail='$totalM',salaireB='$salaire',nbr_retard='$totalRetard',total_avance='$totalA',total_mise='$totalMise',arrondi='$arrondi',salaire='$salaireC',salaireA='$salaireF' WHERE idSP='$IDP'");
	}else{
	$req3= mysql_query("INSERT INTO personnel_salaire(idSP,matricule, salaire_base, mois, nbm_mois, nbm_travail, salaireB,nbr_retard, total_avance,total_mise, arrondi, salaire, salaireA) VALUES ('$IDP','$matricule','$salaire_brut','$mois','$nbm_mois','$totalM','$salaire','$totalRetard','$totalA','$totalMise','$arrondi','$salaireC','$salaireF')");
	//$sql=mysql_query("UPDATE personnel_info SET arrondi='$arrondi2' where matricule='$matricule' ");
	}
	}else{
	//Cas salaire FIXE**************************************************************************************************************** 
	//Total avance 
	$req3= mysql_query("SELECT * FROM personnel_avance where dateA like '$mois%' and matricule='$matricule'");
	$totalA=0;
	while($a3=mysql_fetch_object($req3))
    {
    $montant =$a3->montant;	
	$totalA=$totalA+$montant;
    }
	//Total mise à pied
	$reqM= mysql_query("SELECT * FROM personnel_mise where dateM like '$mois%' and matricule='$matricule'");
	$totalMise=0;
	while($aM=mysql_fetch_object($reqM))
    {
    $montantMise =$aM->montant;	
	$totalMise=$totalMise+$montantMise;
    }
	//Total absence
	$reqAB= mysql_query("SELECT * FROM personnel_absence where dateD like '$mois%' and matricule='$matricule'");
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
	$reqV=mysql_query("SELECT * from personnel_salaire where idSP='$IDP'");
	$nbrV=mysql_num_rows($reqV);
	if($nbrV>0){
	$req3= mysql_query("UPDATE personnel_salaire SET salaire_base='$salaire_brut',nbm_mois='$nbm_mois',nbm_travail='$nbm_travail',salaireB='$salaireF1',total_avance='$totalA',total_mise='$totalMise',arrondi='$arrondi',salaire='$salaireF2',salaireA='$salaireF3' WHERE idSP='$IDP'");
	}else{
	$req3= mysql_query("INSERT INTO personnel_salaire(idSP,matricule, salaire_base, mois, nbm_mois, nbm_travail, salaireB, total_avance,total_mise,arrondi, salaire, salaireA) VALUES ('$IDP','$matricule','$salaire_brut','$mois','$nbm_mois','$nbm_travail','$salaireF1','$totalA','$totalMise','$arrondi','$salaireF2','$salaireF3')");
	}
	//
	$sqlArrondi=mysql_query("UPDATE personnel_info SET arrondi='$arrondi2' where matricule='$matricule' ");
	}
	}
/////////////////////////Affichage des salaires
$req5= mysql_query("SELECT * FROM personnel_salaire where mois like '$mois'");
$req51= mysql_query("SELECT sum(salaireA) FROM personnel_salaire where mois like '$mois'");
$Tsalaire=mysql_result($req51,0);
  echo'<table  id="myTable" class="tablesorter" cellspacing="0" cellpadding="0"><thead>
  <tr><td colspan=6></td><td colspan=2> <b> Mois : '.$mois.'  </b> </td>
  <td> <b> Total : </b></td><td colspan=2><b>'.$Tsalaire.' TND </b> </td><td><a href="../pages/consult_salaire.php" ><img src="../image/consult.png" onclick="printSalaire();" alt="Print" style="cursor:pointer;" width="40" height="35"  /></a>
  </td></tr>
  <tr style=text-align:center>
  <th style=text-align:center><b>Matricule</b></th>
  <th style=text-align:center><b>Nom & Prenom</b></th>
  <th style=text-align:center><b>Catégorie</b></th>  
  <th style=text-align:center><b>Salaire Brut</b></th>
  <th style=text-align:center><b>Total minute</b></th>
  <th style=text-align:center><b>Salaire</b></th>
  <th style=text-align:center><b>NBR retards</b></th>
   <th style=text-align:center><b> Mise à pied</b></th>
  <th style=text-align:center><b> Avances</b></th> 
  <th style=text-align:center><b>Arrondi </b></th>
  <th style=text-align:center><b> Salaire NET </b></th>
  <th style=text-align:center><b> NET arrondi</b></th>
 
  </tr>';
  $i=0;
  while($a5=mysql_fetch_object($req5))
    {
	
    $mat=$a5->matricule;
    $sB=$a5->salaire_base;
    $nbm=$a5->nbm_travail;
    $SB=$a5->salaireB;
    $TA=$a5->total_avance;
    $AR=$a5->arrondi;
    $S=$a5->salaire;
    $sA=$a5->salaireA;
    $mise=$a5->total_mise;
    $retard=$a5->nbr_retard;

    
    
	$req6= mysql_query("SELECT * FROM personnel_info where matricule ='$mat'");
	$data=mysql_fetch_array($req6);
	$nom=$data['nom'];
	$category=$data['category'];
    echo"<tr ><td  style=\"text-align:center \">".$mat."</td>
	<td  style=\"text-align:center \">".$nom."</td>
	<td  style=\"text-align:center \">".$category."</td>	
	<td  style=\"text-align:center ;background-color:#F8FBEF\">".$sB."</td>
	<td  style=\"text-align:center \">".$nbm."</td>
	<td  style=\"text-align:center ;background-color:#F6CED8\">".$SB."</td>
	<td  style=\"text-align:center \">".$retard."</td>
	<td  style=\"text-align:center \">".$mise."</td>
	<td  style=\"text-align:center \">".$TA."</td>	
	<td  style=\"text-align:center \">".$AR."</td>
	<td  style=\"text-align:center \">".$S."</td>
	<td  style=\"text-align:center ;background-color:#F7819F\">".$sA."</td>
	</tr>";

 
}
 echo '</thead></table>';
 mysql_close();
}
  ?>