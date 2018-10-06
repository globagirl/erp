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
$cl_four=@$_POST['cl_four'];
$valeur=@$_POST['valeur'];
$noteUpdate=$_POST['note'];
$nom=$_SESSION['userName'];
$userID=$_SESSION['userID'];
$note="Check your file extension PLZ !!";
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
        $PN=$objPHPExcel->getActiveSheet()->getCell("A".$rowIndex)->getValue();
        $prixU=$objPHPExcel->getActiveSheet()->getCell("B".$rowIndex)->getValue();
        //Update prices produit
        if($cl_four=="client"){
            $sq=mysql_query("select price from prices where IDproduit='$PN' and marginL='1' and marginH='-1'");
            if (mysql_num_rows($sq)>0){
                $prixA=@mysql_result($sq,0);
                $epsilon = 0.00001;
                if(abs($prixA - $prixU) < $epsilon){
                    $note=$note."<br> The product price : ".$PN." hasn't been updated. ";
                }else{
                    $x=rand(1,999);
                    $y=rand(8,989);
                    $idH='cl'.$y.$x;
                    $q1=mysql_query("UPDATE  prices SET price='$prixU' where IDproduit='$PN' and marginL='1' and marginH='-1'");
                    $q2=mysql_query("INSERT INTO historique_prices(idH,item,ancien_prix,nouveau_prix, dateM, operateur,typeH) VALUES ('$idH','$PN','$prixA','$prixU',NOW(),'$nom','client')");
                    $sql3=mysql_query("INSERT INTO update_prices_product(ID, client, item, ancien_prix, nouveau_prix, dateM, operateur, description) VALUES
                  ('$idH','$valeur','$PN','$prixA','$prixU',NOW(),'$userID','$noteUpdate')");
                    $sql2=mysql_query("UPDATE commande_items SET prixU='$prixU'  WHERE produit='$PN' and statut != 'closed'");
                    $note=$note."<br><b> The product price : ".$PN." has been updated, check price PLZ</b> ";
                }
            }else{
                $note=$note."<br> The Product ".$PN." doesn't exist. ";
            }
        }else{
            $sq=mysql_query("select prix from article1 where code_article='$PN'");
            if (mysql_num_rows($sq)>0){
                $priceA=mysql_result($sq,0);
                $x=rand(1,999);
                $y=rand(8,999);
                $z=rand(1,99);
                $idH='f'.$x.$y.$z;
                $sql1=mysql_query("UPDATE  article1 SET prix='$prixU' where code_article='$PN'");
                $sql2=mysql_query("INSERT INTO historique_prices(idH,cl_four,item,ancien_prix,nouveau_prix, dateM, operateur,typeH)
                        VALUES ('$idH','$valeur','$PN','$priceA','$prixU',NOW(),'$userID','$cl_four')");
                $sql3=mysql_query("INSERT INTO update_prices_item(ID, four, item, ancien_prix, nouveau_prix, dateM, operateur, description) 
                VALUES ('$idH','$valeur','$PN','$priceA','$prixU',NOW(),'$userID','$noteUpdate')");
            }else{
                $note=$note."<br>Article ".$PN." doesn't exist. ";
            }
        }
    }

}
mysql_close();
if($note == ""){
    header('Location: ../pages/update_price.php?status=sent');
    //echo "OK";
}else{
    echo('<p>'.$note.'</p><br><a href="../pages/update_price.php">>>RETURN</a>');
}
?>
