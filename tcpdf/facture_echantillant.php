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
        $this->SetY(-30);
        // Set font
        $this->SetFont('helvetica', 'I', 8);
        // Page number
        $this->Cell(0,35, 'Page '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');

        //include('../include/utile/facture_footer.php');

        $this->SetX(10);
        $this->Cell(0, 5, 'Tel: 00216 72 44 47 30',0, false, '', 0, '', 0, false, 'T', 'M');

        $this->SetX(10);
        $this->Cell(0,12, 'FAX: 00216 72 44 47 05',0, false, '', 0, '', 0, false, 'T', 'M');

        $this->SetX(10);
           $this->Cell(0,18, 'E-mail:contact@starzelectronics.com', 0, false, '', 0, '', 0, false, 'T', 'M');

        $this->SetX(10);
        $this->Cell(0,24, 'Web site: wwww.starzelectronics.com', 0, false, '', 0, '', 0, false, 'T', 'M');


        $this->SetX(80);
        $this->Cell(0, 5, 'N°RC: B134852001',0, false, '', 0, '', 0, false, 'T', 'M');

        $this->SetX(80);
        $this->Cell(0,12, 'N°CD: 804206Z ',0, false, '', 0, '', 0, false, 'T', 'M');

        $this->SetX(80);
           $this->Cell(0,20, 'N°TVA:  764435W/M/A/000', 0, false, '', 0, '', 0, false, 'T', 'M');


        $this->SetX(150);
        $this->Cell(0, 5, 'Account Name : STARZ ELECTRONICS ',0, false, '', 0, '', 0, false, 'T', 'M');

        $this->SetX(150);
        $this->Cell(0,12, 'Bank : BNA ',0, false, '', 0, '', 0, false, 'T', 'M');

        $this->SetX(150);
           $this->Cell(0,18, 'IBAN : TN59 03 200 012 0191 029115 31', 0, false, '', 0, '', 0, false, 'T', 'M');

        $this->SetX(150);
        $this->Cell(0,25, 'Code Bic : BNTETNTT ', 0, false, '', 0, '', 0, false, 'T', 'M');

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
$nbr =@$_POST['nbr'];
$dateJ=date('Y-m-d');
$dateJ2=date('Ymd');

$IDfact=@$_POST['IDfact'];
$client =@$_POST['client'];
$termeP=@$_POST['termeP'];
$dev =@$_POST['dev'];
$total =@$_POST['total'];
$pdf->AddPage('P', 'A4');

$sql=mysql_query("INSERT INTO facture_echantillon(numFact,dateF,client, devise,termeP,montant) VALUES ('$IDfact','$dateJ','$client','$dev','$termeP','$total')");
//

$pdf->SetFont('times', 'B', 10);
// set some text to print
$pdf->ln(20);
$tbl = <<<EOD
<table border="0" cellpadding="0" cellspacing="0">
 <tr style="color:#333333;">
   <td width="40" height="10" align="center" ></td>
   <td width="400" height="10" align="center" ><font size="30">INVOICE </font></td>
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
$pdf->MultiCell(40, 5,'D'.$IDfact, 0, 'C', 1, 0);


$pdf->SetFillColor(255,255 ,255);
$pdf->SetTextColor(0,0 ,0);
$pdf->MultiCell(4, 5,'', 0, 'C', 1, 0);


$pdf->SetFillColor(223,242 ,255);
$pdf->SetTextColor(0,0 ,0);
$pdf->MultiCell(40, 5,$dateJ, 0, 'C', 1, 0);
$pdf->ln(15);
$tbl = <<<EOD


<table border="0" cellpadding="9" cellspacing="15">

 <tr style="background-color:#73C2FB;color:#333333;">

 <td width="200" height="8" align="center" >Shipped From </td>

 <td width="200" height="8" align="center" >BILL TO </td>

 <td width="200" height="8" align="center" >SHIP TO </td>
</tr>
</table>
EOD;
$pdf->writeHTML($tbl, true, false, false, false, '');

$pdf->ln(-8);

$pdf->SetFillColor(255,255 ,255);
$pdf->SetTextColor(0,0 ,0);
$pdf->MultiCell(4,5,'', 0, 'C', 1, 0);


$pdf->SetFillColor(223,242 ,255);
$pdf->SetTextColor(0,0 ,0);
$pdf->MultiCell(56.5, 30,''.'Starz Electronics 3 Rue Hedi Chaker 7000 Bizerte Tunisia', 0, 'C', 1, 0);

$pdf->SetFillColor(255,255 ,255);
$pdf->SetTextColor(0,0 ,0);
$pdf->MultiCell(4,5,'', 0, 'C', 1, 0);


$pdf->SetFillColor(223,242 ,255);
$pdf->SetTextColor(0,0 ,0);
$pdf->MultiCell(56.5, 30,''.$client, 0, 'C', 1, 0);


$pdf->SetFillColor(255,255 ,255);
$pdf->SetTextColor(0,0 ,0);
$pdf->MultiCell(4,5,'', 0, 'C', 1, 0);

$pdf->SetFillColor(223,242 ,255);
$pdf->SetTextColor(0,0 ,0);
$pdf->MultiCell(56.5,30,''.$client, 0, 'C', 1, 0);



$pdf->ln(30);
$tbl = <<<EOD
<table border="0" cellpadding="1" cellspacing="15">
  <tr style="background-color:#73C2FB;color:#333333;">

  <td width="370" align="center">Ref /Description </td>
  <td width="100" align="center" > QTY</td>
  <td width="100" align="center" > Weight KG</td>
</tr>
</table>
EOD;

$pdf->writeHTML($tbl, true, false, false, false, '');
$pdf->ln(-8);
$i=1;

while($nbr>=$i){
    $prdN="P".$i;
    $QN="Q".$i;
    $WN="W".$i;
	  $prd=@$_POST[$prdN];
	  $qte =@$_POST[$QN];
    $poids=@$_POST[$WN];
    $ID=$IDfact."X".$i;
	  $sq=mysql_query("INSERT INTO facture_echantillon_item (ID,IDfact, IDproduit, qty,poids) VALUES ('$ID','$IDfact','$prd','$qte','$poids')");


$pdf->SetFillColor(255,255 ,255);
$pdf->SetTextColor(0,0 ,0);
$pdf->MultiCell(4, 5,'', 0, 'C', 1, 0);

/*
$pdf->SetFillColor(223,242 ,255);
$pdf->SetTextColor(0,0 ,0);
$pdf->MultiCell(40, 5,''.$prd, 0, 'C', 1, 0);
$pdf->SetFillColor(255,255 ,255);
$pdf->SetTextColor(0,0 ,0);
$pdf->MultiCell(4, 5,'', 0, 'C', 1, 0);*/

$sql4 = mysql_query ("SELECT description FROM produit1 WHERE code_produit = '$prd' ");
$description = @mysql_result($sql4,0);

$pdf->SetFillColor(223,242 ,255);
$pdf->SetTextColor(0,0 ,0);
$pdf->MultiCell(105, 5,$prd.' '.$description, 0, 'C', 1, 0);



$pdf->SetFillColor(255,255 ,255);
$pdf->SetTextColor(0,0 ,0);
$pdf->MultiCell(4, 5,'', 0, 'C', 1, 0);

$pdf->SetFillColor(223,242 ,255);
$pdf->SetTextColor(0,0 ,0);
$pdf->MultiCell(28, 5,''.$qte, 0, 'C', 1, 0);


$pdf->SetFillColor(255,255 ,255);
$pdf->SetTextColor(0,0 ,0);
$pdf->MultiCell(4, 5,'', 0, 'C', 1, 0);

$pdf->SetFillColor(223,242 ,255);
$pdf->SetTextColor(0,0 ,0);
$pdf->MultiCell(28, 5,''.$poids, 0, 'C', 1, 0);
$pdf->ln(8);
$i++;
}

$pdf->ln(6);
//PRIX total
$tbl = <<<EOD


<table border="0" cellpadding="3" cellspacing="15">

 <tr style="background-color:#73C2FB;color:#333333;">
 <td width="325"  bgcolor="#FFFFFF" align="center"> </td>
 <td width="150" align="center"> Total </td>
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
$pdf->MultiCell(30, 6,''.$total, 0, 'C', 1, 0);

$pdf->ln(2);
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
//PRIX total
$tbl = <<<EOD


<table border="0" cellpadding="3" cellspacing="15">

 <tr style="background-color:#73C2FB;color:#333333;">
 <td width="325"  bgcolor="#FFFFFF" align="center"> </td>
 <td width="150" align="center"> Terms </td>
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
$pdf->MultiCell(30, 6,''.$termeP, 0, 'C', 1, 0);
$pdf->ln(2);
//

mysql_close();

//Close and output PDF document
$pdf->Output('facture_echantillant.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+
?>
