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
    'align' => '',
    'stretch' => false,
    'fitwidth' => true,
    'cellfitalign' => '',
    'border' => false,
    'hpadding' => 0,//'auto',
    'vpadding' => 0,//'auto',
    'fgcolor' => array(0,0,0),
    'bgcolor' => false, //array(255,255,255),
    'text' => false,
    'font' => 'helvetica',
    'fontsize' => 20
	);
//
$PO=$_POST['PO'];
$prd=$_POST['prd'];
$desc=$_POST['desc'];
$qty=$_POST['qty'];
$qtyB=$_POST['qtyB'];
$nbrB=$_POST['nbrB'];
$dateE=$_POST['dateE'];
//
$DDtime = strtotime($dateE);
$num_semaine = strftime("%W",$DDtime);
$year= strftime("%Y",$DDtime);
$DD=$year.'W'.$num_semaine;
//
$qtyR=$qty;
// Calcul du qte par box
$x=0;
//


//$pdf->SetMargins(0, 0, 0,true);
$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);
//$pdf->setPrintFooter(true);
$QTE=1;
/*while ($x < $qty){
$x++;*/

/*
if($qtyR>=$qtyB){
  $QTE=$qtyB;
  $qtyR=$qtyR-$qtyB;
}else{
  $QTE=$qtyR;
}*/
$pdf->AddPage();
$pdf->SetMargins(0, 0, 0,true);
$pdf->SetFillColor(255,255 ,255);
$pdf->SetTextColor(0,0 ,0);
$pdf->SetXY(17, 2.5);
//logo
//Determiner NetConnect ou commscope logo
$subProd=substr($prd,0,3);
//$pdf->Image('../image/CS.png',top, left, larg, long, 'png', '', 'M', false, 300, '', false, false, 0, false, false, false);
if((strtoupper($subProd)=="NPC") || (strtoupper($subProd)=="NCC")){
  $pdf->Image('../image/NTC.jpg','', '', 68, 8, 'jpg', '', 'M', false, 300, '', false, false, 0, false, false, false);
  $formTik="LF-006";
  /*$pdf->Image('../image/CS1.jpg','', '', 68, 8, 'jpg', '', 'M', false, 300, '', false, false, 0, false, false, false);
  $formTik="LF-007";*/
}else{
  $pdf->Image('../image/CS1.jpg','', '', 68, 8, 'jpg', '', 'M', false, 300, '', false, false, 0, false, false, false);
  $formTik="LF-007";  
  //
  /*
  $pdf->Image('../image/NTC.jpg','', '', 68, 8, 'jpg', '', 'M', false, 300, '', false, false, 0, false, false, false);
  $formTik="LF-006";*/
}

//line
$styleLigne = array('width' => 1.2, 'cap' => 'butt', 'join' => 'mm', 'dash' => 0, 'color' => array(0, 0, 0));
$pdf->Line(1.2, 15.2, 98.5, 15.2, $styleLigne);//$pdf->Line(left, p1 hauteur,longueur ,p2 hauteur, $style);
//product ID
$pdf->SetXY(5, 17.7);
$pdf->SetFont('Helvetica', '', 9);
$pdf->MultiCell('','','(1P)PROD ID', 0, 'L', 0, 0, '', '', false);
$pdf->SetXY(27, 17.7);
$pdf->SetFont('Helvetica', '', 11);
$pdf->MultiCell('','',$prd, 0, 'L', 0, 0, '', '', true);
//

	
//$pdf->write1DBarcode($code, 'C39',LEFT , TOP, Logueur,30,10, $style, 'N');
$pdf->SetXY(10, 22.9);
$pdf->write1DBarcode($prd, 'C39','' ,'', 60,8.7,'', $style, 'N');

////UPC PROD ID
$re1=@mysql_query("SELECT UPC FROM commande2 where PO='$PO'");
$UPC=@mysql_result($re1,0);
$pdf->SetXY(5, 32.3);
$pdf->SetFont('Helvetica', '', 9);
$pdf->MultiCell('','','(3P)UPC PROD ID', 0, 'L', 0, 0, '', '', true);
$pdf->SetXY(39.5, 31.6);
$pdf->SetFont('Helvetica', '', 11);
$pdf->MultiCell('','',$UPC, 0, 'L', 0, 0, '', '', true);
//

	$pdf->SetXY(10, 36.5);
//$pdf->write1DBarcode($code, 'C39',LEFT , TOP, Logueur,30,10, $style, 'N');
if($UPC != ""){
  $pdf->write1DBarcode($UPC, 'C39','' , '', 60,8.7,'', $style, 'N');
}
//ligne

$styleLigne = array('width' => 0.3, 'cap' => 'butt', 'join' => 'mm', 'dash' => 0, 'color' => array(0, 0, 0));
$pdf->Line(1.6, 46.5, 98.5, 46.5, $styleLigne);//$pdf->Line(left, p1 hauteur,longueur ,p2 hauteur, $style);
//decription prd
$pdf->SetFont('Helvetica', '', 9);
$pdf->SetXY(6, 48.3);
$pdf->MultiCell('','','PRODUCT DESCRIPTION', 0, 'L', 0, 0, '', '', true);
$pdf->SetXY(4, 53.2);
$pdf->SetFont('Helvetica', '', 10);
$pdf->MultiCell(65,'',$desc, 0, 'L', 0, 0, '', '', true);///A revoir cas 2 ligne
//ligne

