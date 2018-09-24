<?php
include('../connexion/connexionDB.php');
// Include the main TCPDF library (search for installation path).
require_once('tcpdf.php');


// Extend the TCPDF class to create custom Header and Footer
class MYPDF extends TCPDF {

    // Page header
   public function Header() {
       


    }

    // Page footer
    public function Footer() {
        // Position at 15 mm from bottom
        $this->SetY(-15);
        // Set font
        $this->SetFont('helvetica', 'I', 8);
        // Page number
        $this->Cell(0, 10, 'Page '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
    }
	
}

// create new PDF document
$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Pluto ');


// set default header data
//$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);

// set header and footer fonts
/*
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
*/
// set some language-dependent strings (optional)
if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
    require_once(dirname(__FILE__).'/lang/eng.php');
    $pdf->setLanguageArray($l);
}

// ---------------------------------------------------------

$IDinvoiceT=@$_POST['IDinvoice'];
$four=@$_POST['four'];
$dateJ=date("d/m/Y");
//
$reqMax= mysql_query("SELECT max(IDpay) FROM payment_fournisseur ");
$max=@mysql_result($reqMax,0);
$max++;
$pdf->SetFont('times', 'B', 10);
// add a page
$pdf->AddPage('P', 'A4');
$pdf->SetMargins(10, 10, 0,true);
$pdf->setPrintHeader(false);
$pdf->SetFillColor(255,255 ,255);
$pdf->SetTextColor(0,0 ,0);

$pdf->ln(5);
$pdf->MultiCell(250, 9,'Fournisseur : '.$four, 0, 'L', 1, 0);
$pdf->ln(8);
$pdf->MultiCell(100, 9,'Date : '.$dateJ, 0, 'L', 1, 0);
$pdf->ln(8);
$pdf->MultiCell(100, 9,'REF : '.$max, 0, 'L', 1, 0);

$pdf->ln(20);
$pdf->MultiCell(40, 9,'N° facture', 0, 'L', 1, 0);
$pdf->MultiCell(35, 9,'Date facture',0, 'L', 1, 0);
$pdf->MultiCell(35, 9,'Echéance',0, 'L', 1, 0);
$pdf->MultiCell(35, 9,'Montant',0, 'L', 1, 0);
$pdf->MultiCell(20, 9,'Devise',0, 'L', 1, 0);


$pdf->ln(9);
$i=0;
$j=0;

$totalT=0;
$currency="EUR";
$pdf->SetFont('times', '', 10);
foreach ($IDinvoiceT as $IDinvoice) {

 $j++;
 $i++;
 
 if ($j==23){
$pdf->setPrintHeader(false);

 $pdf->AddPage('P', 'A4');
 $j=1;
 $pdf->ln(2);
 }
 
$req= mysql_query("SELECT dateF,dateP,total,currency FROM supplier_invoice where IDinvoice='$IDinvoice'");
$a=@mysql_fetch_array($req);
$total =$a['total'];
$currency =$a['currency'];
$totalT=$totalT+$total;
$n=strpos($IDinvoice,"-");     
$invoice=substr($IDinvoice,$n+1);
$pdf->MultiCell(40, 8,''.$invoice, 0, 'L', 1, 0);
$pdf->MultiCell(35, 8,''.$a['dateF'],0, 'L', 1, 0);
$pdf->MultiCell(35, 8,''.$a['dateP'],0, 'L', 1, 0);
$pdf->MultiCell(35, 8,''.$total,0, 'L', 1, 0);
$pdf->MultiCell(20, 8,''.$currency,0, 'L', 1, 0);
$pdf->ln(8);

}
$pdf->SetFont('times', 'B', 12);
$pdf->MultiCell(110, 8,'Total : ', 0, 'R', 1, 0);
$pdf->MultiCell(110, 8,$totalT." ".$currency, 0, 'L', 1, 0);
$pdf->ln(8);






// set filling color




// Close and output PDF document
mysql_close();
$pdf->Output('liste.pdf', 'I');

// ============================================================+
// END OF FILE
// ============================================================+
?>