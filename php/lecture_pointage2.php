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
$mfM=$mf+15;
//Samedi
$hdS=@$_POST['hdS'];
$mdS=@$_POST['mdS'];
$mdMS=$mdS+10;
$hfS=@$_POST['hfS'];
$mfS=@$_POST['mfS'];
$mfMS=$mfS+15;
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
//Permission

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
            $nbrMP=0;
            $Pdate=$row2['dateP'];
            //verifier si il est samedi
            $samediD= strtotime($Pdate);
            $samedi= strftime("%a",$samediD);
            if(($samedi=="Sat") || ($samedi=="Sun")){
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
            $heureInter1 =  strtotime($heureMin."+ 15 minutes");
            $heureInter2=date("H:i", $heureInter1);
            if(($heureMax != $heureMin )and ($heureMax>$heureInter2)){ //determiner si il ya les deux pointage
                //Calcul total minute travail
                //Horaire debut
                /*
                if($heureMin < $horaireD){
                $heureMin=$horaireD;
                }*/
                //Determiner les minutes a soustracter
                //horaireDM est l horaire d'entrée + 15 mn
                /*if($heureMin > $horaireD){
                    $p1=@mysql_query("select * from personnel_permission where dateP='$Pdate' and matricule='$mat'");
                    if(mysql_num_rows($p1)>0){
                    $etat="RP";
                    $mnRT=0;
                    $sous=0;
                    }else{
                        $etat="R";
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
                        }else{
                            $sous=0;
                        }
                    }//fin vérification permission
                //
                }else{
                    $p1=@mysql_query("select * from personnel_permission where dateP='$Pdate' and matricule='$mat'");
                    if(mysql_num_rows($p1)>0){
                    $etat="P";
                    $dataP=mysql_fetch_array($p1);
                    $nbrMP=$dataP['nbrH'];
                    $mnRT=0;
                    $sous=0;
                    }else{
                    $etat="----";
                    $mnRT=0;
                    $sous=0;
                    }
                }*/
                //Horaire du fin
                /*
                if(($heureMax<$horaireFM)and ($heureMax >$horaireF )){
                    $heureMax=$horaireF;
                }*/
                //
                $etat="----";
                $mnRT=0;
                $sous=0;
                $x=$heureMax-$heureMin;
                $m1=substr($heureMax,3,2);
                $m2=substr($heureMin,3,2);
                $x2=$m1-$m2;
                $xR=(($x*60)+$x2)-$pause;
                //soustraction permission
                $xR=$xR-$nbrMP;
                //Somme des minute aprés soustraction
                $xR2=$xR-$sous;
                if($xR2<0){
                    $xR2=0;
                }
                //$xR2=$xR;
                //vérification du double pointage
                $sq2=mysql_query("select * FROM personnel_doublep WHERE newMat='$mat'");
                $nbrD=@mysql_num_rows($sq2);
                if($nbrD>0){
                    $data=mysql_fetch_array($sq2);
                    $matD=$data['mat'];
                    $idP=$matD."/".$Pdate;
                    $sql2 = mysql_query("INSERT INTO personnel_pointage (idP,matricule,dateP,heureD,heureF,totalM,etat,retard,totalMF) values ('$idP','$matD','$Pdate','$heureMin','$heureMax','$xR','$etat','$mnRT','$xR2')");
                }else{
                    $idP=$mat."/".$Pdate;
                    $sql2 = mysql_query("INSERT INTO personnel_pointage (idP,matricule,dateP,heureD,heureF,totalM,etat,retard,totalMF) values ('$idP','$mat','$Pdate','$heureMin','$heureMax','$xR','$etat','$mnRT','$xR2')");
                }
            }else{//Pointage a corriger
                //vérification du double pointage
                $sq2=mysql_query("select * FROM personnel_doublep WHERE newMat='$mat'");
                $nbrD=@mysql_num_rows($sq2);
                if($nbrD>0){
                    $data=mysql_fetch_array($sq2);
                    $matD=$data['mat'];
                    $idP=$matD."/".$Pdate;
                    $sql2 = mysql_query("INSERT INTO personnel_pointage (idP,matricule,dateP,heureD,heureF,statut) values ('$idP','$matD','$Pdate','$heureMin','$heureMax','n')");
                }else{
                    $idP=$mat."/".$Pdate;
                    $sql2 = mysql_query("INSERT INTO personnel_pointage (idP,matricule,dateP,heureD,heureF,statut) values ('$idP','$mat','$Pdate','$heureMin','$heureMax','n')");
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