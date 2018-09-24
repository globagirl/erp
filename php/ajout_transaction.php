<?php
session_start();
include('../connexion/connexionDB.php');
    $userID=$_SESSION['userID'];
	  $sqlC=mysql_query("SELECT max(IDtrans) FROM transaction_compte");
    $IDtrans=@mysql_result($sqlC,0);
	  $IDtrans++;
    $compte = $_POST['compte'];
    //$ref =@$_POST['REF'];
    $typeT =$_POST['typeT'];
    $catT =$_POST['catT'];
    $modeT =$_POST['modeT'];
    $desc =$_POST['DESC'];
    $dateT =$_POST['dateT'];
    $montant =$_POST['montant'];
	  $etat=$_POST['etat'];
	/*
	if(isset($_POST['etat'])){
	    $etat =$_POST['etat'];
	}else{
	    $etat='R';
	}*/
	if(isset($_POST['REF'])){
	    $ref =$_POST['REF'];
	}else{
	    $ref="";
	}


    $sql1=mysql_query("INSERT INTO transaction_compte(IDtrans,compte,ref,typeT,modeT,catT,description, etat,dateT,montant,dateE) VALUES ('$IDtrans','$compte','$ref','$typeT','$modeT','$catT','$desc','$etat','$dateT','$montant',NOW())");

	if($etat =='R'){
	    if($typeT == 'RT'){
		    $sql2=mysql_query("UPDATE compte_banque SET soldeR=soldeR-'$montant' WHERE REFcompte='$compte'");
		}else{
	        $sql2=mysql_query("UPDATE compte_banque SET soldeR=soldeR+'$montant' WHERE REFcompte='$compte'");
		}
	}
  $msg= " Nouveau payment du Client :  <b>".$catT."</b><br><b>Montant : </b> ".$montant." ";
  if($catT=="TYCO" ||$catT=="CommeScope" || $catT=="C.Scope" ){
    $sql4=mysql_query("INSERT INTO notification(emetteur, destinataire, message, dateN,chemin) VALUES ('$userID','COM','$msg',NOW(),'msg')");
    $sql4=mysql_query("INSERT INTO notification(emetteur, destinataire, message, dateN,chemin) VALUES ('$userID','FIN','$msg',NOW(),'msg')");

  }


	$msg="a ajouté la transaction N° <b>".$IDtrans."</b>";
    $His=mysql_query("INSERT INTO historique(user_id,action,tab,ligne,date_heure)VALUES('$userID','$msg','ajout_transaction','$IDtrans',NOW())");
    mysql_close();
    header('Location: ../pages/ajout_transaction.php');
?>
