<?php
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
$client=$_POST['client'];
$cat=$_POST['cat'];
$noteUpdate=$_POST['note'];
$nom=$_SESSION['userName'];
$userID=$_SESSION['userID'];
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
		        $basePN=$objPHPExcel->getActiveSheet()->getCell("A".$rowIndex)->getValue();
			      $PN=$objPHPExcel->getActiveSheet()->getCell("B".$rowIndex)->getValue();
            $desc=$objPHPExcel->getActiveSheet()->getCell("C".$rowIndex)->getValue();
			      $lenght=$objPHPExcel->getActiveSheet()->getCell("D".$rowIndex)->getValue();
            $prixU=$objPHPExcel->getActiveSheet()->getCell("E".$rowIndex)->getValue();
            $MOQ=$objPHPExcel->getActiveSheet()->getCell("F".$rowIndex)->getValue();
			//$color=$objPHPExcel->getActiveSheet()->getCell("D".$rowIndex)->getValue();
			//$weight=$objPHPExcel->getActiveSheet()->getCell("E".$rowIndex)->getValue();
			//$matRev=$objPHPExcel->getActiveSheet()->getCell("F".$rowIndex)->getValue();
			//$drawRev=$objPHPExcel->getActiveSheet()->getCell("G".$rowIndex)->getValue();
			//$Tlot=$objPHPExcel->getActiveSheet()->getCell("H".$rowIndex)->getValue();
			//$MOQ=$objPHPExcel->getActiveSheet()->getCell("I".$rowIndex)->getValue();

		    if($i>1){
			  //Vérification des colonnes
			 /* if((strtoupper($basePN)=="BASE PN") && (strtoupper($PN)=="PN") && (strtoupper($lenght)=="LENGHT") && (strtoupper($color)=="COLOR") &&
				 (strtoupper($weight)=="WEIGHT") && (strtoupper($matRev)=="MAT REV") && (strtoupper($drawRev)=="DRAW REV") &&
				 (strtoupper($Tlot)=="T LOT") && (strtoupper($MOQ)=="MOQ") && (strtoupper($prixU)=="UNIT PRICE")){
				  $i++;
			  }else{
				//Quiiter le traitement
				  $note="Vérifier votre template SVP !! ";
					//echo strtoupper($basePN).' '.strtoupper($PN).' '.$lenght;
				  break;
			  }*/
	     $sq=mysql_query("SELECT taille_lot, nbr_paquet FROM cable_par_carton where length='$lenght' ");
       $data=mysql_fetch_array($sq);
       $TLot=$data['taille_lot'];
       $sql="INSERT INTO produit1(code_produit, produit, categorie, longueur, description, taille_lot, nbr_box, prix)
				VALUES ('$PN','$basePN','$cat','$lenght','$desc','$TLot','$MOQ','$prixU')";
				if (!mysql_query($sql)) {
          	 $sql2=mysql_query("UPDATE produit1 SET produit='$basePN',categorie='$cat', longueur='$lenght',
														 description='$desc',taille_lot='$TLot',
														 nbr_box='$MOQ' WHERE code_produit='$PN'");
            //Update prices
            $sq=mysql_query("select price from prices where IDproduit='$PN' and marginL='1' and marginH='-1'");
            $prixA=@mysql_result($sq,0);
            $epsilon = 0.00001;
             if(abs($prixA - $prixU) < $epsilon){
                  $note=$note."<br> le prix du  produit ".$PN." n'a pas  été mis a jour. ";
             }else{
                  $x=rand(1,999);
                  $y=rand(8,989);
                  $idH='cl'.$y.$x;
                  $q1=mysql_query("UPDATE  prices SET price='$prixU' where IDproduit='$PN' and marginL='1' and marginH='-1'");
                  $q2=mysql_query("INSERT INTO historique_prices(idH,item,ancien_prix,nouveau_prix, dateM, operateur,typeH) VALUES ('$idH','$PN','$prixA','$prixU',NOW(),'$nom','client')");
                  $sql3=mysql_query("INSERT INTO update_prices_product(ID, client, item, ancien_prix, nouveau_prix, dateM, operateur, description) VALUES
                  ('$idH','$client','$PN','$prixA','$prixU',NOW(),'$userID','$noteUpdate')");
                  $sql2=mysql_query("UPDATE commande_items SET prixU='$prixU'  WHERE produit='$PN' and statut != 'closed'");
                  $note=$note."<br><b> le prix du  produit ".$PN." a été mis a jour veillez vérifier le prix SVP</b> ";
            }



				}else{
					//echo "<br>".$PN;
					$sql2=mysql_query("INSERT INTO prices(IDproduit, marginL, marginH, price) VALUES ('$PN','1','-1','$prixU')");
				}

		  }
		}

}
mysql_close();

		if($note == ""){
      header('Location: ../pages/ajout_produit_auto.php?status=sent');
		 //echo "OK";
    }else{
      echo('<p>'.$note.'</p><br><a href="../pages/ajout_produit_auto.php">retour >></a>');
    }
?>
