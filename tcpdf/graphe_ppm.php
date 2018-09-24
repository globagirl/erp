<?php
include('../connexion/connexionDB.php');
// Include the main TCPDF library (search for installation path).
require_once('tcpdf.php');
// Extend the TCPDF class to create custom Header and Footer
class MYPDF extends TCPDF {
   //Page header
    public function Header() {
        $DD=date("Y-m-d");
		$this->SetFillColor(187,212,225);
		$DDtime = strtotime($DD);
		$num_semaine = strftime("%W",$DDtime);
		$y= strftime("%Y",$DDtime);
		$this->Cell(50,10,'Année:'.$y,1,false,'C','R');
		$this->Cell(80,10,'PPM ',1,false,'C','R');
		$this->Cell(0,10,' Semaine:'.$num_semaine,1,false,'C','R');
    }											   
}

// create new PDF document
$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Ghribi NouR El Houda');
$pdf->SetTitle('Graphe production');

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

$pdf->SetFont('times', 'B', 14);
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

$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Times','',12);
$pdf->Cell(60,8,'Process: Production',1,false,'C','R');
$pdf->Cell(60,8,'Article:Cable',1,false,'C','R');
$pdf->Cell(0,8,'Type article :Cat5e,cat6 & cat6a ',1,false,'C','R');
$pdf->ln();
$pdf->Cell(0,8,'Responsable:DAHMANI Walid ',1,false,'C','R');
$pdf->ln(2);
$year=$_POST['year'];
$D=date("Y-m-d");
$D=$D.$year;
$image_file = '../pChart/img/PPMCAT6'.$D.'.png';	
$image_file2 = '../pChart/img/PPMCAT5'.$D.'.png';
$image_file3 = '../pChart/img/PPMCAT6a'.$D.'.png';	
$pdf->Image($image_file, 15, 50, 180,120, 'png', '', 'C', false, 0, '', false, false, 0, false, false, false);
$pdf->Image($image_file2, 15, 152, 180,120, 'png', '', 'C', false, 0, '', false, false, 0, false, false, false);
$pdf->AddPage('P', 'A4');
$pdf->Image($image_file3, 15, 50, 180,120, 'png', '', 'C', false, 0, '', false, false, 0, false, false, false);
//Close and output PDF document
mysql_close();
$pdf->Output('graphe_production.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+
?>