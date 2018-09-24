<?php
include('../connexion/connexionDB.php');
// Include the main TCPDF library (search for installation path).
require_once('tcpdf.php');
// Extend the TCPDF class to create custom Header and Footer
class MYPDF extends TCPDF {
    public function Footer() {

 }
}
// create new PDF document
//$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
$i=101.6;
$j=101.6;
$pageLayout = array($i, $j); //  or array($height, $width)
//$pdf = new TCPDF('p', 'mm', $pageLayout, true, 'UTF-8', false);
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, $pageLayout, true, 'UTF-8', false);
// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('PLUTO');


// set default header data
//$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);

// set header and footer fonts
//$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
//$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
//$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
//$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
//$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// set auto page breaks
//$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
$pdf->SetAutoPageBreak(TRUE, 0);
// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
// set some language-dependent strings (optional)
if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
    require_once(dirname(__FILE__).'/lang/eng.php');
    $pdf->setLanguageArray($l);
}

// ---------------------------------------------------------
//Style bar code
$style = array(
     'position' => '',
    'align' => 'C',
    'stretch' => false,
    'fitwidth' => true,
    'cellfitalign' => '',
    'border' => false,
    'hpadding' => 0,
    'vpadding' =>0,
    'fgcolor' => array(0,0,0),
    'bgcolor' => false, //array(255,255,255),
    'text' => false,
    'font' => 'helvetica',
    'fontsize' => 20
	);
//
$PO=$_POST['PO'];
$OF=$_POST['OF'];
$prd=$_POST['prd'];
$desc=$_POST['desc'];
$qty=$_POST['qty'];
$qtyB=$_POST['qtyB'];
$FR=$_POST['FR'];
$nbrB=$_POST['nbrB'];
$dateE=$_POST['dateE'];
$numP=@$_POST['numP'];
//
$DDtime = strtotime($dateE);
$num_semaine = strftime("%W",$DDtime);
$year= strftime("%Y",$DDtime);
$DD=$year.'W'.$num_semaine;

// Calcul du qte par box
$x=$FR-1;
$qtyR=$qty-($qtyB*$x);
//
$nbrB=$nbrB+$x;

