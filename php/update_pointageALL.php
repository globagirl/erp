<?php
session_start();
include('../connexion/connexionDB.php');
$date1=@$_POST['date1'];
$date2=@$_POST['date2'];
$hd=$_POST['hd'];
$md=$_POST['md'];
$hf=$_POST['hf'];
$mf=$_POST['mf'];
$pauseJ = $_POST['pause'];
//Samedi
$hdS=@$_POST['hdS'];
$mdS=@$_POST['mdS'];
$hfS=@$_POST['hfS'];
$mfS=@$_POST['mfS'];
$pauseS=@$_POST['pauseS'];
$horaireDS=$hdS.':'.$mdS.':00';
$horaireFS=$hfS.':'.$mfS.':00';
//
$horaireDJ=$hd.':'.$md.':00';
$horaireFJ=$hf.':'.$mf.':00';
$mnRT=0;
$etat='---';
if(($date1=="")and ($date2=="")){
    $req1= "SELECT * FROM personnel_pointage where statut='n'";
}else if( ($date1!="")and ($date2!="")){
    $req1= "SELECT * FROM personnel_pointage where ((dateP >= '$date1') and (dateP <= '$date2')) and statut='n'";
}
$r=mysql_query($req1) or die(mysql_error());
while($a=mysql_fetch_object($r)){
    //permission
    $nbrMP=0;
    $sous=0;
    //
    $mat=$a->matricule;
    $dateP =$a->dateP;
    $heureP =$a->heureD;
    //$heureF =$a->heureF;
    //Poste soir
    /*
    if($heureF>$horaireDN){
        $heureDN=$a->heureNuitD;
        $interMinSoir =  strtotime($heureDN."+ 30 minutes");
        $interMinSoir=date("H:i", $interMinSoir);
        if($horaireDN>$interMinSoir){
            $heureFN=$horaireDN;
        }else{
            $heureFN=$heureDN;
            $heureDN=$horaireF;//horaire fin par défaut
        }
        $xSoir=$heureFN-$heureDN;
        $m1Soir=substr($heureFN,3,2);
        $m2Soir=substr($heureDN,3,2);
        $x2Soir=$m1Soir-$m2Soir;
        $pauseSoir=(($xSoir*60)+$x2Soir);

    }*/
    $samediD= strtotime($dateP);
    $samedi= strftime("%a",$samediD);
    if($samedi=="Sat"){
        $pause=$pauseS;
        $horaireD=$horaireDS;
        $horaireF=$horaireFS;
        $horaireF2=$horaireF;
        $horaireD2=$horaireD;
    }else{
        $pause=$pauseJ;
        $horaireD=$horaireDJ;
        $horaireF=$horaireFJ;
        $horaireF2=$horaireF;
        $horaireD2=$horaireD;
    }
    if($heureP < '12:15:00'){
        $horaireD=$heureP;
    }else{
        $horaireF=$heureP;
    }
    //Ne pas prendre en compte ceux qui arrive tot
    if($horaireD < $horaireD2){
        $horaireD=$horaireD2;
    }
    //Ne pas prendre en compte ceux qui retourne tard
    /*if($horaireF> $horaireF2){
        $horaireF=$horaireF2;
    }*/
    //Retard
    /*if($horaireD > $horaireD2){
      $p1=@mysql_query("select * from personnel_permission where dateP='$dateP' and matricule='$mat'");
        if(mysql_num_rows($p1)>0){
            $etat="RP";
            $mnRT=0;
            $sous=0;
        }else{	//Determiner les minutes a soustracter
        $etat="R";
            $mnR=$horaireD-$horaireD2;
            $mnR1=substr($horaireD,3,2);
            $mnR2=substr($horaireD2,3,2);
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
        }
    }else{
      $p1=@mysql_query("select * from personnel_permission where dateP='$dateP' and matricule='$mat'");
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
    //Calcul
    $x=$horaireF-$horaireD;
    $m1=substr($horaireF,3,2);
    $m2=substr($horaireD,3,2);
    $x2=$m1-$m2;
    $xR=(($x*60)+$x2)-$pause;
    //Somme des minute aprés soustraction
    $xR2=$xR-$sous;
    if($xR2<0){
        $xR2=0;
    }
    //$xR2=$xR;
    $sql=mysql_query("UPDATE personnel_pointage SET heureD='$horaireD',heureF='$horaireF',statut='y', totalM='$xR',
	etat='$etat',retard='$mnRT',totalMF='$xR2'	where matricule='$mat' and dateP='$dateP'");
}
mysql_close();
header('Location: ../pages/update_pointage.php');
?>