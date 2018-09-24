<?php
session_start ();
include('../connexion/connexionDB.php');
// Include the main TCPDF library (search for installation path).
require_once('tcpdf.php');
// Extend the TCPDF class to create custom Header and Footer
class MYPDF extends TCPDF {
      //Page header
    public function Header() {
        // Logo
        $image_file = 'img/logo.jpg';
        $this->Image($image_file, 5, 8, 30, 10, 'JPG', '', 'M', false, 300, '', false, false, 0, false, false, false);
        // Set font
        $this->SetFont('helvetica', 'B', 20);
        // Title
	      $image_file = 'logos/tuv.jpg';
        $this->Image($image_file, 165, 8, 35, 17, 'JPG', '', 'M', false, 300, '', false, false, 0, false, false, false);
        // Set font
        $this->SetFont('helvetica', 'B', 20);

    }
    // Page footer
    public function Footer() {
        // Position at 15 mm from bottom
        $this->SetY(-15);
        // Set font
        $this->SetFont('helvetica', 'I', 10);
        // Page number
        $this->Cell(0, 10, 'Page '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
    }

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

$dateJ=date('Y-m-d');
$dateJ2=date('Ymd');

if(isset($_POST['IDdevis'])){
$IDdevis=$_POST['IDdevis'];
$_SESSION['IDdevis']=$IDdevis;
}else{
$IDdevis=$_SESSION['IDdevis'];
}
$pdf->AddPage('P', 'A4');

$sql=@mysql_query("SELECT * from demande_devis where IDdemande='$IDdevis'");
$data=mysql_fetch_array($sql);
//

$pdf->SetFont('times', 'B', 10);
// set some text to print
$pdf->ln(20);
$tbl = <<<EOD
<table border="0" cellpadding="0" cellspacing="0">
 <tr style="color:#333333;">
   <td width="40" height="10" align="center" ></td>
   <td width="400" height="10" align="center" ><font size="30">Devis </font></td>
</tr>
</table>
EOD;
$pdf->writeHTML($tbl, true, false, false, false, '');
$pdf->ln(10);

$tbl = <<<EOD
<table border="0" cellpadding="2" cellspacing="15">
  <tr style="background-color:#73C2FB;color:#333333;">
    <td width="140" align="center"> <b> N° demande </b> </td>
    <td width="140" align="center"> <b> Date  </b> </td>
  </tr>
</table>

EOD;
$pdf->writeHTML($tbl, true, false, false, false, '');
$pdf->ln(-8);

$pdf->SetFillColor(255,255 ,255);
$pdf->SetTextColor(0,0 ,0);
$pdf->MultiCell(4, 5,'', 0, 'C', 1, 0);


$pdf->SetFillColor(223,242 ,255);
$pdf->SetTextColor(0,0 ,0);
$pdf->MultiCell(40, 5,'D'.$IDdevis, 0, 'C', 1, 0);


$pdf->SetFillColor(255,255 ,255);
$pdf->SetTextColor(0,0 ,0);
$pdf->MultiCell(4, 5,'', 0, 'C', 1, 0);


$pdf->SetFillColor(223,242 ,255);
$pdf->SetTextColor(0,0 ,0);
$pdf->MultiCell(40, 5,$data['dateE'], 0, 'C', 1, 0);
$pdf->ln(15);
$tbl = <<<EOD


<table border="0" cellpadding="2" cellspacing="15">

 <tr style="background-color:#73C2FB;color:#333333;">
 <td width="190" bgcolor="#FFFFFF" colspan="12"></td>

 <td width="180" height="5" align="center" >Client </td>
</tr>
</table>
EOD;
$pdf->writeHTML($tbl, true, false, false, false, '');

$pdf->ln(-8);

$pdf->SetFillColor(255,255 ,255);
$pdf->SetTextColor(0,0 ,0);
$pdf->MultiCell(109,5,'', 0, 'C', 1, 0);

$pdf->SetFillColor(223,242 ,255);
$pdf->SetTextColor(0,0 ,0);
$pdf->MultiCell(50,24,$data['client'], 0, 'C', 1, 0);

$pdf->ln(30);
$tbl = <<<EOD
<table border="0" cellpadding="1" cellspacing="15">
  <tr style="background-color:#73C2FB;color:#333333;">
  <td width="140" align="center"> Ref </td>
  <td width="360" align="center">Description </td>
  <td width="70" align="center" > Unit price</td>

</tr>
</table>
EOD;

$pdf->writeHTML($tbl, true, false, false, false, '');
$pdf->ln(-8);
$i=1;
  $sq=mysql_query("select * FROM demande_devis_produit where IDdemande='$IDdevis'");
while($data2=mysql_fetch_array($sq)){
$prd=$data2['IDproduit'];
$prixU=$data2['prixU'];
$pdf->SetFillColor(255,255 ,255);
$pdf->SetTextColor(0,0 ,0);
$pdf->MultiCell(4, 5,'', 0, 'C', 1, 0);


$pdf->SetFillColor(223,242 ,255);
$pdf->SetTextColor(0,0 ,0);
$pdf->MultiCell(40, 5,''.$prd, 0, 'C', 1, 0);
$pdf->SetFillColor(255,255 ,255);
$pdf->SetTextColor(0,0 ,0);
$pdf->MultiCell(4, 5,'', 0, 'C', 1, 0);

$sql4 = mysql_query ("SELECT description FROM produit1 WHERE code_produit = '$prd' ");
$description = @mysql_result($sql4,0);

$pdf->SetFillColor(223,242 ,255);
$pdf->SetTextColor(0,0 ,0);
$pdf->MultiCell(102, 5,''.$description, 0, 'C', 1, 0);

$pdf->SetFillColor(255,255 ,255);
$pdf->SetTextColor(0,0 ,0);
$pdf->MultiCell(4, 5,'', 0, 'C', 1, 0);

$pdf->SetFillColor(223,242 ,255);
$pdf->SetTextColor(0,0 ,0);
$pdf->MultiCell(20, 5,''.$prixU, 0, 'C', 1, 0);


$pdf->SetFillColor(255,255 ,255);
$pdf->SetTextColor(0,0 ,0);
$pdf->MultiCell(4, 5,'', 0, 'C', 1, 0);
$pdf->ln(8);
$i++;
}

$pdf->ln(6);
//PRIX total
$tbl = <<<EOD


<table border="0" cellpadding="3" cellspacing="15">

 <tr style="background-color:#73C2FB;color:#333333;">
 <td width="325"  bgcolor="#FFFFFF" align="center"> </td>
 <td width="150" align="center"> Devise </td>
</tr>
</table>
EOD;
$pdf->writeHTML($tbl, true, false, false, false, '');
$pdf->ln(-15);
$pdf->SetFillColor(255,255 ,255);
$pdf->SetTextColor(0,0 ,0);
$pdf->MultiCell(145, 6,'', 0, 'C', 1, 0);

$pdf->SetFillColor(223,242 ,255);
$pdf->SetTextColor(0,0 ,0);
$pdf->MultiCell(30, 6,''.$data['devise'], 0, 'C', 1, 0);



$pdf->ln(2);
//

mysql_close();
//Close and output PDF document
$pdf->Output('demande_prix.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+
?>
