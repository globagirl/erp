<?php
include('../connexion/connexionDB.php');
//Je charge les librairies de pChart qui se trouve dans le dossier class pour qu'il puisse afficher un graphique
include("class/pData.class.php");
include("class/pDraw.class.php");
include("class/pImage.class.php");
include("class/pPie.class.php");
include("class/pIndicator.class.php");
include('../include/functions/accounting_profit_functions.php');

// Je créer un nouvel objet contenant mes données pour le graphique
 $MyData = new pData();

/*Je présente ma série de données à utiliser pour le graphique et je détermine le titre de l'axe vertical avec setAxisName*/
// jours un tableau qui contient les jours
$payAncien = array();
$pay = array();
$jourJ=date("Y-m-d");
$jourJ=strtotime($jourJ);
$num = strftime("%m",$jourJ);
$mois = strftime("%B",$jourJ);
$year = strftime("%Y",$jourJ);
//$mois=$mois." ".$year;
$ancien=$year-1;
//THIS YEAR

for ($i=1;$i<=12;$i++){

if($i<10){
$nbr=$ancien."-0".$i;
}else{
$nbr=$ancien."-".$i;
}

$req= mysql_query("SELECT num_fact,date_E FROM fact1 where date_E LIKE '$nbr-%' and (client='1004' or client='1003')");
$totalTC=0;
$prixT=0;
$totQ=0;
while($a=@mysql_fetch_object($req)){
	$fact=$a->num_fact;
	//selection des commandes

	$req1= mysql_query("SELECT * FROM fact_items where idF='$fact'");
	while($data=mysql_fetch_object($req1))
    {
     $qteC=$data->qty;
     $OF=$data->OF;
     $produit=$data->produit;
     $prix=$data->prixT;
     $prixT=$prix+$prixT;
     $totQ=$totQ+$qteC;
	   //theoretical cost
     //Real coast
     $TC=calcul_real_coast($OF);
     $totalTC=$totalTC+$TC;
    }
}
$payT=$prixT-$totalTC;
if($totQ != 0){
$average=$payT/$totQ;
$average=round($average,2);
}else{
$average=null;
}


$payAncien[] =$average;
//END

}
///Année courante
for ($i=1;$i<=12;$i++){

if($i<10){
$nbr=$year."-0".$i;
$nb="0".$i;
}else{
$nbr=$year."-".$i;
$nb=$i;
}
if($nb<$num){
$r1= mysql_query("SELECT * FROM fact1 where date_E LIKE '$nbr-%' and (client='1004' or client='1003')");
$totalTC=0;
$prixT=0;
$totQ=0;
while($a=@mysql_fetch_object($r1)){
	$fact=$a->num_fact;
	//selection des commandes
	$r11= mysql_query("SELECT * FROM fact_items where idF='$fact'");
	while($data=mysql_fetch_object($r11)){
     $qteC=$data->qty;
     $OF=$data->OF;
	   $produit=$data->produit;
     $prix=$data->prixT;
	   $prixT=$prix+$prixT;
	   $totQ=$totQ+$qteC;
     //Real coast
     $TC=calcul_real_coast($OF);
     $totalTC=$totalTC+$TC;
    }
}
$payT=$prixT-$totalTC;
$average=$payT/$totQ;
}else{
  $totalTC=0;
  $prixT=0;
  $totQ=0;
  $r1= mysql_query("SELECT PO,date_exped FROM commande2 where date_exped LIKE '$nbr-%' and (client='1004' or client='1003') and (statut='waiting' or statut='incomplete')");
  while($a=@mysql_fetch_object($r1)){
	$PO=$a->PO;
  $dateE=$a->date_exped;
	//selection des commandes
	$r11= mysql_query("SELECT * FROM commande_items where PO='$PO'");
	while($data=mysql_fetch_object($r11)){
     $qteC=$data->qty;
	   $produit=$data->produit;
     $prix=$data->prixT;
     $prixU=$data->prixU;
	   $statut=$data->statut;
	  if($statut=="incomplete"){
	     $reqInc=mysql_query("SELECT sum(qte) FROM ordre_fabrication1 where PO='$PO'");
	     $qteMoin=mysql_result($reqInc,0);
	     $qteC=$qteC-$qteMoin;
       $prix=$prix-($prixU*$qteMoin);
	   }
	   $prixT=$prix+$prixT;
	   $totQ=$totQ+$qteC;
	   //theoretical cost
	   $TC=calcul_theo_coast($produit,$qteC,$dateE);
     $totalTC=$totalTC+$TC;
    }

}
//
$r3= mysql_query("SELECT OF,PO,produit,qte,date_exped_conf,statut FROM ordre_fabrication1 where date_exped_conf LIKE '$nbr-%'");
//$req3= mysql_query("SELECT PO,date_exped FROM commande2 where date_exped LIKE '$nbr-%' and (client='1004' or client='1003') and statut !='waiting' and statut !='planned'");
while($a3=@mysql_fetch_object($r3)){
	$PO=$a3->PO;
  $r31=mysql_query("SELECT PO FROM commande2 where (client='1004' or client='1003') and PO='$PO'");
  if(mysql_num_rows($r31)>0){
  $dateE=$a3->date_exped_conf;
  $qteC=$a3->qte;
  $produit=$a3->produit;
  $OF=$a3->OF;
  $statut=$a3->statut;
  $r32= mysql_query("SELECT prixU FROM commande_items where PO='$PO'");
  $prixU=mysql_result($r32,0);
  $prix=$prixU*$qteC;
  $prixT=$prix+$prixT;
  $totQ=$totQ+$qteC;
  //Real cost
  if($statut != "planned"){
    $TC=calcul_real_coast($OF);
  }else{
    $TC=calcul_theo_coast($produit,$qteC,$dateE);
  }
  $totalTC=$totalTC+$TC;
 }
}
$payT=$prixT-$totalTC;
if($totQ>0){
$average=$payT/$totQ;
}else{
$average=0;
}
}
$average=round($average,2);
if($average != 0){
    $pay[] =$average;
}else{
    $pay[] =null;
}
//END

}

