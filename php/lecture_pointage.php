<?php
//Base de donnée
include('../connexion/connexionDB.php');
//Traitement des erreur
error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);

//Ouvrir la bibliothéque PHPExcel
require_once('../PHPExcel/Classes/PHPExcel.php');

// Ouvrir un fichier Excel en lecture
$objReader = PHPExcel_IOFactory::createReader('Excel2007');
//Tous les jours
$pauseJ=$_POST['pause'];
$hd=$_POST['hd'];
$md=$_POST['md'];
$mdM=$md+10;
$hf=$_POST['hf'];
$mf=$_POST['mf'];
//$mfM=$mf+15;
$mfM=$mf+0;
//Samedi
$hdS=@$_POST['hdS'];
$mdS=@$_POST['mdS'];
$mdMS=$mdS+10;
$hfS=@$_POST['hfS'];
$mfS=@$_POST['mfS'];

//Poste Nuit
$hdN=@$_POST['hdN'];
$mdN=@$_POST['mdN'];
$hfN=@$_POST['hfN'];
$mfN=@$_POST['mfN'];
//$mfMS=$mfS+15;
$mfMS=$mfS+0;
$pauseS=@$_POST['pauseS'];
//horaire journaliére
$horaireDJ=$hd.':'.$md.':00';
$horaireDMJ=$hd.':'.$mdM.':00';
$horaireFJ=$hf.':'.$mf.':00';
$horaireFMJ=$hf.':'.$mfM.':00';
//les horaires du samedi
$horaireDS=$hdS.':'.$mdS.':00';
$horaireDMS=$hdS.':'.$mdMS.':00';
$horaireFS=$hfS.':'.$mfS.':00';
$horaireFMS=$hfS.':'.$mfMS.':00';
//Horaire Nuit
$horaireDN=$hdN.':'.$mdN.':00';
$horaireFN=$hfN.':'.$mfN.':00';
//File
$fichier = basename($_FILES['fileP']['name']);
$extension = strrchr($_FILES['fileP']['name'], '.');
if($extension==".xlsx"){
$fichier1=$_FILES['fileP']['tmp_name'];
$objPHPExcel = $objReader->load($fichier1);

$rowIterator = $objPHPExcel->getActiveSheet()->getRowIterator();
foreach($rowIterator as $row) {
    $rowIndex = $row->getRowIndex ();
 	$matricule=$objPHPExcel->getActiveSheet()->getCell("A".$rowIndex)->getValue();
	$cell_4 = $objPHPExcel->getActiveSheet()->getCell("C".$rowIndex) ;
    $timestamp = PHPExcel_Shared_Date::ExcelToPHP($cell_4->getValue());
    $heureP = PHPExcel_Style_NumberFormat::toFormattedString($cell_4->getCalculatedValue(), 'hh:mm:ss');
//echo $cell_value;
    $dateP = date('Y-m-d',$timestamp);
//echo 'Date  '.$date."\r\n" ;
    $sql = mysql_query("INSERT INTO personnel_pointage_inter (matricule,dateP,heureP) values ('$matricule','$dateP','$heureP')");
}
//Insertion dans la base
$req1=mysql_query("select DISTINCT matricule from personnel_pointage_inter");

while($row1=mysql_fetch_array($req1))
    {
	
	$mat=$row1['matricule'];
	$req2=mysql_query("select DISTINCT dateP from personnel_pointage_inter where matricule='$mat'");
	while($row2=mysql_fetch_array($req2))
    {	
	//Permission
	$nbrMP=0;
	//Initialisation
	$etat="----";
	$mnRT=0;
	$sous=0;
	//
	$Pdate=$row2['dateP'];
	//verifier si il est samedi
	$samediD= strtotime($Pdate);
    $samedi= strftime("%a",$samediD);
	if($samedi=="Sat"){
	    $horaireD=$horaireDS;
		$horaireDM=$horaireDMS;
		$horaireF=$horaireFS;
		$horaireFM=$horaireFMS;
		$pause=$pauseS;
	}else{
	  $horaireD=$horaireDJ;
		$horaireDM=$horaireDMJ;
		$horaireF=$horaireFJ;
		$horaireFM=$horaireFMJ;
		$pause=$pauseJ;
	}

	$r1=mysql_query("select min(heureP) from personnel_pointage_inter where dateP='$Pdate' and matricule='$mat'");
	$r2=mysql_query("select max(heureP) from personnel_pointage_inter where dateP='$Pdate' and matricule='$mat'");


	$heureMin = mysql_result($r1,0);
	$heureMax = mysql_result($r2,0);
	//Heures intermaidiare
	$heureInter1 =  strtotime($heureMin."+ 15 minutes");
	$heureInter2=date("H:i", $heureInter1);

	$heureInterMax =  strtotime($heureMax."- 15 minutes");
	$heureInterMax=date("H:i", $heureInterMax);
	
	//Pour Poste nuit 
	
	$pauseSoir=0;
	$r1=mysql_query("select min(heureP)  from personnel_pointage_inter where dateP='$Pdate' and matricule='$mat' and heureP != '$heureMin' and heureP != '$heureMax'");
	$heureMinSoir = @mysql_result($r1,0);
	$r2=mysql_query("select max(heureP)  from personnel_pointage_inter where dateP='$Pdate' and matricule='$mat' and heureP != '$heureMin' and heureP != '$heureMax' and heureP != '$heureMinSoir'");
    
	$heureMaxSoir = @mysql_result($r2,0);
    if(($heureMinSoir != NULL) && ($heureMaxSoir != NULL) ){
	  //Vérification par heure itermédiaire
     if($heureMinSoir >= $heureInter2 && $heureMaxSoir <= $heureInterMax){

	  //
	  $xSoir=$heureMaxSoir-$heureMinSoir;
	  $m1Soir=substr($heureMaxSoir,3,2);
	  $m2Soir=substr($heureMinSoir,3,2);
	  $x2Soir=$m1Soir-$m2Soir;
	  $pauseSoir=(($xSoir*60)+$x2Soir);

	  if($pauseSoir<30){
		$pauseSoir=0;
	  }
	}
    }
	//Vérification 
    $interMaxSoir =  strtotime($heureMaxSoir."- 15 minutes");
	$interMaxSoir=date("H:i", $interMaxSoir);
	$verif=1;
	if(($heureMax >= $horaireDN) && ($heureMinSoir != NULL) && ($heureMaxSoir != NULL)){
       $verif=1;
	}else if (($heureMax >= $horaireDN) && ($heureMinSoir >= $interMaxSoir)){
	   $verif=0;
	   
	}else if ($heureMax >= $horaireDN){
		$verif=0;
	
	}

	if(($heureMax != $heureMin )and ($heureMax>$heureInter2) and ($verif == 1)){
	//Calcul total minute travail
	//
	if($heureMin < $horaireD){
	$heureMin=$horaireD;
	}
	//Determiner les minutes a soustracter
	//horaireDM est l horaire d'entrée + 15 mn
	if($heureMin > $horaireD){
	  $p1=@mysql_query("select * from personnel_permission where dateP='$Pdate' and matricule='$mat'");
		if(mysql_num_rows($p1)>0){
		$etat="RP";
		$mnRT=0;
		$sous=0;
		}else if($samedi=="Sun"){
		$etat="Sun";
		$mnRT=0;
		$sous=0;
		}else{
	    $etat="R";
      $sous=0;
      if($Pdate != "2018-01-12" && $Pdate != "2018-01-13"){

			$mnR=$heureMin-$horaireD;
			$mnR1=substr($heureMin,3,2);
			$mnR2=substr($horaireD,3,2);
			$mnR3=$mnR1-$mnR2;
			$mnRT=($mnR*60)+$mnR3;
			if($mnRT <= 240){
			    if($mnRT<5){
	                $sous=5-$mnRT;
	            }else if($mnRT>= 6 && $mnRT<= 15){
	                $sous=120-$mnRT;

	            }else if($mnRT>= 16){
	                $sous=240-$mnRT;

	            }

			}
      }/*else{
			    $sous=0;
			}*/
			 //$sous=0;
		}//fin vérification permission
	//
	}else{
	  $p1=@mysql_query("select dateP,nbrH from personnel_permission where dateP='$Pdate' and matricule='$mat'");
		if(mysql_num_rows($p1)>0){
		$etat="P";
		$dataP=mysql_fetch_array($p1);
		$nbrMP=$dataP['nbrH'];
		$mnRT=0;
		$sous=0;
		}/*else{
	    $etat="----";
		$mnRT=0;
		$sous=0;
		}*/
	}
	//
	if(($heureMax<$horaireFM)and ($heureMax >$horaireF )){
	    $heureMax=$horaireF;
	}
	//

	$x=$heureMax-$heureMin;
	$m1=substr($heureMax,3,2);
	$m2=substr($heureMin,3,2);
	$x2=$m1-$m2;
	$xR=(($x*60)+$x2)-$pause;
	$xR=$xR-$pauseSoir; //Poste nuit
    //
   
	//soustraction permission
	$xR=$xR-$nbrMP;//Avoir
	//Vérification heure allaitement
	$reqHA=@mysql_query("select matricule,nbrH from personnel_heure_allait where dateD <= '$Pdate' and dateF >= '$Pdate' and matricule='$mat'");
	if(mysql_num_rows($reqHA)>0){

		$dataHA=mysql_fetch_array($reqHA);
		$nbrHA=$dataHA['nbrH'];
		$etat="+".$nbrHA." HA";
		$nbrHA=$nbrHA*60;
		$xR=$xR+$nbrHA;
	}

	//Somme des minute aprés soustraction
	if(($mat != 5000) && ($mat != 780)){//hayet Jmaii n'ai pas conserné
		$xR2=$xR-$sous;
	}else{
		$xR2=$xR;
	}
	
	if($xR2<0){
	    $xR2=0;
	}
	//$xR2=$xR;

	//vérification du double pointage
	$sq2=mysql_query("select mat,newMat FROM personnel_doublep WHERE newMat='$mat'");
	$nbrD=@mysql_num_rows($sq2);
	if($nbrD>0){
	$data=mysql_fetch_array($sq2);
	$matD=$data['mat'];
	$idP=$matD."/".$Pdate;
	$sql2 = mysql_query("INSERT INTO personnel_pointage (idP,matricule,dateP,heureD,heureF,totalM,etat,retard,totalMF,heureNuitD,heureNuitF,pauseNuit)
	 values ('$idP','$matD','$Pdate','$heureMin','$heureMax','$xR','$etat','$mnRT','$xR2','$heureMinSoir','$heureMaxSoir','$pauseSoir')");
	}else{
	$idP=$mat."/".$Pdate;
	$sql2 = mysql_query("INSERT INTO personnel_pointage (idP,matricule,dateP,heureD,heureF,totalM,etat,retard,totalMF,heureNuitD,heureNuitF,pauseNuit) 
	values ('$idP','$mat','$Pdate','$heureMin','$heureMax','$xR','$etat','$mnRT','$xR2','$heureMinSoir','$heureMaxSoir','$pauseSoir')");
	}


	}else{//Pointage a corriger
	//vérification du double pointage
	if($verif==0){
        $stat="PN";
	}else{
        $stat="n";
	}
	$sq2=mysql_query("select mat,newMat FROM personnel_doublep WHERE newMat='$mat'");
	$nbrD=@mysql_num_rows($sq2);
	if($nbrD>0){
	$data=mysql_fetch_array($sq2);
	$matD=$data['mat'];
	$idP=$matD."/".$Pdate;
	$sql2 = mysql_query("INSERT INTO personnel_pointage (idP,matricule,dateP,heureD,heureF,heureNuitD,heureNuitF,statut)
	 values ('$idP','$matD','$Pdate','$heureMin','$heureMax','$heureMinSoir','$heureMaxSoir','$stat')");
	}else{
	$idP=$mat."/".$Pdate;
	$sql2 = mysql_query("INSERT INTO personnel_pointage (idP,matricule,dateP,heureD,heureF,heureNuitD,heureNuitF,statut) 
	values ('$idP','$mat','$Pdate','$heureMin','$heureMax','$heureMinSoir','$heureMaxSoir','$stat')");
	}
	}

    }



   }
  $sql3=mysql_query("DELETE FROM personnel_pointage_inter");
  mysql_close();
  header('Location: ../pages/pointage.php?status=sent');
  }else{
  mysql_close();
  header('Location: ../pages/pointage.php?status=fail');
  }

?>
