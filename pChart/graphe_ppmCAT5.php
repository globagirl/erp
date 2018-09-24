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
$year=$_POST['year'];
$ppm = array(); 
$semaine = array(); 
$qteD = array(0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0); 
$qte = array(1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1); 
$jourJ=date("Y-m-d");
$jourJST = strtotime($jourJ);
$cet_semaine = strftime("%W",$jourJST);
$this_year = strftime("%Y",$jourJST);
$req1= mysql_query("SELECT PO,nbr_def,qte_e,date_debut FROM pro_test_pol where date_debut like '$year%'");

while($data1=mysql_fetch_array($req1)){
    $PO=$data1['PO'];
	$req2= mysql_query("SELECT produit FROM commande_items where POitem='$PO'");
	$prd=@mysql_result($req2,0);
	$req3= mysql_query("SELECT categorie FROM produit1 where code_produit='$prd'");
	$cat=@mysql_result($req3,0);
	$dateD=$data1['date_debut'];
	$dateD= strtotime($dateD);
    $s = strftime("%W",$dateD);
    $s=intval($s);
	if($cat=='CAT 5e'){
	$qteD[$s]=$qteD[$s]+$data1['nbr_def'];
	$qte[$s]=$qte[$s]+$data1['qte_e'];
	}
}
if($year>2016){
$m=1;
}else{
$m=24;
}

if($year != $this_year){
$dernierJ=$year."-12-30";
$dernierJ= strtotime($dernierJ);
$cet_semaine = strftime("%W",$dernierJ);
}
for ($i=$m;$i<=$cet_semaine;$i++){
$PPM=($qteD[$i]/$qte[$i])*1000000;
if($PPM>10000){
   $PPM = $PPM/5;
 }
$PPM=round($PPM,2);
$ppm[] =$PPM; 
$semaine[] ="Week ".$i; 
//END 

}



////

 $MyData->addPoints($ppm,"PPM");
  $MyData->addPoints($semaine,"Labels");



 $MyData->setSerieWeight("PPM");
 $MyData->setAxisName(0,"PPM");

/*J'indique les données horizontales du graphique. Il doit y avoir le même nombre que pour ma série de données précédentes (logique)*/

 $MyData->setSerieDescription("Labels","Semaine");
 $MyData->setAbscissa("Labels");
 $MyData->setSerieWeight("Labels");

 $MyData->setPalette("Semaine",array("R"=>191,"G"=>10,"B"=>46));



/* Je crée l'image qui contiendra mon graphique précédemment crée */
 $myPicture = new pImage(830,400,$MyData);
 //$myPicture->Antialias = FALSE; 
/* Je crée une bordure à mon image */
//$myPicture->drawGradientArea(0,0,700,230,DIRECTION_VERTICAL,$tableau); 
//$myPicture->drawRectangle(0,0,829,329,array("R"=>0,"G"=>0,"B"=>0));

/* J'indique le titre de mon graphique, son positionnement sur l'image et sa police */ 
 $myPicture->setFontProperties(array("FontName"=>"fonts/Forgotte.ttf","FontSize"=>11));
$myPicture->drawText(200,25,"PPM ".$year." : CAT5",array("FontSize"=>18,"Align"=>TEXT_ALIGN_BOTTOMMIDDLE));

/* Je choisi le fond de mon graphique */
 $myPicture->setFontProperties(array("FontName"=>"fonts/pf_arma_five.ttf","FontSize"=>6));

/* Je détermine la taille du graphique et son emplacement dans l'image */
 $myPicture->setGraphArea(60,40,800,310);

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

//$myPicture->drawXThreshold($mois,array("ValueIsLabel"=>TRUE,"WriteCaption"=>TRUE,"Caption"=>"This month","Alpha"=>70,"Ticks"=>1));
$myPicture->drawThreshold(8000,array("WriteCaption"=>TRUE,"Caption"=>"Limit"));
 $MyData->setSerieDrawable("PPM",TRUE); 
 $myPicture->drawLineChart(); 
$myPicture->drawPlotChart(array("DisplayValues"=>FALSE,"PlotBorder"=>FALSE,"BorderSize"=>2,"Surrounding"=>-60,"BorderAlpha"=>60));





/* J'indique le chemin où je souhaite que mon image soit créée */
//$randX=rand().rand(1,9);
$D=date("Y-m-d");
$D=$D.$year;
$myPicture->Render("img/PPMCAT5".$D.".png");
echo('<br><br><img src="../pChart/img/PPMCAT5'.$D.'.png"  alt="Print" style="cursor:pointer;" width="1000" height="600"/>');
?>