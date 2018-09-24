<?php

define('CLASS_PATH','../../');
require_once(CLASS_PATH.'tcpdf.php');
require_once(CLASS_PATH."label/class.label.php");
require_once(CLASS_PATH."label/examples/class.labelExample.php");

// Identifiant du format de l'étiquette choisie
$label_id = "1";
$data = array();
$info = array(
		'cab'		=> 	'1234567890',
		'typeCAB'	=>	'C128B',
		);

// Création d'une ligne par étiquette (nbre d'etiquettes = 5)
for ($j=0; $j < 5; $j++){
	array_push($data,$info);
}

$pdf = new labelExemple( $label_id, $data ,"../", "labels.xml", true);

$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor("Madvic");
$pdf->SetTitle("Etiquettes par kiwi");
$pdf->SetSubject("Création d'étiquettes Code Barre");
$pdf->SetKeywords("TCPDF, PDF, example, test, guide, kiwi");

// remove default header/footer
$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);

// remove default margin
$pdf->SetHeaderMargin(0);
$pdf->SetFooterMargin(0);

$pdf->SetAutoPageBreak( true, 0);

//set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO); 

$pdf->Addlabel();

// Affichage du document dans le navigateur
$pdf->Output("doc.pdf", "I");
?>