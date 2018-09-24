<?php
include('../connexion/connexionDB.php');
//Je charge les librairies de pChart qui se trouve dans le dossier class pour qu'il puisse afficher un graphique
include("class/pData.class.php");
include("class/pDraw.class.php");
include("class/pImage.class.php");
include("class/pPie.class.php");
include("class/pIndicator.class.php");

// Je créer un nouvel objet contenant mes données pour le graphique 
 $MyData = new pData();

/*Je présente ma série de données à utiliser pour le graphique et je détermine le titre de l'axe vertical avec setAxisName*/  
// jours un tableau qui contient les jours 
$qtyAncien = array(); 
$qty = array(); 
$jourJ=date("Y-m-d");
$jourJ=strtotime($jourJ);
$num = strftime("%m",$jourJ);
$mois = strftime("%B",$jourJ);
$year = strftime("%Y",$jourJ);
$ancien=$year-1;
//$mois=$mois." ".$year;
for ($i=1;$i<=12;$i++){

if($i<10){
$nbr=$ancien."-0".$i;
$nbr2="0".$i;

}else{
$nbr=$ancien."-".$i;
$nbr2=$i;
}

	
$req212= mysql_query("SELECT sum(qte) FROM fact1 where (client='1004' or client='1003') and date_E LIKE '$nbr-%'");
$CMD2=mysql_result($req212,0);
$qteT=$CMD2;

if($qteT != 0){
   $qtyAncien[] =$qteT; 
}else{
   $qtyAncien[] =null; 
}
//END 

}
//THIS year
for ($i=1;$i<=12;$i++){

if($i<10){
$nbr=$year."-0".$i;
$nbr2="0".$i;
}else{
$nbr=$year."-".$i;
$nbr2=$i;
}

if($nbr2<$num){
$req1= mysql_query("SELECT sum(qte) FROM fact1 where date_E LIKE '$nbr-%' and (client='1004' or client='1003')");
$qteT=mysql_result($req1,0);
}else if($nbr2==$num){
$req21= mysql_query("SELECT * FROM commande2 where (client='1004' or client='1003') and date_exped LIKE '$nbr-%'");
$qtyCMD=0;
while($dataCMD=mysql_fetch_array($req21)){
	$PO=$dataCMD['PO'];
	$req211= mysql_query("SELECT sum(qty) FROM commande_items where statut !='closed' and PO='$PO'");
	$CMD1=mysql_result($req211,0);
	$qtyCMD=$qtyCMD+$CMD1;
}	
$req212= mysql_query("SELECT sum(qte) FROM fact1 where (client='1004' or client='1003') and date_E LIKE '$nbr-%'");
$CMD2=mysql_result($req212,0);
$qteT=$CMD2+$qtyCMD;
}else{
$req1= mysql_query("SELECT sum(qte_demande) FROM commande2 where date_exped LIKE '$nbr-%' and (client='1004' or client='1003')");
$qteT=mysql_result($req1,0);
}
if($qteT != 0){
   $qty[] =$qteT; 
}else{
   $qty[] =null; 
}
//END 

}


////

 $MyData->addPoints($qtyAncien,"Last year");
 $MyData->addPoints($qty,"QTY");
  $MyData->addPoints(array("January","February","March","April","May","June","July","August","September","October","November","December"),"Labels");



 $MyData->setSerieWeight("Last year");
 $MyData->setSerieWeight("QTY");
 $MyData->setAxisName(0,"Quantity");

/*J'indique les données horizontales du graphique. Il doit y avoir le même nombre que pour ma série de données précédentes (logique)*/

 $MyData->setSerieDescription("Labels","Months");
 $MyData->setAbscissa("Labels");
 $MyData->setSerieWeight("Labels");

 $MyData->setPalette("Months",array("R"=>191,"G"=>10,"B"=>46));



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
/*
 $myPicture->drawLegend(830,60,array("Style"=>LEGEND_NOBORDER,"R"=>173,"G"=>163,"B"=>83,"Surrounding"=>20,"Family"=>LEGEND_FAMILY_LINE,"BoxWidth"=>30));
*/
//Chart1

$myPicture->drawXThreshold($mois,array("ValueIsLabel"=>TRUE,"WriteCaption"=>TRUE,"Caption"=>"This month","Alpha"=>70,"Ticks"=>1));
 $myPicture->drawThreshold(70000,array("WriteCaption"=>TRUE,"Caption"=>"Limit"));
 $MyData->setSerieDrawable("QTY",TRUE); 
 $myPicture->drawLineChart(); 
$myPicture->drawPlotChart(array("DisplayValues"=>TRUE,"PlotBorder"=>FALSE,"BorderSize"=>2,"Surrounding"=>-60,"BorderAlpha"=>60));





/* J'indique le chemin où je souhaite que mon image soit créée */
$randX=rand().rand(1,9);
 $myPicture->Render("img/QTY".$randX.".png");
  echo('<img src="../pChart/img/QTY'.$randX.'.png"  alt="Print" style="cursor:pointer;" />');
?>