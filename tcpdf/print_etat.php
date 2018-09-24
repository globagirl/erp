<?php
session_start();
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
		
		
       


$this->ln(10);


$tbl = <<<EOD
<table border="1" cellpadding="2" cellspacing="0" width="100%">

 <tr style="color:#333333" >
 
 <td width="100"  align="center" > <img src="img/logo.jpg"  width="85px" height="45px" /></td> 
 <td width="455" height="30" align="center" ><font size="15"><br>Etat salaire  </font></td> 
  <td width="100" height="30" align="center" ><font size="9">Ref:E-GRH-06 version: 01   <br>Date :21/06/2016</font></td>
</tr>
</table>
EOD;


$this->writeHTML($tbl, true, false, false, false, '');

$this->ln(-19);




$this->SetFillColor(255,255 ,255);
$this->SetTextColor(0,0 ,0);
$this->MultiCell(170, 20,'', 0, 'C', 1, 0);
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
   
$mois=$_POST['mois'];
$year=$_POST['year'];
$mois=$year."-".$mois;
$val=$_POST['val'];
$recherche=$_POST['recherche'];

$pdf->SetFont('times', 'B', 11);
// add a page
$pdf->AddPage('P', 'A4');
$pdf->ln(13);

// set some text to print
$req2= mysql_query("SELECT matricule,nom,category FROM personnel_info where $recherche ='$val'");
$data2=mysql_fetch_array($req2);
$mat=$data2['matricule'];

$req1=mysql_query("SELECT sum(nbr_retard) AS nbrRetard,sum(total_mise) AS totalMise, sum(total_avance) AS totalAvance,salaire_base AS salaire_base,nbm_mois AS nbm_mois,mois AS mois FROM personnel_salaire where mois like '$mois%' and matricule='$mat'");
$data=mysql_fetch_array($req1);
$pdf->SetFillColor(255, 255, 255);
/*
$req2= mysql_query("SELECT * FROM personnel_info where matricule ='$mat'");
$data2=mysql_fetch_array($req2);
*/
$pdf->MultiCell(40, 6, 'MAT : '.$mat, 1, 'C', 1, 0, '', '', true);

$pdf->MultiCell(75, 6, ''.$data2['nom'], 1, 'C', 1, 0, '', '', true);
$pdf->MultiCell(70, 6, ''.$data2['category'], 1, 'C', 1, 0, '', '', true);
$pdf->ln(6);

$pdf->MultiCell(65, 6, 'Salaire brut :  '.$data['salaire_base'], 1, 'C', 1, 0, '', '', true);
$pdf->MultiCell(60, 6, 'Mois :  '.$data['mois'], 1, 'C', 1, 0, '', '', true);
$pdf->MultiCell(60, 6, 'Temps du travail(mn) : '.$data['nbm_mois'], 1, 'C', 1, 0, '', '', true);
$pdf->ln(6);

$pdf->MultiCell(60, 6, 'Total retards : '.$data['nbrRetard'], 1, 'C', 1, 0, '', '', true);
$pdf->MultiCell(65, 6, 'Total mise à pied : '.$data['totalMise'], 1, 'C', 1, 0, '', '', true);
$pdf->MultiCell(60, 6, 'Total avances: '.$data['totalAvance'], 1, 'C', 1, 0, '', '', true);

$pdf->ln(12);
$pdf->MultiCell(8, 8, '', 1, 'C', 1, 0, '', '', true);
$pdf->MultiCell(25, 8, 'Debut', 1, 'C', 1, 0, '', '', true);
$pdf->MultiCell(25, 8, 'Fin ', 1, 'C', 1, 0, '', '', true);
$pdf->MultiCell(26, 8, 'Tmp acc(mn)', 1, 'C', 1, 0, '', '', true);
$pdf->MultiCell(26, 8, 'Tmp acc(H)', 1, 'C', 1, 0, '', '', true);
$pdf->MultiCell(25, 8, 'Salaire  ', 1, 'C', 1, 0, '', '', true);
$pdf->MultiCell(25,8, 'NET  ', 1, 'C', 1, 0, '', '', true);
$pdf->MultiCell(25, 8, 'NET arrondi ', 1, 'C', 1, 0, '', '', true);
$pdf->ln(8);
$req3= mysql_query("SELECT dateD,dateF,nbm_travail,salaireB,salaire,salaireA FROM personnel_salaire where mois like '$mois%' and matricule='$mat' ORDER BY dateD ASC");
$n=0;
while($data3=mysql_fetch_array($req3)){
$tempAcc=$data3['nbm_travail'];
$tempAccH=$tempAcc/60;
$tempAccH=round($tempAccH,2);
$n++;
$pdf->MultiCell(8, 6, ''.$n, 1, 'C', 1, 0, '', '', true);
$pdf->MultiCell(25, 6, ''.$data3['dateD'], 1, 'C', 1, 0, '', '', true);
$pdf->MultiCell(25, 6, ''.$data3['dateF'], 1, 'C', 1, 0, '', '', true);
$pdf->MultiCell(26, 6, ' '.$data3['nbm_travail'], 1, 'C', 1, 0, '', '', true);
$pdf->MultiCell(26, 6, ' '.$tempAccH, 1, 'C', 1, 0, '', '', true);
$pdf->MultiCell(25, 6, ''.$data3['salaireB'], 1, 'C', 1, 0, '', '', true);
$pdf->MultiCell(25, 6, ''.$data3['salaire'], 1, 'C', 1, 0, '', '', true);
$pdf->MultiCell(25, 6, ''.$data3['salaireA'], 1, 'C', 1, 0, '', '', true);
$pdf->ln(6);


}
$pdf->ln(8);


