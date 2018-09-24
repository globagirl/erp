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
 
 <td width="100"  align="center" > <img src="img/logo.jpg"  width="82px" height="60px" /></td> 
 <td width="455" height="30" align="center" ><br><font size="18">Accounting profits </font><br><br><br></td> 
  <td width="100" height="30" align="center" ><br><font size="9"><br>Ref:E-Fin-01 version: 01   <br>Date :05/07/2016</font></td>
</tr>
</table>
EOD;


$this->writeHTML($tbl, true, false, false, false, '');

$this->ln(-19);

$date1=@$_POST['date1'];
$date1 = strtotime($date1);
$date1= date("d- M -Y",$date1);
$date2=@$_POST['date2'];
$date2 = strtotime($date2);
$date2= date("d- M -Y",$date2);

$this->SetFillColor(255,255 ,255);
$this->SetTextColor(0,0 ,0);
$this->MultiCell(180, 15,'From  '.$date1.' To '.$date2, 0, 'C', 1, 0);
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
$pdf->SetTitle('Accounting profit');
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
$date1=@$_POST['date1'];
$date2=@$_POST['date2'];
$recherche=@$_POST['recherche'];
$valeur=@$_POST['valeur'];
$R2=@$_POST['R2'];
$totalProfit=0;
$totalRevenues=0;
$totalCosts=0;
$devise="";
$req= "SELECT * FROM commande2 where date_exped >= '$date1' and date_exped<= '$date2'";



