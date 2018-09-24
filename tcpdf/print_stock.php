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
 <td width="455" height="30" align="center" ><br><font size="18">Fiche stock magazin </font><br><br><br></td> 
  <td width="100" height="30" align="center" ><br><font size="9">Ref:E-Log-02 version: 05   <br>Date :16/05/2016</font></td>
</tr>
</table>
EOD;


$this->writeHTML($tbl, true, false, false, false, '');

$this->ln(-19);

$date = date("d/m/Y");


$this->SetFillColor(255,255 ,255);
$this->SetTextColor(0,0 ,0);
$this->MultiCell(180, 15,'Le :'.$date, 0, 'C', 1, 0);
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
 $valeur=@$_POST['valeur'];
$recherche=@$_POST['recherche'];
$statut=@$_POST['statut'];
if($statut=="a"){
if($recherche=="a"){
$req= "SELECT * FROM article1";
}
 else{
$req= "SELECT * FROM article1 where $recherche like '$valeur'";
}} else if($statut=="StockN"){
if($recherche=="a"){
$req= "SELECT * FROM article1 where stock=0";
} else {
$req= "SELECT * FROM article1 where $recherche like '$valeur' and stock=0";
}
}
 else if($statut=="StockNN"){
if($recherche=="a"){
$req= "SELECT * FROM article1 where stock >0";
}
 else{
$req= "SELECT * FROM article1 where $recherche like '$valeur' and stock>0";
}
 }


  $r=mysql_query($req) or die(mysql_error());


$pdf->SetFont('times', 'B', 10);
// add a page
$pdf->AddPage('P', 'A4');
{

// set some text to print


$pdf->ln(20);




$pdf->SetFillColor(255,255 ,255);
$pdf->SetTextColor(0,0 ,0);
$pdf->MultiCell(12, 8,'N°', 1, 'C', 1, 0);


$pdf->SetFillColor(255,255 ,255);
$pdf->SetTextColor(0,0 ,0);
$pdf->MultiCell(36, 8,'Item',1, 'C', 1, 0);


$pdf->SetFillColor(255,255 ,255);
$pdf->SetTextColor(0,0 ,0);
$pdf->MultiCell(90, 8,'Description',1, 'C', 1, 0);




$pdf->SetFillColor(255,255 ,255);
$pdf->SetTextColor(0,0 ,0);
$pdf->MultiCell(24, 8,'Stock', 1, 'C', 1, 0);
//$pdf->MultiCell(22, 8,'Total paquet', 1, 'C', 1, 0);


$pdf->SetFillColor(255,255,255);
$pdf->SetTextColor(0,0 ,0);

$pdf->MultiCell(20, 8,'Visa', 1, 'C', 1, 0);



$pdf->ln(8);


$i=0;
$j=0;
while($row = @mysql_fetch_array($r))

 {
 $j++;
 $i++;
 
 if ($j==27){
$pdf->setPrintHeader(false);

 $pdf->AddPage('P', 'A4');
 $j=1;
 $pdf->ln(5);
 }
 

 
 // $pdf->ln(-1);

 // il faut ajouter boucle for pour ne dépasse pas les 7 cases 
$article=$row['code_article'];
$reqS= mysql_query("SELECT sum(qte_res) FROM paquet2 where IDarticle='$article' or IDarticle LIKE '$article'");
	$somme=mysql_result($reqS,0);
	$somme=round($somme,4);


$pdf->SetFillColor(255,255 ,255);
$pdf->SetTextColor(0,0 ,0);
$pdf->MultiCell(12, 8,''.$i, 1, 'C', 1, 0);


$pdf->SetFillColor(255,255 ,255);
$pdf->SetTextColor(0,0 ,0);
$pdf->MultiCell(36, 8,''.$row['code_article'],1, 'C', 1, 0);


$pdf->SetFillColor(255,255 ,255);
$pdf->SetTextColor(0,0 ,0);
$pdf->MultiCell(90, 8,''.$row['description'],1, 'C', 1, 0);


$stock=$row['stock'];
if($stock==$somme){
$c1=255;
$c2=255;
$c3=255;
}else{
/*$c1=225;
$c2=210;
$c3=115;*/
$c1=255;
$c2=255;
$c3=255;
}

$pdf->SetFillColor($c1,$c2 ,$c3);
$pdf->SetTextColor(0,0 ,0);
$pdf->MultiCell(24, 8,''.$row['stock'].' '.$row['unit'], 1, 'C', 1, 0);
//$pdf->MultiCell(22, 8,''.$somme.' '.$row['unit'], 1, 'C', 1, 0);


$pdf->SetFillColor(255,255,255);
$pdf->SetTextColor(0,0 ,0);
$pdf->MultiCell(20, 8,'', 1, 'C', 1, 0);



$pdf->ln(8);

}

$pdf->ln(8);

$pdf->SetFillColor(255,255 ,255);
$pdf->SetTextColor(40,1 ,255);
$pdf->MultiCell(50, 6,'', 0, 'C', 1, 0);

$pdf->MultiCell(50, 6,' '.'NBR : '.$i, 0, 'C', 1, 0);




}
// set filling color




// Close and output PDF document
mysql_close();
$pdf->Output('example_003.pdf', 'I');

// ============================================================+
// END OF FILE
// ============================================================+
?>