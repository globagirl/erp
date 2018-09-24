<?php
//Base de donnée
session_start();
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
$nom=$_SESSION['userName'];
$four=$_POST['four'];
$devise=$_POST['devise'];
$userID=$_SESSION['userID'];
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
 	$article=$objPHPExcel->getActiveSheet()->getCell("A".$rowIndex)->getValue();
 	//$desc=$objPHPExcel->getActiveSheet()->getCell("B".$rowIndex)->getValue();
  //$X=$objPHPExcel->getActiveSheet()->getCell("C".$rowIndex)->getValue();
 	//$prixOld=$objPHPExcel->getActiveSheet()->getCell("D".$rowIndex)->getValue();
  $prix=$objPHPExcel->getActiveSheet()->getCell("B".$rowIndex)->getValue();
 	//$typeA=$objPHPExcel->getActiveSheet()->getCell("E".$rowIndex)->getValue();
 	//$unit=$objPHPExcel->getActiveSheet()->getCell("F".$rowIndex)->getValue();
  /*
	if($article != ""){
	    $prix=$prixT/$X;
		  $prix=round($prix,4);
        $sql = "INSERT INTO article1 (code_article,typeA, description,supplier, stock, stock_min,prix,devise,unit,catA)
        VALUES ('$article','$typeA', '$desc','$four', 0, 0,'$prix','$devise','$unit','Production')";
        if (!mysql_query($sql)) {

        }
    }
}*/
  $sql1=mysql_query("SELECT prix FROM article1 WHERE code_article='$article'");
  /*if (!mysql_query($sql1)) {
    $note=$note."<br>Ancien prix non trouvé : ".$article;
  }else{*/
    $prixOld=@mysql_result($sql1,0);
    if($prixOld != $prix){
    $sql2="UPDATE article1 SET prix='$prix',catA='Production' WHERE code_article='$article'";
			if (!mysql_query($sql2)) {
        $note=$note."<br>".$article;
			}else{
          $x=rand(1,999);
          $y=rand(8,989);
          $idH='four'.$y.$x;
          $msg="Retour aux prix quotation fichier reçu le 29/03/2018 de la part de linda";
          $q2="INSERT INTO historique_prices(idH,cl_four,item,ancien_prix,nouveau_prix, dateM, operateur,typeH)
                          VALUES ('$idH','$four','$article','$prixOld','$prix',NOW(),'$nom','fournisseur')";
          $sql3=mysql_query("INSERT INTO update_prices_item(ID, four, item, ancien_prix, nouveau_prix, dateM, operateur, description) VALUES
                          ('$idH','$four','$article','$prixOld','$prix',NOW(),'$userID','$msg')");
          $note=$note."<br>Article :".$article." Ancien prix :".$prixOld." Nouveau prix:".$prix;
          if (!mysql_query($q2)) {
             $note=$note."<br>Historique prix non ajouté :".$article;
			   }
      }
    }
  //}
}
mysql_close();
if($note == ""){
  header('Location: ../pages/ajout_article_auto.php?status=sent');
  }else{
  echo('<p>'.$note.'</p><br><a href="../pages/ajout_article_auto.php">retour >></a>');
  }
}else{
  header('Location: ../pages/ajout_article_auto.php?status=fail');
  }

?>
