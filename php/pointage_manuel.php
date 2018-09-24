<?php
//Code vérifié
include('../connexion/connexionDB.php');
//Every day
$hd=$_POST['hd'];
$md=$_POST['md'];
$hf=$_POST['hf'];
$mf=$_POST['mf'];
$pause=$_POST['pause'];
//Samedi
$hdS=@$_POST['hdS'];
$mdS=@$_POST['mdS'];
$hfS=@$_POST['hfS'];
$mfS=@$_POST['mfS'];
$pauseS=@$_POST['pauseS'];
//
//Poste Nuit
$hdN=@$_POST['hdN'];
$mdN=@$_POST['mdN'];
$hfN=@$_POST['hfN'];
$mfN=@$_POST['mfN'];
//
$dateD=$_POST['dateD'];
$dateF=@$_POST['dateF'];
$recherche=$_POST['recherche'];
$valeur=$_POST['valeur'];
//les horaires
$horaireD=$hd.':'.$md.':00';
$horaireF=$hf.':'.$mf.':00';
//les horaires du samedi
$horaireDS=$hdS.':'.$mdS.':00';
$horaireFS=$hfS.':'.$mfS.':00';
//Horaire Nuit
$horaireDN=$hdN.':'.$mdN.':00';
$horaireFN=$hfN.':'.$mfN.':00';
//definier la dateF
if($dateF==""){
    $dateF=$dateD;
}

if($recherche =="a"){
    $req1=mysql_query("SELECT * FROM personnel_info where etat='actif' and typeS='V'");
}else{
    $req1=mysql_query("SELECT * FROM personnel_info where  $recherche LIKE '$valeur'");
}

while($row1=mysql_fetch_array($req1)){	
	$mat=$row1['matricule'];
    $dateX=$dateD;	
	while($dateF >= $dateX){		
	//verifier si il est samedi 
	$samedi= strtotime($dateX);
	$samedi= strftime("%a",$samedi);
	if(isset($_POST['chekNuit'])){//Vérification poste Nuit
		if($samedi != "Sun"){
			//nuit
			$n=$hfN-$hdN;
			$n2=$mfN-$mdN;
			$nR=($n*60)+$n2;
			//
			if($samedi=="Sat"){
				if(isset($_POST['chek'])){						
				$x=$hfS-$hdS;	
				$x2=$mfS-$mdS;
				
				$xR=(($x*60)+$x2)-$pauseS;
				$xR=$xR+$nR;
				$idP=$mat."/".$dateX;
				$sql2 = mysql_query("INSERT INTO personnel_pointage (idP,matricule,dateP,heureD,heureF,totalM,etat,retard,totalMF,heureNuitD,heureNuitF) 
				values ('$idP','$mat','$dateX','$horaireDS','$horaireFN','$xR','PM','0','$xR','$horaireFS','$horaireDN')");

				}
			}else{
				$x=$hf-$hd;	
				$x2=$mf-$md;
				$xR=(($x*60)+$x2)-$pause;
				$xR=$xR+$nR;
				$idP=$mat."/".$dateX;
				$sql2 = mysql_query("INSERT INTO personnel_pointage (idP,matricule,dateP,heureD,heureF,totalM,etat,retard,totalMF,heureNuitD,heureNuitF) 
				values ('$idP','$mat','$dateX','$horaireD','$horaireFN','$xR','PM','0','$xR','$horaireF','$horaireDN')");
			}	

		}

	}else{//Pas de poste nuit	
	  if($samedi != "Sun"){
	    if($samedi=="Sat"){
		    if(isset($_POST['chek'])){
		    $x=$hfS-$hdS;	
	        $x2=$mfS-$mdS;
	        $xR=(($x*60)+$x2)-$pauseS;
			$idP=$mat."/".$dateX;
	        $sql2 = mysql_query("INSERT INTO personnel_pointage (idP,matricule,dateP,heureD,heureF,totalM,etat,retard,totalMF) values ('$idP','$mat','$dateX','$horaireDS','$horaireFS','$xR','PM','0','$xR')");
			}
	    }else{
		    $x=$hf-$hd;	
	        $x2=$mf-$md;
	        $xR=(($x*60)+$x2)-$pause;
			$idP=$mat."/".$dateX;
	        $sql2 = mysql_query("INSERT INTO personnel_pointage (idP,matricule,dateP,heureD,heureF,totalM,etat,retard,totalMF) values ('$idP','$mat','$dateX','$horaireD','$horaireF','$xR','PM','0','$xR')");
	    }	
	    
	  }
	}  
	//Incrimenter la date
	$dateX=strtotime($dateX);
	$dateX=strtotime("+1 day",$dateX);
	$dateX=date("Y-m-d",$dateX);
	}		
}//fin requéte
mysql_close();
header('Location: ../pages/pointage_manuel.php?status=sent');

?>