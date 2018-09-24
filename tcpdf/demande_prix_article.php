<?php
include('../connexion/connexionDB.php');
// Include the main TCPDF library (search for installation path).
require_once('tcpdf.php');
// Extend the TCPDF class to create custom Header and Footer
class MYPDF extends TCPDF {
    //Page header
    public function Header() {
        // Logo
        $image_file = 'img/logo.jpg';
        $this->Image($image_file, 5, 8, 30, 10, 'JPG', '', 'M', false, 300, '', false, false, 0, false, false, false);
        // Set font
        $this->SetFont('helvetica', 'B', 20);
        // Title
	      $image_file = 'logos/tuv.jpg';
        $this->Image($image_file, 165, 8, 35, 17, 'JPG', '', 'M', false, 300, '', false, false, 0, false, false, false);
        // Set font
        $this->SetFont('helvetica', 'B', 20);
    }

    // Page footer
    public function Footer() {
        // Position at 15 mm from bottom
        $this->SetY(-15);
        // Set font
        $this->SetFont('helvetica', 'I', 10);
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

$nbr =@$_POST['nbr'];
$dateJ=date('Y-m-d');
$dateJ2=date('Ymd');

//Ajout
$IDdemande=@$_POST['IDdemande'];
$dateD=@$_POST['dateD'];
$four =@$_POST['four'];
$tpay=@$_POST['tpay'];
$dev =@$_POST['dev'];
$sql=@mysql_query("INSERT INTO demande_prix(IDdemande, fournisseur, dateD, dateE, devise,termeP) VALUES ('$IDdemande','$four','$dateD','$dateJ','$dev','$tpay')");

//
$sqlF = mysql_query ("SELECT nom,adr FROM fournisseur1  WHERE nom LIKE '$four'");
$rowF = @mysql_fetch_array($sqlF);
$pdf->SetFont('times', 'B', 10);
// add a page
$pdf->AddPage('P', 'A4');


// set some text to print


$pdf->ln(20);

$tbl = <<<EOD
<table border="0" cellpadding="0" cellspacing="0">

 <tr style="color:#333333;">
 <td width="40" height="10" align="center" ></td>
 <td width="400" height="10" align="center" ><font size="30">Demande de prix </font></td>

</tr>
</table>
EOD;
$pdf->writeHTML($tbl, true, false, false, false, '');

$pdf->ln(10);
$tbl = <<<EOD

<table border="0" cellpadding="2" cellspacing="15">

  <tr style="background-color:#73C2FB;color:#333333;">
  <td width="140" align="center"> <b> N° demande </b> </td>
  <td width="140" align="center"> <b> Date  </b> </td>
  <td width="100" align="center"><b>Date demandé</b></td>

  </tr>
 </table>
EOD;
$pdf->writeHTML($tbl, true, false, false, false, '');
$pdf->ln(-8);
$pdf->SetFillColor(255,255 ,255);
$pdf->SetTextColor(0,0 ,0);
$pdf->MultiCell(4, 5,'', 0, 'C', 1, 0);
$pdf->SetFillColor(223,242 ,255);
$pdf->SetTextColor(0,0 ,0);
$pdf->MultiCell(40, 5,'DP'.$IDdemande, 0, 'C', 1, 0);
$pdf->SetFillColor(255,255 ,255);
$pdf->SetTextColor(0,0 ,0);
$pdf->MultiCell(4, 5,'', 0, 'C', 1, 0);
$pdf->SetFillColor(223,242 ,255);
$pdf->SetTextColor(0,0 ,0);
$pdf->MultiCell(40, 5,$dateJ, 0, 'C', 1, 0);
$pdf->SetFillColor(255,255 ,255);
$pdf->SetTextColor(0,0 ,0);
$pdf->MultiCell(4, 5,'', 0, 'C', 1, 0);
$pdf->SetFillColor(223,242 ,255);
$pdf->SetTextColor(0,0 ,0);
$pdf->MultiCell(28, 5,''.$dateD, 0, 'C', 1, 0);
$pdf->ln(15);
$tbl = <<<EOD
<table border="0" cellpadding="2" cellspacing="15">
 <tr style="background-color:#73C2FB;color:#333333;">
 <td width="190" bgcolor="#FFFFFF" colspan="6"></td>
 <td width="180" height="5" align="center" >Fournisseur</td>
 <td width="180" height="5" align="center" >Adresse de livraison </td>
</tr>
</table>
EOD;
$pdf->writeHTML($tbl, true, false, false, false, '');

$pdf->ln(-8);


$pdf->SetFillColor(255,255 ,255);
$pdf->SetTextColor(0,0 ,0);
$pdf->MultiCell(83, 5,'', 0, 'C', 1, 0);

$pdf->SetFillColor(223,242 ,255);
$pdf->SetTextColor(0,0 ,0);
$pdf->MultiCell(51, 24,$rowF['adr'], 0, 'C', 1, 0);
$pdf->SetFillColor(255,255 ,255);
$pdf->SetTextColor(0,0 ,0);
$pdf->MultiCell(4,5,'', 0, 'C', 1, 0);

$pdf->SetFillColor(223,242 ,255);
$pdf->SetTextColor(0,0 ,0);
$pdf->MultiCell(51,24,'STARZ ELECTRONICS
03 Rue Hedi Chaker  7000 BIZERTE TUNISIA
Tel: +216 72 44 47 30
Fax: +216 72 44 47 05 ', 0, 'C', 1, 0);




$pdf->ln(30);





$tbl = <<<EOD


<table border="0" cellpadding="1" cellspacing="15">

  <tr style="background-color:#73C2FB;color:#333333;">
  <td width="140" align="center"> Ref </td>
  <td width="360" align="center">Description </td>
  <td width="72" align="center" > Qty </td>
  <td width="36" align="center" > UM </td>


</tr>
</table>
EOD;

$pdf->writeHTML($tbl, true, false, false, false, '');
$pdf->ln(-8);
$i=1;

while($nbr>=$i){

    $artN="I".$i;
    $qN="Q".$i;

	$art=@$_POST[$artN];
	$q =@$_POST[$qN];
	$sq=mysql_query("INSERT INTO demande_prix_article(IDdemande, IDarticle, qte) VALUES ('$IDdemande','$art','$q')");


$pdf->SetFillColor(255,255 ,255);
$pdf->SetTextColor(0,0 ,0);
$pdf->MultiCell(4, 5,'', 0, 'C', 1, 0);


$pdf->SetFillColor(223,242 ,255);
$pdf->SetTextColor(0,0 ,0);
$pdf->MultiCell(40, 5,''.$art, 0, 'C', 1, 0);



$pdf->SetFillColor(255,255 ,255);
$pdf->SetTextColor(0,0 ,0);
$pdf->MultiCell(4, 5,'', 0, 'C', 1, 0);

$sql4 = mysql_query ("SELECT description,unit FROM article1 WHERE code_article = '$art' ");
$row4 = @mysql_fetch_array($sql4);

$pdf->SetFillColor(223,242 ,255);
$pdf->SetTextColor(0,0 ,0);
$pdf->MultiCell(102, 5,''.$row4['description'], 0, 'C', 1, 0);



$pdf->SetFillColor(255,255 ,255);
$pdf->SetTextColor(0,0 ,0);
$pdf->MultiCell(4, 5,'', 0, 'C', 1, 0);

$pdf->SetFillColor(223,242 ,255);
$pdf->SetTextColor(0,0 ,0);
$pdf->MultiCell(20, 5,''.$q, 0, 'C', 1, 0);


$pdf->SetFillColor(255,255 ,255);
$pdf->SetTextColor(0,0 ,0);
$pdf->MultiCell(4, 5,'', 0, 'C', 1, 0);

$pdf->SetFillColor(223,242 ,255);
$pdf->SetTextColor(0,0 ,0);
$pdf->MultiCell(10, 5,''.$row4['unit'], 0, 'C', 1, 0);

$pdf->SetFillColor(255,255 ,255);
$pdf->SetTextColor(0,0 ,0);
$pdf->MultiCell(4, 5,'', 0, 'C', 1, 0);
$pdf->ln(8);
$i++;
}


$pdf->ln(6);
//PRIX total
$tbl = <<<EOD
<table border="0" cellpadding="3" cellspacing="15">

 <tr style="background-color:#73C2FB;color:#333333;">
 <td width="325"  bgcolor="#FFFFFF" align="center"> </td>
 <td width="150" align="center"> Devise </td>
</tr>
</table>
EOD;
$pdf->writeHTML($tbl, true, false, false, false, '');
$pdf->ln(-15);





$pdf->SetFillColor(255,255 ,255);
$pdf->SetTextColor(0,0 ,0);
$pdf->MultiCell(145, 6,'', 0, 'C', 1, 0);



$pdf->SetFillColor(223,242 ,255);
$pdf->SetTextColor(0,0 ,0);
$pdf->MultiCell(30, 6,''.$dev, 0, 'C', 1, 0);



$pdf->ln(2);

$tbl = <<<EOD
<table border="0" cellpadding="3" cellspacing="15">

 <tr style="background-color:#73C2FB;color:#333333;">
  <td width="325"  bgcolor="#FFFFFF" align="center">  </td>
 <td width="150" align="center"> Terme de payment </td>
</tr>
</table>
EOD;
$pdf->writeHTML($tbl, true, false, false, false, '');
$pdf->ln(-15);

//
$pdf->SetFillColor(255,255 ,255);
$pdf->SetTextColor(0,0 ,0);
$pdf->MultiCell(145, 6,'', 0, 'C', 1, 0);


$pdf->SetFillColor(223,242 ,255);
$pdf->SetTextColor(0,0 ,0);
$pdf->MultiCell(30, 6,''.$tpay, 0, 'C', 1, 0);

if($four=="CHAKIRA CABLE"){
$pdf->ln(46);
$pdf->SetFillColor(255,255 ,255);
$pdf->SetTextColor(0,0,0);
$pdf->MultiCell(100, 6,'*'.$art.' conforme aux normes européennes', 0, 'L', 1, 0);
}

//


// set filling color


//
mysql_close();

//Close and output PDF document

$pdf->Output('demande_prix.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+
?>
