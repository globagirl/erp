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

$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

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
$pdf->setPrintFooter(false);
function afficheZone($y,$pdf,$styleLigne){

   //Ligne
  $pdf->Line(1.6, $y-1, 205, $y-1, $styleLigne);//$pdf->Line(left, p1 hauteur,longueur ,p2 hauteur, $style);
  $pdf->SetXY(15,$y );
  $pdf->SetFont('Helvetica', 'B', 9);
  $pdf->MultiCell('','','Purshase order ', 0, 'L', 0, 0, '', '', true);

  $pdf->SetXY(55,$y );
  $pdf->SetFont('Helvetica', 'B', 9);
  $pdf->MultiCell('','','Part number /Description', 0, 'L', 0, 0, '', '', true);
  /*
  $pdf->SetXY(55,73 );
  $pdf->SetFont('Helvetica', 'B', 8);
  $pdf->MultiCell('','','Description', 0, 'L', 0, 0, '', '', true);
  */
  $pdf->SetXY(115,$y);
  $pdf->SetFont('Helvetica', 'B', 9);
  $pdf->MultiCell('','','QTY THIS SHIP', 0, 'L', 0, 0, '', '', true);

  $pdf->SetXY(145,$y );
  $pdf->SetFont('Helvetica', 'B', 9);
  $pdf->MultiCell('','','QTY ORDER', 0, 'L', 0, 0, '', '', true);

   $pdf->SetXY(175,$y );
  $pdf->SetFont('Helvetica', 'B', 9);
  $pdf->MultiCell('','','UNIT', 0, 'L', 0, 0, '', '', true);
$pdf->Line(1.6, $y+8, 205, $y+8, $styleLigne);
}

