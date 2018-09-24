<?php
include('../connexion/connexionDB.php');
// Include the main TCPDF library (search for installation path).
require_once('tcpdf.php');


// Extend the TCPDF class to create custom Header and Footer
class MYPDF extends TCPDF {

    // Page header
   public function Header() {
     $this->SetFont('times', 'B', 12);
     $this->ln(10);
     $tbl = <<<EOD
<table border="1" cellpadding="4" cellspacing="0" width="100%">

 <tr style="color:#333333" >
 
 <td width="100"  align="center" > <br><br><img src="img/logo.jpg"  width="85px" height="45px" /></td> 
 <td width="455" height="30" align="center" ><br><br><br><font size="18">FINAL CHECK </font><br>
 <br>
 <br></td> 
  <td width="94" height="30" align="center" ><br><br><font size="9">Ref:E-PRO-15 version: 01   <br>Date :15/06/2012</font></td>
</tr>
</table>
EOD;


$this->writeHTML($tbl, true, false, false, false, '');


    }

    // Page footer
    public function Footer() {
       $this->SetY(-15);
        // Set font
        $this->SetFont('helvetica', 'I', 8);
        // Page number
        $this->Cell(0, 10, 'Page '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
     
    }
	
}

// create new PDF document
$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

//$pdf = new TCPDF('p', 'mm', $pageLayout, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Pluto');


// set default header data
//$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);

// set header and footer fonts
/*
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));*/

// set default monospaced font
//$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
/*
// set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);*/

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE,0);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// set some language-dependent strings (optional)
if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
    require_once(dirname(__FILE__).'/lang/eng.php');
    $pdf->setLanguageArray($l);
}

// ---------------------------------------------------------

$dateE=$_POST['dateE'];
$DDtime = strtotime($dateE);
$num_semaine = strftime("%W",$DDtime);
$year= strftime("%Y",$DDtime);
$DD=$year.$num_semaine;
$req= mysql_query("SELECT PO,produit FROM ordre_fabrication1 where date_exped_conf='$dateE'");
 $pdf->setPrintHeader(true);
$pdf->setPrintFooter(true);

