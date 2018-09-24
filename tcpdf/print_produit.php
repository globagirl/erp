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
<table border="1" cellpadding="2" cellspacing="0" width="100%">

 <tr style="color:#333333" >
 
 <td width="100"  align="center" > <img src="img/logo.jpg"  width="85px" height="60px" /></td> 
 <td width="455" height="30" align="center" ><br><font size="18">Item Accounting </font><br><br><br></td> 
  <td width="100" height="30" align="center" ><br><font size="9"><br>Ref:E-Fin-01 version: 01   <br>Date :05/07/2016</font></td>
</tr>
</table>
EOD;


$this->writeHTML($tbl, true, false, false, false, '');

$this->ln(-19);



$date1= date("F j, Y");


$this->SetFillColor(255,255 ,255);
$this->SetTextColor(0,0 ,0);
$this->MultiCell(180, 15,'Date: '.$date1, 0, 'C', 1, 0);
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
$pdf->SetAuthor('Pluto');
$pdf->SetTitle('Item accounting');
//$pdf->SetSubject('TCPDF Tutorial');
//$pdf->SetKeywords('TCPDF, PDF, example, test, guide');

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

$valeur=@$_POST['valeur'];
$recherche=$_POST['recherche'];

if($recherche=="a"){
$req= "SELECT * FROM produit1";
}
 else{
$req= "SELECT * FROM produit1 where $recherche='$valeur'";
}



$pdf->SetFont('times', 'B', 11);
// add a page
$pdf->AddPage('P', 'A4');
{

// set some text to print


$r=mysql_query($req) or die(mysql_error());
$pdf->ln(30);

$pdf->SetFillColor(223,242 ,255);
$pdf->MultiCell(8, 10, ' N° ', 1, 'C', 1, 0, '', '', true);
$pdf->MultiCell(30, 10, 'Item Id ', 1, 'C', 1, 0, '', '', true);
$pdf->MultiCell(65, 10, 'Description', 1, 'C', 1, 0, '', '', true);
$pdf->MultiCell(20, 10, 'Category', 1, 'C', 1, 0, '', '', true);
$pdf->MultiCell(20, 10, 'Length', 1, 'C', 1, 0, '', '', true);
$pdf->MultiCell(20, 10, 'Taille du lot', 1, 'C', 1, 0, '', '', true);
$pdf->MultiCell(22, 10, 'Price', 1, 'C', 1, 0, '', '', true);


$pdf->ln(10);
$i=1;
$j=0;

$pdf->SetFont('times', 'B', 10);
while($a = @mysql_fetch_object($r))

 {

 
 if ($j==20){
$pdf->setPrintHeader(false);

 $pdf->AddPage('P', 'A4');
 $j=1;
 $pdf->ln(2);
 }
   $produit=$a->code_produit;
	 $cat=$a->categorie;
	 $long=$a->longueur;
	 $desc=$a->description;
	 $tLot=$a->taille_lot;
     //Price	 
	  $req1= mysql_query("SELECT price FROM prices where IDproduit LIKE '$produit' or IDproduit ='$produit'");
	$price=@mysql_result($req1,0);
	//Affichage
	if($price == null){
	$pdf->SetFillColor(225, 187, 221);
	
	}else{
	$pdf->SetFillColor(255, 255, 255);
	}
	///
	
	//
   $pdf->MultiCell(8, 10, ''.$i, 1, 'C', 1, 0, '', '', true);
   
   $pdf->MultiCell(30, 10, ''.$produit, 1, 'C', 1, 0, '', '', true);
   $pdf->MultiCell(65, 10, ''.$desc, 1, 'C', 1, 0, '', '', true);
   $pdf->MultiCell(20,10, ''.$cat, 1, 'C', 1, 0, '', '', true);
   $pdf->MultiCell(20, 10, ''.$long, 1, 'C', 1, 0, '', '', true);
   $pdf->MultiCell(20, 10, ''.$tLot, 1, 'C', 1, 0, '', '', true);
   $pdf->MultiCell(22, 10, ''.$price, 1, 'C', 1, 0, '', '', true);
  
   $i++;
   $j++;
   $pdf->ln(10);
	
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