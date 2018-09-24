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
 <td width="455" height="30" align="center" ><br><font size="18">Liste des salaires </font><br>
 <br>
 <br></td> 
  <td width="100" height="30" align="center" ><br><br><font size="9">Ref:E-GRH-01 version: 01   <br>Date :16/05/2016</font></td>
</tr>
</table>
EOD;


$this->writeHTML($tbl, true, false, false, false, '');

$this->ln(-19);
$dateD=@$_POST['dateD'];
$dateF=@$_POST['dateF'];


//$M=date_format($mois, 'F Y');
$this->SetFillColor(255,255 ,255);
$this->SetTextColor(0,0 ,0);
$this->MultiCell(180, 15,'Du '.$dateD.' au  '.$dateF, 0, 'C', 1, 0);
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
$dateF=@$_POST['dateF'];
$dateD=@$_POST['dateD'];
$year=@$_POST['year'];



$req1= "SELECT * FROM personnel_salaire where dateD='$dateD' and dateF='$dateF'";
$nbrPersonnel=0;
$totalS=0;




$pdf->SetFont('times', 'B', 11);
// add a page
$pdf->AddPage('P', 'A4');
{

// function
function afficheLigne($pdf,$mat,$nom,$salaireB,$nbm,$salaire,$avance,$mise,$salaireA){
    $pdf->MultiCell(35, 9,''.$mat, 1, 'C', 1, 0);
	$pdf->MultiCell(70, 9,''.$nom,1, 'C', 1, 0);
	//$pdf->MultiCell(18, 9,''.$salaireB,1, 'C', 1, 0);
	//$pdf->MultiCell(20, 9,''.$nbm,1, 'C', 1, 0);
	//$pdf->MultiCell(20, 9,''.$salaire,1, 'C', 1, 0);
	//$pdf->MultiCell(20, 9,''.$mise,1, 'C', 1, 0);
	//$pdf->MultiCell(18, 9,''.$avance,1, 'C', 1, 0);
	$pdf->MultiCell(40, 9,''.$salaireA,1, 'C', 1, 0);
	$pdf->MultiCell(40, 9,'',1, 'C', 1, 0);
	$pdf->ln(9);
}

$r=mysql_query($req1) or die(mysql_error());
$nbr=mysql_num_rows($r);
$pdf->ln(20);
$pdf->SetFillColor(255,255 ,255);
$pdf->SetTextColor(0,0 ,0);
//$pdf->SetFont('times', 'B', 12);
$pdf->MultiCell(35, 10,'Matricule', 1, 'C', 1, 0);
$pdf->MultiCell(70, 10,'Nom & prenom',1, 'C', 1, 0);
//$pdf->MultiCell(18, 10,'Salaire Brut',1, 'C', 1, 0);
//$pdf->MultiCell(20, 10,'Temps acc(mn)',1, 'C', 1, 0);
//$pdf->MultiCell(20, 10,'Salaire',1, 'C', 1, 0);
//$pdf->MultiCell(20, 10,'Mise a pied',1, 'C', 1, 0);
//$pdf->MultiCell(18, 10,'Avance',1, 'C', 1, 0);
$pdf->MultiCell(40, 10,'NET Arrondi',1, 'C', 1, 0);
$pdf->MultiCell(40, 10,'visa',1, 'C', 1, 0);

$pdf->ln(10);
$i=0;
$j=0;
while($a =mysql_fetch_object($r))

 {
    $mat=$a->matricule;
    $salaireB=$a->salaire_base;
    $nbm=$a->nbm_travail;
    $salaire=$a->salaireB;
    $avance=$a->total_avance;
    $mise=$a->total_mise;   
    $salaireA=$a->salaireA;  
	if($salaireA > 0){ 
    if($mise==0){
	$mise="----";
	}
	if($avance==0){
	$avance="----";
	}
if($i>0){
   if ($j==26){
    $pdf->setPrintHeader(false);
	$pdf->AddPage('P', 'A4');
	$j=1;
	$i++;
	$pdf->ln(2); 
  }
}else{
   if ($j==23){
    $pdf->setPrintHeader(false);
	$pdf->AddPage('P', 'A4');
	$i++;
	$j=1;
	$pdf->ln(2); 
  }
}
if($recherche =="A"){
	$req2= mysql_query("SELECT nom,matricule FROM personnel_info where matricule ='$mat'");
	$data=mysql_fetch_array($req2);
	$nom=$data['nom'];	
	$nbrPersonnel++;
	$totalS=$totalS+$salaireA;
	afficheLigne($pdf,$mat,$nom,$salaireB,$nbm,$salaire,$avance,$mise,$salaireA);
    $j++;
	
}else if($recherche == "matricule"){
	$req2= mysql_query("SELECT nom,matricule FROM personnel_info where matricule ='$mat'");
	$data=mysql_fetch_array($req2);
	$nom=$data['nom'];	
	$mat2=$data['matricule'];
	if($valeur==$mat2){
	    $nbrPersonnel++;
	    $totalS=$totalS+$salaireA;
        afficheLigne($pdf,$mat,$nom,$salaireB,$nbm,$salaire,$avance,$mise,$salaireA);
		$j++;
		$pdf->ln(9);
    }
}else if($recherche == "category"){
	$req2= mysql_query("SELECT nom,matricule,category FROM personnel_info where matricule ='$mat'");
	$data=mysql_fetch_array($req2);
	$nom=$data['nom'];	
	$category=$data['category'];
	if($valeur==$category){
	    $nbrPersonnel++;
	    $totalS=$totalS+$salaireA;
        afficheLigne($pdf,$mat,$nom,$salaireB,$nbm,$salaire,$avance,$mise,$salaireA);
		$j++;
		
    }
}else if($recherche == "typeS"){
	$req2= mysql_query("SELECT nom,matricule,typeS FROM personnel_info where matricule ='$mat'");
	$data=mysql_fetch_array($req2);
	$nom=$data['nom'];	
	$typeS=$data['typeS'];
	if($valeur==$typeS){
	    $nbrPersonnel++;
	    $totalS=$totalS+$salaireA;
        afficheLigne($pdf,$mat,$nom,$salaireB,$nbm,$salaire,$avance,$mise,$salaireA);
		$j++;
		
    }
}else if($recherche == "nom"){
	$req2= mysql_query("SELECT nom,matricule FROM personnel_info where matricule ='$mat'");
	$data=mysql_fetch_array($req2);
	$nom=$data['nom'];	
	
	if($valeur==$nom){
	    $nbrPersonnel++;
	    $totalS=$totalS+$salaireA;
        afficheLigne($pdf,$mat,$nom,$salaireB,$nbm,$salaire,$avance,$mise,$salaireA);
		$j++;
		
    }
}



}
}

$pdf->ln(8);
$pdf->MultiCell(50, 9,'Nbr personnel: '.$nbrPersonnel,1, 'C', 1, 0);
$pdf->ln(9);
$pdf->MultiCell(50, 9,'Total salaire: '.$totalS.' TND',1, 'C', 1, 0);
}
// set filling color
mysql_close();



// Close and output PDF document

$pdf->Output('liste_des_salaires.pdf', 'I');

// ============================================================+
// END OF FILE
// ============================================================+
?>