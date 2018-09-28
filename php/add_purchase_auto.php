<?php
/**
 * Created by PhpStorm.
 * User: Mustapha
 * Date: 28/09/2018
 * Time: 15:44
 */
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
$fournisseur=$_POST['fournisseur'];
$devise=$_POST['devise'];
$tpay=$_POST['tpay'];
//File
$fichier = basename($_FILES['fileP']['name']);
$extension = strrchr($_FILES['fileP']['name'], '.');
if($extension==".xlsx"){
    $fichier1=$_FILES['fileP']['tmp_name'];
    $objPHPExcel = $objReader->load($fichier1);
    $rowIterator = $objPHPExcel->getActiveSheet()->getRowIterator();
    $note="";
    foreach($rowIterator as $row) {
        $rowIndex = $row->getRowIndex ();
        $IDordre=$objPHPExcel->getActiveSheet()->getCell("B".$rowIndex)->getValue();
        $cell_4 = $objPHPExcel->getActiveSheet()->getCell("A".$rowIndex) ;
        $timestamp = PHPExcel_Shared_Date::ExcelToPHP($cell_4->getValue());
        $dateE = date('Y-m-d',$timestamp);
//Date Client
//        $dateC = strtotime($dateE."+ 7 days");
//        $dateC= date('Y-m-d', $dateC);
//echo 'Date  '.$date."\r\n" ;
        if($IDordre != "" and $dateE > "2016-07-1"){
            $sql = mysql_query("SELECT IDordre from ordre_achat2 where IDordre='$IDordre'");
            if(mysql_num_rows($sql) !=0){
                //Update purchse
                $sql2 =mysql_query("UPDATE ordre_achat2 SET Date_prevue='$dateE' WHERE IDordre='$IDordre'");
                $sql3=mysql_query("UPDATE ordre_achat_article1 SET Date_prevue='$dateE' where IDordre='$IDordre'");
            } //Fin vérification prix produit
        } //Fin vérification existance produit
        else{
            $item=strtoupper($item);
            if(( $item!= "ACHAT") and ($item != "ORDER") and ($item != null) and ($item != 'PRODUIT')){
                $note=$note."<br> UPDATE ==>Error Purchase  ".$IDordre." : Invalid ID !! ";
            }
        } //FIN ajout NOTE
    } //FIN verification statut
    /*else{
    $sql2 =mysql_query("UPDATE commande2 SET date_demande_client='$dateC',date_exped='$dateE' WHERE PO='$PO'");
    }*/

    mysql_close();
    if($note == ""){
        header('Location: ../pages/add_purchase_auto.php?status=sent');
    }else{
        echo('<p>'.$note.'</p><br><a href="../pages/add_purchase_auto.php"> >>Return </a>');
    }
}else{
    header('Location: ../pages/add_purchase_auto.php?status=fail');
}
?>