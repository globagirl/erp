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

$IDcartonT=@$_POST['IDcarton'];
foreach ($IDcartonT as $IDcarton) {
//
$sq=@mysql_query("SELECT * FROM carton_palette where IDcarton='$IDcarton'");
$data=mysql_fetch_array($sq);
//
$n=strpos($IDcarton,'/')+1;
$l=strlen($IDcarton)-1;
$x=substr($IDcarton, $n, $l);
//
$poids=$data['poids'];
$poidsLB=$poids*2.20462;
$poidsLB=round($poidsLB,3);
//
$PO=$data['PO'];
//
$OF=$data['OF'];
$sql2=mysql_query("SELECT date_exped_conf FROM ordre_fabrication1 where OF='$OF'");
$dateE=@mysql_result($sql2,0);

//
$DDtime = strtotime($dateE);
$num_semaine = strftime("%W",$DDtime);
$year= strftime("%Y",$DDtime);
$DD=$year.'W'.$num_semaine;


//$pdf->SetMargins(0, 0, 0,true);
$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);
//$pdf->setPrintFooter(true);
//Génération Num palette 



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
$pdf->MultiCell('','',$data['IDproduit'], 0, 'L', 0, 0, '', '', true);
//

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
	
//$pdf->write1DBarcode($code, 'C39',LEFT , TOP, Logueur,30,10, $style, 'N');
$prd=$data['IDproduit'];
$pdf->SetXY(4, 20.5);
$pdf->write1DBarcode($prd, 'C39','' ,'', 60,8.7,'', $style, 'N');
//
$style = array('width' => 0.3, 'cap' => 'butt', 'join' => 'mm', 'dash' => 0, 'color' => array(0, 0, 0));
$pdf->Line(0.5, 30, 98.5, 30, $style);//$pdf->Line(left, p1 hauteur,longueur ,p2 hauteur, $style);

/*
////UPC PROD ID

$pdf->SetXY(4, 31);
$pdf->SetFont('Helvetica', '', 10);
$pdf->MultiCell('','','PO', 0, 'L', 0, 0, '', '', true);
$pdf->SetXY(37, 30);
$pdf->SetFont('Helvetica', '', 12);
$pdf->MultiCell('','','XXXXXXXXXX', 0, 'L', 0, 0, '', '', true);
//

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
	$pdf->SetXY(4, 36.5);
//$pdf->write1DBarcode($code, 'C39',LEFT , TOP, Logueur,30,10, $style, 'N');
  $pdf->write1DBarcode($PO, 'C39','' , '', 60,8.7,'', $style, 'N');
  */
//China E
$pdf->SetXY(77, 32);

//$pdf->Image('../image/CS.png',top, left, larg, long, 'png', '', 'M', false, 300, '', false, false, 0, false, false, false);
$pdf->Image('../image/chinaE.png','', '', 10, 10, 'png', '', 'M', false, 300, '', false, false, 0, false, false, false);
$pdf->SetXY(71, 82);
//ligne

$style = array('width' => 0.3, 'cap' => 'butt', 'join' => 'mm', 'dash' => 0, 'color' => array(0, 0, 0));
$pdf->Line(1.6, 47, 98.5, 47, $style);//$pdf->Line(left, p1 hauteur,longueur ,p2 hauteur, $style);
//QTY
$QTE=$data['qte'];
$pdf->SetFont('Helvetica', '', 10);
//$pdf->SetXY(4, 48);
$pdf->SetXY(4, 32);
$pdf->MultiCell('','','(Q)QUANTITY', 0, 'L', 0, 0, '', '', true);
//$pdf->SetXY(29, 47);
$pdf->SetXY(29, 31);
$pdf->SetFont('Helvetica', '', 12);
$pdf->MultiCell('','',$QTE.'EA', 0, 'L', 0, 0, '', '', true);
//

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
    
	);
	//$pdf->SetXY(4, 54.6);
	$pdf->SetXY(4, 37.5);
//$pdf->write1DBarcode($code, 'C39',LEFT , TOP, Logueur,30,10, $style, 'N');
  $pdf->write1DBarcode($QTE, 'C39','' , '', 20,8.7,'', $style, 'N');
  
  //ligne
