<?php
include('../connexion/connexionDB.php');
// Include the main TCPDF library (search for installation path).
require_once('tcpdf.php');


// Extend the TCPDF class to create custom Header and Footer
class MYPDF extends TCPDF {

    // Page header
   public function Header() {
        
        $this->SetFont('times', 'B', 12);
       
	


$this->ln(10);


$tbl = <<<EOD
<table border="1" cellpadding="2" cellspacing="0" width="100%">

 <tr style="color:#333333" >
 
 <td width="100"  align="center" > <img src="img/logo.jpg"  width="85px" height="60px" /></td> 
 <td width="455" height="30" align="center" ><br><font size="18">Item Accounting </font><br><br><br></td> 
  <td width="100" height="30" align="center" ><br><font size="9"><br>Ref:E-Fin-01 version: 01   <br>Date :05/07/2016</font></td>
</tr>
</table>
EOD;


$this->writeHTML($tbl, true, false, false, false, '');

$this->ln(-19);



$date1= date("F j, Y");


$this->SetFillColor(255,255 ,255);
$this->SetTextColor(0,0 ,0);
$this->MultiCell(180, 15,'Date: '.$date1, 0, 'C', 1, 0);
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
$pdf->SetTitle('Item accounting');
//$pdf->SetSubject('TCPDF Tutorial');
//$pdf->SetKeywords('TCPDF, PDF, example, test, guide');

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

$recherche=@$_POST['recherche'];
$valeur=@$_POST['valeur'];

$totalProfit=0;
$totalRevenues=0;
$totalCosts=0;
$note="";
$devise="";
if($recherche=="long"){
	$req= "SELECT * FROM produit1 where longueur='$valeur'";
	}else if($recherche=="item"){
	$req="SELECT * FROM produit1 where code_produit LIKE '%$valeur%'";
	}else if($recherche=="cat"){
	$req="SELECT * FROM produit1 where categorie='$valeur'";
	}else if($recherche=="a"){
	$req="SELECT * FROM produit1";
	}



$pdf->SetFont('times', 'B', 11);
// add a page
$pdf->AddPage('P', 'A4');
{

// set some text to print


$r=mysql_query($req) or die(mysql_error());
$pdf->ln(30);

$pdf->SetFillColor(223,242 ,255);
$pdf->MultiCell(8, 8, ' N° ', 1, 'C', 1, 0, '', '', true);

$pdf->MultiCell(30, 8, 'Item Id ', 1, 'C', 1, 0, '', '', true);
$pdf->MultiCell(25, 8, 'Category', 1, 'C', 1, 0, '', '', true);
$pdf->MultiCell(25, 8, 'Price', 1, 'C', 1, 0, '', '', true);
$pdf->MultiCell(25, 8, 'Explicit costs  ', 1, 'C', 1, 0, '', '', true);
$pdf->MultiCell(25, 8, 'Gross margin ', 1, 'C', 1, 0, '', '', true);
$pdf->MultiCell(30, 8, 'Gross margin % ', 1, 'C', 1, 0, '', '', true);
$pdf->MultiCell(17, 8, 'Visa ', 1, 'C', 1, 0, '', '', true);

$pdf->ln(8);
$i=1;
$j=0;

$pdf->SetFont('times', 'B', 11);
while($a = @mysql_fetch_object($r))

 {

 
 if ($j==33){
$pdf->setPrintHeader(false);

 $pdf->AddPage('P', 'A4');
 $j=1;
 $pdf->ln(2);
 }
   $produit=$a->code_produit;
	 $cat=$a->categorie;
     //Al taklifa	 
	 $totalItem=0;
    
	 $req3= mysql_query("SELECT * FROM produit_article1 where IDproduit='$produit'");
	 while($data3=@mysql_fetch_object($req3)){
	 $qteB=$data3->qte;	 
	 $article=$data3->IDarticle;
	
	 $req4= mysql_query("SELECT * FROM article1 where code_article='$article'");
	 $data4=mysql_fetch_object($req4);
	 $prixA=$data4->prix;	 
	 $prixTItem=$prixA*$qteB;
	 $totalItem=$totalItem+$prixTItem;
	 
	 }
	  ///Prix produit
	  	 $reqPrix= mysql_query("SELECT price FROM prices where IDproduit='$produit'");
	     $prixT=@mysql_result($reqPrix,0);
		 //
		 //
	 if(($prixT != null) and ($totalItem != 0)){
	 $profit=$prixT-$totalItem;
	//Affichage
	if($profit<= 0){
	$pdf->SetFillColor(225, 187, 221);
	}
	else if($totalItem==0){
	$pdf->SetFillColor(205, 225, 187);
	}else{
	$pdf->SetFillColor(255, 255, 255);
	}
	///
	
	$P1=$totalItem/$prixT;
	$P2=(1-$P1)*100;
	$P2=round($P2,2);
	//
   $pdf->MultiCell(8, 6, ''.$i, 1, 'C', 1, 0, '', '', true);
   
   $pdf->MultiCell(30, 6, ''.$produit, 1, 'C', 1, 0, '', '', true);
   $pdf->MultiCell(25, 6, ''.$cat, 1, 'C', 1, 0, '', '', true);
   $pdf->MultiCell(25, 6, ''.$prixT, 1, 'C', 1, 0, '', '', true);
   $pdf->MultiCell(25, 6, ''.$totalItem, 1, 'C', 1, 0, '', '', true);
   $pdf->MultiCell(25, 6, ''.$profit, 1, 'C', 1, 0, '', '', true);
   $pdf->MultiCell(30, 6, ''.$P2.' % ', 1, 'C', 1, 0, '', '', true);
   $pdf->MultiCell(17, 6, ' ', 1, 'C', 1, 0, '', '', true);
   $i++;
   $j++;
   $pdf->ln(6);
	//Calcul total 
	$totalProfit=$totalProfit+$profit;
	$totalRevenues=$totalRevenues+$prixT;
	$totalCosts=$totalCosts+$totalItem;
	}
    
	}
	if($totalRevenues != 0){
    $PT1=$totalCosts/$totalRevenues;
	$PT2=(1-$PT1)*100;
	$PT2=round($PT2,2);
	}else{$PT2=0;}
	$pdf->SetFont('times', 'B', 13);
	$pdf->SetFillColor(223,242 ,255);
   $pdf->ln(10);
   $pdf->MultiCell(100, 8,'Total revenues : '.$totalRevenues  .' '.$devise, 0, 'R', 0, 0, '', '', true);
   $pdf->ln(8);
   $pdf->MultiCell(100, 8, 'Total costs: '.$totalCosts .' '.$devise, 0, 'R', 0, 0, '', '', true);
   $pdf->ln(8);
   $pdf->MultiCell(100, 8, 'Accounting profit :'.$totalProfit .' '.$devise, 0, 'R', 0, 0, '', '', true);
   $pdf->ln(8);
   $pdf->MultiCell(100, 8, 'Profit percentage: '.$PT2 .'%', 0, 'R', 0, 0, '', '', true);
}

// set filling color




// Close and output PDF document
mysql_close();
$pdf->Output('example_003.pdf', 'I');

// ============================================================+
// END OF FILE
// ============================================================+
?>