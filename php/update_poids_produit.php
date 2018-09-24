<?php
//Base de donnée 
include('../connexion/connexionDB.php');
//Traitement des erreur
error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);

//Ouvrir la bibliothéque PHPExcel 
require_once('../PHPExcel/Classes/PHPExcel.php');

// Ouvrir un fichier Excel en lecture
$objReader = PHPExcel_IOFactory::createReader('Excel2007');
//Pause
$cat=$_POST['cat'];

$note="Vérifier votre extension de fichier SVP !!";

//File
$fichier = basename($_FILES['fileP']['name']);
$extension = strrchr($_FILES['fileP']['name'], '.');
if($extension==".xlsx"){
    $fichier1=$_FILES['fileP']['tmp_name'];
		$objPHPExcel = $objReader->load($fichier1);
		$rowIterator = $objPHPExcel->getActiveSheet()->getRowIterator();
		$note="";
		$i=0;
    foreach($rowIterator as $row) {
      $i++;
      $rowIndex = $row->getRowIndex ();
		    $long=$objPHPExcel->getActiveSheet()->getCell("A".$rowIndex)->getValue();
			$poids=$objPHPExcel->getActiveSheet()->getCell("B".$rowIndex)->getValue();
		
		if($i>1){	
				$sql2=mysql_query("UPDATE produit1 SET poids='$poids' WHERE categorie='$cat' and longueur='$long' ");
					 

		}
    }
		
}
    mysql_close();
    if($note == ""){
      header('Location: ../pages/update_poids_produit.php?status=sent');
		 //echo "OK";
    }else{
      echo('<p>'.$note.'</p><br><a href="../pages/update_poids_produit.php">retour >></a>');
    }
?>