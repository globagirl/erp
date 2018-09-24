<?php
include('../connexion/connexionDB.php');

// Include the main TCPDF library (search for installation path).
require_once('tcpdf.php');


// Extend the TCPDF class to create custom Header and Footer
class MYPDF extends TCPDF {
    public function Footer() {
       
 }
}	


// create new PDF document
//$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
$i=102;
$j=165;
$pageLayout = array($i, $j); //  or array($height, $width)
//$pdf = new TCPDF('p', 'mm', $pageLayout, true, 'UTF-8', false);
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, $pageLayout, true, 'UTF-8', false);
// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('PLUTO');


// set default header data
//$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);

// set header and footer fonts
//$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
//$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
//$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
//$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
//$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// set auto page breaks
//$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
$pdf->SetAutoPageBreak(TRUE, 0);
// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
// set some language-dependent strings (optional)
if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
    require_once(dirname(__FILE__).'/lang/eng.php');
    $pdf->setLanguageArray($l);
}

// ---------------------------------------------------------

$client=@$_POST['client'];
$dateE=@$_POST['dateE'];

//


// Calcul du qte par box
$x=0;
//

$sql=@mysql_query("SELECT * FROM palette where dateE = '$dateE' and client='$client'");
$nbr=mysql_num_rows($sql);
//$pdf->SetMargins(0, 0, 0,true);
$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);
$x=0;
while ($data=@mysql_fetch_array($sql)){
$x++;
$IDpalette=$data['IDpalette'];
$pdf->AddPage();
$pdf->SetMargins(0, 0, 0,true);
$pdf->SetFillColor(255,255 ,255);
$pdf->SetTextColor(0,0 ,0);
//Poids
$poids=$data['poids'];
$poids=round($poids,3);
$poidsLB=$poids*2.20462;
$poidsLB=round($poidsLB,3);
//
//Les adresses 
$sql2=@mysql_query("SELECT adr_client,IDvendeur FROM client1 where name_client='$client'");
$data2=@mysql_fetch_array($sql2);
$IDvendeur=$data2['IDvendeur'];
$pdf->SetXY(4, 2.5);

$pdf->SetFont('Helvetica', '', 9);
$pdf->MultiCell('','','FR:', 0, 'L', 0, 0, '', '', true);
$pdf->SetXY(4, 6);
$pdf->SetFont('Helvetica', '', 7);
$pdf->MultiCell(40,'','Starz Electronics 
3 Rue Hedi Chaker 7000 Bizerte Tunisia 
 Tel: 00216 72 44 47 30 
 FAX: 00216 72 44 47 05', 0, 'L', 0, 0, '', '', true);
//
$pdf->Line(51, 0.1, 51, 27);
$pdf->SetXY(54, 2.5);
$pdf->SetFont('Helvetica', '', 9);
$pdf->MultiCell('','','TO:', 0, 'L', 0, 0, '', '', true);
$pdf->SetXY(54, 6);
$pdf->SetFont('Helvetica', '', 7);
$pdf->MultiCell('','',$data2['adr_client'], 0, 'L', 0, 0, '', '', true);

$style = array('width' => 0.3, 'cap' => 'butt', 'join' => 'mm', 'dash' => 0, 'color' => array(0, 0, 0));
$pdf->Line(0.5, 27, 101, 27, $style);//$pdf->Line(left, p1 hauteur,longueur ,p2 hauteur, $style);
////UPC PAL ID
//Déterminer type palette 
$typeP=$data['typeP'];
$desc="";
if($typeP=="3S"){
  $sql3=@mysql_query("SELECT PO,IDproduit FROM carton_palette where IDpalette='$IDpalette' LIMIT 1");
  $data3=@mysql_fetch_array($sql3);
  $PO=$data3['PO'];
  $POcode='14K'.$PO;
  $prd=$data3['IDproduit'];
  $prdCode='1P'.$prd;
  $sql4=@mysql_query("SELECT description FROM produit1 where code_produit='$prd'");
  $desc=@mysql_result($sql4,0);
}else if($typeP=="5S"){
  $sql3=@mysql_query("SELECT PO FROM carton_palette where IDpalette='$IDpalette' LIMIT 1");
  $data3=@mysql_fetch_array($sql3);
  $PO=$data3['PO'];
  $POcode='14K'.$PO;
  $prd="MIXE DLOAD";
  $prdCode=$prd;
}else if($typeP=="6S"){
  $sql3=@mysql_query("SELECT IDproduit FROM carton_palette where IDpalette='$IDpalette' LIMIT 1");
  $data3=@mysql_fetch_array($sql3);
  $PO="MULTI ORDER";
  $POcode=$PO;
   $prd=$data3['IDproduit'];
   $prdCode='1P'.$prd;
   $sql4=@mysql_query("SELECT description FROM produit1 where code_produit='$prd'");
  $desc=@mysql_result($sql4,0);
}else if($typeP=="7S"){
  $PO="MULTI ORDER";
  $prd="MIXED LOAD";
  $prdCode=$prd;
  $POcode=$PO;
}

//
$pdf->SetXY(4, 28);
$pdf->SetFont('Helvetica', '', 10);
$pdf->MultiCell('','','('.$typeP.')PKG ID', 0, 'L', 0, 0, '', '', true);
$pdf->SetXY(40, 28);
$pdf->SetFont('Helvetica', '', 11);
$pdf->MultiCell('','',$IDvendeur.$IDpalette, 0, 'L', 0, 0, '', '', true);
//
$palCode=$typeP.$IDvendeur.$IDpalette;
//Style


$style = array(
     'position' => '',
    'align' => 'C',
    'stretch' => false,
    'fitwidth' => true,
    'cellfitalign' => '',
    'border' => false,
    'hpadding' => 0,
    'vpadding' =>0,
    'fgcolor' => array(0,0,0),
    'bgcolor' => false, //array(255,255,255),
    'text' => false,
    'font' => 'helvetica',   
	);
	$pdf->SetXY(4, 33);
//$pdf->write1DBarcode($code, 'C39',LEFT , TOP, Logueur,30,10, $style, 'N');
  $pdf->write1DBarcode($palCode,'C39','','',90,8.7,'', $style, 'N');
 
//ligne

$style = array('width' => 0.3, 'cap' => 'butt', 'join' => 'mm', 'dash' => 0, 'color' => array(0, 0, 0));
$pdf->Line(1.6, 44, 101, 44, $style);//$pdf->Line(left, p1 hauteur,longueur ,p2 hauteur, $style);
//PO

$pdf->SetFont('Helvetica', '', 10);
$pdf->SetXY(4, 45);
$pdf->MultiCell('','','(14K)CUST PO', 0, 'L', 0, 0, '', '', true);
$pdf->SetXY(55, 45);
$pdf->SetFont('Helvetica', '', 11);
$pdf->MultiCell('','',$PO, 0, 'L', 0, 0, '', '', true);
//

//Style bar code 
$style = array(
     'position' => '',
    'align' => 'C',
    'stretch' => false,
    'fitwidth' => true,
    'cellfitalign' => '',
    'border' => false,
    'hpadding' => 0,
    'vpadding' =>0,
    'fgcolor' => array(0,0,0),
    'bgcolor' => false, //array(255,255,255),
    'text' => false,
    'font' => 'helvetica',    
	);
	
	$pdf->SetXY(4, 50);
//$pdf->write1DBarcode($code, 'C39',LEFT , TOP, Logueur,30,10, $style, 'N');
  $pdf->write1DBarcode($POcode,'C39','','',85,8.7,'', $style, 'N');
  
  //ligne

$style = array('width' => 0.3, 'cap' => 'butt', 'join' => 'mm', 'dash' => 0, 'color' => array(0, 0, 0));
$pdf->Line(0.5, 61, 101, 61, $style);//$pdf->Line(left, p1 hauteur,longueur ,p2 hauteur, $style);
//ID produit
$pdf->SetFont('Helvetica', '', 10);
$pdf->SetXY(4, 62);
$pdf->MultiCell('','','(1P)CUST PROD ID ', 0, 'L', 0, 0, '', '', true);
$pdf->SetXY(40, 62);
$pdf->SetFont('Helvetica', '', 11);
$pdf->MultiCell('','',$prd, 0, 'L', 0, 0, '', '', true);
//

//Style bar code 
$style = array(
     'position' => '',
    'align' => 'C',
    'stretch' => false,
    'fitwidth' => true,
    'cellfitalign' => '',
    'border' => false,
    'hpadding' => 0,
    'vpadding' =>0,
    'fgcolor' => array(0,0,0),
    'bgcolor' => false, //array(255,255,255),
    'text' => false,
    'font' => 'helvetica',
    
	);
	
	$pdf->SetXY(4, 67);
//$pdf->write1DBarcode($code, 'C39',LEFT , TOP, Logueur,30,10, $style, 'N');
  $pdf->write1DBarcode($prdCode, 'C39','' , '', 85,8.7,'', $style, 'N');
  
  //ligne

$style = array('width' => 0.3, 'cap' => 'butt', 'join' => 'mm', 'dash' => 0, 'color' => array(0, 0, 0));
$pdf->Line(0.5, 78, 101, 78, $style);//$pdf->Line(left, p1 hauteur,longueur ,p2 hauteur, $style);

//QTY
$qte=$data['totalQte'];
$pdf->SetFont('Helvetica', '', 10);
$pdf->SetXY(4, 79);
$pdf->MultiCell('','','(7Q)QUANTITY ', 0, 'L', 0, 0, '', '', true);
$pdf->SetXY(40, 79);
$pdf->SetFont('Helvetica', '', 11);
$pdf->MultiCell('','',$qte.'PC', 0, 'L', 0, 0, '', '', true);
//

//Style bar code 
$style = array(
     'position' => '',
    'align' => 'C',
    'stretch' => false,
    'fitwidth' => true,
    'cellfitalign' => '',
    'border' => false,
    'hpadding' => 0,
    'vpadding' =>0,
    'fgcolor' => array(0,0,0),
    'bgcolor' => false, //array(255,255,255),
    'text' => false,
    'font' => 'helvetica',
    
	);
	$qteCode="7Q".$qte."PC";
	$pdf->SetXY(4, 84);
//$pdf->write1DBarcode($code, 'C39',LEFT , TOP, Logueur,30,10, $style, 'N');
  $pdf->write1DBarcode($qteCode, 'C39','' , '', 60,8.7,'', $style, 'N');
  
  //ligne

$style = array('width' => 0.3, 'cap' => 'butt', 'join' => 'mm', 'dash' => 0, 'color' => array(0, 0, 0));
$pdf->Line(0.5, 95, 70, 95, $style);//$pdf->Line(left, p1 hauteur,longueur ,p2 hauteur, $style);


//UPC

/*
$pdf->SetFont('Helvetica', '', 10);
$pdf->SetXY(4, 96);
$pdf->MultiCell('','','(1P) SUPP PROD ID: ', 0, 'L', 0, 0, '', '', true);
$pdf->SetXY(40, 96);
$pdf->SetFont('Helvetica', '', 11);
$pdf->MultiCell('','','XXXXXXXX', 0, 'L', 0, 0, '', '', true);
//

//Style bar code 
$style = array(
     'position' => '',
    'align' => 'C',
    'stretch' => false,
    'fitwidth' => true,
    'cellfitalign' => '',
    'border' => false,
    'hpadding' => 0,
    'vpadding' =>0,
    'fgcolor' => array(0,0,0),
    'bgcolor' => false, //array(255,255,255),
    'text' => false,
    'font' => 'helvetica',
    
	);
	$upcCode="Dragon";
	$pdf->SetXY(4, 101);
//$pdf->write1DBarcode($code, 'C39',LEFT , TOP, Logueur,30,10, $style, 'N');
  $pdf->write1DBarcode($upcCode, 'C39','' , '', 60,8.7,'', $style, 'N');
*/  
  //ligne
/*
$style = array('width' => 0.3, 'cap' => 'butt', 'join' => 'mm', 'dash' => 0, 'color' => array(0, 0, 0));
$pdf->Line(0.5, 112, 101, 112, $style);//$pdf->Line(left, p1 hauteur,longueur ,p2 hauteur, $style);

*/

//Description produit

$pdf->SetFont('Helvetica', '', 9);
$pdf->SetXY(4, 96);
$pdf->MultiCell(65,'','DESCRIPTION:', 0, 'L', 0, 0, '', '', true);
$pdf->SetXY(4, 101);
$pdf->SetFont('Helvetica', '', 10);
//$pdf->MultiCell(80,'','XXXXXXXXXXX', 0, 'L', 0, 0, '', '', true);


$style = array('width' => 0.3, 'cap' => 'butt', 'join' => 'mm', 'dash' => 0, 'color' => array(0, 0, 0));
$pdf->Line(0.5, 141, 101, 141, $style);//$pdf->Line(left, p1 hauteur,longueur ,p2 hauteur, $style);

//Pak count
$pdf->SetFont('Helvetica', '', 7);
$pdf->SetXY(4, 142);
$pdf->MultiCell(65,'','PACKAGE COUNT:', 0, 'L', 0, 0, '', '', true);
$pdf->SetXY(14, 147);
$pdf->SetFont('Helvetica', '', 8);
$pdf->MultiCell('','',$x.' OF '.$nbr, 0, 'L', 0, 0, '', '', true);

//WEIGHT
$xc=100;
$yc=100;

//$pdf->Line(51, du point , 51, to point);
$pdf->Line(51, 141, 51, 165);
$pdf->SetFont('Helvetica', '', 7);
$pdf->SetXY(54, 142);
$pdf->MultiCell(65,'','PACKAGE WEIGHT:', 0, 'L', 0, 0, '', '', true);
$pdf->SetXY(60, 147);
$pdf->SetFont('Helvetica', '', 8);
$pdf->MultiCell('','',$poidsLB.'LB /'.$poids.' KG', 0, 'L', 0, 0, '', '', true);

}
mysql_close();
$pdf->Output('labelPalette.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+
?>