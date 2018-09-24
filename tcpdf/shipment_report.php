<?php
session_start ();
include('../connexion/connexionDB.php');

// Include the main TCPDF library (search for installation path).
require_once('tcpdf.php');


// Extend the TCPDF class to create custom Header and Footer
class MYPDF extends TCPDF {
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
$pdf->setPrintHeader(false);
$pdf->setPrintFooter(true);
if((isset($_POST['client'])) && (isset($_POST['dateE']))){
$client=$_POST['client'];
$dateE=$_POST['dateE'];
$_SESSION['client_ship']=$client;	
$_SESSION['date_ship']=$dateE;	
}else{
$client=$_SESSION['client_ship'];
$dateE=$_SESSION['date_ship'];
}

//Définir le code client
$sq = mysql_query ("SELECT IDvendeur FROM client1 WHERE name_client LIKE '$client'");
$IDvendeur=@mysql_result($sq,0);
//
$pdf->AddPage();
$pdf->SetMargins(0, 0, 0,true);
$pdf->SetFillColor(255,255 ,255);
$pdf->SetTextColor(0,0 ,0);
//
$dateJ=date('d/m/Y');
$pdf->SetXY(8, 4);
$pdf->SetFont('Helvetica', '', 7);
$pdf->MultiCell('','',$dateJ, 0, 'L', 0, 0, '', '', true);
//Titre
$pdf->SetXY(8, 8);
$pdf->SetFont('Helvetica', 'B', 20);
$pdf->MultiCell('','','Shipment Report', 0, 'L', 0, 0, '', '', true);

$pdf->SetXY(8,20);
$pdf->SetFont('Helvetica', 'B', 8);
$pdf->MultiCell('','','Supplier Id:', 0, 'L', 0, 0, '', '', true);

$pdf->SetXY(25,20 );
$pdf->SetFont('Helvetica', '', 8);
$pdf->MultiCell('','',''.$IDvendeur, 0, 'L', 0, 0, '', '', true);

$pdf->SetXY(8,24 );
$pdf->SetFont('Helvetica', 'B', 8);
$pdf->MultiCell('','','Supplier :', 0, 'L', 0, 0, '', '', true);

$pdf->SetXY(25,24 );
$pdf->SetFont('Helvetica', '', 8);
$pdf->MultiCell('','','Starz Electronics', 0, 'L', 0, 0, '', '', true);

$pdf->SetXY(8,28 );
$pdf->SetFont('Helvetica', 'B', 8);
$pdf->MultiCell('','','Address :', 0, 'L', 0, 0, '', '', true);

$pdf->SetXY(25,28 );
$pdf->SetFont('Helvetica', '', 8);
$pdf->MultiCell(40,'','3 Rue Hedi Chaker 7000 Bizerte Tunisia', 0, 'L', 0, 0, '', '', true);

//Ship rep ID
    
	
	//
	$DDtime = strtotime($dateE);
	$num_semaine = strftime("%W",$DDtime);
	$year= strftime("%Y",$DDtime);
	$DD=$year.'W'.$num_semaine;
	
