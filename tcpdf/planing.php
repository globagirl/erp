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
        $this->SetFont('helvetica', 'B', 20);
        // Title
	// $image_file = 'logos/tuv.jpg';
        // $this->Image($image_file, 150, 20, 50, 20, 'JPG', '', 'M', false, 300, '', false, false, 0, false, false, false);
        // Set font
        $this->SetFont('helvetica', 'B', 20);
		
		
		
		$d= @$_POST['dat_exp'];
        $s= @$_POST['sem'];
        $y= @$_POST['year'];


$this->ln(10);


$tbl = <<<EOD
<table border="1" cellpadding="2" cellspacing="0" width="100%">

 <tr style="color:#333333" >
 
 <td width="100"  align="center" > <img src="img/logo.jpg"  width="85px" height="45px" /></td> 
 <td width="455" height="30" align="center" ><font size="15">Planning de Production </font></td> 
  <td width="100" height="30" align="center" ><font size="9">Ref:E-Log-02 version: 05   <br>Date :16/05/2016</font></td>
</tr>
</table>
EOD;


$this->writeHTML($tbl, true, false, false, false, '');

$this->ln(-19);




$this->SetFillColor(255,255 ,255);
$this->SetTextColor(0,0 ,0);
$this->MultiCell(170, 20,' SEM : '.$s.'-'.$y, 0, 'C', 1, 0);
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
     
		
		
		
		$d= @$_POST['dat_exp'];
        $s= @$_POST['sem'];
        $y= @$_POST['year'];



$som=0;
$sql = mysql_query ("SELECT * FROM ordre_fabrication1  WHERE date_exped_conf= '$d' ORDER BY (select categorie from produit1 where produit1.code_produit= ordre_fabrication1.produit) ASC");





$pdf->SetFont('times', 'B', 11);
// add a page
$pdf->AddPage('P', 'A4');
{

// set some text to print


$pdf->ln(20);




$tbl = <<<EOD


<table border="1" cellpadding="1" cellspacing="">

  <tr style="background-color:#c7e6fd;color:#333333;">
  <td width="80" align="center">Catégories </td> 
    <td width="85" align="center">Num° OF </td> 
  <td width="85" align="center">Num° PO</td> 
  <td width="85" align="center" >Code Produit </td> 
  <td width="80" align="center" >Longueur </td> 
  <td width="80" align="center" >QTY</td> 
  <td width="80" align="center" >Date d'échéance </td> 
 <td width="80" align="center" >Signature </td> 
  
</tr>
</table>
EOD;




$pdf->writeHTML($tbl, true, false, false, false, '');

$pdf->ln(-3);
$i=0;
while($row1 = @mysql_fetch_array($sql))

 {
 $i++;
 $produit=$row1['produit'];
 $PO=$row1['PO'];
 $sql2 = mysql_query ("SELECT * FROM produit1  WHERE code_produit= '$produit' ");
 $row3 = @mysql_fetch_array($sql2);
 $sql3 = mysql_query ("SELECT * FROM commande_items WHERE PO= '$PO' ");
 $row2 = @mysql_fetch_array($sql3);
 if ($i==30||$i==60||$i==90||$i==120){
$pdf->setPrintHeader(false);

 $pdf->AddPage('P', 'A4');
 $pdf->ln(2);
 }
 

 
 // $pdf->ln(-1);
$som=$som+$row1['qte'];
 // il faut ajouter boucle for pour ne dépasse pas les 7 cases 




$pdf->SetFillColor(255,255 ,255);
$pdf->SetTextColor(0,0 ,0);
$pdf->MultiCell(22.8, 6,''.$row3['categorie'], 1, 'C', 1, 0);


$pdf->SetFillColor(255,255 ,255);
$pdf->SetTextColor(0,0 ,0);
$pdf->MultiCell(24, 6,''.$row1['OF'],1, 'C', 1, 0);


$pdf->SetFillColor(255,255 ,255);
$pdf->SetTextColor(0,0 ,0);
$pdf->MultiCell(24, 6,''.$row1['PO'],1, 'C', 1, 0);




$pdf->SetFillColor(255,255 ,255);
$pdf->SetTextColor(0,0 ,0);
$pdf->MultiCell(24, 6,''.$row1['produit'], 1, 'C', 1, 0);


$pdf->SetFillColor(255,255,255);
$pdf->SetTextColor(0,0 ,0);
if(($row3['categorie']=="PCB") or ($row3['categorie']=="Others")){
$pdf->MultiCell(22.5, 6,'----', 1, 'C', 1, 0);
}else{
$pdf->MultiCell(22.5, 6,''.$row3['longueur'], 1, 'C', 1, 0);
}

$pdf->SetFillColor(255,255 ,255);
$pdf->SetTextColor(0,0 ,0);
$pdf->MultiCell(22.5,6,''.$row1['qte'],1, 'C', 1, 0);


$pdf->SetFillColor(255,255 ,255);
$pdf->SetTextColor(0,0 ,0);
$pdf->MultiCell(22.5, 6,''.$row1['date_exped_conf'], 1, 'C', 1, 0);


$pdf->SetFillColor(255,255 ,255);
$pdf->SetTextColor(0,0 ,0);
$pdf->MultiCell(22.5, 6,'', 1, 'C', 1, 0);


$pdf->ln(6);

}

 $pdf->ln(5);
$pdf->SetFillColor(255,255 ,255);
$pdf->SetTextColor(0,0 ,0);
$pdf->MultiCell(94, 6,'', 0, 'C', 1, 0);





$pdf->SetFillColor(255,255 ,255);
$pdf->SetTextColor(40,1 ,255);
$pdf->MultiCell(50, 6,'Total QTE  '.$som, 0, 'C', 1, 0);

$pdf->MultiCell(50, 6,' '.'NBR CMD: '.$i, 0, 'C', 1, 0);




}
// set filling color




// Close and output PDF document
mysql_close();
$pdf->Output('example_003.pdf', 'I');

// ============================================================+
// END OF FILE
// ============================================================+
?>