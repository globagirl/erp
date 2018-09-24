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
 <td width="455" height="30" align="center" ><br><font size="18">Invoices List </font><br><br><br></td> 
  <td width="100" height="30" align="center" ><br><font size="9">Ref:E-Fin-01 version: 01   <br>Date :16/05/2016</font></td>
</tr>
</table>
EOD;


$this->writeHTML($tbl, true, false, false, false, '');

$this->ln(-19);

$date = date("d/m/Y");


$this->SetFillColor(255,255 ,255);
$this->SetTextColor(0,0 ,0);
$this->MultiCell(180, 15,'Date :'.$date, 0, 'C', 1, 0);
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
$recherche=$_POST['recherche'];
$valeur=@$_POST['valeur'];
$margeD=$_POST['margeD'];
$date1=@$_POST['date1'];
$date2=@$_POST['date2'];
$totalE1=0;
$totalT1=0;
$totalD1=0;
$totalE2=0;
$totalT2=0;
$totalD2=0;

if(($recherche=="a") and ($date1=="")and ($date2=="")){
$req1= "SELECT * FROM supplier_invoice";

$req2= "SELECT * FROM expense";

}else if(($recherche=="a") and ($date1!="")and ($date2!="")){
$req1= "SELECT * FROM supplier_invoice where (($margeD >= '$date1') and ($margeD <= '$date2'))";
$req2= "SELECT * FROM expense where (($margeD >= '$date1') and ($margeD <= '$date2'))";
}else if(($date1=="")and ($date2=="") and ($recherche !="a")){
 if($recherche=="un_expense"){
$req1="x";
$req2= "SELECT * FROM expense ";
}else if($recherche == "catI"){
$req1= "SELECT * FROM supplier_invoice where $recherche like '%$valeur%'";
$req2= "SELECT * FROM expense where $recherche like '%$valeur%'";
}else{
$req2="x";
$req1= "SELECT * FROM supplier_invoice where $recherche like '%$valeur%'";
}
}else{
 if($recherche=="un_expense"){
$req1="x";
$req2= "SELECT * FROM expense where (($margeD >= '$date1') and ($margeD<= '$date2')) ";
}else if($recherche == "catI"){
$req1= "SELECT * FROM supplier_invoice where (($recherche like '%$valeur%') and (($margeD >= '$date1') and ($margeD <= '$date2')))";
$req2= "SELECT * FROM expense where (($recherche like '%$valeur%') and (($margeD >= '$date1') and ('$margeD' <= '$date2')))";
}else{
$req2="x";
$req1= "SELECT * FROM supplier_invoice where (($recherche like '%$valeur%') and (($margeD >= '$date1') and ($margeD <= '$date2')))";
}
}




