<?php
session_start();
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
        $this->SetFont('helvetica', 'B', 20);
        // Title
	// $image_file = 'logos/tuv.jpg';
        // $this->Image($image_file, 150, 20, 50, 20, 'JPG', '', 'M', false, 300, '', false, false, 0, false, false, false);
        // Set font
        $this->SetFont('helvetica', 'B', 20);
		
		
       


$this->ln(10);


$tbl = <<<EOD
<table border="1" cellpadding="2" cellspacing="0" width="100%">

 <tr style="color:#333333" >
 
 <td width="100"  align="center" > <img src="img/logo.jpg"  width="85px" height="45px" /></td> 
 <td width="455" height="30" align="center" ><font size="15"><br>Demande de relance </font></td> 
  <td width="100" height="30" align="center" ><font size="9">Ref:E-Log-06 version: 01   <br>Date :16/05/2016</font></td>
</tr>
</table>
EOD;


$this->writeHTML($tbl, true, false, false, false, '');

$this->ln(-19);




$this->SetFillColor(255,255 ,255);
$this->SetTextColor(0,0 ,0);
$this->MultiCell(170, 20,'', 0, 'C', 1, 0);
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
     
	$demande=$_POST['demande'];

 $IDoperateur=$_SESSION['userID'];
 include('../connexion/connexionDB.php');
 $sqlOP=mysql_query("select nom from users1 where ID='$IDoperateur'");
 $user=mysql_result($sqlOP,0);
$sql = "UPDATE demande_relance SET statut='C',dateV=NOW(),verificateur='$user' WHERE IDrelance='$demande'";


if (!mysql_query($sql)) {
die('Error: ' . mysql_error()); 
    header('Location: ../pages/relance_confirmation.php?status=fail');
}else{
  $His=mysql_query("INSERT INTO historique(user_id,action,tab,ligne,date_heure)VALUES('$IDoperateur','add','confirmation relance','$demande',NOW())"); 
   
} 





$pdf->SetFont('times', 'B', 11);
// add a page
$pdf->AddPage('P', 'A4');


// set some text to print


$pdf->ln(20);
$sql = mysql_query("SELECT * FROM demande_relance where IDrelance='$demande'");
$data=mysql_fetch_array($sql);
$pdf->SetFillColor(255, 255, 255);
$pdf->MultiCell(185, 8, 'Production', 1, 'C', 1, 0, '', '', true);
$pdf->ln(8);
$pdf->MultiCell(55, 6, 'Relance N° : '.$data['IDrelance'], 1, 'C', 1, 0, '', '', true);
$pdf->MultiCell(75, 6, 'Demandeur : '.$data['demandeur'], 1, 'C', 1, 0, '', '', true);
$pdf->MultiCell(55, 6, 'Date demande :  '.$data['dateD'], 1, 'C', 1, 0, '', '', true);
$pdf->ln(6);
$pdf->MultiCell(92, 6, 'PO client : '.$data['PO'], 1, 'C', 1, 0, '', '', true);
$pdf->MultiCell(93, 6, 'Article : '.$data['produit'], 1, 'C', 1, 0, '', '', true);
//$pdf->MultiCell(55, 6, 'Qty a relancer:  '.$data['qty']. ' pc', 1, 'C', 1, 0, '', '', true);
$pdf->ln(6);
$pdf->MultiCell(185, 8, '', 1, 'L', 1, 0, '', '', true);
$pdf->ln(8);
$pdf->MultiCell(65, 10, 'Caude de demande : ', 1, 'C', 1, 0, '', '', true);
$pdf->MultiCell(120, 10, ''.$data['cause'], 1, 'C', 1, 0, '', '', true);

$pdf->ln(10);
$pdf->MultiCell(65, 10, 'Détail : ', 1, 'C', 1, 0, '', '', true);
$pdf->MultiCell(120, 10, ''.$data['detail'], 1, 'C', 1, 0, '', '', true);

$pdf->ln(10);
$pdf->MultiCell(185, 8, '', 1, 'L', 1, 0, '', '', true);

$pdf->ln(8);
$pdf->MultiCell(185, 6, '   Quantité à relancer : '.$data['qty'] . ' pc', 1, 'L', 1, 0, '', '', true);
$pdf->ln(6);
$pdf->MultiCell(10, 6, 'N°', 1, 'C', 1, 0, '', '', true);
$pdf->MultiCell(80, 6, 'Item ID  ', 1, 'C', 1, 0, '', '', true);
$pdf->MultiCell(55, 6, 'Qty   ', 1, 'C', 1, 0, '', '', true);
$pdf->MultiCell(40, 6, 'visa   ', 1, 'C', 1, 0, '', '', true);
$pdf->ln(6);
$sql2 = mysql_query("SELECT * FROM demande_relance_items where IDrelance='$demande'");
$i=0;
while($data2=mysql_fetch_array($sql2)){
$i++;
$pdf->MultiCell(10, 6, ''.$i, 1, 'C', 1, 0, '', '', true);
$pdf->MultiCell(80, 6, ''.$data2['item'], 1, 'C', 1, 0, '', '', true);
$pdf->MultiCell(55, 6, ''.$data2['qty'], 1, 'C', 1, 0, '', '', true);
$pdf->MultiCell(40, 6, '', 1, 'C', 1, 0, '', '', true);
$pdf->ln(6);
}

$pdf->ln(10);

//Qualite
$pdf->MultiCell(185, 8, 'Qualité', 1, 'C', 1, 0, '', '', true);
$pdf->ln(8);
$pdf->MultiCell(55, 6, 'Vérificateur ', 1, 'C', 1, 0, '', '', true);

$pdf->MultiCell(55, 6, 'Date verification   ', 1, 'C', 1, 0, '', '', true);
$pdf->MultiCell(75, 6, 'Visa ', 1, 'C', 1, 0, '', '', true);
$pdf->ln(6);
$pdf->MultiCell(55, 6, ''.$data['verificateur'], 1, 'C', 1, 0, '', '', true);

$pdf->MultiCell(55, 6, ''.$data['dateV'], 1, 'C', 1, 0, '', '', true);
$pdf->MultiCell(75, 6, '', 1, 'C', 1, 0, '', '', true);



// Close and output PDF document
//$pdf->writeHTML($html, true, 0, true, 0);
$pdf->Output('example_003.pdf', 'I');

// ============================================================+
// END OF FILE
// ============================================================+