$pdf->MultiCell(10, 12, ' ', 1, 'C', 1, 0, '', '', true);
$pdf->MultiCell(27, 12, 'Date', 1, 'C', 1, 0, '', '', true);
$pdf->MultiCell(28, 12, 'Heure début', 1, 'C', 1, 0, '', '', true);
$pdf->MultiCell(28, 12, 'Heure Fin  ', 1, 'C', 1, 0, '', '', true);
$pdf->MultiCell(20, 12, 'Total (mn) ', 1, 'C', 1, 0, '', '', true);
$pdf->MultiCell(18, 12, 'Retard (mn) ', 1, 'C', 1, 0, '', '', true);
$pdf->MultiCell(18, 12, 'Soustraction (mn) ', 1, 'C', 1, 0, '', '', true);
$pdf->MultiCell(20, 12, 'Brut(mn) ', 1, 'C', 1, 0, '', '', true);
$pdf->MultiCell(16, 12, 'Etat ', 1, 'C', 1, 0, '', '', true);

$pdf->ln(12);
$i=$n;
//Traitement
$dateM1=$mois."-01";
$dateM= strtotime($dateM1);
$dateM2= strtotime("next month",$dateM);
$dateM2=strtotime("-1 day",$dateM2);
$dateM2=date("Y-m-d",$dateM2);
$dateX=$dateM1;
while($dateX <= $dateM2){
$sql2 = mysql_query("SELECT * FROM personnel_pointage where dateP LIKE '$dateX' and matricule = '$mat'");
$nbr=mysql_num_rows($sql2);

if($nbr>0){
$i++;
$data3=mysql_fetch_array($sql2);
$pauseNuit=$data3['pauseNuit'];
$retard=$data3['retard'];
$sous=0;
if($retard<5 && $retard>0){
	$sous=5;
}else if($retard>= 6 && $retard<= 15){
	$sous=120;
}else if($retard>= 16){
	$sous=240;
}
$y=$i-$n;
if($pauseNuit>0){
    $pdf->MultiCell(10, 12, ''.$y, 1, 'C', 1, 0, '', '', true);
    $pdf->MultiCell(27, 12, ''.$data3['dateP'], 1, 'C', 1, 0, '', '', true);
    $pdf->MultiCell(28, 6, ''.$data3['heureD'], 1, 'C', 1, 0, '', '', true);
    $pdf->MultiCell(28, 6, ''.$data3['heureNuitD'], 1, 'C', 1, 0, '', '', true);
    $pdf->MultiCell(20, 6, '--', 1, 'C', 1, 0, '', '', true);
    $pdf->MultiCell(18, 6, '--', 1, 'C', 1, 0, '', '', true);
    $pdf->MultiCell(18, 6, '--', 1, 'C', 1, 0, '', '', true);
    $pdf->MultiCell(20, 6, '--', 1, 'C', 1, 0, '', '', true);
    $pdf->MultiCell(16, 6, '--', 1, 'C', 1, 0, '', '', true);
    $pdf->ln(6);
    $pdf->MultiCell(10, 6, '', 1, 'C', 1, 0, '', '', true);
    $pdf->MultiCell(27, 6, '', 1, 'C', 1, 0, '', '', true);
    $pdf->MultiCell(28, 6, ''.$data3['heureNuitF'], 1, 'C', 1, 0, '', '', true);
    $pdf->MultiCell(28, 6, ''.$data3['heureF'], 1, 'C', 1, 0, '', '', true);
    $pdf->MultiCell(20, 6, ''.$data3['totalM'], 1, 'C', 1, 0, '', '', true);
    $pdf->MultiCell(18, 6, ''.$data3['retard'], 1, 'C', 1, 0, '', '', true);
    $pdf->MultiCell(18, 6, ''.$sous, 1, 'C', 1, 0, '', '', true);
    $pdf->MultiCell(20, 6, ''.$data3['totalMF'], 1, 'C', 1, 0, '', '', true);
    $pdf->MultiCell(16, 6, ''.$data3['etat'], 1, 'C', 1, 0, '', '', true);
    $pdf->ln(6);
    $i++;
}else{
    $pdf->MultiCell(10, 6, ''.$y, 1, 'C', 1, 0, '', '', true);
    $pdf->MultiCell(27, 6, ''.$data3['dateP'], 1, 'C', 1, 0, '', '', true);
    $pdf->MultiCell(28, 6, ''.$data3['heureD'], 1, 'C', 1, 0, '', '', true);
    $pdf->MultiCell(28, 6, ''.$data3['heureF'], 1, 'C', 1, 0, '', '', true);
    $pdf->MultiCell(20, 6, ''.$data3['totalM'], 1, 'C', 1, 0, '', '', true);
    $pdf->MultiCell(18, 6, ''.$data3['retard'], 1, 'C', 1, 0, '', '', true);
    $pdf->MultiCell(18, 6, ''.$sous, 1, 'C', 1, 0, '', '', true);
    $pdf->MultiCell(20, 6, ''.$data3['totalMF'], 1, 'C', 1, 0, '', '', true);
    $pdf->MultiCell(16, 6, ''.$data3['etat'], 1, 'C', 1, 0, '', '', true);
    $pdf->ln(6);
}

}else{

$req31= mysql_query("SELECT dateD,dateF FROM personnel_conge where dateD<='$dateX' and dateF >='$dateX' and matricule='$mat'");
$nbrC=@mysql_num_rows($req31);
$req32= mysql_query("SELECT dateD,dateF FROM public_holiday where dateD<='$dateX' and dateF >='$dateX'");

$nbrPH=@mysql_num_rows($req32);
if($nbrC>0){
$etatA="Congé";
}else if($nbrPH>0){
$etatA="Jour Férié";
}else{
$etatA="Absent";
}
$dateX2=strtotime($dateX);
$sun=strftime ( "%a",$dateX2);
if(($sun != "Sun")&&($sun != "Sat")){
$pdf->SetFillColor(222, 225, 137);
$sunD=$etatA;
/*$i++;
$y=$i-$n;
$pdf->MultiCell(10, 6, ''.$y, 1, 'C', 1, 0, '', '', true);
$pdf->MultiCell(27, 6, ''.$dateX, 1, 'C', 1, 0, '', '', true);
$pdf->MultiCell(28, 6, '------', 1, 'C', 1, 0, '', '', true);
$pdf->MultiCell(28, 6, '------', 1, 'C', 1, 0, '', '', true);
$pdf->MultiCell(20, 6, '0', 1, 'C', 1, 0, '', '', true);
$pdf->MultiCell(18, 6, '0', 1, 'C', 1, 0, '', '', true);
$pdf->MultiCell(18, 6, '0', 1, 'C', 1, 0, '', '', true);
$pdf->MultiCell(20, 6, '0', 1, 'C', 1, 0, '', '', true);
$pdf->MultiCell(16, 6, ''.$etatA, 1, 'C', 1, 0, '', '', true);
$pdf->ln(6);
$pdf->SetFillColor(255, 255, 255);*/
}else{
if($sun=="Sun"){
$sunD="Dimanche";
}else{
$sunD="Samedi";
}
$pdf->SetFillColor(225, 222, 221);
}
$i++;
$y=$i-$n;
$pdf->MultiCell(10, 6, ''.$y, 1, 'C', 1, 0, '', '', true);
$pdf->MultiCell(27, 6, ''.$dateX, 1, 'C', 1, 0, '', '', true);
$pdf->MultiCell(148, 6, ' '.$sunD, 1, 'C', 1, 0, '', '', true);
$pdf->SetFillColor(255, 255, 255);
$pdf->ln(6);

/*}//*/

}

$dateX=strtotime($dateX);
$dateX=strtotime("+1 day",$dateX);
$dateX=date("Y-m-d",$dateX);
//dexiéme page
if ($i==26){
    $pdf->setPrintHeader(false);
	$pdf->AddPage('P', 'A4');	
	$pdf->ln(5);
}//
}
$pdf->ln(1);

mysql_close();

// Close and output PDF document
//$pdf->writeHTML($html, true, 0, true, 0);
$pdf->Output('etat_salaire.pdf', 'I');

// ============================================================+
// END OF FILE
// ============================================================+
?>