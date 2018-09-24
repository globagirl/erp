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
$client=$_POST['client'];
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
 	$PO=$objPHPExcel->getActiveSheet()->getCell("B".$rowIndex)->getValue();
 	$item=$objPHPExcel->getActiveSheet()->getCell("C".$rowIndex)->getValue();
 	$qty=$objPHPExcel->getActiveSheet()->getCell("D".$rowIndex)->getValue();
 	$long=$objPHPExcel->getActiveSheet()->getCell("E".$rowIndex)->getValue();
  $UPC=$objPHPExcel->getActiveSheet()->getCell("F".$rowIndex)->getValue();
	$cell_4 = $objPHPExcel->getActiveSheet()->getCell("A".$rowIndex) ;
    $timestamp = PHPExcel_Shared_Date::ExcelToPHP($cell_4->getValue());

    $dateE = date('Y-m-d',$timestamp);
//Date Client
$dateC = strtotime($dateE."+ 7 days");
$dateC= date('Y-m-d', $dateC);
//
//echo 'Date  '.$date."\r\n" ;
if($PO != "" and $dateE > "2016-07-1"){
$sql = mysql_query("SELECT POitem from commande_items where POitem='$PO'");
if(mysql_num_rows($sql) ==0){
$sql1 = mysql_query("SELECT code_produit from produit1 where code_produit LIKE '%$item%' and longueur LIKE '$long'");
if(mysql_num_rows($sql1) != 0){
$produit=mysql_result($sql1,0);
//selection prix produit
$sq=mysql_query("select  price from  prices where ((IDproduit='$produit') and (marginL <= '$qty')and (marginH >='$qty' or marginH ='-1')) ");
if(mysql_num_rows($sq)==0){
$note=$note."<br> Erreur PO ".$PO." :Le prix du  produit ".$item." n'existe pas !! ";
}else{
//Insertion de la commande
$prixU=mysql_result($sq,0);
$prixT=$prixU*$qty;

     //Priority
    $SQ1=mysql_query("SELECT count(PR) FROM commande2 where date_exped='$dateE'");
    $PR=mysql_result($SQ1,0);
	$PR++;

$sql2 = "INSERT INTO commande2(PO,UPC,date_ent_cmd,date_demande_client,date_exped,client,qte_demande,terme_pay,prix_total,devise,PR)
VALUES  ('$PO','$UPC',NOW(),'$dateC','$dateE','$client','$qty','$tpay','$prixT','$devise','$PR')";


if (!mysql_query($sql2)) {
die('Error: ' . mysql_error());
    header('Location: ../pages/ajout_commande_no.php?status=fail');
}else{
	$sql3=mysql_query("INSERT INTO commande_items(POitem, PO, produit, qty, prixU, prixT,dateExp, statut)
	VALUES ('$PO','$PO','$produit','$qty','$prixU','$prixT','$dateE','waiting')");

}
}//Fin vérification prix produit
}else{
$item=strtoupper($item);
if(( $item!= "ACHAT") and ($item != "ORDER") and ($item != null) and ($item != 'PRODUIT')){
     $note=$note."<br> Erreur PO  ".$PO." :Le produit ".$item." n'existe pas !! ";
}
}//Fin ajout NOTE

}//Fin vérification exictance commande
else{ //Update commande
$sqlS=mysql_query("SELECT statut from commande_items where PO LIKE '$PO' or PO ='$PO'");
$statut=@mysql_result($sqlS,0);
if($statut=='waiting'){//Pas d'OF
$sql1 = mysql_query("SELECT code_produit from produit1 where code_produit LIKE '%$item%' and longueur='$long'");
if(mysql_num_rows($sql1) != 0){
$produit=mysql_result($sql1,0);
//selection prix produit
$sq=mysql_query("select  price from  prices where ((IDproduit='$produit') and (marginL <= '$qty')and ((marginH >='$qty') or (marginH ='-1'))) ");
if(mysql_num_rows($sq)==0){
$note=$note."<br> UPDATE==> Erreur PO ".$PO." :Le prix du  produit ".$item." n'existe pas !! ";
}else{ //Update de la commande waiting

$prixU=mysql_result($sq,0);
$prixT=$prixU*$qty;
if($dateE > "2017-11-11"){
   $sql2 =mysql_query("UPDATE commande2 SET UPC='$UPC',client='$client',date_demande_client='$dateC',date_exped='$dateE',qte_demande='$qty',prix_total='$prixT' WHERE PO='$PO'");
}else{
  $sql2 =mysql_query("UPDATE commande2 SET date_demande_client='$dateC',date_exped='$dateE',qte_demande='$qty',prix_total='$prixT' WHERE PO='$PO'");
}
$sql3=mysql_query("UPDATE commande_items SET  produit='$produit', qty='$qty', prixU='$prixU', prixT='$prixT', dateExp='$dateE' where POitem='$PO'");
} //Fin vérification prix produit
} //Fin vérification existance produit
else{
$item=strtoupper($item);
if(( $item!= "ACHAT") and ($item != "ORDER") and ($item != null) and ($item != 'PRODUIT')){
$note=$note."<br> UPDATE ==>Erreur PO  ".$PO." :Le produit ".$item." n'existe pas !! ";
}

} //FIN ajout NOTE
} //FIN verification statut
/*else{
$sql2 =mysql_query("UPDATE commande2 SET date_demande_client='$dateC',date_exped='$dateE' WHERE PO='$PO'");
}*/
} //Fin update commande

} //Fin vérification par date
}
mysql_close();
if($note == ""){
  header('Location: ../pages/ajout_commande_auto.php?status=sent');
  }else{
  echo('<p>'.$note.'</p><br><a href="../pages/ajout_commande_auto.php">retour >></a>');
  }
}else{
  header('Location: ../pages/ajout_commande_auto.php?status=fail');
  }

?>
