<?php
include('../connexion/connexionDB.php');


// Include the main TCPDF library (search for installation path).
require_once('tcpdf.php');





// Extend the TCPDF class to create custom Header and Footer
class MYPDF extends TCPDF {

    //Page header
    public function Header() {
        // Logo
        $image_file = 'img/logo.jpg';
        $this->Image($image_file, 5, 5, 40, 20, 'JPG', '', 'M', false, 300, '', false, false, 0, false, false, false);
        // Set font
        $this->SetFont('helvetica', 'B', 20);
        // Title
	

$this->MultiCell(80, 5,'WORK ORDER', 1, 'C', 0, 1, 65, 13, true);
$this->SetFont('helvetica', '', 10);

$txt = 'Ref:E-PRO-02 version:04  Date:26/11/2013';
$this->MultiCell(35, 5,$txt, 1, 'C', 0, 1, 160, 10, true);


    }

    // Page footer
    // public function Footer() {
        // Position at 15 mm from bottom
        // $this->SetY(-15);
        // Set font
        // $this->SetFont('helvetica', 'I', 8);
        // Page number
        // $this->Cell(0, 10, 'Page '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
    // }
}

// create new PDF document
$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Nicola Asuni');
$pdf->SetTitle('TCPDF Example 003');
$pdf->SetSubject('TCPDF Tutorial');
$pdf->SetKeywords('TCPDF, PDF, example, test, guide');

// set default header data
$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);

// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
// $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
// $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// set some language-dependent strings (optional)
if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
    require_once(dirname(__FILE__).'/lang/eng.php');
    $pdf->setLanguageArray($l);
}

// ---------------------------------------------------------

// set font


$o=$_POST['num_of1'];
 $p=@$_POST['num_of2'];
 if($p ==""){
 $p=$o;
 }
$sql = mysql_query ("SELECT * FROM plan1 WHERE OF BETWEEN $o AND $p ");




while($row = @mysql_fetch_array($sql)) {
$pdf->SetFont('times', 'B', 13);
// add a page
$pdf->AddPage('P', 'A4');

$style = array(
    'position' => '',
    'align' => 'C',
    'stretch' => false,
    'fitwidth' => true,
    'cellfitalign' => '',
    'border' => true,
    'hpadding' => 'auto',
    'vpadding' => 'auto',
    'fgcolor' => array(0,0,0),
    'bgcolor' => false, //array(255,255,255),
    'text' => true,
    'font' => 'helvetica',
    'fontsize' => 8,
    'stretchtext' => 4
	);
$code=$row['numPlan'];
// CODE 128 AUTO
$pdf->write1DBarcode($code, 'C128', 80, 28, '', 16, 0.3, $style, 'N');

// set some text to print


$pdf->ln();





// set filling color
$pdf->SetFillColor(187,210,255);

// set cell height ratio
$OF=$row['OF'];
$sql0 = mysql_query ("SELECT * FROM ordre_fabrication1 WHERE OF='$OF'");
$row0 = @mysql_fetch_array($sql0);
$produit=$row0['produit'];
$POx=$row0['PO'];
$sql1 = mysql_query ("SELECT * FROM commande_items WHERE POitem='$POx'");
$rowX = @mysql_fetch_array($sql1);

$sql1 = mysql_query ("SELECT * FROM produit1 WHERE code_produit='$produit'");
$row1 = @mysql_fetch_array($sql1);

$pdf->Cell(50,8,'Plan number: '.$row['numPlan'],1,false,'C','R');
$pdf->Cell(43,8,'PO : '.$row0['PO'],1,false,'C','R');
$pdf->Cell(33,8,'FO : '.$row['OF'],1,false,'C','R');
$pdf->Cell(0,8,'Part Number : '.$row0['produit'],1,false,'C','R');

$pdf->ln();
$pdf->SetFont('Times','',12);
$pdf->Cell(60,8,'Quantity: '.$row['qte_p'],1,0,'C');

$pdf->Cell(60,8,'Batch Qty: '.$row0['nbr_plan'],1,0,'C');
$pdf->Cell(0,8,'Revision : '.$row1['revision'],1,0,'C');



$pdf->ln();

$pdf->Cell(60,8,'Starting date: '.$row0['date_lance'],1,0,'C');
$pdf->Cell(60,8,'Expiration date : '.$row0['date_exped_conf'],1,0,'C');
$pdf->Cell(0,8,'Quantity ordered : '.$row0['qte'],1,0,'C');



$pdf->ln();

$pdf->SetFont('Times','',10);
$pdf->Cell(90,6,'Category: '.$row1['categorie'],1,0,'C');

$pdf->Cell(0,6,'Description :'.$row1['description'],1,0,'C');


$pdf->ln();

if ($row1['categorie']==("UPM3"))
{
	$image_file = 'img/upm3.jpg';

}else if ($row1['categorie']==("PLUX FG"))
{
	$image_file = 'img/c1.jpg';

}
elseif (($row1['categorie']=="PCB") or ($row1['categorie']=="Others"))
{
	$image_file = 'img/bodyPCB.jpg';

}
else
{
$image_file = 'img/body4.jpg';

}


$pdf->Image($image_file, 15, 90, 181, 170, 'JPG', '', 'M', false, 300, '', false, false, 0, false, false, false);
}


//Close and output PDF document
mysql_close();
$pdf->Output('example_003.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+
?>