	//
	$IDship=$DD.'N1';
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
	$pdf->SetXY(8, 39);
//$pdf->write1DBarcode($code, 'C39',LEFT , TOP, Logueur,30,10, $style, 'N');
  $pdf->write1DBarcode($IDship, 'C39','' , '', 70,8.7,'', $style, 'N');
 
//ligne

$style = array('width' => 0.3, 'cap' => 'butt', 'join' => 'mm', 'dash' => 0, 'color' => array(0, 0, 0));
$pdf->Line(1.6, 49, 205, 49, $style);//$pdf->Line(left, p1 hauteur,longueur ,p2 hauteur, $style);

$pdf->SetXY(8,50 );
$pdf->SetFont('Helvetica', 'B', 8);
$pdf->MultiCell('','','Master Bill / Shipment :', 0, 'L', 0, 0, '', '', true);

$pdf->SetXY(50,50 );
$pdf->SetFont('Helvetica', '', 8);
$pdf->MultiCell('','',$IDship, 0, 'L', 0, 0, '', '', true);

//ligne
$style = array('width' => 0.3, 'cap' => 'butt', 'join' => 'mm', 'dash' => 0, 'color' => array(0, 0, 0));
$pdf->Line(1.6, 55, 205, 55, $style);//$pdf->Line(left, p1 hauteur,longueur ,p2 hauteur, $style);

$totOrders=0;
$totPal=0;
$totBoxs=0;
$totQty=0;

$x=55; //Point de départ
$sql=@mysql_query("SELECT DISTINCT PO FROM carton_palette where IDpalette IN (SELECT IDpalette FROM palette where client='$client' and dateE='$dateE' and statut='closed')");
while ($data=@mysql_fetch_array($sql)){
  $PO=$data['PO'];
  //
  $totCartPO=0;
  $totQtyPO=0;
  //
   //Verif
	  if($x>250){
	     $pdf->AddPage();
		 $pdf->SetMargins(0, 0, 0,true);
		 $x=20;
	  }
	  //
  $x=$x+2;
  $pdf->SetXY(8,$x );
  $pdf->SetFont('Helvetica', 'B', 8);
  $pdf->MultiCell('','','Order number :', 0, 'L', 0, 0, '', '', true);
  $pdf->SetXY(50,$x);
  $pdf->SetFont('Helvetica', '', 8);
  $pdf->MultiCell('','',$PO, 0, 'L', 0, 0, '', '', true);
   
  //Total orders 
  $totOrders++;
  //
  $sql1=@mysql_query("SELECT DISTINCT IDpalette,IDproduit FROM carton_palette where PO='$PO'");
  while ($data1=@mysql_fetch_array($sql1)){
     $IDpalette=$data1['IDpalette'];
     $IDproduit=$data1['IDproduit'];
	 //
	 $totCartPal=0;
	 $totQtyPal=0;
	 //
	 
	 //Verif
	  if($x>250){
	     $pdf->AddPage();
		 $pdf->SetMargins(0, 0, 0,true);
		 $x=20;
	  }
	  //
	  $x=$x+10;
	  $style = array('width' => 0.3, 'cap' => 'butt', 'join' => 'mm', 'dash' => 0, 'color' => array(0, 0, 0));
	  $pdf->Line(1.6, $x, 205, $x, $style);//$pdf->Line(left, p1 hauteur,longueur ,p2 hauteur, $style);
	 
	 //
	   //Verif
	  if($x>250){
	     $pdf->AddPage();
		 $pdf->SetMargins(0, 0, 0,true);
		 $x=20;
	  }
	  //
	  $x=$x+2;
	  $pdf->SetXY(8,$x);
	  $pdf->SetFont('Helvetica', 'B', 8);
	  $pdf->MultiCell('','','IBL Number / Pallet :', 0, 'L', 0, 0, '', '', true);
	  $pdf->SetXY(40,$x );
	  $pdf->SetFont('Helvetica', '', 8);
	  $pdf->MultiCell('','',$IDpalette, 0, 'L', 0, 0, '', '', true);
	  //Code a barre palette
	  
	  $pdf->SetXY(70, $x);
	  //$pdf->write1DBarcode($code, 'C39',LEFT , TOP, Logueur,30,10, $style, 'N');
	  $pdf->write1DBarcode($IDpalette, 'C39','' , '', 80,8.7,'', $style, 'N');  
	  //
	   //Verif
	  if($x>250){
	     $pdf->AddPage();
		 $pdf->SetMargins(0, 0, 0,true);
		 $x=20;
	  }
	  //
	  $x=$x+10;
	  $style = array('width' => 0.3, 'cap' => 'butt', 'join' => 'mm', 'dash' => 0, 'color' => array(0, 0, 0));
	  $pdf->Line(1.6, $x, 205, $x, $style);//$pdf->Line(left, p1 hauteur,longueur ,p2 hauteur, $style);
	  //Produit
	   //Verif
	  if($x>250){
	     $pdf->AddPage();
		 $pdf->SetMargins(0, 0, 0,true);
		 $x=20;
	  }
	  //
	  $x=$x+4;
	  $pdf->SetXY(8,$x);
	  $pdf->SetFont('Helvetica', 'B', 8);
	  $pdf->MultiCell('','','Part Number :', 0, 'L', 0, 0, '', '', true);
	  $pdf->SetXY(40,$x );
	  $pdf->SetFont('Helvetica', '', 8);
	  $pdf->MultiCell('','',$IDproduit, 0, 'L', 0, 0, '', '', true);
	  //Header tableau
	   //Verif
	  if($x>250){
	     $pdf->AddPage();
		 $pdf->SetMargins(0, 0, 0,true);
		 $x=20;
	  }
	  //
	  $x=$x+7;
	  $pdf->SetXY(25,$x);
	  $pdf->SetFont('Helvetica', 'B', 8);
	  $pdf->MultiCell('','','License Tag ', 0, 'L', 0, 0, '', '', true);
	  $pdf->SetXY(80,$x );
	  $pdf->SetFont('Helvetica', 'B', 8);
	  $pdf->MultiCell('','','Qty in Package', 0, 'L', 0, 0, '', '', true);
	  //
	  $sql2=@mysql_query("SELECT IDcarton,qte FROM carton_palette where PO='$PO' and IDpalette='$IDpalette'");
	  
      while ($data2=@mysql_fetch_array($sql2)){
	    $qte=$data2['qte'];
		
		 //Verif
	  if($x>250){
	     $pdf->AddPage();
		 $pdf->SetMargins(0, 0, 0,true);
		 $x=20;
	  }
	  //
        $x=$x+4;
		$pdf->SetXY(25,$x);
		$pdf->SetFont('Helvetica', '', 8);
		$pdf->MultiCell('','',$data2['IDcarton'], 0, 'L', 0, 0, '', '', true);
		$pdf->SetXY(80,$x);
		$pdf->SetFont('Helvetica', '', 8);
		$pdf->MultiCell('','',$data2['qte'].' /PC', 0, 'L', 0, 0, '', '', true);
		$totCartPal++;
		$totQtyPal=$totQtyPal+$qte;
	 } // fin liste carton 
	 //Total carton et qte
	 
	  if($x>250){
	     $pdf->AddPage();
		 $pdf->SetMargins(0, 0, 0,true);
		 $x=20;
	  }
	  //
	  $x=$x+7;
	  $pdf->SetXY(25,$x);
	  $pdf->SetFont('Helvetica', 'B', 8);
	  $pdf->MultiCell('','','Total Quantity for Pallet : '.$totQtyPal .' /PC ', 0, 'L', 0, 0, '', '', true);
	  //
	  if($x>250){
	     $pdf->AddPage();
		 $pdf->SetMargins(0, 0, 0,true);
		 $x=20;
	  }
	  //
	  $x=$x+5;
	  $pdf->SetXY(25,$x );
	  $pdf->SetFont('Helvetica', 'B', 8);
	  $pdf->MultiCell('','','Total Cartons For Pallet :'.$totCartPal, 0, 'L', 0, 0, '', '', true);
	  //Addition
	  $totCartPO=$totCartPO+$totCartPal;
	  $totQtyPO=$totQtyPO+$totQtyPal;
	 } //palette
	 //Les totals par PO 
	  if($x>250){
	     $pdf->AddPage();
		 $pdf->SetMargins(0, 0, 0,true);
		 $x=20;
	  }
	  //
	  $x=$x+7;
	  $pdf->SetXY(25,$x);
	  $pdf->SetFont('Helvetica', 'B', 9);
	  $pdf->MultiCell('','','Order Number : '.$PO , 0, 'L', 0, 0, '', '', true);
	  
	  if($x>250){
	     $pdf->AddPage();
		 $pdf->SetMargins(0, 0, 0,true);
		 $x=20;
	  }
	  //
	  $x=$x+5;
	  $pdf->SetXY(25,$x);
	  $pdf->SetFont('Helvetica', 'B', 8);
	  $pdf->MultiCell('','','Total Quantity for order Number : '.$totQtyPO .' /PC ', 0, 'L', 0, 0, '', '', true);
	  //
	  if($x>250){
	     $pdf->AddPage();
		 $pdf->SetMargins(0, 0, 0,true);
		 $x=20;
	  }
	  //
	  $x=$x+5;
	  $pdf->SetXY(25,$x );
	  $pdf->SetFont('Helvetica', 'B', 8);
	  $pdf->MultiCell('','','Total Cartons For order Number :'.$totCartPO, 0, 'L', 0, 0, '', '', true);
	  //Addition
	  $totBoxs=$totBoxs+$totCartPO;
	  $totQty=$totQty+$totQtyPO;
	 /////////
	  //Verif
	  if($x>250){
	     $pdf->AddPage();
		 $pdf->SetMargins(0, 0, 0,true);
		 $x=20;
	  }
	  //
	  $x=$x+5;	  
	  $style = array('width' => 0.3, 'cap' => 'butt', 'join' => 'mm', 'dash' => 0, 'color' => array(0, 0, 0));
	  $pdf->Line(1.6, $x, 205, $x, $style);//$pdf->Line(left, p1 hauteur,longueur ,p2 hauteur, $style);
	 }// PO
	 