while($row = @mysql_fetch_array($req)) {
//$pdf->SetMargins(0, 0, 0,true);
$pdf->AddPage();
$pdf->setCellPaddings(2, 2, 0, 0);
$pdf->SetFont('times', 'B', 10);


$PO=$row['PO'];
$produit=$row['produit'];
$req2= mysql_query("SELECT nbr_box FROM produit1 where code_produit ='$produit'");
$nbrBox=mysql_result($req2,0);
$pdf->SetFillColor(255,255 ,255);
$pdf->SetTextColor(0,0 ,0);
$pdf->SetXY(10, 50);
$pdf->MultiCell(80, 9,'Purchase order : '.$PO, 1, 'L', 1, 0,'', '',true);

//Les AFFICHAGE
$pdf->setCellPaddings(1, 0, 0, 0);
$pdf->SetXY(70, 162);
$pdf->MultiCell(50, 9,'Order: '.$PO, 0, 'L', 1, 0,'', '',true);
$pdf->SetXY(70, 177);
$pdf->MultiCell(58, 9,'Part Number: '.$produit, 0, 'L', 1, 0,'', '',true);
$pdf->SetXY(70, 190);
$pdf->MultiCell(50, 9,'Batch : '.$DD, 0, 'L', 1, 0,'', '',true);
$pdf->SetXY(70, 226);
$pdf->MultiCell(50, 9,'NBR Cable/Box : '.$nbrBox, 0, 'L', 1, 0,'', '',true);
//$pdf->setCellPaddings(2, 4, 6, 8);
//Left=2, Top=4, Right=6, Bottom=8
//Cable label
$pdf->SetXY(10, 62);
$pdf->setCellPaddings(2, 20, 2, 20);
$pdf->MultiCell(40, 8,'Cable Label', 1, 'C', 1, 0,'', '',true);
//
$pdf->SetXY(50, 62);
$pdf->SetFont('times', 'B', 8);
$pdf->setCellPaddings(0, 1, 0, 1);
$pdf->MultiCell(18, 8,'Samples NBR', 1, 'C', 1, 0,'', '',true);
//
$pdf->SetXY(50, 70);
$pdf->setCellPaddings(2, 16, 2, 17);
$pdf->MultiCell(18, 8,'', 1, 'C', 1, 0,'', '',true);
//
$pdf->SetXY(68, 62);
$pdf->setCellPaddings(2, 21, 2, 20);
$pdf->MultiCell(60, 8,'', 1, 'C', 1, 0,'', '',true);
//
$pdf->SetXY(128, 62);
$pdf->SetFont('times', 'B', 8);
$pdf->setCellPaddings(0, 1, 0, 1);
$pdf->MultiCell(25, 8,'OK/Not OK', 1, 'C', 1, 0,'', '',true);
//
$pdf->SetXY(128, 70);
$pdf->setCellPaddings(2, 16, 2, 17);
$pdf->MultiCell(25, 8,'', 1, 'C', 1, 0,'', '',true);
//
$pdf->SetXY(153, 62);
$pdf->SetFont('times', 'B', 8);
$pdf->setCellPaddings(0, 1, 0, 1);
$pdf->MultiCell(20, 8,'Date', 1, 'C', 1, 0,'', '',true);
//
$pdf->SetXY(153, 70);
$pdf->setCellPaddings(2, 16, 2, 17);
$pdf->MultiCell(20, 8,'', 1, 'C', 1, 0,'', '',true);
//
$pdf->SetXY(173, 62);
$pdf->SetFont('times', 'B', 8);
$pdf->setCellPaddings(0, 1, 0, 1);
$pdf->MultiCell(20, 8,'Signature', 1, 'C', 1, 0,'', '',true);
//
$pdf->SetXY(173, 70);
$pdf->setCellPaddings(2, 16, 2, 17);
$pdf->MultiCell(20, 8,'', 1, 'C', 1, 0,'', '',true);

//Plastic bag label +48
$pdf->SetXY(10, 110);
$pdf->SetFont('times', 'B', 10);
$pdf->setCellPaddings(2, 20, 2, 20);
$pdf->MultiCell(40, 8,'Plastic bag Label', 1, 'C', 1, 0,'', '',true);
//
$pdf->SetXY(50, 110);
$pdf->SetFont('times', 'B', 8);
$pdf->setCellPaddings(0, 1, 0, 1);
$pdf->MultiCell(18, 8,'Samples NBR', 1, 'C', 1, 0,'', '',true);
//
$pdf->SetXY(50, 118);
$pdf->setCellPaddings(2, 16, 2, 17);
$pdf->MultiCell(18, 8,'', 1, 'C', 1, 0,'', '',true);
//
$pdf->SetXY(68, 110);
$pdf->setCellPaddings(2, 21, 2, 20);
$pdf->MultiCell(60, 8,'', 1, 'C', 1, 0,'', '',true);
//
$pdf->SetXY(128, 110);
$pdf->SetFont('times', 'B', 8);
$pdf->setCellPaddings(0, 1, 0, 1);
$pdf->MultiCell(25, 8,'OK/Not OK', 1, 'C', 1, 0,'', '',true);
//
$pdf->SetXY(128, 118);
$pdf->setCellPaddings(2, 16, 2, 17);
$pdf->MultiCell(25, 8,'', 1, 'C', 1, 0,'', '',true);
//
$pdf->SetXY(153, 110);
$pdf->SetFont('times', 'B', 8);
$pdf->setCellPaddings(0, 1, 0, 1);
$pdf->MultiCell(20, 8,'Date', 1, 'C', 1, 0,'', '',true);
//
$pdf->SetXY(153, 118);
$pdf->setCellPaddings(2, 16, 2, 17);
$pdf->MultiCell(20, 8,'', 1, 'C', 1, 0,'', '',true);
//
$pdf->SetXY(173, 110);
$pdf->SetFont('times', 'B', 8);
$pdf->setCellPaddings(0, 1, 0, 1);
$pdf->MultiCell(20, 8,'Signature', 1, 'C', 1, 0,'', '',true);
//
$pdf->SetXY(173, 118);
$pdf->setCellPaddings(2, 16, 2, 17);
$pdf->MultiCell(20, 8,'', 1, 'C', 1, 0,'', '',true);

//Box label +48
$pdf->SetXY(10, 158);
$pdf->SetFont('times', 'B', 10);
$pdf->setCellPaddings(2, 20, 2, 20);
$pdf->MultiCell(40, 8,'Box Label', 1, 'C', 1, 0,'', '',true);
//
$pdf->SetXY(50, 158);
$pdf->SetFont('times', 'B', 8);
$pdf->setCellPaddings(0, 1, 0, 1);
$pdf->MultiCell(18, 8,'Samples NBR', 1, 'C', 1, 0,'', '',true);
//
$pdf->SetXY(50, 166);
$pdf->setCellPaddings(2, 16, 2, 17);
$pdf->MultiCell(18, 8,'', 1, 'C', 1, 0,'', '',true);
//
$pdf->SetXY(68, 158);
$pdf->setCellPaddings(2, 21, 2, 20);
$pdf->MultiCell(60, 8,'', 1, 'C', 1, 0);
//
$pdf->SetXY(128, 158);
$pdf->SetFont('times', 'B', 8);
$pdf->setCellPaddings(0, 1, 0, 1);
$pdf->MultiCell(25, 8,'OK/Not OK', 1, 'C', 1, 0);
//
$pdf->SetXY(128, 166);
$pdf->setCellPaddings(2, 16, 2, 17);
$pdf->MultiCell(25, 8,'', 1, 'C', 1, 0);
//
$pdf->SetXY(153, 158);
$pdf->SetFont('times', 'B', 8);
$pdf->setCellPaddings(0, 1, 0, 1);
$pdf->MultiCell(20, 8,'Date', 1, 'C', 1, 0);
//
$pdf->SetXY(153, 166);
$pdf->setCellPaddings(2, 16, 2, 17);
$pdf->MultiCell(20, 8,'', 1, 'C', 1, 0);
//
$pdf->SetXY(173, 158);
$pdf->SetFont('times', 'B', 8);
$pdf->setCellPaddings(0, 1, 0, 1);
$pdf->MultiCell(20, 8,'Signature', 1, 'C', 1, 0);
//
$pdf->SetXY(173, 166);
$pdf->setCellPaddings(2, 16, 2, 17);
$pdf->MultiCell(20, 8,'', 1, 'C', 1, 0);


//QTY +48
$pdf->SetXY(10, 206);
$pdf->SetFont('times', 'B', 10);
$pdf->setCellPaddings(2, 20, 2, 20);
$pdf->MultiCell(40, 8,'QTY / BOX', 1, 'C', 1, 0);
//
$pdf->SetXY(50, 206);
$pdf->SetFont('times', 'B', 8);
$pdf->setCellPaddings(0, 1, 0, 1);
$pdf->MultiCell(18, 8,'Samples NBR', 1, 'C', 1, 0);
//
$pdf->SetXY(50, 214);
$pdf->setCellPaddings(2, 16, 2, 17);
$pdf->MultiCell(18, 8,'', 1, 'C', 1, 0);
//
$pdf->SetXY(68, 206);
$pdf->setCellPaddings(2, 21, 2, 20);
$pdf->MultiCell(60, 8,'', 1, 'C', 1, 0);
//
$pdf->SetXY(128, 206);
$pdf->SetFont('times', 'B', 8);
$pdf->setCellPaddings(0, 1, 0, 1);
$pdf->MultiCell(25, 8,'OK/Not OK', 1, 'C', 1, 0);
//
$pdf->SetXY(128, 214);
$pdf->setCellPaddings(2, 16, 2, 17);
$pdf->MultiCell(25, 8,'', 1, 'C', 1, 0);
//
$pdf->SetXY(153, 206);
$pdf->SetFont('times', 'B', 8);
$pdf->setCellPaddings(0, 1, 0, 1);
$pdf->MultiCell(20, 8,'Date', 1, 'C', 1, 0);
//
$pdf->SetXY(153, 214);
$pdf->setCellPaddings(2, 16, 2, 17);
$pdf->MultiCell(20, 8,'', 1, 'C', 1, 0);
//
$pdf->SetXY(173, 206);
$pdf->SetFont('times', 'B', 8);
$pdf->setCellPaddings(0, 1, 0, 1);
$pdf->MultiCell(20, 8,'Signature', 1, 'C', 1, 0);
//
$pdf->SetXY(173, 214);
$pdf->setCellPaddings(2, 16, 2, 17);
$pdf->MultiCell(20, 8,'', 1, 'C', 1, 0);
}








 
// set filling color




// Close and output PDF document
mysql_close();
$pdf->Output('final_check.pdf', 'I');

// ============================================================+
// END OF FILE
// ============================================================+
?>