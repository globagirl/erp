<?php
include('../connexion/connexionDB.php');
// Include the main TCPDF library (search for installation path).
require_once('tcpdf.php');
// Extend the TCPDF class to create custom Header and Footer
class MYPDF extends TCPDF {
   //Page header
    public function Header() {
        $DD=$_POST['date1'];
		$this->SetFillColor(187,212,225);
		$DDtime = strtotime($DD);
		$num_semaine = strftime("%W",$DDtime);
		$year= strftime("%Y",$DDtime);
		$this->Cell(50,10,'Année:'.$year,1,false,'C','R');
		$this->Cell(80,10,'Taux de productivité par semaine ',1,false,'C','R');
		$this->Cell(0,10,' Semaine:'.$num_semaine,1,false,'C','R');
    }											   
}

// create new PDF document
$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Ghribi NouR El Houda');
$pdf->SetTitle('Graphe production');

// set default header data
$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);

// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
// $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
// $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

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

$DD=$_POST['date1'];
$DF=$_POST['date2'];
$pdf->SetFont('times', 'B', 14);
// add a page
$pdf->AddPage('P', 'A4');

$style = array(
    'position' => '',
    'align' => 'C',
    'stretch' => false,
    'fitwidth' => true,
    'cellfitalign' => '',
    'border' => true,
    'hpadding' => 'auto',
    'vpadding' => 'auto',
    'fgcolor' => array(0,0,0),
    'bgcolor' => false, //array(255,255,255),
    'text' => true,
    'font' => 'helvetica',
    'fontsize' => 8,
    'stretchtext' => 4
	);

$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Times','',12);
$pdf->Cell(60,8,'Process: Production',1,false,'C','R');
$pdf->Cell(60,8,'Article:Cable',1,false,'C','R');
$pdf->Cell(0,8,'Type article :Cat5e & cat6 ',1,false,'C','R');
$pdf->ln();
$pdf->Cell(0,8,'Responsable:DAHMANI Walid ',1,false,'C','R');
$pdf->ln(13);
//
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Times','',12);
$pdf->Cell(25,6,'',1,false,'C','R');
$pdf->Cell(26,6,'Lundi',1,false,'C','R');
$pdf->Cell(26,6,'Mardi',1,false,'C','R');
$pdf->Cell(26,6,'Mercredi',1,false,'C','R');
$pdf->Cell(26,6,'Jeudi',1,false,'C','R');
$pdf->Cell(26,6,'Vendredi',1,false,'C','R');
$pdf->Cell(26,6,'Samedi',1,false,'C','R');
$pdf->ln(6);
$pdf->Cell(25,6,'Production',1,false,'C','R');
$J=0;   
$tab=array(); 
while($DF>=$DD) 
{ 
    $J++;
	$sql25 = mysql_query ("SELECT * FROM pro_emb WHERE date_debut LIKE '$DD%'");
	$qty=0;
	while($data25=@mysql_fetch_array($sql25)){
	    $qteS=$data25['qte_e'];
		$qty=$qteS+$qty;
    }
	$pdf->Cell(26,6,''.$qty,1,false,'C','R');
	if($J==6){
	    $val=($qty/3500)*100;
	}else{
	    $val=($qty/7000)*100;
	}
	$val=round($val,2);
	$tab[$J]=$val;
	//
	$dateNext= strtotime($DD."+ 1 day");
	$DD= date('Y-m-d', $dateNext);
} 
if ($J<6){
    while($J<6){
	    $J++;
		$pdf->Cell(30,6,'0',1,false,'C','R');
		$tab[$J]=0;
	}
}
//
$pdf->ln(6);
$pdf->Cell(25,6,'Objectif',1,false,'C','R');
$pdf->Cell(26,6,'7000',1,false,'C','R');
$pdf->Cell(26,6,'7000',1,false,'C','R');
$pdf->Cell(26,6,'7000',1,false,'C','R');
$pdf->Cell(26,6,'7000',1,false,'C','R');
$pdf->Cell(26,6,'7000',1,false,'C','R');
$pdf->Cell(26,6,'3500',1,false,'C','R');
$pdf->ln(6);
//

$pdf->ln(4);
$pdf->Cell(25,6,'Taux (%)',1,false,'C','R');
for ($x=1;$x<7;$x++){
    $pdf->Cell(26,6,''.$tab[$x],1,false,'C','R');
}

$pdf->ln(6);
$pdf->Cell(25,6,'Objectif(%)',1,false,'C','R');
for ($x=1;$x<7;$x++){
    $pdf->Cell(26,6,'100',1,false,'C','R');
}
$image_file = '../pChart/img/P'.$DF.'.png';	
$image_file2 = '../pChart/img/T'.$DF.'.png';	
$pdf->Image($image_file, 15, 90, 180, 90, 'png', '', 'C', false, 0, '', false, false, 0, false, false, false);
$pdf->Image($image_file2, 15, 184, 180,85, 'png', '', 'C', false, 0, '', false, false, 0, false, false, false);

//Close and output PDF document
mysql_close();
$pdf->Output('graphe_production.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+
?>