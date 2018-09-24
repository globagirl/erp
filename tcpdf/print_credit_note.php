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
        $this->Image($image_file, 5, 8, 30, 10, 'JPG', '', 'M', false, 300, '', false, false, 0, false, false, false);
        // Set font
        $this->SetFont('helvetica', 'B', 20);
        // Title
	$image_file = 'logos/tuv.jpg';
        $this->Image($image_file, 165, 8, 35, 17, 'JPG', '', 'M', false, 300, '', false, false, 0, false, false, false);
        // Set font
        $this->SetFont('helvetica', 'B', 20);
$this->ln(-2);



$tbl = <<<EOD
<table border="0" cellpadding="0" cellspacing="0">

 <tr style="color:#333333;">

 <td width="600" height="10" align="center" ><font size="40"><i>Credit note</i></font></td>

</tr>
</table>
EOD;


$this->writeHTML($tbl, true, false, false, false, '');
    }

    // Page footer
    public function Footer() {
        // Position at 15 mm from bottom
        $this->SetY(-30);
        // Set font
        $this->SetFont('helvetica', 'I', 8);
        // Page number
        $this->Cell(0,35, 'Page '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');





		 $this->SetX(10);
		 $this->Cell(0, 5, 'Tel: 00216 72 44 47 30',0, false, '', 0, '', 0, false, 'T', 'M');

		$this->SetX(10);
		$this->Cell(0,12, 'FAX: 00216 72 44 47 05',0, false, '', 0, '', 0, false, 'T', 'M');

		$this->SetX(10);
        $this->Cell(0,18, 'E-mail:contact@starzelectronics.com', 0, false, '', 0, '', 0, false, 'T', 'M');

		$this->SetX(10);
		$this->Cell(0,24, 'Web site: wwww.starzelectronics.com', 0, false, '', 0, '', 0, false, 'T', 'M');


		 $this->SetX(80);
		 $this->Cell(0, 5, 'N°RC: B134852001',0, false, '', 0, '', 0, false, 'T', 'M');

		$this->SetX(80);
		$this->Cell(0,12, 'N°CD: 804206Z ',0, false, '', 0, '', 0, false, 'T', 'M');

		$this->SetX(80);
        $this->Cell(0,20, 'N°TVA:  764435W/M/A/000', 0, false, '', 0, '', 0, false, 'T', 'M');


		 $this->SetX(150);
		 $this->Cell(0, 5, 'Account Name : STARZ ELECTRONICS ',0, false, '', 0, '', 0, false, 'T', 'M');

		$this->SetX(150);
		$this->Cell(0,12, 'Bank : BIAT ',0, false, '', 0, '', 0, false, 'T', 'M');

		$this->SetX(150);
        $this->Cell(0,18, 'IBAN : TN5908200000505100221260', 0, false, '', 0, '', 0, false, 'T', 'M');

		$this->SetX(150);
		$this->Cell(0,25, 'Code Bic : BIATTNTT ', 0, false, '', 0, '', 0, false, 'T', 'M');
 }
}


// create new PDF document
$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Pluto');
$pdf->SetTitle('credit note');



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

// set font
$CN= @$_POST['CN'];







$sql = mysql_query ("SELECT * FROM credit_note_starz WHERE idCN LIKE '$CN' ");
$row =@mysql_fetch_array($sql);
$fact=$row['IDfact'];
$sql1 = mysql_query ("SELECT * FROM fact1 WHERE num_fact='$fact' ");
$row1 =@mysql_fetch_array($sql1);
$client=$row1['client'];
$sq = mysql_query ("SELECT adress_fact,adress_liv,IDvendeur FROM client1 WHERE name_client LIKE '$client'");
$dataC=@mysql_fetch_array($sq);
$pdf->SetFont('times', 'B', 10);
// add a page
$pdf->AddPage('P', 'A4');


// set some text to print



$pdf->ln(20);
$tbl = <<<EOD

<table border="0" cellpadding="2" cellspacing="15">

  <tr style="background-color:#73C2FB;color:#333333;">
  <td width="140" align="center" > <b> Credit note   </b> </td>
  <td width="20" align="center" BGCOLOR="#FFFFFF" > <b>   </b> </td>
  <td width="100" align="center"><b>Date</b></td>

  <td width="20" align="center" BGCOLOR="#FFFFFF" > <b>   </b> </td>

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
$pdf->MultiCell(40, 5,''.$row['idCN'], 0, 'C', 1, 0);

$date = date("d-m-Y");

$pdf->SetFillColor(255,255 ,255);
$pdf->SetTextColor(0,0 ,0);
$pdf->MultiCell(14, 5,'', 0, 'C', 1, 0);




$pdf->SetFillColor(223,242 ,255);
$pdf->SetTextColor(0,0 ,0);
$pdf->MultiCell(28, 5,''.$row['dateCN'], 0, 'C', 1, 0);



$pdf->SetFillColor(255,255 ,255);
$pdf->SetTextColor(0,0 ,0);
$pdf->MultiCell(14, 5,'', 0, 'C', 1, 0);