//$pdf->SetMargins(0, 0, 0,true);
$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);
//$pdf->setPrintFooter(true);
//Génération Num palette
if($numP!=""){
$pdf->AddPage();
$pdf->SetMargins(0, 0, 0,true);
$pdf->SetFillColor(255,255 ,255);
$pdf->SetTextColor(0,0 ,0);

$pdf->SetXY(0, 18);
$pdf->SetFont('Helvetica', 'B',150);
$pdf->MultiCell('','',$numP, 0, 'C', 0, 0, '', '', false);
}
//
while ($x < $nbrB){
$x++;
if($qtyR>=$qtyB){
  $QTE=$qtyB;
  $qtyR=$qtyR-$qtyB;
}else{
  $QTE=$qtyR;
}
//Ajout a la BD
$IDcarton=$OF.'/'.$x;
$poids=0;
$sq=@mysql_query("SELECT poids FROM produit1 where code_produit='$prd'");
$p1=@mysql_result($sq,0);
$poids=($p1*$QTE)+0.515;
$poids=round($poids,3);
$poidsLB=$poids*2.20462;
$poidsLB=round($poidsLB,3);
$sql=@mysql_query("INSERT INTO carton_palette(IDcarton, OF,PO,IDproduit, qte, poids) VALUES ('$IDcarton','$OF','$PO','$prd','$QTE','$poids')");
//
$pdf->AddPage();
$pdf->SetMargins(0, 0, 0,true);
$pdf->SetFillColor(255,255 ,255);
$pdf->SetTextColor(0,0 ,0);
$pdf->SetXY(4, 3.5);
//logo
//$pdf->Image('../image/CS.png',top, left, larg, long, 'png', '', 'M', false, 300, '', false, false, 0, false, false, false);
$pdf->Image('../image/CS1.jpg','', '', 68, 8, 'jpg', '', 'M', false, 300, '', false, false, 0, false, false, false);

//product ID
$pdf->SetXY(4, 15);
$pdf->SetFont('Helvetica', '', 10);
$pdf->MultiCell('','','(1P)PROD ID', 0, 'L', 0, 0, '', '', true);
$pdf->SetXY(29, 14);
$pdf->SetFont('Helvetica', '', 12);
$pdf->MultiCell('','',$prd, 0, 'L', 0, 0, '', '', true);
//



//$pdf->write1DBarcode($code, 'C39',LEFT , TOP, Logueur,30,10, $style, 'N');
$pdf->SetXY(4, 20.5);
$pdf->write1DBarcode($prd, 'C39','' ,'', 60,8.7,'', $style, 'N');
//
$styleLigne = array('width' => 0.3, 'cap' => 'butt', 'join' => 'mm', 'dash' => 0, 'color' => array(0, 0, 0));
$pdf->Line(0.5, 30, 98.5, 30, $styleLigne);//$pdf->Line(left, p1 hauteur,longueur ,p2 hauteur, $style);


////UPC PROD ID
$re1=@mysql_query("SELECT UPC FROM commande2 where PO='$PO'");
$UPC=@mysql_result($re1,0);
$pdf->SetXY(4, 31);
$pdf->SetFont('Helvetica', '', 10);
$pdf->MultiCell('','','(3P)UPC PROD ID', 0, 'L', 0, 0, '', '', true);
$pdf->SetXY(37, 30);
$pdf->SetFont('Helvetica', '', 12);
$pdf->MultiCell('','',$UPC, 0, 'L', 0, 0, '', '', true);
//
	$pdf->SetXY(4, 36.5);
//$pdf->write1DBarcode($code, 'C39',LEFT , TOP, Logueur,30,10, $style, 'N');
if($UPC != ""){
  $pdf->write1DBarcode($UPC, 'C39','' , '', 60,8.7,'', $style, 'N');
}
//China E
$pdf->SetXY(77, 32);
//$pdf->Image('../image/CS.png',top, left, larg, long, 'png', '', 'M', false, 300, '', false, false, 0, false, false, false);
$pdf->Image('../image/chinaE.png','', '', 10, 10, 'png', '', 'M', false, 300, '', false, false, 0, false, false, false);
$pdf->SetXY(71, 82);
//ligne
$styleLigne = array('width' => 0.3, 'cap' => 'butt', 'join' => 'mm', 'dash' => 0, 'color' => array(0, 0, 0));
$pdf->Line(1.6, 47, 98.5, 47, $styleLigne);//$pdf->Line(left, p1 hauteur,longueur ,p2 hauteur, $style);
//QTY

$pdf->SetFont('Helvetica', '', 10);
$pdf->SetXY(4, 48);
$pdf->MultiCell('','','(Q)QUANTITY', 0, 'L', 0, 0, '', '', true);
$pdf->SetXY(29, 47);
$pdf->SetFont('Helvetica', '', 12);
$pdf->MultiCell('','',$QTE.'EA', 0, 'L', 0, 0, '', '', true);
//
$pdf->SetXY(4, 52.6);
//$pdf->write1DBarcode($code, 'C39',LEFT , TOP, Logueur,30,10, $style, 'N');
$pdf->write1DBarcode($QTE, 'C39','' , '', 20,8.7,'', $style, 'N');

  //ligne
$styleLigne = array('width' => 0.3, 'cap' => 'butt', 'join' => 'mm', 'dash' => 0, 'color' => array(0, 0, 0));
$pdf->Line(0.5, 63, 98.5, 63, $styleLigne);//$pdf->Line(left, p1 hauteur,longueur ,p2 hauteur, $style);
//Description produit

$pdf->SetFont('Helvetica', '', 9);
$pdf->SetXY(4, 65);
$pdf->MultiCell(65,'','PRODUCT DESCRIPTION', 0, 'L', 0, 0, '', '', true);
$pdf->SetXY(4, 70);
$pdf->SetFont('Helvetica', '', 10);
$pdf->MultiCell(59,'',$desc, 0, 'L', 0, 0, '', '', true);
//
$pdf->SetXY(4, 90);
$pdf->SetFont('Helvetica', '', 7);
$pdf->MultiCell('','','For patents see www.CS-pat.com', 0, 'L', 0, 0, '', '', true);

//N° ticket
$pdf->SetXY(95, 90);
$pdf->SetFont('Helvetica', '', 7);
$pdf->MultiCell('','',$x, 0, 'L', 0, 0, '', '', true);
//Agency approval
$pdf->SetXY(67, 68);
//Intertek ETL
//$pdf->Image('../image/CS.png',top, left, larg, long, 'png', '', 'M', false, 300, '', false, false, 0, false, false, false);
//InterteK
$pdf->Image('../image/INTERTEK.jpg','', '', 15, 15, 'jpg', '', 'M', false, 300, '', false, false, 0, false, false, false);
$pdf->SetXY(69, 82);
$pdf->SetFont('Helvetica', '', 6);
$pdf->MultiCell('','','5009497', 0, 'L', 0, 0, '', '', true);
$pdf->SetXY(67, 84);
$pdf->SetFont('Helvetica', '', 6);
$pdf->MultiCell('','','Conforms to UL STD 1863', 0, 'L', 0, 0, '', '', true);
$pdf->SetXY(67, 86);
$pdf->SetFont('Helvetica', '', 6);
$pdf->MultiCell('','','Certified to CSA STD C22.2 No.233 & 182.4', 0, 'L', 0, 0, '', '', true);


//LINE
$styleLigne = array('width' => 0.3, 'cap' => 'butt', 'join' => 'mm', 'dash' => 0, 'color' => array(0, 0, 0));
$pdf->Line(0.5,93.6, 98.5, 93.6, $styleLigne);//$pdf->Line(left, p1 hauteur,longueur ,p2 hauteur, $style);
//

$pdf->SetXY(4, 95);
$pdf->SetFont('Helvetica', '', 8);
$pdf->MultiCell('','','Assembled in Tunisia', 0, 'L', 0, 0, '', '', true);
//RoHS Statement
$pdf->SetXY(67, 50.2);
$pdf->SetFont('Helvetica', '', 6);
$pdf->MultiCell('','','For RoHS Inquiries', 0, 'L', 0, 0, '', '', true);
$pdf->SetXY(67, 52.4);
$pdf->SetFont('Helvetica', '', 6);
$pdf->MultiCell('','','CommScope Inc', 0, 'L', 0, 0, '', '', true);
$pdf->SetXY(67, 55);
$pdf->SetFont('Helvetica', '', 6);
$pdf->MultiCell('','','Corke Abbey , Bray', 0, 'L', 0, 0, '', '', true);
$pdf->SetXY(67, 57.2);
$pdf->SetFont('Helvetica', '', 6);
$pdf->MultiCell('','','Co.Dubblin Ireland', 0, 'L', 0, 0, '', '', true);
$pdf->SetXY(67, 59.4);
$pdf->SetFont('Helvetica', '', 6);
$pdf->MultiCell('','','Attn:Legal Department', 0, 'L', 0, 0, '', '', true);

//
$pdf->SetXY(67, 64.3);
$pdf->SetFont('Helvetica', '', 7);
$pdf->MultiCell('','','ORDER: ', 0, 'L', 0, 0, '', '', true);
$pdf->SetXY(77, 63.4);
$pdf->SetFont('Helvetica', 'B', 9);
$pdf->MultiCell('','',$PO, 0, 'L', 0, 0, '', '', true);

//date
$pdf->SetXY(34, 95);
$pdf->SetFont('Helvetica', '', 8);
$pdf->MultiCell('','',$DD, 0, 'L', 0, 0, '', '', true);
//Building number
$r1=@mysql_query("SELECT client FROM commande2 where PO='$PO'");
$clt=@mysql_result($r1,0);
$r2=@mysql_query("SELECT IDvendeur FROM client1 where name_client='$clt'");
$IDvendeur=@mysql_result($r2,0);

$pdf->SetXY(48, 95);
$pdf->SetFont('Helvetica', '', 8);
$pdf->MultiCell('','',' '.$IDvendeur, 0, 'L', 0, 0, '', '', true);
//weight
$pdf->SetXY(63, 95);
$pdf->SetFont('Helvetica', '', 8);
$pdf->MultiCell('','',$poidsLB.'LB/'.$poids.'KG', 0, 'L', 0, 0, '', '', true);
//Label format
$pdf->SetXY(90, 95);

$pdf->SetFont('Helvetica', '', 8);
$pdf->MultiCell('','','LF-025', 0, 'L', 0, 0, '', '', true);

//Close and output PDF document
}
mysql_close();
$pdf->Output('labelPak.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+
?>
