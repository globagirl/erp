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
        $this->SetFont('helvetica', 'I', 8);
        // Page number
        $this->Cell(0, 10, 'Page '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
    }
}

// create new PDF document
$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
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
$pdf->SetFont('times', 'B', 10);
$x=$_POST['num_bl_1']; 
$y=$_POST['num_bl_2'];		
$sql = mysql_query ("SELECT * FROM bon_livr WHERE num_bl BETWEEN $x AND $y ");
while($row =@mysql_fetch_array($sql)){
// add a page
$pdf->AddPage('P', 'A4');

//determiner les adresse client
$client=$row['client'];
$sq = mysql_query ("SELECT adress_fact,adress_liv FROM client1 WHERE name_client LIKE '$client'");
$dataC=@mysql_fetch_array($sq);
// set some text to print
$tbl = <<<EOD
<table border="0" cellpadding="0" cellspacing="0">
 <tr style="color:#333333;"> 
 <td width="600" height="10" align="center" ><font size="40"><i>Packing List</i></font></td>  
</tr>
</table>
EOD;


$pdf->writeHTML($tbl, true, false, false, false, '');
    
$pdf->ln(20);
$tbl = <<<EOD

<table border="0" cellpadding="2" cellspacing="15">

  <tr style="background-color:#73C2FB;color:#333333;">
  <td width="140" align="center" > <b> BL Number  </b> </td>  
  <td width="20" align="center" BGCOLOR="#FFFFFF" > <b>   </b> </td>   
  <td width="100" align="center"><b>Date</b></td> 
  <td width="20" align="center" BGCOLOR="#FFFFFF" > <b>   </b> </td>  
  <td width="140" align="center"> <b> Delivry date  </b> </td>
  <td width="20" align="center" BGCOLOR="#FFFFFF" > <b>   </b> </td>  
  <td width="100" align="center"><b>Vendor Number</b></td>
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
$pdf->MultiCell(40, 5,'BL'.$row['num_bl'], 0, 'C', 1, 0);
$pdf->SetFillColor(255,255 ,255);
$pdf->SetTextColor(0,0 ,0);
$pdf->MultiCell(14, 5,'', 0, 'C', 1, 0);
$pdf->SetFillColor(223,242 ,255);
$pdf->SetTextColor(0,0 ,0);
$pdf->MultiCell(28, 5,''.$row['date_bl'], 0, 'C', 1, 0);
$pdf->SetFillColor(255,255 ,255);
$pdf->SetTextColor(0,0 ,0);
$pdf->MultiCell(14, 5,'', 0, 'C', 1, 0);
$pdf->SetFillColor(223,242 ,255);
$pdf->SetTextColor(0,0 ,0);
$pdf->MultiCell(40, 5,''.$row['date_liv'], 0, 'C', 1, 0);
$pdf->SetFillColor(255,255 ,255);
$pdf->SetTextColor(0,0 ,0);
$pdf->MultiCell(14, 5,'', 0, 'C', 1, 0);
$pdf->SetFillColor(223,242 ,255);
$pdf->SetTextColor(0,0 ,0);
$pdf->MultiCell(28, 5,''.'459170', 0, 'C', 1, 0);
$pdf->ln(18);
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

$pdf->ln(-12);

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
$pdf->MultiCell(56.5, 30,''.$dataC['adress_fact'], 0, 'C', 1, 0);


$pdf->SetFillColor(255,255 ,255);
$pdf->SetTextColor(0,0 ,0);
$pdf->MultiCell(4,5,'', 0, 'C', 1, 0);

$pdf->SetFillColor(223,242 ,255);
$pdf->SetTextColor(0,0 ,0);
$pdf->MultiCell(56.5,30,''.$dataC['adress_liv'], 0, 'C', 1, 0);




$pdf->ln(50);

$tbl = <<<EOD


<table border="0" cellpadding="1" cellspacing="15">

 <tr style="background-color:#73C2FB;color:#333333;">
 <td width="73" align="center"> PO/No </td> 
 <td width="73" align="center"> Ref </td> 
 <td width="250" align="center" > Description </td> 
 <td width="70" align="center" > Qty Shipped  </td> 
 <td width="50" align="center" > Unit </td> 
 <td width="35" align="center" > Nbr Box </td> 
 
</tr>
</table>
EOD;

$BL=$row['num_bl'];	
$sql2 = mysql_query ("SELECT * FROM bon_livr_items WHERE idBL='$BL'");
$pdf->writeHTML($tbl, true, false, false, false, '');
$pdf->ln(-7);
while($row2 =@mysql_fetch_array($sql2)){
$P= $row2['IDproduit'];
$sql3 = mysql_query ("SELECT description FROM produit1 WHERE code_produit='$P'");
$DES=mysql_result($sql3,0);
$pdf->SetFillColor(255,255 ,255);
$pdf->SetTextColor(0,0 ,0);
$pdf->MultiCell(4, 5,'', 0, 'C', 1, 0);

$pdf->SetFillColor(223,242 ,255);
$pdf->SetTextColor(0,0 ,0);
$pdf->MultiCell(21, 5,''.$row2['PO'], 0, 'C', 1, 0);


$pdf->SetFillColor(255,255 ,255);
$pdf->SetTextColor(0,0 ,0);
$pdf->MultiCell(4, 5,'', 0, 'C', 1, 0);

$pdf->SetFillColor(223,242 ,255);
$pdf->SetTextColor(0,0 ,0);
$pdf->MultiCell(21, 5,''.$row2['IDproduit'], 0, 'C', 1, 0);

$pdf->SetFillColor(255,255 ,255);
$pdf->SetTextColor(0,0 ,0);
$pdf->MultiCell(3, 5,'', 0, 'C', 1, 0);

$pdf->SetFillColor(223,242 ,255);
$pdf->SetTextColor(0,0 ,0);
$pdf->MultiCell(71, 5,''.$DES, 0, 'C', 1, 0);

$pdf->SetFillColor(255,255 ,255);
$pdf->SetTextColor(0,0 ,0);
$pdf->MultiCell(4, 5,'', 0, 'C', 1, 0);

$pdf->SetFillColor(223,242 ,255);
$pdf->SetTextColor(0,0 ,0);
$pdf->MultiCell(20, 5,''.$row2['qty'], 0, 'C', 1, 0);



$pdf->SetFillColor(255,255 ,255);
$pdf->SetTextColor(0,0 ,0);
$pdf->MultiCell(4, 5,'', 0, 'C', 1, 0);

$pdf->SetFillColor(223,242 ,255);
$pdf->SetTextColor(0,0 ,0);
$pdf->MultiCell(15, 5,'PC', 0, 'C', 1, 0);


$pdf->SetFillColor(255,255 ,255);
$pdf->SetTextColor(0,0 ,0);
$pdf->MultiCell(4, 5,'', 0, 'C', 1, 0);

$pdf->SetFillColor(223,242 ,255);
$pdf->SetTextColor(0,0 ,0);
$pdf->MultiCell(10, 5,''.$row2['box'], 0, 'C', 1, 0);
$pdf->ln(6);
}
$pdf->ln(5);
//Total

////////
$pdf->ln(5);
$tbl = <<<EOD


<table border="0" cellpadding="3" cellspacing="15">

 <tr style="background-color:#73C2FB;color:#333333;">
 <td width="325"  bgcolor="#FFFFFF" align="center"> </td> 
 <td width="150" align="center"> Total QTY</td> 
</tr>
</table>
EOD;
$pdf->writeHTML($tbl, true, false, false, false, '');
$pdf->ln(-15);


$pdf->SetFillColor(255,255 ,255);
$pdf->SetTextColor(0,0 ,0);
$pdf->MultiCell(140, 5,'', 0, 'C', 1, 0);


$pdf->SetFillColor(223,242 ,255);
$pdf->SetTextColor(0,0 ,0);
$pdf->MultiCell(30, 5,''.$row['qtu'].' '.'pc', 0, 'C', 1, 0);



$pdf->ln(2);
$tbl = <<<EOD


<table border="0" cellpadding="3" cellspacing="15">

 <tr style="background-color:#73C2FB;color:#333333;">
 <td width="325"  bgcolor="#FFFFFF" align="center"> </td> 
 <td width="150" align="center"> Total Boxs </td> 
</tr>
</table>
EOD;
$pdf->writeHTML($tbl, true, false, false, false, '');
$pdf->ln(-15);


$pdf->SetFillColor(255,255 ,255);
$pdf->SetTextColor(0,0 ,0);
$pdf->MultiCell(140, 5,'', 0, 'C', 1, 0);


$pdf->SetFillColor(223,242 ,255);
$pdf->SetTextColor(0,0 ,0);
$pdf->MultiCell(30, 5,''.$row['nbr_box'], 0, 'C', 1, 0);

}
mysql_close();
//Close and output PDF document

$pdf->Output('bon_livraison.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+
?>