/*
$style = array('width' => 0.3, 'cap' => 'butt', 'join' => 'mm', 'dash' => 0, 'color' => array(0, 0, 0));
$pdf->Line(0.5, 65, 98.5, 65, $style);//$pdf->Line(left, p1 hauteur,longueur ,p2 hauteur, $style);*/
//Description produit
//
$sql2=mysql_query("SELECT description FROM produit1 where code_produit='$prd'");
$desc=@mysql_result($sql2,0);

//
$pdf->SetFont('Helvetica', '', 9);
//$pdf->SetXY(4, 67);
$pdf->SetXY(4, 49);
$pdf->MultiCell(65,'','PRODUCT DESCRIPTION', 0, 'L', 0, 0, '', '', true);
//$pdf->SetXY(4, 72);
$pdf->SetXY(4, 53.6);
$pdf->SetFont('Helvetica', '', 10);
$pdf->MultiCell(59,'',$desc, 0, 'L', 0, 0, '', '', true);
//
$pdf->SetXY(4, 90);
$pdf->SetFont('Helvetica', '', 7);
$pdf->MultiCell('','','For patents see www.CS-pat.com', 0, 'L', 0, 0, '', '', true);

//N° palette
$pdf->SetXY(95, 90);
$pdf->SetFont('Helvetica', '', 7);
$pdf->MultiCell('','',$x, 0, 'L', 0, 0, '', '', true);
//Agency approval
$pdf->SetXY(67, 68);
//Intertek ETL 
/*
//$pdf->Image('../image/CS.png',top, left, larg, long, 'png', '', 'M', false, 300, '', false, false, 0, false, false, false);
$pdf->Image('../image/INTERTEK.jpg','', '', 20, 15, 'jpg', '', 'M', false, 300, '', false, false, 0, false, false, false);
$pdf->SetXY(71, 81);
$pdf->SetFont('Helvetica', '', 7);
$pdf->MultiCell('','','5009497', 0, 'L', 0, 0, '', '', true);
$pdf->SetXY(67, 84);
$pdf->SetFont('Helvetica', '', 6);
$pdf->MultiCell('','','Conforms to UL STD 1863', 0, 'L', 0, 0, '', '', true);
$pdf->SetXY(67, 86);
$pdf->SetFont('Helvetica', '', 6);
$pdf->MultiCell('','','Certified to CSA STD C22.2 No.233 & 182.4', 0, 'L', 0, 0, '', '', true);
*/

//LINE
$style = array('width' => 0.3, 'cap' => 'butt', 'join' => 'mm', 'dash' => 0, 'color' => array(0, 0, 0));
$pdf->Line(0.5,93.6, 98.5, 93.6, $style);//$pdf->Line(left, p1 hauteur,longueur ,p2 hauteur, $style);
//

$pdf->SetXY(4, 95);
$pdf->SetFont('Helvetica', '', 8);
$pdf->MultiCell('','','Assembled in Tunisia', 0, 'L', 0, 0, '', '', true);
//RoHS Statement
$pdf->SetXY(67, 51.2);
$pdf->SetFont('Helvetica', '', 6);
$pdf->MultiCell('','','For RoHS Inquiries', 0, 'L', 0, 0, '', '', true);
$pdf->SetXY(67, 53.4);
$pdf->SetFont('Helvetica', '', 6);
$pdf->MultiCell('','','CommScope Inc', 0, 'L', 0, 0, '', '', true);
$pdf->SetXY(67, 56);
$pdf->SetFont('Helvetica', '', 6);
$pdf->MultiCell('','','Corke Abbey , Bray', 0, 'L', 0, 0, '', '', true);
$pdf->SetXY(67, 58.2);
$pdf->SetFont('Helvetica', '', 6);
$pdf->MultiCell('','','Co.Dubblin Ireland', 0, 'L', 0, 0, '', '', true);
$pdf->SetXY(67, 60.4);
$pdf->SetFont('Helvetica', '', 6);
$pdf->MultiCell('','','Attn:Legal Department', 0, 'L', 0, 0, '', '', true);

//
$pdf->SetXY(67, 67.4);
$pdf->SetFont('Helvetica', '', 7);
$pdf->MultiCell('','','ORDER: ', 0, 'L', 0, 0, '', '', true);
$pdf->SetXY(77, 66.4);
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
//
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