$styleLigne = array('width' => 0.3, 'cap' => 'butt', 'join' => 'mm', 'dash' => 0, 'color' => array(0, 0, 0));
$pdf->Line(1.6, 92.5, 98.5, 92.5, $styleLigne);//$pdf->Line(left, p1 hauteur,longueur ,p2 hauteur, $style);
//ligne

$styleLigne = array('width' => 0.3, 'cap' => 'butt', 'join' => 'mm', 'dash' => 0, 'color' => array(0, 0, 0));
$pdf->Line(1.6, 65.4, 98.5, 65.4, $styleLigne);//$pdf->Line(left, p1 hauteur,longueur ,p2 hauteur, $style);
//QTY

$pdf->SetFont('Helvetica', '', 9);
$pdf->SetXY(71, 48.3);
$pdf->MultiCell('','','(Q)QUANTITY', 0, 'L', 0, 0, '', '', true);
$pdf->SetXY(77.2, 51.6);
$pdf->SetFont('Helvetica', '', 11);
$pdf->MultiCell('','','1EA', 0, 'L', 0, 0, '', '', true);
//


	$pdf->SetXY(72, 56.2);
//$pdf->write1DBarcode($code, 'C39',LEFT , TOP, Logueur,30,10, $style, 'N');
  $pdf->write1DBarcode($QTE, 'C39','' , '', 40,8.7,'', $style, 'N');
  

//Intertek
$pdf->SetXY(10, 67);

//$pdf->Image('../image/CS.png',top, left, larg, long, 'png', '', 'M', false, 300, '', false, false, 0, false, false, false);
$pdf->Image('../image/INTERTEK.jpg','', '', 15, 15, 'jpg', '', 'M', false, 300, '', false, false, 0, false, false, false);
$pdf->SetXY(12, 81);
$pdf->SetFont('Helvetica', '', 6);
$pdf->MultiCell('','','5009497', 0, 'L', 0, 0, '', '', true);
$pdf->SetXY(10, 84);
$pdf->SetFont('Helvetica', '', 6);
$pdf->MultiCell('','','Conforms to UL STD 1863', 0, 'L', 0, 0, '', '', true);
$pdf->SetXY(10, 86.5);
$pdf->SetFont('Helvetica', '', 6);
$pdf->MultiCell('','','Certified to CSA STD C22.2 No.233 & 182.4', 0, 'L', 0, 0, '', '', true);
//China E
$pdf->SetXY(77, 67);

//$pdf->Image('../image/CS.png',top, left, larg, long, 'png', '', 'M', false, 300, '', false, false, 0, false, false, false);
$pdf->Image('../image/chinaE.png','', '', 10, 10, 'png', '', 'M', false, 300, '', false, false, 0, false, false, false);
$pdf->SetXY(71, 81);
//ligne

$styleLigne = array('width' => 0.3, 'cap' => 'butt', 'join' => 'mm', 'dash' => 0, 'color' => array(0, 0, 0));
$pdf->Line(0.5,92.6, 98.5, 92.6, $styleLigne);//$pdf->Line(left, p1 hauteur,longueur ,p2 hauteur, $style);
//


//RoHS Statement
$pdf->SetXY(72, 34);
$pdf->SetFont('Helvetica', '', 6);
$pdf->MultiCell('','','For RoHS Inquiries', 0, 'L', 0, 0, '', '', true);
$pdf->SetXY(72, 36.3);
$pdf->SetFont('Helvetica', '', 6);
$pdf->MultiCell('','','CommScope Inc', 0, 'L', 0, 0, '', '', true);
$pdf->SetXY(72, 38.9);
$pdf->SetFont('Helvetica', '', 6);
$pdf->MultiCell('','','Corke Abbey , Bray', 0, 'L', 0, 0, '', '', true);
$pdf->SetXY(72, 41);
$pdf->SetFont('Helvetica', '', 6);
$pdf->MultiCell('','','Co.Dubblin Ireland', 0, 'L', 0, 0, '', '', true);
$pdf->SetXY(72, 43.5);
$pdf->SetFont('Helvetica', '', 6);
$pdf->MultiCell('','','Attn:Legal Department', 0, 'L', 0, 0, '', '', true);
//
$pdf->SetXY(2, 94);
$pdf->SetFont('Helvetica', '', 8);
$pdf->MultiCell('','','Made in Tunisia', 0, 'L', 0, 0, '', '', true);
//date 
$pdf->SetXY(23.5, 94);
$pdf->SetFont('Helvetica', '', 8);
$pdf->MultiCell('','',$DD, 0, 'L', 0, 0, '', '', true);
//Building number

$r1=@mysql_query("SELECT client FROM commande2 where PO='$PO'");
$clt=@mysql_result($r1,0);
$r2=@mysql_query("SELECT IDvendeur FROM client1 where name_client='$clt'");
$IDvendeur=@mysql_result($r2,0);
$pdf->SetXY(36, 94);
$pdf->SetFont('Helvetica', '', 8);
$pdf->MultiCell('','',' '.$IDvendeur, 0, 'L', 0, 0, '', '', true);
//For..
$pdf->SetXY(49.5, 94);
$pdf->SetFont('Helvetica', '', 7);
$pdf->MultiCell('','',' '.' For patents see www.CS-pat.com', 0, 'L', 0, 0, '', '', true);
//Label format
$pdf->SetXY(89.9, 94);
$pdf->SetFont('Helvetica', '', 7);
$pdf->MultiCell('','',$formTik, 0, 'L', 0, 0, '', '', true);

//Close and output PDF document
//}
mysql_close();
$pdf->Output('labelBag.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+
?>