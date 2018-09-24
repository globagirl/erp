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
 $DD=$_POST['date1'];
 $DF=$_POST['date2'];
/*Je présente ma série de données à utiliser pour le graphique et je détermine le titre de l'axe vertical avec setAxisName*/  
// jours un tableau qui contient les jours 
$tableau = array(); 
while($DF>=$DD) 
{ 
$prod=0;
$sql2 = mysql_query ("SELECT * FROM pro_emb WHERE date_fin LIKE '$DD%'");
while($data=@mysql_fetch_array($sql2)){
$qte=$data['qte_e'];
$prod=$prod+$qte;
}

$tableau[] = $prod; 
//
$dateNext= strtotime($DD."+ 1 day");

$DD= date('Y-m-d', $dateNext);

} 
////
 $MyData->addPoints(array(7000,7000,7000,7000,7000,3500),"objectif");
 $MyData->addPoints($tableau,"Production");

 $MyData->setSerieWeight("objectif",1);
 $MyData->setAxisName(0,"Nombre de piéces");

/*J'indique les données horizontales du graphique. Il doit y avoir le même nombre que pour ma série de données précédentes (logique)*/
 $MyData->addPoints(array("Lundi","Mardi","Mercredi","Jeudi","Vendredi","Samedi","Dimanche"),"Labels");
 $MyData->setSerieDescription("Labels","Jours");
 $MyData->setAbscissa("Labels");
 $MyData->setPalette("Production",array("R"=>47,"G"=>129,"B"=>138));
 $MyData->setPalette("objectif",array("R"=>191,"G"=>10,"B"=>46));

/* Je crée l'image qui contiendra mon graphique précédemment crée */
 $myPicture = new pImage(900,330,$MyData);
 //$myPicture->Antialias = FALSE; 
/* Je crée une bordure à mon image */
//$myPicture->drawGradientArea(0,0,700,230,DIRECTION_VERTICAL,$tableau); 
 $myPicture->drawRectangle(0,0,899,329,array("R"=>0,"G"=>0,"B"=>0));

/* J'indique le titre de mon graphique, son positionnement sur l'image et sa police */ 
 $myPicture->setFontProperties(array("FontName"=>"fonts/Forgotte.ttf","FontSize"=>11));
 $myPicture->drawText(200,25,"Quantité produite par jour",array("FontSize"=>20,"Align"=>TEXT_ALIGN_BOTTOMMIDDLE));

/* Je choisi le fond de mon graphique */
 $myPicture->setFontProperties(array("FontName"=>"fonts/pf_arma_five.ttf","FontSize"=>6));

/* Je détermine la taille du graphique et son emplacement dans l'image */
 $myPicture->setGraphArea(60,40,800,310);

/* Paramètres pour dessiner le graphique à partir des deux abscisses */
 $scaleSettings = array("XMargin"=>10,"YMargin"=>10,"Floating"=>TRUE,"GridR"=>200,"GridG"=>200,"GridB"=>200,"DrawSubTicks"=>TRUE,"CycleBackground"=>TRUE);
 $myPicture->drawScale($scaleSettings);

/* J'insère sur le côté droit le nom de l'auteur et les droits */ 
$myPicture->setShadow(TRUE,array("X"=>1,"Y"=>1,"R"=>0,"G"=>0,"B"=>0,"Alpha"=>10)); 
 $myPicture->drawLegend(780,40,array("Style"=>LEGEND_ROUND,"Alpha"=>20,"Mode"=>LEGEND_HORIZONTAL)); 

//Chart1
 $MyData->setSerieDrawable("objectif",FALSE); 
 $MyData->setSerieDrawable("Production",TRUE); 
 $myPicture->drawBarChart(); 
$myPicture->drawPlotChart(array("DisplayValues"=>TRUE,"PlotBorder"=>FALSE,"BorderSize"=>2,"Surrounding"=>-60,"BorderAlpha"=>60));
//Chart 2
 $MyData->setSerieDrawable("objectif",TRUE); 
 $MyData->setSerieDrawable("Production",FALSE);
$myPicture->drawLineChart(); 
$myPicture->drawPlotChart(array("DisplayValues"=>FALSE,"PlotBorder"=>TRUE,"BorderSize"=>2,"Surrounding"=>-60,"BorderAlpha"=>80));


/* J'indique le chemin où je souhaite que mon image soit créée */

 $myPicture->Render("img/P".$DF.".png");
  echo('<br><br><center><img src="../pChart/img/P'.$DF.'.png"  alt="Print" style="cursor:pointer;" width="900" height="450"  /></center>');
?>