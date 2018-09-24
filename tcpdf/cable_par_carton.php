<?php
include('../connexion/connexionDB.php');
// Include the main TCPDF library (search for installation path).
require_once('tcpdf.php');


// Extend the TCPDF class to create custom Header and Footer
class MYPDF extends TCPDF {

    // Page header
    public function Header() {
          // Logo
        $image_file = 'img/header1.png';
        $this->Image($image_file, 5, 5, 200, 30, 'PNG', '', 'M', false, 300, '', false, false, 0, false, false, false);
        // Set font
        $this->SetFont('helvetica', 'B', 20);
        // Title

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

        $recherche= @$_POST['recherche'];
        $val= @$_POST['valeur'];
        






$pdf->SetFont('times', 'B', 11);
// add a page
$pdf->AddPage('P', 'A4');

{
$pdf->ln(20);
// set some text to print






/*$tbl = <<<EOD


<table border="1" cellpadding="1" cellspacing="">

  <tr style="background-color:#c7e6fd;color:#333333;">
  <td  align="center">Assembly ngth(m) </td> 
  <td  align="center">qty par box</td> 
  <td  align="center" >Taille de lot </td> 
  <td width="80" align="center" >Nombre paquet</td> 
  
</tr>
</table>
EOD;*/


$j=0;
		if ($recherche=="a"){
$req= mysql_query("SELECT * FROM cable_par_carton ");
}
	else if ($recherche=="long"){
$req= mysql_query("SELECT * FROM cable_par_carton where length='$val'");
}

else if($recherche=="qteB"){
$req= mysql_query("SELECT * FROM cable_par_carton where qte_par_box='$val'");
}
else if($recherche=="tlot"){
$req= mysql_query("SELECT * FROM cable_par_carton where  taille_lot='$val'");
}
else if($recherche=="nbrP"){
$req= mysql_query("SELECT * FROM cable_par_carton where nbr_paquet='$val'");
}


//$pdf->writeHTML($tbl, true, false, false, false, '');

//$pdf->ln(-4);
$pdf->SetFillColor(255,255 ,255);
$pdf->SetTextColor(0,0 ,0);
$pdf->MultiCell(45, 8,'Assembly Length(m)', 1, 'C', 1, 0);





$pdf->SetFillColor(255,255 ,255);
$pdf->SetTextColor(0,0 ,0);
$pdf->MultiCell(45, 8,'qty par box',1, 'C', 1, 0);


$pdf->SetFillColor(255,255 ,255);
$pdf->SetTextColor(0,0 ,0);
$pdf->MultiCell(45, 8,'Taille de lot ', 1, 'C', 1, 0);


$pdf->SetFillColor(255,255,255);
$pdf->SetTextColor(0,0 ,0);
$pdf->MultiCell(45, 8,'Nombre paquet', 1, 'C', 1, 0);
$pdf->ln(8);
while($row1 = @mysql_fetch_array($req))

 {

	 if($j==35){
	     $pdf->setPrintHeader(false);
		 $pdf->AddPage('P', 'A4');
		 $j=0;
	 }
	 else{
		
	    $j++; 
	 }


$pdf->SetFillColor(255,255 ,255);
$pdf->SetTextColor(0,0 ,0);
$pdf->MultiCell(45, 6,''.$row1['length'], 1, 'C', 1, 0);





$pdf->SetFillColor(255,255 ,255);
$pdf->SetTextColor(0,0 ,0);
$pdf->MultiCell(45, 6,''.$row1['qte_par_box'],1, 'C', 1, 0);


$pdf->SetFillColor(255,255 ,255);
$pdf->SetTextColor(0,0 ,0);
$pdf->MultiCell(45, 6,''.$row1['taille_lot'], 1, 'C', 1, 0);


$pdf->SetFillColor(255,255,255);
$pdf->SetTextColor(0,0 ,0);
$pdf->MultiCell(45, 6,''.$row1['nbr_paquet'], 1, 'C', 1, 0);



$pdf->ln(6);

}
 





}
// set filling color




// Close and output PDF document
mysql_close();
$pdf->Output('example_003.pdf', 'I');

// ============================================================+
// END OF FILE
// ============================================================+
?>