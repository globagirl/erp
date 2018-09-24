<?php
session_start();
include('../connexion/connexionDB.php');
    $mat = $_POST['mat'];
	$ncin= $_POST['ncin'];
	$nom= $_POST['nom'];
	$prenom= $_POST['prenom'];
	//$parent= $_POST['parent'];
	$dateN= $_POST['dateN'];
	$ad1= $_POST['ad1'];
	$ad2= $_POST['ad2'];
	$typeS= $_POST['typeS'];
	$conge=@$_POST['conge'];
	$contrat= $_POST['contrat'];
	$cat= $_POST['cat'];
	$salaire= $_POST['salaire'];
	$dateE= $_POST['dateE'];
	$note= $_POST['note'];
	$mail= $_POST['mail'];
	$cnss=@$_POST['cnss'];	
    $nbr=$_POST['nbr'];
    $nbr2=$_POST['nbr2'];
    $nbr3=$_POST['nbr3'];
	//Traitement congé
	if($conge==''){ 
	    $conge=0;
	}
	$congeR=168-$conge;
	$jourJ=date("Y-m-d");
    $jourJ=strtotime($jourJ);
	$year = strftime("%Y",$jourJ);

	
	  
	
$np=$prenom." ".$nom;
// photo personnel 
if(!file_exists($_FILES['fileP']['tmp_name'])){
$sql = "INSERT INTO personnel_info(matricule, NCIN, nom,contrat, category, dateN, adresse1, adresse2, salaire,mail,typeS,CNSS) VALUES ('$mat','$ncin','$np','$contrat','$cat','$dateN','$ad1','$ad2','$salaire','$mail','$typeS','$cnss')";

}else{
   $FP = basename($_FILES['fileP']['name']);
	
	//verifier existance
	$sqlFP=mysql_query("SELECT * from personnel_info where imgP like '%$FP'");
		$max1P=mysql_num_rows($sqlFP);
		$max1P++;
		$fichierNameP=$max1P.'-'.$FP;
	//
	$fichier1P=$_FILES['fileP']['tmp_name'];
    // $taille=filesize($fichier['tmp_name'][$i]);
   	//$typeF=$fichier['type'][$i];
	rename($FP,$fichierNameP);
    $destinationP='../image/profil/'.$fichierNameP;	
	if(move_uploaded_file($fichier1P,$destinationP)){
	$sql = "INSERT INTO personnel_info(matricule, NCIN, nom,contrat, category, dateN, adresse1, adresse2, salaire,mail,typeS,conge_acc,conge_res,imgP,CNSS) VALUES ('$mat','$ncin','$np','$contrat','$cat','$dateN','$ad1','$ad2','$salaire','$mail','$typeS','$conge','$congeR','$destinationP','$cnss')";
	}else{
	 echo("Contactez le responsable Systéme SVP !!");
	}		
}


if (!mysql_query($sql)) {
die('Error: ' . mysql_error()); 
header('Location: ../pages/ajout_personnel.php?status=fail');
}else{
$i=0;
$j=0;
$k=0;
//Personnel TEL 
while($nbr>$i){
$i++;
 
 $T="tel".$i;
 $P="P".$i;
 
 $v1=$_POST[$T];
 $v2=$_POST[$P];

	$sql=mysql_query("INSERT INTO personnel_tel(matricule, tel,proprietor)
	VALUES ('$mat','$v1','$v2')");
 
}
//Personnel Diplome
while($nbr2>$j){
$j++;

 $d="diplome".$j;
 $a="dipA".$j;
 
 $v1=$_POST[$d];
 $v2=$_POST[$a];

	$sqlD=mysql_query("INSERT INTO personnel_diplome(matricule, diplome,annee)
	VALUES ('$mat','$v1','$v2')");
 
}
//Personnel formation starz 
while($nbr3>$k){
$k++;

 $k1="FS".$k;
 //$k4="mFS".$k;
 //$k2="dateDF".$k;
 //$k3="dateFF".$k;
 
 $v1C=$_POST[$k1];
 //$v2C=$_POST[$k2];
 //$v3C=$_POST[$k3];
 //$v4C=$_POST[$k4];

	$sqlC=mysql_query("INSERT INTO personnel_starz_formation (matricule,Formation)
	VALUES ('$mat','$v1C')");
 
}
///Personnel Note 
$sqlN=mysql_query("INSERT INTO personnel_note (matricule, note , dateN)
	VALUES ('$mat','$note',NOW())");
///Personnel Date entrée
$sqlDE=mysql_query("INSERT INTO personnel_datee (matricule,dateH,statut)
	VALUES ('$mat','$dateE','E')");
///Traitement du fichier 
$fichier = $_FILES['cv']; 
for($i=0; $i<count($fichier['name']); $i++) {	
	$F=$fichier['name'][$i];
	//verifier existance
	$sqlF=mysql_query("SELECT * from personnel_cv where nameF like '%$F'");
		$max1=mysql_num_rows($sqlF);
		$max1++;
		$fichierName=$max1.'-'.$F;
	//
	$fichier1=$fichier['tmp_name'][$i];	
    // $taille=filesize($fichier['tmp_name'][$i]);
   	//$typeF=$fichier['type'][$i];
	rename($F,$fichierName);
    $destination='../files/personnel/'.$fichierName;	
	if(move_uploaded_file($fichier1,$destination)){
	 $sql1=mysql_query("INSERT INTO personnel_cv(name_F,upDateF, dataF,matricule) VALUES ('$fichierName',NOW(),'$destination','$mat')");
	}else{
	 echo("Contactez le responsable Systéme SVP !!");
	}


}
//Gestion des congés
$sqlCon=mysql_query("INSERT INTO personnel_conge_annuel(yearC, matricule, conge_acc, conge_res) VALUES ('$year','$mat','$conge','$congeR')");
	
///////////FIN///////	
	$userid=$_SESSION['userID'];
	$msg="a ajouté un nouveau personnel ,Matricule: <b>".$mat."</b>";
    $His=mysql_query("INSERT INTO historique(user_id,action,tab,ligne,date_heure)VALUES('$userid','$msg','personnel_info','$mat',NOW())"); 
    header('Location: ../pages/ajout_personnel.php?status=sent');

}  

?>