$pdf->SetFillColor(255,255 ,255);
$pdf->SetTextColor(0,0 ,0);
$pdf->MultiCell(14, 5,'', 0, 'C', 1, 0);



$pdf->ln(18);

$tbl = <<<EOD


<table border="0" cellpadding="9" cellspacing="15">

 <tr style="background-color:#73C2FB;color:#333333;">

 <td width="200" height="8" align="center" >Shipped From </td>

 <td width="200" height="8" align="center" >BILL TO </td>

 <td width="200" height="8" align="center" >SHIP TO </td>
</tr>
</table>
EOD;
$pdf->writeHTML($tbl, true, false, false, false, '');

$pdf->ln(-8);

$pdf->SetFillColor(255,255 ,255);
$pdf->SetTextColor(0,0 ,0);
$pdf->MultiCell(4,5,'', 0, 'C', 1, 0);


$pdf->SetFillColor(223,242 ,255);
$pdf->SetTextColor(0,0 ,0);
$pdf->MultiCell(56.5, 30,''.'Starz Electronics 3 Rue Hedi Chaker 7000 Bizerte Tunisia', 0, 'C', 1, 0);

$pdf->SetFillColor(255,255 ,255);
$pdf->SetTextColor(0,0 ,0);
$pdf->MultiCell(4,5,'', 0, 'C', 1, 0);


$pdf->SetFillColor(223,242 ,255);
$pdf->SetTextColor(0,0 ,0);
$pdf->MultiCell(56.5, 30,''.$dataC['adress_fact'], 0, 'C', 1, 0);


$pdf->SetFillColor(255,255 ,255);
$pdf->SetTextColor(0,0 ,0);
$pdf->MultiCell(4,5,'', 0, 'C', 1, 0);

$pdf->SetFillColor(223,242 ,255);
$pdf->SetTextColor(0,0 ,0);
$pdf->MultiCell(56.5,30,''.$dataC['adress_liv'], 0, 'C', 1, 0);




$pdf->ln(50);


/*


$tbl = <<<EOD


<table border="0" cellpadding="1" cellspacing="15">

 <tr style="background-color:#73C2FB;color:#333333;">
 <td width="150" height="30" align="center"> Original Invoice</td>
  <td width="150" align="center"> Wrong amount </td>
 <td width="150" align="center" > Right amount </td>
 <td width="150" align="center" > To give back </td>

</tr>
</table>
EOD;

$pdf->writeHTML($tbl, true, false, false, false, '');
*/


$pdf->ln(-7);


$pdf->SetFillColor(255,255 ,255);
$pdf->SetTextColor(0,0 ,0);
$pdf->MultiCell(4, 5,'', 0, 'C', 1, 0);


$pdf->SetFillColor(223,242 ,255);
$pdf->SetTextColor(0,0 ,0);
$pdf->MultiCell("", 5,'This credit note is made against invoice n° '.$fact, 0, 'L', 1, 0);
$pdf->ln(7);
$pdf->SetFillColor(255,255 ,255);
$pdf->SetTextColor(0,0 ,0);
$pdf->MultiCell(4, 5,'', 0, 'L', 1, 0);


$pdf->SetFillColor(223,242 ,255);
$pdf->SetTextColor(0,0 ,0);
$pdf->MultiCell("", 5,'Invoice amount :'.$row1['tot_val'].' '.$row['devise'], 0, 'L', 1, 0);





$pdf->ln(7);




$pdf->ln(30);
$tbl = <<<EOD


<table border="0" cellpadding="3" cellspacing="15">

 <tr style="background-color:#73C2FB;color:#333333;">
 <td width="325"  bgcolor="#FFFFFF" align="center"> </td>
 <td width="150" align="center"> Total price </td>
</tr>
</table>
EOD;
$pdf->writeHTML($tbl, true, false, false, false, '');
$pdf->ln(-15);


$pdf->SetFillColor(255,255 ,255);
$pdf->SetTextColor(0,0 ,0);
$pdf->MultiCell(140, 5,'', 0, 'C', 1, 0);


$pdf->SetFillColor(223,242 ,255);
$pdf->SetTextColor(0,0 ,0);
$pdf->MultiCell(30, 5,''.$row['amount'], 0, 'C', 1, 0);



$pdf->ln(2);
$tbl = <<<EOD


<table border="0" cellpadding="3" cellspacing="15">

 <tr style="background-color:#73C2FB;color:#333333;">
  <td width="325"  bgcolor="#FFFFFF" align="center">  </td>
 <td width="150" align="center"> Money currency </td>
</tr>
</table>
EOD;
$pdf->writeHTML($tbl, true, false, false, false, '');
$pdf->ln(-15);

$pdf->SetFillColor(255,255 ,255);
$pdf->SetTextColor(0,0 ,0);
$pdf->MultiCell(140, 5,'', 0, 'C', 1, 0);

$pdf->SetFillColor(223,242 ,255);
$pdf->SetTextColor(0,0 ,0);
$pdf->MultiCell(30, 5,''.$row['devise'], 0, 'C', 1, 0);

$pdf->ln(2);

// set filling color




//Close and output PDF document
mysql_close();
$pdf->Output('credit_note.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+
?>
