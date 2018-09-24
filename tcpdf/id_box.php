<?php
include('../connexion/connexionDB.php');

// Include the main TCPDF library (search for installation path).
require_once('tcpdf.php');


$recherche= $_POST['recherche'];
$val= $_POST['val'];

// Extend the TCPDF class to create custom Header and Footer
class MYPDF extends TCPDF {

    //Page header
    public function Header() {
        // Logo
        // $image_file = 'img/logo.jpg';
        // $this->Image($image_file, 5, 5, 40, 20, 'JPG', '', 'M', false, 300, '', false, false, 0, false, false, false);
        // Set font
        $this->SetFont('helvetica', 'B', 20);
        // Title
	

// $this->MultiCell(80, 5,'PLAN DE TRAVAIL', 1, 'C', 0, 1, 65, 13, true);
// $this->SetFont('helvetica', '', 10);

// $txt = 'Ref:E-PRO-02 version:04  Date:26/11/2013';
// $this->MultiCell(35, 5,$txt, 1, 'C', 0, 1, 160, 10, true);


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
$pdf->SetAuthor('Pluto');


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

$i=0;
$j=0;
$pdf->AddPage('L', 'A4');
if ($recherche=="codeR"){
$sql2 = mysql_query ("SELECT IDpaquet FROM paquet2 WHERE idRO like '%$val%'");

while($row2 = @mysql_fetch_array($sql2)) {




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
    'fontsize' => 80,
    'stretchtext' => 4
	);
	
	
$code=$row2['IDpaquet'];



// CODE 128 AUTO
$style['position'] = 'C';
$pdf->write1DBarcode($code, 'C128','' , '', '', 120, 7, $style, 'N');

// set some text to print


// $pdf->ln();





// set filling color
$pdf->SetFillColor(187,210,255);

// set cell height ratio

$pdf->AddPage('L', 'A4');



}

}else if ($recherche=="IDpaquet"){
$sql2 = mysql_query ("SELECT IDpaquet FROM paquet2 WHERE IDpaquet like '$val%'");

while($row2 = @mysql_fetch_array($sql2)) {




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
    'fontsize' => 80,
    'stretchtext' => 4
	);
	
	
$code=$row2['IDpaquet'];



// CODE 128 AUTO
$style['position'] = 'C';
$pdf->write1DBarcode($code, 'C128','' , '', '', 120, 7, $style, 'N');

// set some text to print


// $pdf->ln();





// set filling color
$pdf->SetFillColor(187,210,255);

// set cell height ratio

$pdf->AddPage('L', 'A4');



}

}else if ($recherche=="IDarticle"){
$sql2 = mysql_query ("SELECT IDpaquet FROM paquet2 WHERE IDarticle like '$val' and qte_res >0");

while($row2 = @mysql_fetch_array($sql2)) {




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
    'fontsize' => 80,
    'stretchtext' => 4
	);
	
	
$code=$row2['IDpaquet'];



// CODE 128 AUTO
$style['position'] = 'C';
$pdf->write1DBarcode($code, 'C128','' , '', '', 120, 7, $style, 'N');

// set some text to print


// $pdf->ln();





// set filling color
$pdf->SetFillColor(187,210,255);

// set cell height ratio

$pdf->AddPage('L', 'A4');



}

}
else
{
$sql = mysql_query ("SELECT IDreception FROM reception WHERE $recherche='$val'");
while($row1 = @mysql_fetch_array($sql)) {

$val2=$row1['IDreception'];
$sql2 = mysql_query ("SELECT IDpaquet FROM paquet2 WHERE idRO like '%$val2%'");
while($row2 = @mysql_fetch_array($sql2)) {




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
    'fontsize' => 80,
    'stretchtext' => 4
	);
	
	
$code=$row2['IDpaquet'];



// CODE 128 AUTO
$style['position'] = 'C';
$pdf->write1DBarcode($code, 'C128','' , '', '', 120, 7, $style, 'N');

// set some text to print


// $pdf->ln();





// set filling color
$pdf->SetFillColor(187,210,255);

// set cell height ratio

$pdf->AddPage('L', 'A4');



}


}
}




//sakar il wihile 


//Close and output PDF document
mysql_close();
$pdf->Output('codePak.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+
?>