if((isset($_POST['client'])) && (isset($_POST['dateE']))){
$client=$_POST['client'];
$dateE=$_POST['dateE'];
$_SESSION['client_ship']=$client;
$_SESSION['date_ship']=$dateE;
}else{
$client=$_SESSION['client_ship'];
$dateE=$_SESSION['date_ship'];
}
if(isset($_POST['IDpal'])){
$IDpal=$_POST['IDpal'];
$_SESSION['IDpal']=$IDpal;
}else{
$IDpal=$_SESSION['IDpal'];
}
//Styles
$styleLigne = array('width' => 0.3, 'cap' => 'butt', 'join' => 'mm', 'dash' => 0, 'color' => array(0, 0, 0));
$dateJ=date('d/m/Y');
//Définir le code client
$sq = mysql_query ("SELECT adress_liv,IDvendeur FROM client1 WHERE name_client LIKE '$client'");
$d1=@mysql_fetch_array($sq);
$IDvendeur=$d1['IDvendeur'];
$adress_liv=$d1['adress_liv'];
/*$sql=@mysql_query("SELECT IDpalette FROM palette where client='$client' and dateE='$dateE'");
while ($data=@mysql_fetch_array($sql)){*/
$IDpal=explode(',',$IDpal);
foreach($IDpal as $IDpalette){
$pdf->AddPage();
$pdf->SetMargins(0, 0, 0,true);
$pdf->SetFillColor(255,255 ,255);
$pdf->SetTextColor(0,0 ,0);
//
//$IDpalette=$data['IDpalette'];
//
$P=1;
$pdf->SetXY(8,8);
$pdf->SetFont('Helvetica', 'B', 7);
$pdf->MultiCell('','','Page '.$P, 0, 'L', 0, 0, '', '', true);
//Titre
$pdf->SetXY(8, 8);
$pdf->SetFont('Helvetica', 'B', 14);
$pdf->MultiCell('','','ORDER/SHIPMENT PACKING LIST SUMMARY', 0, 'C', 0, 0, '', '', true);
//$pdf->Line(1.6, 19, 205, 19, $styleLigne);//$pdf->Line(left, p1 hauteur,longueur ,p2 hauteur, $style);

//Ship to
$pdf->SetXY(8,20);
$pdf->SetFont('Helvetica', '', 8);
$pdf->MultiCell('','','SHIP TO:', 0, 'L', 0, 0, '', '', true);

$pdf->SetXY(8,24);
$pdf->SetFont('Helvetica', 'B', 8);
$pdf->MultiCell(50,'',''.$adress_liv, 0, 'L', 0, 0, '', '', true);


//Ship from
$pdf->SetXY(140,20);
//$pdf->SetXY(8,50);
$pdf->SetFont('Helvetica', '', 8);
$pdf->MultiCell('','','SHIP FROM:', 0, 'L', 0, 0, '', '', true);

$pdf->SetXY(140,24);
//$pdf->SetXY(8,54);
$pdf->SetFont('Helvetica', 'B', 8);
$pdf->MultiCell(50,'','STARZ ELECTRONICS
3 Rue Hedi Chaker 7000 Bizerte Tunisia', 0, 'L', 0, 0, '', '', true);

$pdf->SetXY(8,50);
$pdf->SetFont('Helvetica', 'B', 8);
$pdf->MultiCell('','','Supplier Id:', 0, 'L', 0, 0, '', '', true);

$pdf->SetXY(8,53 );
$pdf->SetFont('Helvetica', '', 8);
$pdf->MultiCell('','',''.$IDvendeur, 0, 'L', 0, 0, '', '', true);

$pdf->SetXY(38,50 );
$pdf->SetFont('Helvetica', 'B', 8);
$pdf->MultiCell('','','Delevery date :', 0, 'L', 0, 0, '', '', true);

$pdf->SetXY(38,53 );
$pdf->SetFont('Helvetica', '', 8);
$pdf->MultiCell('','',''.$dateE, 0, 'L', 0, 0, '', '', true);

$pdf->SetXY(68,50 );
$pdf->SetFont('Helvetica', 'B', 8);
$pdf->MultiCell('','','Palette REF :', 0, 'L', 0, 0, '', '', true);

$pdf->SetXY(68,53 );
$pdf->SetFont('Helvetica', '', 8);
$pdf->MultiCell('','',''.$IDpalette, 0, 'L', 0, 0, '', '', true);

 afficheZone(70,$pdf,$styleLigne);

	//
 //$pdf->Line(left, p1 hauteur,longueur ,p2 hauteur, $style);
$x=78; //Point de départ
$a=0;
$y=0;
$sql1=@mysql_query("SELECT sum(qte) AS qteT, PO ,IDproduit FROM carton_palette where IDpalette='$IDpalette' group by PO");

while ($data1=@mysql_fetch_array($sql1)){
  $qteT=$data1['qteT'];
  $PO=$data1['PO'];
  $IDproduit=$data1['IDproduit'];
  //
  $sq1 = mysql_query ("SELECT description FROM produit1 WHERE code_produit LIKE '$IDproduit'");
  $desc=@mysql_result($sq1,0);

  $sq2 = mysql_query ("SELECT qty FROM commande_items WHERE POitem LIKE '$PO'");
  $qteC=@mysql_result($sq2,0);
  //
  $a++;
  $y++;


	if($a>1){
	  $x=$x+10;
  }else{
    $x=$x+2;
  }

  if($y > 20){
    $pdf->AddPage();
    $pdf->SetMargins(0, 0, 0,true);
    afficheZone(30,$pdf,$styleLigne);
    $x=40;
    $y=0;
    $P++;
    $pdf->SetXY(8,8);
    $pdf->SetFont('Helvetica', 'B', 7);
    $pdf->MultiCell('','','Page '.$P, 0, 'L', 0, 0, '', '', true);
  }
  $pdf->SetXY(8,$x);
  $pdf->SetFont('Helvetica', 'B', 8);
  $pdf->MultiCell('','',$a, 0, 'L', 0, 0, '', '', true);

  $pdf->SetXY(15,$x);
  $pdf->SetFont('Helvetica', 'B', 8);
  $pdf->MultiCell('','',$PO, 0, 'L', 0, 0, '', '', true);

  $pdf->SetXY(55,$x );
  $pdf->SetFont('Helvetica', 'B', 8);
  $pdf->MultiCell('','',$IDproduit, 0, 'L', 0, 0, '', '', true);
  $pdf->SetXY(55,$x+3.4 );
  $pdf->SetFont('Helvetica', 'B', 8);
  $pdf->MultiCell('','',$desc, 0, 'L', 0, 0, '', '', true);

  $pdf->SetXY(115,$x);
  $pdf->SetFont('Helvetica', 'B', 8);
  $pdf->MultiCell('','',$qteT, 0, 'L', 0, 0, '', '', true);

  $pdf->SetXY(145,$x );
  $pdf->SetFont('Helvetica', 'B', 8);
  $pdf->MultiCell('','',$qteC, 0, 'L', 0, 0, '', '', true);

   $pdf->SetXY(175,$x);
  $pdf->SetFont('Helvetica', 'B', 8);
  $pdf->MultiCell('','','EA', 0, 'L', 0, 0, '', '', true);

    }
}

mysql_close();
$pdf->Output('labelPalette.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+
?>
