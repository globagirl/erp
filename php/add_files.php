<?php 
    include('../connexion/connexionDB.php');
    $desc=@$_POST['desc'];
    $type1=@$_POST['type1'];
    $type2=@$_POST['type2'];
    $dossier=@$_POST['dossier'];

	///Traitement du fichier 
	$fichier = basename($_FILES['nameF']['name']);
	$fichier1=$_FILES['nameF']['tmp_name'];
    $taille = filesize($_FILES['nameF']['tmp_name']);
    
    $extension = strrchr($_FILES['nameF']['name'], '.');
    $typeF=$_FILES['nameF']['type'];
    // $destination=$_SERVER['SERVER_NAME'].'/Starz1.1/files/managementFiles/'.$type1.'/'.$type2.'/'.$fichier;
    $destination='../files/managementFiles/'.$dossier.'/'.$type1.'/'.$type2.'/'.$fichier;	
   
	if(move_uploaded_file($fichier1,$destination)){
		if($dossier=="RG45"){
            $destination2= 'RG45/'.$type1.'/'.$type2;
			$sql1=mysql_query("INSERT INTO files_RG45(nameF, description,typeF, sizeF, upDateF, dataF,dossierF,dossier) VALUES ('$fichier','$desc','$typeF','$taille',NOW(),'$destination','$destination2','$type1')");
		}else if($dossier=="UPM3"){	
            $destination2= 'UPM3/'.$type1.'/'.$type2;			
		    $sql1=mysql_query("INSERT INTO files_UPM3(nameF, description,typeF, sizeF, upDateF, dataF,dossierF,dossier) VALUES ('$fichier','$desc','$typeF','$taille',NOW(),'$destination','$destination2','$type1')");
		}
		 header('Location: ../pages/add_files.php?status=sent');
    //echo "<a href=\"../files/invoices/".$fichier."\" target=\"_blank\">Visit W3Schools</a>";  
	}else{
	    echo("Contactez le responsable Systéme SVP !!");
	}
	mysql_close();
?>