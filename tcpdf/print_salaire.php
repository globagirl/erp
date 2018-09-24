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
 
 <td width="100"  align="center" > <img src="img/logo.jpg"  width="85px" height="45px" /></td> 
 <td width="455" height="30" align="center" ><br><font size="18">Liste des salaires </font><br>
 <br>
 <br></td> 
  <td width="100" height="30" align="center" ><br><br><font size="9">Ref:E-GRH-01 version: 01   <br>Date :16/05/2016</font></td>
</tr>
</table>
EOD;


$this->writeHTML($tbl, true, false, false, false, '');

$this->ln(-19);

$mois=$_POST['mois'];

//$M=date_format($mois, 'F Y');
$this->SetFillColor(255,255 ,255);
$this->SetTextColor(0,0 ,0);
$this->MultiCell(180, 15,''.$mois, 0, 'C', 1, 0);
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

$mois=$_POST['mois'];



$req1= "SELECT * FROM personnel_salaire where mois like '$mois%'";




$pdf->SetFont('times', 'B', 10);
// add a page
$pdf->AddPage('P', 'A4');
{

// set some text to print


$r=mysql_query($req1) or die(mysql_error());
$nbr=mysql_num_rows($r);
$pdf->ln(20);
$pdf->SetFillColor(255,255 ,255);
$pdf->SetTextColor(0,0 ,0);

$pdf->MultiCell(18, 9,'Matricule', 1, 'C', 1, 0);
$pdf->MultiCell(34, 9,'Nom & prenom',1, 'C', 1, 0);
$pdf->MultiCell(18, 9,'Salaire Brut',1, 'C', 1, 0);
$pdf->MultiCell(20, 9,'Temps accumulés(mn)',1, 'C', 1, 0);
$pdf->MultiCell(20, 9,'Salaire',1, 'C', 1, 0);
$pdf->MultiCell(20, 9,'Mise a pied',1, 'C', 1, 0);
$pdf->MultiCell(18, 9,'Avance',1, 'C', 1, 0);
$pdf->MultiCell(20, 9,'NET Arrondi',1, 'C', 1, 0);
$pdf->MultiCell(18, 9,'visa',1, 'C', 1, 0);

$pdf->ln(9);
$i=0;
$j=0;
while($row = @mysql_fetch_array($r))

 {
 $j++;
 $i++;
 
 if ($j==23){
$pdf->setPrintHeader(false);

 $pdf->AddPage('P', 'A4');
 $j=1;
 $pdf->ln(2);
 }
$mat=$row['matricule']; 
$req2= mysql_query("SELECT * FROM personnel_info where matricule ='$mat'");
$data=mysql_fetch_array($req2);
$nbm=$row['nbm_travail'];

$pdf->MultiCell(18, 8,''.$mat, 1, 'C', 1, 0);
$pdf->MultiCell(34, 8,''.$data['nom'],1, 'C', 1, 0);
$pdf->MultiCell(18, 8,''.$row['salaire_base'],1, 'C', 1, 0);
$pdf->MultiCell(20, 8,''.$nbm,1, 'C', 1, 0);
$pdf->MultiCell(20, 8,''.$row['salaireB'],1, 'C', 1, 0);
$pdf->MultiCell(20, 8,''.$row['total_mise'],1, 'C', 1, 0);
$pdf->MultiCell(18, 8,''.$row['total_avance'],1, 'C', 1, 0);
$pdf->MultiCell(20, 8,''.$row['salaireA'],1, 'C', 1, 0);
$pdf->MultiCell(18, 8,'',1, 'C', 1, 0);






$pdf->ln(8);

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