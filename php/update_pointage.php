<?php
session_start();
include('../connexion/connexionDB.php');
$mat = $_POST['mat'];
$Pdate = $_POST['D'];
$heureMin = $_POST['hd'];
$heureMax = $_POST['hf'];
$pause = $_POST['pause'];
$hd=$_POST['Hdebut'];
$md=$_POST['Mdebut'];
$mdM=$md+10;
$hf=$_POST['Hfin'];
$mf=$_POST['Mfin'];
//$mfM=$mf+35;
$mfM=$mf+0;
$horaireD=$hd.':'.$md.':00';
$horaireDM=$hd.':'.$mdM.':00';
$horaireF=$hf.':'.$mf.':00';
$horaireFM=$hf.':'.$mfM.':00';
//Permission
$nbrMP=0;
if($heureMin < $horaireD){
    $heureMin=$horaireD;
}
if($heureMax < $horaireFM and $heureMax > $horaireF){
    $heureMax=$horaireF;
}
//
if($heureMin > $horaireD){
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
        if($mnRT < 240){
            if($mnRT<5){
                $sous=5-$mnRT;
            }else if($mnRT>= 6 && $mnRT<= 15){
                $sous=120-$mnRT;
            }else if($mnRT>= 16){
                $sous=240-$mnRT;
            }
            $sous=0;
        }else{
            $sous=0;
        }
        //$sous=0;
    }
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
}
//
$x=$heureMax-$heureMin;
$m1=substr($heureMax,3,2);
$m2=substr($heureMin,3,2);
$x2=$m1-$m2;
$samediD= strtotime($Pdate);
$samedi= strftime("%a",$samediD);
if($samedi=="Sat"){
    $xR=($x*60)+$x2;
}else{
    $xR=(($x*60)+$x2)-$pause;
}
$xR=$xR-$nbrMP;
//Somme des minute aprés soustraction
$xR2=$xR-$sous;
if($xR2<0){
    $xR2=0;
}
//$xR2=$xR;
$sql="UPDATE personnel_pointage SET heureD='$heureMin',heureF='$heureMax',statut='y', totalM='$xR',etat='$etat',retard='$mnRT',totalMF='$xR2' where matricule='$mat' and dateP='$Pdate'";
if (!mysql_query($sql)) {
    die('Error: ' . mysql_error());
}else{
    echo("OK");
}
?>