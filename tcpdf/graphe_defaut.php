<?php

// Include the main TCPDF library (search for installation path).
require_once('tcpdf.php');
// Extend the TCPDF class to create custom Header and Footer
class MYPDF extends TCPDF {
    //Page header
    public function Header() {
	    $this->SetFillColor(255,255,255);
		$this->Cell(50,10,'',1,false,'C','R');
		$this->Cell(80,10,'Taux de defaut journaliére ',1,false,'C','R');
		$this->Cell(0,10,' ',1,false,'C','R');
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

// set font


 $DD=$_POST['date1'];
 $DF=$_POST['date2'];
 $J1=@$_POST['J1'];
 $J2=@$_POST['J2'];
 $J3=@$_POST['J3'];
 $J4=@$_POST['J4'];
 $J5=@$_POST['J5'];
 $J6=@$_POST['J6'];
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


$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Times','',12);
$pdf->Cell(60,8,'Process: Production',1,false,'C','R');
$pdf->Cell(60,8,'Article:Cable',1,false,'C','R');
$pdf->Cell(0,8,'Limite :1% ',1,false,'C','R');
$pdf->ln();
$DDtime = strtotime($DD);
$num_semaine = strftime("%W",$DDtime);
$year= strftime("%Y",$DDtime);
$pdf->Cell(90,8,'Année:'.$year,1,0,'C');
$pdf->Cell(0,8,'Semaine:'.$num_semaine,1,0,'C');
$pdf->ln();
$pdf->Cell(0,8,'Responsable:DAHMANI Walid ',1,false,'C','R');
$pdf->ln(13);
//
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Times','',12);
$pdf->Cell(30,6,'Lundi',1,false,'C','R');
$pdf->Cell(30,6,'Mardi',1,false,'C','R');
$pdf->Cell(30,6,'Mercredi',1,false,'C','R');
$pdf->Cell(30,6,'Jeudi',1,false,'C','R');
$pdf->Cell(30,6,'Vendredi',1,false,'C','R');
$pdf->Cell(30,6,'Samedi',1,false,'C','R');
$pdf->ln(6);
$pdf->Cell(30,6,''.$J1,1,false,'C','R');
$pdf->Cell(30,6,''.$J2,1,false,'C','R');
$pdf->Cell(30,6,''.$J3,1,false,'C','R');
$pdf->Cell(30,6,''.$J4,1,false,'C','R');
$pdf->Cell(30,6,''.$J5,1,false,'C','R');
$pdf->Cell(30,6,''.$J6,1,false,'C','R');

//
$image_file = '../pChart/img/nbrD'.$DF.'.png';
$image_file3 = '../pChart/img/Def1'.$DF.'.png';	
$pdf->Image($image_file, 15, 75, 181,90,'png', '', 'C', false, 0, '', false, false, 0, false, false, false);
$pdf->Image($image_file3, 15, 175, 181, 90, 'png', '', 'C', false, 0, '', false, false, 0, false, false, false);

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

// set filling color
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Times','',12);
$pdf->Cell(60,8,'Process: Production',1,false,'C','R');
$pdf->Cell(60,8,'Article:Cable',1,false,'C','R');
$pdf->Cell(0,8,'Limite:1% ',1,false,'C','R');
$pdf->ln();
$pdf->Cell(90,8,'Année:'.$year,1,0,'C');
$pdf->Cell(0,8,'Semaine: '.$num_semaine,1,0,'C');
$pdf->ln();
$pdf->Cell(0,8,'Responsable:DAHMANI Walid ',1,false,'C','R');
$pdf->ln(13);
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Times','',12);
$pdf->Cell(30,6,'Lundi',1,false,'C','R');
$pdf->Cell(30,6,'Mardi',1,false,'C','R');
$pdf->Cell(30,6,'Mercredi',1,false,'C','R');
$pdf->Cell(30,6,'Jeudi',1,false,'C','R');
$pdf->Cell(30,6,'Vendredi',1,false,'C','R');
$pdf->Cell(30,6,'Samedi',1,false,'C','R');
$pdf->ln(6);
$pdf->Cell(30,6,''.$J1,1,false,'C','R');
$pdf->Cell(30,6,''.$J2,1,false,'C','R');
$pdf->Cell(30,6,''.$J3,1,false,'C','R');
$pdf->Cell(30,6,''.$J4,1,false,'C','R');
$pdf->Cell(30,6,''.$J5,1,false,'C','R');
$pdf->Cell(30,6,''.$J6,1,false,'C','R');	
$image_file2 = '../pChart/img/D2'.$DF.'.png';
$pdf->Image($image_file2, 15, 100, 181,120,'png', '', 'C', false, 0, '', false, false, 0, false, false, false);




//Close and output PDF document

$pdf->Output('graphe_defaut.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+
?>