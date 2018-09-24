<?php
include('../connexion/connexionDB.php');
// Include the main TCPDF library (search for installation path).
require_once('tcpdf.php');


// Extend the TCPDF class to create custom Header and Footer
class MYPDF extends TCPDF {

    // Page header
   public function Header() {
        // Logo
		
        /*$image_file = 'img/logo.jpg';
        $this->Image($image_file, 5, 5, 25, 10, 'JPG', '', 'M', false, 300, '', false, false, 0, false, false, false);*/
        // Set font
        $this->SetFont('times', 'B', 12);
        // Title
	// $image_file = 'logos/tuv.jpg';
        // $this->Image($image_file, 150, 20, 50, 20, 'JPG', '', 'M', false, 300, '', false, false, 0, false, false, false);
        // Set font
        $this->SetFont('times', 'B', 12);
	


$this->ln(10);


$tbl = <<<EOD
<table border="1" cellpadding="2" cellspacing="0" width="100%">

 <tr style="color:#333333" >
 
 <td width="100"  align="center" ><br><img src="img/logo.jpg"  width="85px" height="55px" /></td> 
 <td width="455" height="30" align="center" ><br><font size="18">Fiche etat export </font><br><br><br></td> 
  <td width="100" height="30" align="center" ><br><font size="9"><br>Ref:E-FIN-01 version: 01   <br>Date :09/17/2016</font></td>
</tr>
</table>
EOD;


$this->writeHTML($tbl, true, false, false, false, '');

$this->ln(-19);

$date1=@$_POST['date1'];
$date2=@$_POST['date2'];
$date1=strtotime($date1);
$date1= date("d M  Y",$date1);
$date2=strtotime($date2);
$date2= date("d M  Y",$date2);

$this->SetFillColor(255,255 ,255);
$this->SetTextColor(0,0 ,0);
$this->MultiCell(180, 15,'Du  '.$date1.' à  '.$date2, 0, 'C', 1, 0);
// $this->ln(50);

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
$pdf->SetAuthor('Nicola Asuni');
$pdf->SetTitle('TCPDF Example 003');
$pdf->SetSubject('TCPDF Tutorial');
$pdf->SetKeywords('TCPDF, PDF, example, test, guide');

// set default header data
//$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);

// set header and footer fonts
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

// set some language-dependent strings (optional)
if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
    require_once(dirname(__FILE__).'/lang/eng.php');
    $pdf->setLanguageArray($l);
}

// ---------------------------------------------------------

 include('../connexion/connexionDB.php');





// add a page
$pdf->AddPage('P', 'A4');
{
 $date1=@$_POST['date1'];
 $date2=@$_POST['date2'];
// set some text to print


$pdf->ln(20);



$pdf->SetFont('times', 'B', 12);
$pdf->SetFillColor(255,255 ,255);
$pdf->SetTextColor(0,0 ,0);
$pdf->MultiCell(45, 8,'Date expédition', 1, 'C', 1, 0);


$pdf->SetFillColor(255,255 ,255);
$pdf->SetTextColor(0,0 ,0);
$pdf->MultiCell(40, 8,'Client',1, 'C', 1, 0);


$pdf->SetFillColor(255,255 ,255);
$pdf->SetTextColor(0,0 ,0);
$pdf->MultiCell(30, 8,'Total PO',1, 'C', 1, 0);




$pdf->SetFillColor(255,255 ,255);
$pdf->SetTextColor(0,0 ,0);
$pdf->MultiCell(50, 8,'Total', 1, 'C', 1, 0);



$pdf->SetFillColor(255,255,255);
$pdf->SetTextColor(0,0 ,0);

$pdf->MultiCell(20, 8,'Devise', 1, 'C', 1, 0);



$pdf->ln(8);

$sql = mysql_query ("SELECT sum(tot_val) AS total, count(num_fact) AS nbr , date_E AS dateE ,client AS client , devise AS devise FROM fact1 WHERE date_E >='$date1' and date_E <= '$date2' group by date_E,client,devise");
$i=0;
$j=0;
$pdf->SetFont('times', 'B', 10);
while($data=mysql_fetch_array($sql))

 {
 $j++;
 $i++;
 
 if ($j==30){
$pdf->setPrintHeader(false);

 $pdf->AddPage('P', 'A4');
 $j=1;
 $pdf->ln(5);
 }
 
$tot=round($data['total'],4);


$pdf->SetFillColor(255,255 ,255);
$pdf->SetTextColor(0,0 ,0);
$pdf->MultiCell(45, 7,''.$data['dateE'], 1, 'C', 1, 0);


$pdf->SetFillColor(255,255 ,255);
$pdf->SetTextColor(0,0 ,0);
$pdf->MultiCell(40, 7,''.$data['client'],1, 'C', 1, 0);


$pdf->SetFillColor(255,255 ,255);
$pdf->SetTextColor(0,0 ,0);
$pdf->MultiCell(30, 7,''.$data['nbr'],1, 'C', 1, 0);





$pdf->SetFillColor(255,255 ,255);
$pdf->SetTextColor(0,0 ,0);
$pdf->MultiCell(50, 7,''.$tot, 1, 'C', 1, 0);



$pdf->SetFillColor(255,255,255);
$pdf->SetTextColor(0,0 ,0);
$pdf->MultiCell(20, 7,''.$data['devise'], 1, 'C', 1, 0);



$pdf->ln(7);

}

$pdf->ln(8);




}
// set filling color




// Close and output PDF document
mysql_close();
$pdf->Output('example_003.pdf', 'I');

// ============================================================+
// END OF FILE
// ============================================================+
?>