<?php
session_start(); //Multiple service
$IDoperateur=$_SESSION['userID'];
include('../connexion/connexionDB.php');
$supplier=@$_POST['supplier'];
$catI=@$_POST['catI'];
$nbr=@$_POST['nbr'];
$typeI="Service";
$x=0;
//echo $nbr."<br>";
while($x<$nbr){
    $x++;
    //echo $x."<br>";
	$invN="inv".$x;
	$totalN="total".$x;
	$imgN="imgFact".$x;
	$paidN="paid".$x;
	$deviseN="devise".$x;
	$coursTNDN="coursTND".$x;
	$invoice=@$_POST[$invN];
	$total=@$_POST[$totalN];
    $devise=@$_POST[$deviseN];
    $coursTND=@$_POST[$coursTNDN];
	$invoice='-'.$invoice;
	$sql2S=mysql_query("SELECT IDinvoice from supplier_invoice where IDinvoice like '%$invoice'");
	$max=mysql_num_rows($sql2S);
	$max++;
	$IDinvoice=$max.$invoice;

    if(isset($_POST[$paidN])){
            $modeP="modeP".$x;
            $dateP="dateP".$x;
            $dateF="dateF".$x;
            $modePay=$_POST[$modeP];
            $datePay=$_POST[$dateP];			
            $dateFact=$_POST[$dateF];			
            $sql2=mysql_query("INSERT INTO supplier_invoice(IDinvoice, supplier, dateE,dateF,dateP,total,currency,coursTND,status,typeI,catI) VALUES ('$IDinvoice','$supplier',NOW(),'$dateFact','$datePay','$total','$devise','$coursTND','paid','$typeI','$catI')");
			if(($modePay=='Virement') || ($modePay=='Cheque')){
			    $refP="ref".$x;			    
			    $NCP="NC".$x;
			    $ref = $_POST[$refP];				
				$NC=$_POST[$NCP];
				$sql21=mysql_query("INSERT INTO invoice_mode_pay(reference, modeP, compte, dateP, num_invoice,montant) VALUES ('$ref','$modePay','$NC','$datePay','$IDinvoice','$total')");
			}else{
                if($modePay=='Autre'){
			    $refP="ref".$x;
                $ref =@$_POST[$refP];
				    if($ref != ""){
				        $modePay=$ref;
				    }
			    }
				$sql21=mysql_query("INSERT INTO invoice_mode_pay(modeP,dateP, num_invoice,montant) VALUES ('$modePay','$datePay','$IDinvoice','$total')");
            }
 
   }else{
   $sql1=mysql_query("INSERT INTO supplier_invoice(IDinvoice, supplier, dateE,total,currency,coursTND, status,typeI,catI,fileI) VALUES 
   ('$IDinvoice','$supplier',NOW(),'$total','$devise','$coursTND','unpaid','$typeI','$catI','$fichierName')");
   }
   ///Traitement du fichier 
	$fichier = $_FILES[$imgN];
	for($i=0; $i<count($fichier['name']); $i++) {
	
	$F=$fichier['name'][$i];
	//verifier existance
	$sqlF=mysql_query("SELECT * from invoice_files where nameF like '%$F'");
		$max1=mysql_num_rows($sqlF);
		$max1++;
		$fichierName=$max1.'-'.$F;
	//
	$fichier1=$fichier['tmp_name'][$i];	
    $taille=filesize($fichier['tmp_name'][$i]);
   	$typeF=$fichier['type'][$i];
	rename($F,$fichierName);
    $destination='../files/invoices/'.$fichierName;	
	if(move_uploaded_file($fichier1,$destination)){
	 $sql1=mysql_query("INSERT INTO invoice_files(nameF, typeF, sizeF, upDateF, dataF,IDinvoice) VALUES ('$fichierName','$typeF','$taille',NOW(),'$destination','$IDinvoice')");
	}else{
	 echo("Contactez le responsable Systéme SVP !!");
	}
	}
///////////FIN///////
 /*
 //historique
       $msg= "  a crée la facture  N°   ".$IDinvoice."";
	   $HIS=mysql_query("INSERT INTO historique(user_id,action,tab,ligne,date_heure)VALUES('$IDoperateur','$msg','Invoice','$IDinvoice',NOW())"); 
	   //
	   */
}	 
      mysql_close();  
	  header('Location: ../pages/supplier_invoice.php?status=sent');
?>