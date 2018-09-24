<?php
//Code vérifié
include('../connexion/connexionDB.php');
    $dateD = $_POST['dateD'];
    $dateF = $_POST['dateF'];
	$typeC=$_POST['typeC'];
	$payC=$_POST['payC'];
	$recherche=$_POST['recherche'];
	$valeur=$_POST['valeur'];
	$jourJ=strtotime($dateF);
	$year = strftime("%Y",$jourJ);
    $mois = strftime("%m",$jourJ);
    $mois=$year."-".$mois;
    //echo $mois;

	//Calcul nbr heure
	$nbrH=0;
	$dateX=$dateD;
    while($dateX <= $dateF){
        $D=strtotime($dateX);
        $D=strftime ( "%a",$D);
	    if($D != "Sun"){
	        $nbrH=$nbrH+8;

	    }
	    $dateX=strtotime($dateX);
        $dateX=strtotime("+1 day",$dateX);
        $dateX=date("Y-m-d",$dateX);
	}
	if(isset($_POST['demiJD'])){
	 $nbrH=$nbrH-4;

	}
	if(isset($_POST['demiJF'])){
	 $nbrH=$nbrH-4;

	}
	//
	$sql2=mysql_query("select matricule,salaire from personnel_info where $recherche='$valeur'");
	$data2=mysql_fetch_array($sql2);
  $mat=$data2['matricule'];
	$idC=$mat."/".$dateD;
    if($payC=="PN"){
        $nbm=10080;
        $salaire=$data2['salaire'];
        $montant=($salaire/$nbm)*($nbrH*60);
        $montant=round($montant);
        $sql=mysql_query("INSERT INTO personnel_conge(idPC,matricule,nbrH,typeC,dateD,dateF,payC,montant)VALUES ('$idC','$mat','$nbrH','$typeC','$dateD','$dateF','$payC','$montant')");

        mysql_close();
        header('Location: ../pages/consult_conge.php');


    }else{
     $sql=mysql_query("INSERT INTO personnel_conge(idPC,matricule,nbrH,typeC,dateD,dateF,payC)VALUES ('$idC','$mat','$nbrH','$typeC','$dateD','$dateF','$payC')");
      mysql_close();
     header('Location: ../pages/ajout_conge.php?status=sent');
    }
	//$sql=mysql_query("INSERT INTO personnel_conge(idPC,matricule,nbrH,typeC,dateD,dateF,payC)VALUES ('$idC','$mat','$nbrH','$typeC','$dateD','$dateF','$payC')");
	//$sql5=mysql_query("UPDATE personnel_conge_annuel SET conge_acc=conge_acc+'$nbrH', conge_res=conge_res-'$nbrH' where matricule='$mat' and yearC='$year'");

	mysql_close();

?>
