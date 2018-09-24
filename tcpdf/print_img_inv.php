<?php
include('../connexion/connexionDB.php');
// Include the main TCPDF library (search for installation path).
require_once('tcpdf.php');


// Extend the TCPDF class to create custom Header and Footer
class MYPDF extends TCPDF {

    // Page header
   public function Header() {
     /*   // Logo
		
        $image_file = 'img/logo.jpg';
        $this->Image($image_file, 5, 5, 25, 10, 'JPG', '', 'M', false, 300, '', false, false, 0, false, false, false);
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
*/
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
$pdf->SetAuthor('PLUTO');


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
$pdf->setPrintHeader(false);

if(($recherche=="a") and ($date1=="")and ($date2=="")){
$req1= "SELECT IDinvoice,supplier,dateF FROM supplier_invoice";

$req2= "SELECT IDexpense,fileE FROM expense";

}else if(($recherche=="a") and ($date1!="")and ($date2!="")){
$req1= "SELECT IDinvoice,supplier,dateF FROM supplier_invoice where (($margeD >= '$date1') and ($margeD <= '$date2'))";
$req2= "SELECT IDexpense,fileE FROM expense where (($margeD >= '$date1') and ($margeD <= '$date2'))";
}else if(($date1=="")and ($date2=="") and ($recherche !="a")){
 if($recherche=="un_expense"){
$req1="x";
$req2= "SELECT * FROM expense ";
}else if($recherche == "catI"){
$req1= "SELECT IDinvoice,supplier,dateF FROM supplier_invoice where $recherche like '%$valeur%'";
$req2= "SELECT IDexpense,fileE FROM expense where $recherche like '%$valeur%'";
}else{
$req2="x";
$req1= "SELECT IDinvoice,supplier,dateF FROM supplier_invoice where $recherche like '%$valeur%'";
}
}else{
 if($recherche=="un_expense"){
$req1="x";
$req2= "SELECT IDexpense,fileE FROM expense where (($margeD >= '$date1') and ($margeD<= '$date2')) ";
}else if($recherche == "catI"){
$req1= "SELECT IDinvoice,supplier ,dateF FROM supplier_invoice where (($recherche like '%$valeur%') and (($margeD >= '$date1') and ($margeD <= '$date2')))";
$req2= "SELECT IDexpense,fileE FROM expense where (($recherche like '%$valeur%') and (($margeD >= '$date1') and ('$margeD' <= '$date2')))";
}else{
$req2="x";
$req1= "SELECT IDinvoice,supplier,dateF FROM supplier_invoice where (($recherche like '%$valeur%') and (($margeD >= '$date1') and ($margeD <= '$date2')))";
}
}




$pdf->SetFont('times', '', 10);

{

// set some text to print
if($req1 != "x"){
$r=mysql_query($req1) or die(mysql_error());

while($row =@mysql_fetch_array($r))

 {
 $IDinvoice=$row['IDinvoice'];
 $supplier=$row['supplier'];
 $n=strpos($IDinvoice,"-");	
 $IDinv=substr($IDinvoice,$n+1);
 
 
 $r1=@mysql_query("SELECT dataF,IDinvoice,typeF FROM invoice_files where IDinvoice='$IDinvoice'");
 while($data1 =@mysql_fetch_array($r1)){
 $pdf->setPrintHeader(false);
 $pdf->AddPage('P', 'A4');
 $pdf->SetFillColor(255,255 ,255);
 $pdf->MultiCell(85, 6,'N° facture :'.$IDinv.' ',1, 'C', 1, 0);
 $pdf->MultiCell(100, 6,'Fournisseur :'.$supplier.' ',1, 'C', 1, 0);
 $pdf->ln(6);
 $r2=@mysql_query("SELECT reference,compte,modeP,montant,dateP FROM invoice_mode_pay where num_invoice='$IDinvoice'");
 $pdf->MultiCell(5, 6,' ',1, 'C', 1, 0);
 $pdf->MultiCell(25, 6,'Mode pay',1, 'C', 1, 0);
 $pdf->MultiCell(25, 6,'Date FACT',1, 'C', 1, 0);
 $pdf->MultiCell(20, 6,'Montant',1, 'C', 1, 0);
 $pdf->MultiCell(25, 6,'REF',1, 'C', 1, 0);
 $pdf->MultiCell(60, 6,'Banque',1, 'C', 1, 0);
 $pdf->MultiCell(25, 6,'Date PAY',1, 'C', 1, 0);
 $n=0;
 while($data2 =@mysql_fetch_array($r2)){
    $pdf->ln(6);
    $n++;
    $modPay=$data2['modeP'];
    $compte=@$data2['compte'];
	$pdf->SetFillColor(255,255 ,255);
    
	$pdf->MultiCell(5, 6,$n,1, 'c', 1, 0);
	$pdf->MultiCell(25, 6,$data2['modeP'],1, 'C', 1, 0);
	$pdf->MultiCell(25, 6,$row['dateF'],1, 'C', 1, 0);
    $pdf->MultiCell(20, 6,$data2['montant'],1, 'C', 1, 0);	
	if($compte != NULL){
	$r3=@mysql_query("SELECT NUMcompte,banque FROM compte_banque where REFcompte='$compte'");
	$data3 =@mysql_fetch_array($r3);
	$pdf->MultiCell(25, 6,$data2['reference'],1, 'L', 1, 0);
    $pdf->MultiCell(60, 6,$data3['banque'].' '.$data3['NUMcompte'].' ',1, 'C', 1, 0);
    $pdf->MultiCell(25, 6,$data2['dateP'],1, 'C', 1, 0);
	}else{
	$pdf->MultiCell(25, 6,'----',1, 'C', 1, 0);
    $pdf->MultiCell(60, 6,'----',1, 'C', 1, 0);
    $pdf->MultiCell(25, 6,'----',1, 'C', 1, 0);
	}
	
    
	
	 $pdf->ln(6);
 }
 
 $typeF=$data1['typeF'];
 $n1=strpos($typeF,"/");	
 $typeF=substr($typeF,$n1+1);
 //$pdf->MultiCell(70, 6,$typeF,1, 'L', 1, 0);
 $image_file = $data1['dataF'];
 $pdf->Image($image_file, 10, 70, 200, 200, $typeF, '', 'M', false, 300, '', false, false, 0, false, false, false);
 }
}
}
/*
if($req2 != "x"){

$r2=mysql_query($req2) or die(mysql_error());
while($row =@mysql_fetch_array($r))

 {
 $IDinvoice=$row['IDinvoice'];
 $supplier=$row['supplier'];
 $n=strpos($IDinvoice,"-");	
 $IDinv=substr($IDinvoice,$n+1);
 
 
 $r1=@mysql_query("SELECT dataF,IDinvoice,typeF FROM invoice_files where IDinvoice='$IDinvoice'");
 while($data1 =@mysql_fetch_array($r1)){
 $pdf->setPrintHeader(false);
 $pdf->AddPage('P', 'A4');
 $pdf->SetFillColor(255,255 ,255);
 $pdf->MultiCell(80, 6,'N° facture :'.$IDinv.' ',1, 'L', 1, 0);
 $pdf->MultiCell(100, 6,'Fournisseur :'.$supplier.' ',1, 'L', 1, 0);
 $pdf->ln(6);
 $r2=@mysql_query("SELECT reference,compte,modeP,montant FROM invoice_mode_pay where num_invoice='$IDinvoice'");
 while($data2 =@mysql_fetch_array($r2)){
    $modPay=$data2['modeP'];
    $compte=@$data2['compte'];
	$pdf->SetFillColor(255,255 ,255);
    
	$pdf->MultiCell(40, 6,'Mode pay: '.$data2['modeP'].' ',1, 'L', 1, 0);
    $pdf->MultiCell(30, 6,'Montant: '.$data2['montant'].' ',1, 'L', 1, 0);	
	if($compte != NULL){
	$r3=@mysql_query("SELECT NUMcompte,banque FROM compte_banque where REFcompte='$compte'");
	$data3 =@mysql_fetch_array($r3);
	$pdf->MultiCell(40, 6,'REF: '.$data2['reference'].' ',1, 'L', 1, 0);
    $pdf->MultiCell(70, 6,$data3['banque'].' '.$data3['NUMcompte'].' ',1, 'L', 1, 0);
	}else{
	$pdf->MultiCell(40, 6,'----',1, 'L', 1, 0);
    $pdf->MultiCell(70, 6,'----',1, 'L', 1, 0);
	}
	
    
	
	 $pdf->ln(6);
 }
 
 $typeF=$data1['typeF'];
 $n1=strpos($typeF,"/");	
 $typeF=substr($typeF,$n+1);
 
 $image_file = $data1['dataF'];
 $pdf->Image($image_file, 10, 70, 170, 200, 'JPG', '', 'M', false, 300, '', false, false, 0, false, false, false);
 }

}

$pdf->ln(6);



}*/
}
// set filling color

mysql_close();


// Close and output PDF document

$pdf->Output('facture.pdf', 'I');

// ============================================================+
// END OF FILE
// ============================================================+
?>