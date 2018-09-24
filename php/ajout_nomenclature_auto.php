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
$nbrC=$_POST['nbrC'];
$note="Vérifier votre extension de fichier SVP !!";

//File
$fichier = basename($_FILES['fileP1']['name']);
$extension = strrchr($_FILES['fileP1']['name'], '.');
if($extension==".xlsx"){
    $fichier1=$_FILES['fileP1']['tmp_name'];
	$objPHPExcel = $objReader->load($fichier1);
	$rowIterator = $objPHPExcel->getActiveSheet()->getRowIterator();
	$note="";
	$i=0;
    foreach($rowIterator as $row) {
        $i++;
        if($i>1){
            $code=65;
            $rowIndex = $row->getRowIndex ();
		        $PN=$objPHPExcel->getActiveSheet()->getCell("A".$rowIndex)->getValue();
            for ($nombre_de_lignes = 1; $nombre_de_lignes <= $nbrC; $nombre_de_lignes++){
                $code++;
                $col=chr($code);
                $article=$objPHPExcel->getActiveSheet()->getCell($col.$rowIndex)->getValue();
                $code++;
                $col=chr($code);
                $qte=$objPHPExcel->getActiveSheet()->getCell($col.$rowIndex)->getValue();
                $sq=mysql_query("SELECT * from  produit_article1 where IDproduit='$PN' and IDarticle='$article'");
                if(mysql_num_rows($sq)>0){
                   $note=$note."<br> nomenclature du  produit  ".$PN." et l'article ".$article." a été mise a jour ..";
                   $sql=mysql_query("UPDATE produit_article1 SET qte='$qte' WHERE IDproduit='$PN' and IDarticle='$article'");
                }else {
                  $sql="INSERT INTO produit_article1(IDproduit, IDarticle, qte) VALUES ('$PN','$article','$qte')";
                  if (!mysql_query($sql)) {
                    $note=$note."<br> Vérifier que le produit  ".$PN." et l'article ".$article." existe déja ..";
                  }
                }

            }
        }
    }

}
mysql_close();
if($note == ""){
      header('Location: ../pages/ajout_produit_auto.php?status=sent');
}else{
      echo('<p>'.$note.'</p><br><a href="../pages/ajout_produit_auto.php">retour >></a>');
}
?>