$pdf->SetFont('times', 'B', 10);
// add a page
$pdf->AddPage('P', 'A4');
{

// set some text to print
if($req1 != "x"){

$r=mysql_query($req1) or die(mysql_error());
$nbr=mysql_num_rows($r);
$pdf->ln(20);
$pdf->SetFillColor(255,255 ,255);
$pdf->SetTextColor(0,0 ,0);
$pdf->MultiCell(100, 6,''.$nbr.' Invoices',0, 'L', 0, 0);
$pdf->ln(10);


$tbl = <<<EOD


<table border="1" cellpadding="1" cellspacing="">

  <tr style="background-color:#c7e6fd;color:#333333;">
  <td width="106" align="center">Ivoice N°</td> 
    <td width="213" align="center">Supplier </td> 
  <td width="85" align="center">Invoice type</td> 
  <td width="85" align="center" >Category </td> 
  <td width="85" align="center" >Total </td>  
 <td width="81" align="center" >Status </td> 
  
</tr>
</table>
EOD;




$pdf->writeHTML($tbl, true, false, false, false, '');

$pdf->ln(-5);
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
    $IDinvoice=$row['IDinvoice'];
	$n=strpos($IDinvoice,"-");	
    $IDinvoice=substr($IDinvoice,$n+1);

$pdf->SetFillColor(255,255 ,255);
$pdf->SetTextColor(0,0 ,0);
$pdf->MultiCell(30, 9,''.$IDinvoice, 1, 'C', 1, 0);


$pdf->SetFillColor(255,255 ,255);
$pdf->SetTextColor(0,0 ,0);
$pdf->MultiCell(60, 9,''.$row['supplier'],1, 'C', 1, 0);


$pdf->SetFillColor(255,255 ,255);
$pdf->SetTextColor(0,0 ,0);
$pdf->MultiCell(24, 9,''.$row['typeI'],1, 'C', 1, 0);

$pdf->SetFillColor(255,255 ,255);
$pdf->SetTextColor(0,0 ,0);
$pdf->MultiCell(24, 9,''.$row['catI'],1, 'C', 1, 0);




$pdf->SetFillColor(255,255 ,255);
$pdf->SetTextColor(0,0 ,0);
$pdf->MultiCell(24, 9,''.$row['total'].' '.$row['currency'], 1, 'C', 1, 0);


$pdf->SetFillColor(255,255,255);
$pdf->SetTextColor(0,0 ,0);

$pdf->MultiCell(22.9, 9,''.$row['status'], 1, 'C', 1, 0);



$pdf->ln(9);

}

$pdf->ln(6);



}
if($req2 != "x"){

$r2=mysql_query($req2) or die(mysql_error());
$nbr2=mysql_num_rows($r2);
$pdf->ln(20);
$pdf->SetFillColor(255,255 ,255);
$pdf->SetTextColor(0,0 ,0);
$pdf->MultiCell(100, 6,''.$nbr2.'  Unbilled expences',0, 'L', 0, 0);
$pdf->ln(12);


$tbl = <<<EOD


<table border="1" cellpadding="1" cellspacing="">

  <tr style="background-color:#c7e6fd;color:#333333;">
  <td width="53" align="center"> N°</td> 
    <td width="283" align="center">Description </td>
  <td width="142" align="center" >Category </td>
<td width="86" align="center">Payment date </td>  
  <td width="85" align="center" >Amount </td>  
  
  
</tr>
</table>
EOD;




$pdf->writeHTML($tbl, true, false, false, false, '');

$pdf->ln(-5);
$i=0;
$j=0;
while($row2 = @mysql_fetch_array($r2))

 {
 $j++;
 $i++;
 
 if ($j==35){
$pdf->setPrintHeader(false);

 $pdf->AddPage('P', 'A4');
 $j=1;
 $pdf->ln(2);
 }
    

$pdf->SetFillColor(255,255 ,255);
$pdf->SetTextColor(0,0 ,0);
$pdf->MultiCell(15, 6,''.$row2['IDexpense'], 1, 'C', 1, 0);


$pdf->SetFillColor(255,255 ,255);
$pdf->SetTextColor(0,0 ,0);
$pdf->MultiCell(80, 6,''.$row2['description'],1, 'C', 1, 0);


$pdf->SetFillColor(255,255 ,255);
$pdf->SetTextColor(0,0 ,0);
$pdf->MultiCell(40, 6,''.$row2['catI'],1, 'C', 1, 0);

$pdf->SetFillColor(255,255 ,255);
$pdf->SetTextColor(0,0 ,0);
$pdf->MultiCell(24, 6,''.$row2['dateP'],1, 'C', 1, 0);




$pdf->SetFillColor(255,255 ,255);
$pdf->SetTextColor(0,0 ,0);
$pdf->MultiCell(24, 6,''.$row2['amount'].' '.$row2['currency'], 1, 'C', 1, 0);





$pdf->ln(6);

}

$pdf->ln(6);



}
}
// set filling color




// Close and output PDF document
mysql_query();
$pdf->Output('example_003.pdf', 'I');

// ============================================================+
// END OF FILE
// ============================================================+
?>