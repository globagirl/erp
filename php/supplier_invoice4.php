<?php
    ///service , credit note , expence
    session_start();
	$IDoperateur=$_SESSION['userID'];
	include('../connexion/connexionDB.php');
	$invoice=@$_POST['invoice'];
	$supplier=@$_POST['supplier'];
	$total=@$_POST['total'];
	$devise=@$_POST['devise'];
	$typeI=@$_POST['typeI'];
    $catI=@$_POST['catI'];
    $dateP=@$_POST['dateP'];
    $dateF=@$_POST['dateF'];
    $coursTND=@$_POST['coursTND'];
      $invoiceCredit=@$_POST['invoiceCredit'];
	if($dateP==""){
	$dateP=date("Y-m-d");
	}
    $invoice='-'.$invoice;
    $sql2S=mysql_query("SELECT IDinvoice,supplier from supplier_invoice where IDinvoice like '%$invoice'");
	$max=mysql_num_rows($sql2S);
	$max++;
	$IDinvoice=$max.$invoice;
    ///Traitement du fichier
	$fichier = $_FILES['imgFact'];
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
    if(isset($_POST['paid1'])){//si la facture est déja payé
		$modePay=$_POST['modeP1'];
    $sql2="INSERT INTO supplier_invoice(IDinvoice, supplier, dateE,dateF,dateP,total,currency,coursTND, status,typeI,catI,invoiceCredit)
     VALUES ('$IDinvoice','$supplier',NOW(),'$dateF','$dateP','$total','$devise','$coursTND','paid','$typeI','$catI','$invoiceCredit')";
		if (!mysql_query($sql2)) {
            die('Error: ' . mysql_error());
            header('Location: ../pages/supplier_invoice.php?status=fail');
        }else{
            if(($modePay=='Virement') || ($modePay=='Cheque')){
			    $ref = $_POST['ref1'];
				$NC=$_POST['NC1'];
				$sql21=mysql_query("INSERT INTO invoice_mode_pay(reference, modeP, compte, dateP, num_invoice,montant) VALUES ('$ref','$modePay','$NC','$dateP','$IDinvoice','$total')");
			}else{
                if($modePay=='Autre'){
                $ref =@$_POST['ref1'];
				    if($ref != ""){
				        $modePay=$ref;
				    }
			    }
				$sql21=mysql_query("INSERT INTO invoice_mode_pay(modeP, dateP, num_invoice,montant) VALUES ('$modePay','$dateP','$IDinvoice','$total')");
            }
        }
    }else{
            $sql2="INSERT INTO supplier_invoice(IDinvoice, supplier, dateE,dateF,total,currency,coursTND, status,typeI,catI,invoiceCredit) VALUES
            ('$IDinvoice','$supplier',NOW(),'$dateF','$total','$devise','$coursTND','unpaid','$typeI','$catI','$invoiceCredit')";
            if (!mysql_query($sql2)) {
            die('Error: ' . mysql_error());
            header('Location: ../pages/supplier_invoice.php?status=fail');
            }
    }
    }
    /// FIN///////
    //historique
    $msg= "  a crée la facture  N°   ".$IDinvoice."";
	$HIS=mysql_query("INSERT INTO historique(user_id,action,tab,ligne,date_heure)VALUES('$IDoperateur','$msg','Invoice','$IDinvoice',NOW())");
	//
	mysql_close();
	//Redirection
	header('Location: ../pages/supplier_invoice.php?status=sent');
?>