     ////////////
     if($x>250){
	     $pdf->AddPage();
		 $pdf->SetMargins(0, 0, 0,true);
		 $x=20;
	  }
	  //
	  $x=$x+7;
	  $pdf->SetXY(25,$x);
	  $pdf->SetFont('Helvetica', 'B', 10);
	  $pdf->MultiCell('','','Total Quantity : '.$totQty .' /PC ', 0, 'L', 0, 0, '', '', true);
	  //
	  if($x>250){
	     $pdf->AddPage();
		 $pdf->SetMargins(0, 0, 0,true);
		 $x=20;
	  }
	  //
	  $x=$x+5;
	  $pdf->SetXY(25,$x );
	  $pdf->SetFont('Helvetica', 'B', 10);
	  $pdf->MultiCell('','','Total Cartons:'.$totBoxs, 0, 'L', 0, 0, '', '', true);
	  
	  //
	  $sql4=@mysql_query("SELECT count(IDpalette) FROM palette where client='$client' and dateE='$dateE'");
	  $totPal=@mysql_result($sql4,0);
	  if($x>250){
	     $pdf->AddPage();
		 $pdf->SetMargins(0, 0, 0,true);
		 $x=20;
	  }
	  //
	  $x=$x+5;
	  $pdf->SetXY(25,$x );
	  $pdf->SetFont('Helvetica', 'B', 10);
	  $pdf->MultiCell('','','Total Pallets:'.$totPal, 0, 'L', 0, 0, '', '', true);
      $sql5=@mysql_query("INSERT INTO shipment_report(IDshipment, dateE,dateC, client, nbrPal) VALUES ('$IDship','$dateE',NOW(),'$client','$totPal')");

    /////////	 

mysql_close();
$pdf->Output('labelPalette.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+
?>