$pdf->SetFont('times', 'B', 11);
// add a page
$pdf->AddPage('P', 'A4');
{

// set some text to print


$r=mysql_query($req) or die(mysql_error());
$pdf->ln(30);

$pdf->SetFillColor(223,242 ,255);


$pdf->MultiCell(27, 10, 'Purchase order', 1, 'C', 1, 0, '', '', true);
$pdf->MultiCell(24, 10, 'Shipping date', 1, 'C', 1, 0, '', '', true);
$pdf->MultiCell(25, 10, 'Item Id ', 1, 'C', 1, 0, '', '', true);
$pdf->MultiCell(18, 10, 'Qty', 1, 'C', 1, 0, '', '', true);
$pdf->MultiCell(24, 10, 'Revenues', 1, 'C', 1, 0, '', '', true);
$pdf->MultiCell(24, 10, 'Real cost  ', 1, 'C', 1, 0, '', '', true);
$pdf->MultiCell(24, 10, 'Theoretical cost', 1, 'C', 1, 0, '', '', true);
$pdf->MultiCell(24, 10, 'Profits ', 1, 'C', 1, 0, '', '', true);

$pdf->ln(10);
$i=0;
$j=0;
 $x=1;
$pdf->SetFont('times', 'B', 11);
while($a = @mysql_fetch_object($r))

 {

 //$i++;

 
 if ($j==25){
$pdf->setPrintHeader(false);

 $pdf->AddPage('P', 'A4');
 $j=1;
 $pdf->ln(2);
 }
    $PO=$a->PO;	 
	$dateE=$a->date_exped;	
	$devise=$a->devise;
	//selection des commandes
	if($R2=="shipped"){
	$req1= mysql_query("SELECT * FROM commande_items where PO='$PO' and statut !='waiting' and statut !='planned'");
	}else if($R2=="shippedNot"){
	$req1= mysql_query("SELECT * FROM commande_items where PO='$PO' and (statut ='waiting' or statut ='planned')");
	}else{
	$req1= mysql_query("SELECT * FROM commande_items where PO='$PO'");
	}
	while($data=mysql_fetch_object($req1))
    {
	
	 
     $PO=$data->PO;	 
     $qteC=$data->qty;	 
	 $prixT=$data->prixT;	
	 $produit=$data->produit;
	 $statut=$data->statut;
	 
	 if($statut=="incomplete"){
	 $reqInc=mysql_query("SELECT sum(qte) FROM ordre_fabrication1 where PO='$PO'");
	 $qteC=mysql_result($reqInc,0);
	 }
	 
	 	 //theoretical cost
	 $totalTC=0;
	  $req3= mysql_query("SELECT DISTINCT IDarticle,qte FROM produit_article1 where IDproduit='$produit'");
	 while($data3=@mysql_fetch_object($req3)){
	 $qteB=$data3->qte;	 
	 $article=$data3->IDarticle;
	
	 $req4= mysql_query("SELECT * FROM article1 where code_article='$article'");
	 $data4=mysql_fetch_object($req4);
	 $prixA=$data4->prix;	 
	 $prixTItem=$prixA*($qteB*$qteC);
	 $totalTC=$totalTC+$prixTItem;
	 
	 }
     //Al taklifa	 
	 $totalItem=0;
	 if($statut !="waiting" and $statut !="planned"){
     $req2= mysql_query("SELECT * FROM sortie_stock1 where commande= '$PO'");
	 if(mysql_num_rows($req2)>0){
	 while($data2=mysql_fetch_object($req2)){
	 $IDpaquet=$data2->IDpaquet;	 
	 $qte=$data2->qte;	
	 $req3= mysql_query("SELECT * FROM paquet2 where IDpaquet='$IDpaquet'");
	 $data3=mysql_fetch_object($req3);
	 $R=$data3->idRO;	 
	 $article=$data3->IDarticle;
	
	 if($R==""){ //ID reception introuvable
	 $req4= mysql_query("SELECT * FROM article1 where code_article='$article'");
	 $data4=mysql_fetch_object($req4);
	 $prixA=$data4->prix;	 
	 $prixTItem=$prixA*$qte;
	 $totalItem=$totalItem+$prixTItem;
	 
	 
	 }else{
	 $req4= mysql_query("SELECT * FROM reception_items where item='$article' and IDreception='$R'");
	 $data4=mysql_fetch_object($req4);
	 $qty=$data4->qty;	 
	 $price=$data4->price;	
	 $prixUItem=$price/$qty;
	 $prixTItem=$prixUItem*$qte;
	 $totalItem=$totalItem+$prixTItem;
	 }
	 }
	 }else{//Pas de sortie stock
	 
	  $totalItem=$totalTC;
	 }}else{//Pas de sortie stock
	 
	  $totalItem="----";
	 }
	 if($totalItem=="----"){
	  $profit=$prixT-$totalTC;
	 }else{
	 $profit=$prixT-$totalItem;
	 }
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
	$aff=0;
	if($recherche=="cat"){
	$note="";
	$reqR= mysql_query("SELECT categorie FROM produit1 where code_produit='$produit'");
	$cat=mysql_result($reqR,0);
	if($cat==$valeur){
	$aff=1;
	}else{
	$aff=0;
	}
	}else if($recherche=="long"){
	$note="";
	$reqR= mysql_query("SELECT longueur FROM produit1 where code_produit='$produit'");
	$long=mysql_result($reqR,0);
	if($long==$valeur){
	$aff=1;
	}else{
	$aff=0;
	}
	}else if($recherche=="item"){
    $note="";	
	if($produit==$valeur){
	$aff=1;
	}else{
	$aff=0;
	}
	}else if($recherche=="po"){	
	$note="";
	if($PO==$valeur){
	$aff=1;
	}else{
	$aff=0;
	}
	}else{
	$aff=1;
	}
	
	///Partie qui se répéte
	if($aff==1){

   $pdf->MultiCell(27, 8, ''.$PO, 1, 'C', 1, 0, '', '', true);
   $pdf->MultiCell(24, 8, ''.$dateE, 1, 'C', 1, 0, '', '', true);
   $pdf->MultiCell(25, 8, ''.$produit, 1, 'C', 1, 0, '', '', true);
   $pdf->MultiCell(18, 8, ''.$qte, 1, 'C', 1, 0, '', '', true);
   $pdf->MultiCell(24, 8, ''.$prixT, 1, 'C', 1, 0, '', '', true);
   $pdf->MultiCell(24, 8, ''.$totalTC, 1, 'C', 1, 0, '', '', true);
   $pdf->MultiCell(24, 8, ''.$totalItem, 1, 'C', 1, 0, '', '', true);
   $pdf->MultiCell(24, 8, ''.$profit, 1, 'C', 1, 0, '', '', true);
  $x++;
   $j++;
   $pdf->ln(8);
	//Calcul total 
	$totalProfit=$totalProfit+$profit;
	$totalRevenues=$totalRevenues+$prixT;
	$totalCosts=$totalCosts+$totalItem;
	}
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