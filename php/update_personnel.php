<?php
session_start();
include('../connexion/connexionDB.php');
$mat = $_POST['mat'];
$ncin= $_POST['ncin'];
$cnss=@$_POST['cnss'];
$nom= $_POST['nom'];
$typeS= $_POST['typeS'];
$dateN= $_POST['dateN'];
$ad1= $_POST['ad1'];
$ad2= $_POST['ad2'];
$contrat= $_POST['contrat'];
$cat= $_POST['cat'];
$salaire= $_POST['salaire'];
$dateE=@$_POST['dateE'];
$salaireI=@$_POST['salaireI'];
$mail= $_POST['mail'];
$nbr=$_POST['nbr'];
$nbr2=$_POST['nbr2'];
$nbr3=$_POST['nbr3'];
$nbr4=$_POST['nbr4'];
// photo personnel 
if(!file_exists($_FILES['fileP']['tmp_name'])){
    $sql = "UPDATE personnel_info SET NCIN='$ncin',nom='$nom',mail='$mail',contrat='$contrat',category='$cat',dateN='$dateN',adresse1='$ad1',adresse2='$ad2',salaire='$salaire',salaireI='$salaireI',typeS='$typeS',CNSS='$cnss' WHERE matricule='$mat'";
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
        $sql = "UPDATE personnel_info SET NCIN='$ncin',nom='$nom',mail='$mail',contrat='$contrat',category='$cat',dateN='$dateN',adresse1='$ad1',adresse2='$ad2',salaire='$salaire',salaireI='$salaireI',imgP='$destinationP' WHERE matricule='$mat'";
    }else{
        echo("Contactez le responsable Systéme SVP !!");
    }
}
if (!mysql_query($sql)) {
    die('Error: ' . mysql_error());
}else{
    $i=0;
    $y=0;
    $i4=0;
//DateE
    if($dateE != "" && $dateE != "0000-00-00"){
        $sqlE = mysql_query("SELECT idDE FROM personnel_datee where matricule='$mat'");
        $nbrE=mysql_num_rows($sqlE);
        $nbrE=$nbrE-1;
        $idDE=mysql_result($sqlE,$nbrE);
        $sqlE1=mysql_query("UPDATE personnel_datee set dateE='$dateE' where idDE='$idDE'");
    }
//Personnel TEL 
    $sql2=mysql_query("DELETE FROM personnel_tel where 	matricule='$mat'");
    while($nbr>$i){
        $i++;
        $T="tel".$i;
        $P="P".$i;
        $v1=$_POST[$T];
        $v2=$_POST[$P];
        $sql=mysql_query("INSERT INTO personnel_tel(matricule, tel,proprietor)
	VALUES ('$mat','$v1','$v2')");
    }
//Personnel Training
    $sql2=mysql_query("DELETE FROM personnel_starz_formation where 	matricule='$mat'");
    while($nbr4>$i4){
        $i4++;
        $FS="FS".$i4;
        $F=$_POST[$FS];
        $sql=mysql_query("INSERT INTO personnel_starz_formation(matricule, Formation)
	VALUES ('$mat','$F')");
    }
//Personnel Diplome
    $sql2=mysql_query("DELETE FROM personnel_diplome where 	matricule='$mat'");
    while($nbr3>$y){
        $y++;
        $d="diplome".$y;
        $a="dipA".$y;
        $v1=$_POST[$d];
        $v2=$_POST[$a];
        $sql=mysql_query("INSERT INTO personnel_diplome(matricule, diplome,annee)
	VALUES ('$mat','$v1','$v2')");
    }
///Personnel Note 
    $j=0;
    if($nbr2==0){//supression des notes
        $sql2=mysql_query("DELETE FROM personnel_note where matricule='$mat'");
    }else{
        while($nbr2>$j){
            $j++;
            $N="note".$j;
            $NS="noteS".$j;
            $v1=$_POST[$N];
            if(isset($_POST[$NS])){
                $idPN=$_POST[$NS];
                $sql=mysql_query("UPDATE personnel_note SET note='$v1' where idPN='$idPN'");
            }else{
                $sql=mysql_query("INSERT INTO personnel_note (matricule, note , dateN) 	VALUES ('$mat','$v1',NOW())");
            }
        }
    }
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
///////////FIN///////	
    $userid=$_SESSION['userID'];
    $msg="a modifié les cordonnées du personnel ayant le matricule: <b>".$mat."</b>";
    $His=mysql_query("INSERT INTO historique(user_id,action,tab,ligne,date_heure)VALUES('$userid','$msg','personnel_info','$mat',NOW())");
    header('Location: ../pages/consult_personnel.php?status=sent');
}
?>