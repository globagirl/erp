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
$desc=@$_POST['desc'];

$note="";
//File
$fichier = basename($_FILES['fileP']['name']);
$extension = strrchr($_FILES['fileP']['name'], '.');
if($extension==".xlsx"){
$fichier1=$_FILES['fileP']['tmp_name'];
$objPHPExcel = $objReader->load($fichier1);
$rowIterator = $objPHPExcel->getActiveSheet()->getRowIterator();

foreach($rowIterator as $row) {
 
    $rowIndex = $row->getRowIndex ();
 	
 	$prdL=$objPHPExcel->getActiveSheet()->getCell("A".$rowIndex)->getValue();
 	$rev=$objPHPExcel->getActiveSheet()->getCell("B".$rowIndex)->getValue();
  
	$sql=mysql_query("SELECT produit FROM produit1 where code_produit ='$prdL'");
	$prd=mysql_result($sql,0);
	$sql1="UPDATE produit1 SET draw_rev='$rev' where produit ='$prd'";


if (!mysql_query($sql1)) {
    $note=$note."<br>Non inséré :".$prd;
}



}
if($note == ""){
  header('Location: ../pages/excel_to_sql.php?status=sent');
  }else{
  echo('<p>'.$note.'</p><br><a href="../pages/excel_to_sql.php">retour >></a>');
  }
}else{
  header('Location: ../pages/excel_to_sql.php?status=fail');
  }
  mysql_close();
?>