////

 $MyData->addPoints($payAncien,"Last year");
 $MyData->addPoints($pay,"QTY");
 $MyData->addPoints(array("January","February","March","April","May","June","July","August","September","October","November","December"),"Labels");



 $MyData->setSerieWeight("QTY");
 $MyData->setSerieWeight("Last year");
 $MyData->setAxisName(0,"Profits");

/*J'indique les données horizontales du graphique. Il doit y avoir le même nombre que pour ma série de données précédentes (logique)*/

 $MyData->setSerieDescription("Labels","Months");
 $MyData->setAbscissa("Labels");
 $MyData->setSerieWeight("Labels");

 $MyData->setPalette("Months",array("R"=>255,"G"=>9,"B"=>9));



/* Je crée l'image qui contiendra mon graphique précédemment crée */
 $myPicture = new pImage(670,360,$MyData);
 //$myPicture->Antialias = FALSE;
/* Je crée une bordure à mon image */
//$myPicture->drawGradientArea(0,0,700,230,DIRECTION_VERTICAL,$tableau);
 //$myPicture->drawRectangle(0,0,829,329,array("R"=>0,"G"=>0,"B"=>0));

/* J'indique le titre de mon graphique, son positionnement sur l'image et sa police */
 $myPicture->setFontProperties(array("FontName"=>"fonts/Forgotte.ttf","FontSize"=>11));
 /*$myPicture->drawText(200,25,"Production of this year",array("FontSize"=>20,"Align"=>TEXT_ALIGN_BOTTOMMIDDLE));*/

/* Je choisi le fond de mon graphique */
 $myPicture->setFontProperties(array("FontName"=>"fonts/pf_arma_five.ttf","FontSize"=>6));

/* Je détermine la taille du graphique et son emplacement dans l'image */
 $myPicture->setGraphArea(60,40,650,310);

/* Paramètres pour dessiner le graphique à partir des deux abscisses */
 $scaleSettings = array("XMargin"=>10,"YMargin"=>10,"Floating"=>TRUE,"GridR"=>200,"GridG"=>200,"GridB"=>200,"DrawSubTicks"=>TRUE,"CycleBackground"=>TRUE,'LabelRotation'=>30);
 $myPicture->drawScale($scaleSettings);

/* J'insère sur le côté droit le nom de l'auteur et les droits */
$myPicture->setShadow(TRUE,array("X"=>1,"Y"=>1,"R"=>0,"G"=>0,"B"=>0,"Alpha"=>10));
 $myPicture->setFontProperties(array("FontSize"=>10,"R"=>30,"G"=>30,"B"=>30));
/* $myPicture->drawLegend(830,60,array("Style"=>LEGEND_NOBORDER,"R"=>173,"G"=>163,"B"=>83,"Surrounding"=>20,"Family"=>LEGEND_FAMILY_LINE,"BoxWidth"=>30));
*/
//Chart1

$myPicture->drawXThreshold($mois,array("ValueIsLabel"=>TRUE,"WriteCaption"=>TRUE,"Caption"=>"This month","Alpha"=>70,"Ticks"=>1));

 $MyData->setSerieDrawable("QTY",TRUE);
 $myPicture->drawLineChart();
$myPicture->drawPlotChart(array("DisplayValues"=>TRUE,"PlotBorder"=>FALSE,"BorderSize"=>2,"Surrounding"=>-60,"BorderAlpha"=>60));


mysql_close();


/* J'indique le chemin où je souhaite que mon image soit créée */
 $randX=rand().rand(1,9);
 $myPicture->Render("img/average".$randX.".png");
  echo('<img src="../pChart/img/average'.$randX.'.png"  alt="Print" style="cursor:pointer;" />');
?>
